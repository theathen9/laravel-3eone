<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\ClassModel;
use App\Models\Branch;
use App\Models\Room;
use Illuminate\Http\Request;


class InstituteController extends Controller
{
    public function rooms(Request $request)
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where('room_name', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $rooms = $query->orderBy('room_name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.institute.rooms', [
            'rooms' => $rooms,
            'totalRooms' => Room::count(),
            'activeRooms' => Room::where('status', 1)->count(),
            'inactiveRooms' => Room::where('status', 0)->count(),
            'totalCapacity' => Room::where('status', 1)->sum('capacity'),
        ]);
    }
    public function positions(Request $request)
    {
        $query = Position::query();

        // Search positions
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where('position_name', 'like', "%{$search}%");
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Paginated positions
        $positions = $query
            ->orderBy('position_name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.institute.positions', [
            'positions' => $positions,

            // Statistics
            'totalPositions' => Position::count(),
            'activePositions' => Position::where('status', 1)->count(),
            'inactivePositions' => Position::where('status', 0)->count(),
        ]);
    }

    public function branches(Request $request)
    {
        $query = Branch::query();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('branch_name', 'like', "%{$search}%")
                    ->orWhere('branch_code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $branches = $query
            ->orderBy('branch_name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.institute.branches', [
            'branches' => $branches,
            'totalBranches' => Branch::count(),
            'activeBranches' => Branch::where('status', 1)->count(),
            'inactiveBranches' => Branch::where('status', 0)->count(),
        ]);
    }
}
