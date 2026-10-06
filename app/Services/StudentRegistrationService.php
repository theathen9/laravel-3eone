<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\ClassModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StudentRegistrationService
{
    /**
     * Process one step of student registration.
     */
    public function process(array $data, ?UploadedFile $profileImage = null): array
    {
        return DB::transaction(function () use ($data, $profileImage) {

            $step = (int) ($data['step'] ?? 1);

            return match ($step) {
                1 => $this->saveStudent($data, $profileImage),
                2 => $this->saveClasses($data),
                3 => $this->completeRegistration($data),
                default => throw new \InvalidArgumentException(
                    'Invalid registration step.'
                ),
            };
        });
    }

    /**
     * STEP 1
     *
     * Create or update the student draft.
     */
    protected function saveStudent(
        array $data,
        ?UploadedFile $profileImage = null
    ): array {

        // Create a new Student Eloquent model
        $student = new Student();

        $studentData = [
            // Student
            'student_id' => $data['student_id'] ?? null,
            'student_code' => $data['student_code'] ?? null,


            'first_name_kh' => $data['first_name_kh'] ?? null,
            'last_name_kh'  => $data['last_name_kh'] ?? null,

            'first_name_en' => $data['first_name_en'] ?? null,
            'last_name_en'  => $data['last_name_en'] ?? null,

            'gender' => $data['gender'] ?? null,
            'dob'    => $data['dob'] ?? null,

            // Birth address
            'birth_addr_province' => $data['birth_addr_province'] ?? null,
            'birth_addr_district' => $data['birth_addr_district'] ?? null,
            'birth_addr_commune'  => $data['birth_addr_commune'] ?? null,
            'birth_addr_village'  => $data['birth_addr_village'] ?? null,

            // Current address
            'curr_addr_province' => $data['curr_addr_province'] ?? null,
            'curr_addr_district' => $data['curr_addr_district'] ?? null,
            'curr_addr_commune'  => $data['curr_addr_commune'] ?? null,
            'curr_addr_village'  => $data['curr_addr_village'] ?? null,

            // Contact
            'phone1' => $data['phone1'] ?? null,
            'phone2' => $data['phone2'] ?? null,
            'email'  => isset($data['email'])
                ? strtolower(trim($data['email']))
                : null,

            // Academic
            'academic_year' => $data['academic_year'] ?? null,

            'register_at' => $data['register_at']
                ?? now()->toDateString(),

            // Guardian 1
            'guardian1_name' => trim(
                ($data['guardian1_name_first'] ?? '') . ' ' .
                    ($data['guardian1_name_last'] ?? '')
            ),

            'guardian1_relationship' =>
            $data['guardian1_relationship'] ?? null,

            'guardian1_phone' =>
            $data['guardian1_phone'] ?? null,



            // Guardian 2
            'guardian2_name' => trim(
                ($data['guardian2_name_first'] ?? '') . ' ' .
                    ($data['guardian2_name_last'] ?? '')
            ),

            'guardian2_relationship' =>
            $data['guardian2_relationship'] ?? null,

            'guardian2_phone' =>
            $data['guardian2_phone'] ?? null,

            // Guardian address
            'guardian_curr_addr_province' =>
            $data['guardian_curr_addr_province'] ?? null,

            'guardian_curr_addr_district' =>
            $data['guardian_curr_addr_district'] ?? null,

            'guardian_curr_addr_commune' =>
            $data['guardian_curr_addr_commune'] ?? null,

            'guardian_curr_addr_village' =>
            $data['guardian_curr_addr_village'] ?? null,

            'guardian_email' =>
            $data['guardian_email'] ?? null,

            // System
            'created_by' => $data['created_by'] ?? null,
            'status'     => 'draft',
        ];

        // Upload profile image
        if ($profileImage) {
            $studentData['profile_image'] = $profileImage->store(
                'students',
                'public'
            );
        }

        // Fill and save the Student model
        $student->fill($studentData);
        $student->save();

        // student_id is available after save()
        return [
            'success' => true,
            'message' => 'Student information saved.',
            'step' => 1,
            'data' => [
                ...$data,
                'student_id' => $student->student_id,
                'student_code' => $student->student_code,
            ],
        ];
    }

    /**
     * STEP 2
     *
     * Create/update student class enrollments.
     */
    protected function saveClasses(array $data): array
    {
        $studentId = $data['student_id'] ?? null;

        if (!$studentId) {
            throw new \InvalidArgumentException(
                'Student ID is required.'
            );
        }

        $student = Student::findOrFail($studentId);

        $classIds = $data['class_ids'] ?? [];

        if (empty($classIds)) {
            throw new \InvalidArgumentException(
                'Please select at least one class.'
            );
        }

        /*
         * Remove previous draft enrollments for this student
         * before rebuilding the current selection.
         *
         * This works well with your wizard because Step 2
         * can be saved multiple times.
         */
        Enrollment::where('student_id', $student->student_id)
            ->delete();

        foreach ($classIds as $classId) {

            $class = ClassModel::findOrFail($classId);

            if ($class->status !== 'Active') {
                throw new \InvalidArgumentException(
                    "Class {$class->class_code} is not active."
                );
            }

            if (
                $class->current_students >=
                $class->max_students
            ) {
                throw new \InvalidArgumentException(
                    "Class {$class->class_code} is full."
                );
            }

            /*
             * IMPORTANT:
             *
             * Do NOT trust price from JavaScript.
             *
             * Replace this with your actual course/fee lookup
             * once we see tblCourses.
             */
            $price = $this->getClassPrice($class);

            Enrollment::create([
                'student_id' => $student->student_id,
                'class_id' => $class->class_id,
                'price' => $price,
                'discount' => 0,
                'created_by' => $data['created_by'] ?? null,
            ]);
        }

        return [
            'success' => true,
            'step' => 2,
            'student_id' => $student->student_id,
            'message' => 'Classes saved.',
        ];
    }

    /**
     * STEP 3
     *
     * Create invoice, invoice items and payment.
     */
    protected function completeRegistration(array $data): array
    {
        $studentId = $data['student_id'] ?? null;

        if (!$studentId) {
            throw new \InvalidArgumentException(
                'Student ID is required.'
            );
        }

        $student = Student::findOrFail($studentId);

        $enrollments = Enrollment::where(
            'student_id',
            $student->student_id
        )->get();

        if ($enrollments->isEmpty()) {
            throw new \InvalidArgumentException(
                'No classes selected.'
            );
        }

        $discountPercent = (float) (
            $data['discount'] ?? 0
        );

        $amountPaid = (float) (
            $data['amount_paid'] ?? 0
        );

        $total = $enrollments->sum(
            fn($enrollment) =>
            (float) $enrollment->price
        );

        $discountAmount =
            $total * ($discountPercent / 100);

        $finalTotal =
            max(0, $total - $discountAmount);

        if ($amountPaid > $finalTotal) {
            throw new \InvalidArgumentException(
                'Amount paid cannot be greater than the final total.'
            );
        }

        /*
         * Create invoice.
         */
        $invoice = Invoice::create([
            'invoice_no' => $this->generateInvoiceNumber(),
            'student_id' => $student->student_id,
            'invoice_date' => now()->toDateString(),
            'total_amount' => $finalTotal,
            'created_by' => $data['created_by'],
            'status' => $amountPaid >= $finalTotal
                ? 'Paid'
                : 'Partial',
        ]);

        /*
         * Create invoice items.
         */
        foreach ($enrollments as $enrollment) {

            $itemAmount = (float) $enrollment->price;

            InvoiceItem::create([
                'enrollment_id' => $enrollment->enrollment_id,
                'invoice_id' => $invoice->invoice_id,
                'description' =>
                'Class Enrollment #' .
                    $enrollment->class_id,
                'amount' => $itemAmount,
            ]);

            /*
             * Store the discount on the enrollment.
             */
            $enrollment->discount =
                $discountPercent;

            $enrollment->updated_at = now();
            $enrollment->save();
        }

        /*
         * Create payment only when money was actually paid.
         *
         * tblPayments has CHECK(amount > 0).
         */
        if ($amountPaid > 0) {

            Payment::create([
                'invoice_id' => $invoice->invoice_id,
                'payment_date' => now()->toDateString(),
                'amount' => $amountPaid,
                'payment_method_id' =>
                $data['payment_method_id'],
                'reference_no' =>
                $data['reference_no'] ?? null,
                'created_by' => $data['created_by'],
                'status' => 'Completed',
            ]);
        }

        /*
         * Update class student counts.
         */
        foreach ($enrollments as $enrollment) {

            ClassModel::where(
                'class_id',
                $enrollment->class_id
            )->increment('current_students');
        }

        /*
         * Registration is now complete.
         */
        $student->status = 'active';
        $student->save();

        return [
            'success' => true,
            'message' => 'Student registered successfully.',
            'step' => 3,
            'student_id' => $student->student_id,
            'invoice_id' => $invoice->invoice_id,
            'invoice_no' => $invoice->invoice_no,
            'total' => $total,
            'discount' => $discountAmount,
            'final_total' => $finalTotal,
            'amount_paid' => $amountPaid,
            'balance' => $finalTotal - $amountPaid,
        ];
    }

    /**
     * Get the real class price.
     *
     * This must be connected to your actual fee/course schema.
     */
    protected function getClassPrice(ClassModel $class): float
    {
        if (!$class->relationLoaded('course')) {
            $class->load('course');
        }

        if (!$class->course) {
            throw new \RuntimeException(
                "Class {$class->class_id} is not linked to a course."
            );
        }

        return (float) $class->course->price;
    }


    /**
     * Generate unique invoice number.
     */
    protected function generateInvoiceNumber(): string
    {
        do {
            $number =
                'INV-' .
                now()->format('Ymd') .
                '-' .
                strtoupper(Str::random(6));
        } while (
            Invoice::where(
                'invoice_no',
                $number
            )->exists()
        );

        return $number;
    }
}
