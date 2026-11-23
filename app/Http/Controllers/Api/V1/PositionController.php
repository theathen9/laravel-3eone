<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\PositionsRequest;
use App\Http\Resources\Api\V1\PositionResource;
use App\Models\Position;
use App\Services\PositionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function __construct(
        protected PositionService $positionService
    ) {}

    /**
     * GET /api/v1/positions
     */
    public function index(Request $request): JsonResponse
    {
        $limit = max(1, min((int) $request->input('limit', 10), 100));
        $positions = $this->positionService->index($limit);

        return response()->json([
            'success' => true,
            'message' => 'Positions retrieved successfully.',
            'data' => array_map(
                fn (Position $position) => (new PositionResource($position))->resolve($request),
                $positions->items()
            ),
            'pagination' => [
                'current_page' => $positions->currentPage(),
                'per_page' => $positions->perPage(),
                'total' => $positions->total(),
                'limit' => $limit,
                'last_page' => $positions->lastPage(),
                'from' => $positions->firstItem(),
                'to' => $positions->lastItem(),
            ],
        ]);
    }

    /**
     * POST /api/v1/positions
     */
    public function process(PositionsRequest $request): JsonResponse
    {
        $position = $this->positionService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Position created successfully.',
            'data' => (new PositionResource($position))->resolve($request),
        ], 201);
    }

    /**
     * GET /api/v1/positions/{id}
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $position = $this->positionService->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Position retrieved successfully.',
            'data' => (new PositionResource($position))->resolve($request),
        ]);
    }

    /**
     * PUT/PATCH /api/v1/positions/{id}
     */
    public function update(PositionsRequest $request, int $id): JsonResponse
    {
        $position = $this->positionService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Position updated successfully.',
            'data' => (new PositionResource($position))->resolve($request),
        ]);
    }

    /**
     * DELETE /api/v1/positions/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->positionService->hasHistory($id)) {
            return response()->json([
                'success' => false,
                'message' => 'This position has employee history and cannot be deleted.',
            ], 422);
        }

        $this->positionService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Position deleted successfully.',
        ]);
    }
}
