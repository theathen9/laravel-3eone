<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\V1\EmployeesRequest;
use Illuminate\Http\Request;

use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeService $employeeService
    ) {}


    public function index(Request $request): JsonResponse
    {
        $limit = min((int) $request->input('limit', 10), 100);

        $employees = $this->employeeService->paginate($limit);

        return response()->json([
            'success' => true,
            'message' => 'Employees retrieved successfully',
            'data' => $employees->items(),
            'pagination' => [
                'current_page' => $employees->currentPage(),
                'per_page' => $employees->perPage(),
                'total' => $employees->total(),
                'limit' => $limit,
                'last_page' => $employees->lastPage(),
                'from' => $employees->firstItem(),
                'to' => $employees->lastItem(),
            ],
        ]);
    }

    public function process(EmployeesRequest $request): JsonResponse
    {
        $data = $this->employeeService->create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Employee created successfully.',
            'data' => $data,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $employee = $this->employeeService->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Employee retrieved successfully',
            'data' => $employee,
        ]);
    }

    public function update(
        EmployeesRequest $request,
        int $id
    ): JsonResponse {
        $employee = $this->employeeService->update(
            $id,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully',
            'data' => $employee,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->employeeService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted successfully',
        ]);
    }
}
