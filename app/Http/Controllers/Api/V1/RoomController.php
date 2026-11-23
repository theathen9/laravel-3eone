<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RoomsRequest;
use App\Http\Resources\Api\V1\RoomResource;
use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct(
        protected RoomService $roomService
    ) {}

    /**
     * GET /api/v1/rooms
     */
    public function index(Request $request): JsonResponse
    {
        $limit = max(1, min((int) $request->input('limit', 10), 100));
        $rooms = $this->roomService->index($limit);

        return response()->json([
            'success' => true,
            'message' => 'Rooms retrieved successfully.',
            'data' => array_map(
                fn (Room $room) => (new RoomResource($room))->resolve($request),
                $rooms->items()
            ),
            'pagination' => [
                'current_page' => $rooms->currentPage(),
                'per_page' => $rooms->perPage(),
                'total' => $rooms->total(),
                'limit' => $limit,
                'last_page' => $rooms->lastPage(),
                'from' => $rooms->firstItem(),
                'to' => $rooms->lastItem(),
            ],
        ]);
    }

    /**
     * POST /api/v1/rooms
     */
    public function process(RoomsRequest $request): JsonResponse
    {
        $room = $this->roomService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Room created successfully.',
            'data' => (new RoomResource($room))->resolve($request),
        ], 201);
    }

    /**
     * GET /api/v1/rooms/{id}
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $room = $this->roomService->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Room retrieved successfully.',
            'data' => (new RoomResource($room))->resolve($request),
        ]);
    }

    /**
     * PUT/PATCH /api/v1/rooms/{id}
     */
    public function update(RoomsRequest $request, int $id): JsonResponse
    {
        $room = $this->roomService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Room updated successfully.',
            'data' => (new RoomResource($room))->resolve($request),
        ]);
    }

    /**
     * DELETE /api/v1/rooms/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        if ($this->roomService->isAssigned($id)) {
            return response()->json([
                'success' => false,
                'message' => 'This room is assigned to a class and cannot be deleted.',
            ], 422);
        }

        $this->roomService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Room deleted successfully.',
        ]);
    }
}
