<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\BranchesRequest;
use App\Http\Resources\Api\V1\BranchResource;
use App\Models\Branch;
use App\Services\BranchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct(
        protected BranchService $branchService
    ) {}

    /**
     * GET /api/v1/branches
     */
    public function index(Request $request): JsonResponse
    {
        $limit = max(1, min((int) $request->input('limit', 10), 100));

        $branches = $this->branchService->index($limit);

        return response()->json([
            'success' => true,
            'message' => 'Branches retrieved successfully.',
            'data' => array_map(
                fn (Branch $branch) => (new BranchResource($branch))->resolve($request),
                $branches->items()
            ),
            'pagination' => [
                'current_page' => $branches->currentPage(),
                'per_page' => $branches->perPage(),
                'total' => $branches->total(),
                'limit' => $limit,
                'last_page' => $branches->lastPage(),
                'from' => $branches->firstItem(),
                'to' => $branches->lastItem(),
            ],
        ]);
    }

    /**
     * POST /api/v1/branches
     */
    public function process(BranchesRequest $request): JsonResponse
    {
        $branch = $this->branchService->create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Branch created successfully.',
            'data' => (new BranchResource($branch))->resolve($request),
        ], 201);
    }

    /**
     * GET /api/v1/branches/{id}
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $branch = $this->branchService->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Branch retrieved successfully.',
            'data' => (new BranchResource($branch))->resolve($request),
        ]);
    }

    /**
     * PUT/PATCH /api/v1/branches/{id}
     */
    public function update(
        BranchesRequest $request,
        int $id
    ): JsonResponse {
        $branch = $this->branchService->update(
            $id,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Branch updated successfully.',
            'data' => (new BranchResource($branch))->resolve($request),
        ]);
    }

    /**
     * DELETE /api/v1/branches/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $this->branchService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Branch deleted successfully.',
        ]);
    }
}
