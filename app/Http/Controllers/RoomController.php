<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Building;
use App\Services\EventBusService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('building')->get();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        $buildings = Building::all();
        return view('rooms.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'code'        => 'required|unique:rooms,code|max:10',
            'name_ar'     => 'required|max:255',
            'name_en'     => 'required|max:255',
            'floor'       => 'required|integer|min:0',
            'capacity'    => 'required|integer|min:1',
            'type'        => 'required|in:lecture,lab,office,meeting,auditorium',
            'is_lab'      => 'boolean',
            'description' => 'nullable',
        ]);

        $room = Room::create($request->all());

        app(EventBusService::class)->dispatch('room.created', [
            'room_id' => $room->id,
            'code' => $room->code,
            'building_id' => $room->building_id,
            'is_lab' => $room->is_lab,
        ]);

        return redirect()->route('rooms.index')->with('success', 'تم إضافة القاعة بنجاح!');
    }

    public function show(string $id)
    {
        $room = Room::with('building')->findOrFail($id);
        return view('rooms.show', compact('room'));
    }

    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        $buildings = Building::all();
        return view('rooms.edit', compact('room', 'buildings'));
    }

    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'code'        => 'required|max:10|unique:rooms,code,' . $id,
            'name_ar'     => 'required|max:255',
            'name_en'     => 'required|max:255',
            'floor'       => 'required|integer|min:0',
            'capacity'    => 'required|integer|min:1',
            'type'        => 'required|in:lecture,lab,office,meeting,auditorium',
            'is_lab'      => 'boolean',
            'description' => 'nullable',
        ]);

        $room->update($request->all());

        app(EventBusService::class)->dispatch('room.updated', [
            'room_id' => $room->id,
            'code' => $room->code,
            'building_id' => $room->building_id,
        ]);

        return redirect()->route('rooms.index')->with('success', 'تم تحديث بيانات القاعة بنجاح!');
    }

    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $roomId = $room->id;
        $room->delete();

        app(EventBusService::class)->dispatch('room.deleted', [
            'room_id' => $roomId,
        ]);

        return redirect()->route('rooms.index')->with('success', 'تم حذف القاعة من النظام بنجاح!');
    }
}
