<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use App\Models\Room;
use App\Models\Department;
use App\Services\EventBusService;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{
    public function index()
    {
        $laboratories = Laboratory::with(['room.building', 'department'])->get();
        return view('laboratories.index', compact('laboratories'));
    }

    public function create()
    {
        $rooms = Room::where('is_lab', true)->orWhere('type', 'lab')->get();
        $departments = Department::all();
        return view('laboratories.create', compact('rooms', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id'       => 'nullable|exists:rooms,id',
            'department_id' => 'nullable|exists:departments,id',
            'name_ar'       => 'required|max:255',
            'name_en'       => 'required|max:255',
            'capacity'      => 'required|integer|min:1',
            'description'   => 'nullable',
            'is_active'     => 'boolean',
        ]);

        $lab = Laboratory::create($request->all());

        app(EventBusService::class)->dispatch('laboratory.created', [
            'laboratory_id' => $lab->id,
            'name_ar' => $lab->name_ar,
            'room_id' => $lab->room_id,
            'department_id' => $lab->department_id,
        ]);

        return redirect()->route('laboratories.index')->with('success', 'تم إضافة المعمل بنجاح!');
    }

    public function show(string $id)
    {
        $laboratory = Laboratory::with(['room.building', 'department'])->findOrFail($id);
        return view('laboratories.show', compact('laboratory'));
    }

    public function edit(string $id)
    {
        $laboratory = Laboratory::findOrFail($id);
        $rooms = Room::where('is_lab', true)->orWhere('type', 'lab')->get();
        $departments = Department::all();
        return view('laboratories.edit', compact('laboratory', 'rooms', 'departments'));
    }

    public function update(Request $request, string $id)
    {
        $laboratory = Laboratory::findOrFail($id);

        $request->validate([
            'room_id'       => 'nullable|exists:rooms,id',
            'department_id' => 'nullable|exists:departments,id',
            'name_ar'       => 'required|max:255',
            'name_en'       => 'required|max:255',
            'capacity'      => 'required|integer|min:1',
            'description'   => 'nullable',
            'is_active'     => 'boolean',
        ]);

        $laboratory->update($request->all());

        app(EventBusService::class)->dispatch('laboratory.updated', [
            'laboratory_id' => $laboratory->id,
            'name_ar' => $laboratory->name_ar,
            'room_id' => $laboratory->room_id,
            'department_id' => $laboratory->department_id,
        ]);

        return redirect()->route('laboratories.index')->with('success', 'تم تحديث بيانات المعمل بنجاح!');
    }

    public function destroy(string $id)
    {
        $laboratory = Laboratory::findOrFail($id);
        $labId = $laboratory->id;
        $laboratory->delete();

        app(EventBusService::class)->dispatch('laboratory.deleted', [
            'laboratory_id' => $labId,
        ]);

        return redirect()->route('laboratories.index')->with('success', 'تم حذف المعمل من النظام بنجاح!');
    }
}
