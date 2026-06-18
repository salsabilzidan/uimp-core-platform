<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Services\EventBusService;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::withCount('rooms')->get();
        return view('buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('buildings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'    => 'required|unique:buildings,code|max:10',
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'location' => 'nullable|max:255',
            'floors'   => 'required|integer|min:1',
            'description' => 'nullable',
        ]);

        $building = Building::create($request->all());

        app(EventBusService::class)->dispatch('building.created', [
            'building_id' => $building->id,
            'code' => $building->code,
            'name_ar' => $building->name_ar,
            'floors' => $building->floors,
        ]);

        return redirect()->route('buildings.index')->with('success', 'تم إضافة المبنى بنجاح!');
    }

    public function show(string $id)
    {
        $building = Building::with('rooms')->findOrFail($id);
        return view('buildings.show', compact('building'));
    }

    public function edit(string $id)
    {
        $building = Building::findOrFail($id);
        return view('buildings.edit', compact('building'));
    }

    public function update(Request $request, string $id)
    {
        $building = Building::findOrFail($id);

        $request->validate([
            'code'    => 'required|max:10|unique:buildings,code,' . $id,
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'location' => 'nullable|max:255',
            'floors'   => 'required|integer|min:1',
            'description' => 'nullable',
        ]);

        $building->update($request->all());

        app(EventBusService::class)->dispatch('building.updated', [
            'building_id' => $building->id,
            'code' => $building->code,
            'name_ar' => $building->name_ar,
        ]);

        return redirect()->route('buildings.index')->with('success', 'تم تحديث بيانات المبنى بنجاح!');
    }

    public function destroy(string $id)
    {
        $building = Building::findOrFail($id);
        $buildingId = $building->id;
        $building->delete();

        app(EventBusService::class)->dispatch('building.deleted', [
            'building_id' => $buildingId,
        ]);

        return redirect()->route('buildings.index')->with('success', 'تم حذف المبنى من النظام بنجاح!');
    }
}
