<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Building;
use App\Models\Laboratory;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('building');

        if ($request->filled('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('is_lab')) {
            $query->where('is_lab', filter_var($request->is_lab, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('min_capacity')) {
            $query->where('capacity', '>=', $request->min_capacity);
        }

        return response()->json($query->paginate($request->per_page ?? 50));
    }

    public function show(string $id)
    {
        $room = Room::with('building')->findOrFail($id);
        return response()->json($room);
    }

    public function buildings()
    {
        return response()->json(Building::withCount('rooms')->get());
    }

    public function laboratories(Request $request)
    {
        $query = Laboratory::with(['room.building', 'department']);

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
        }

        return response()->json($query->paginate($request->per_page ?? 50));
    }
}
