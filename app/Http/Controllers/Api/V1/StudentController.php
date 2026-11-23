<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StudentsRequest;
use App\Http\Resources\Api\V1\StudentResource;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(
        protected StudentService $studentService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $limit = max(1, min((int) $request->input('limit', 10), 100));
        $students = $this->studentService->index($limit);

        return response()->json([
            'success' => true,
            'message' => 'Students retrieved successfully.',
            'data' => array_map(
                fn (Student $student) => (new StudentResource($student))->resolve($request),
                $students->items()
            ),
            'pagination' => [
                'current_page' => $students->currentPage(),
                'per_page' => $students->perPage(),
                'total' => $students->total(),
                'limit' => $limit,
                'last_page' => $students->lastPage(),
                'from' => $students->firstItem(),
                'to' => $students->lastItem(),
            ],
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $student = $this->studentService->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Student retrieved successfully.',
            'data' => (new StudentResource($student))->resolve($request),
        ]);
    }

    public function update(
        StudentsRequest $request,
        int $id
    ): JsonResponse {
        $student = $this->studentService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully.',
            'data' => (new StudentResource($student))->resolve($request),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        if (! $this->studentService->delete($id)) {
            return response()->json([
                'success' => false,
                'message' => 'This student has enrollment, invoice, or academic records and cannot be deleted.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully.',
        ]);
    }
}
