<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StudentRegistrationRequest;
use App\Services\StudentRegistrationService;
use Illuminate\Http\JsonResponse;
use App\Models\ClassModel;

class StudentRegistrationController extends Controller
{
    public function __construct(
        protected StudentRegistrationService $registrationService
    ) {}

    public function process(StudentRegistrationRequest $request): JsonResponse
    {
        $result = $this->registrationService->process(
            $request->validated(),
            $request->file('profile_image')
        );

        return response()->json($result);
    }
    public function create()
    {
        $classes = ClassModel::with([
            'course',
            'teacher',
            'room',
        ])->get();

        return view('admin.student.registrations', compact('classes'));
    }
}
