<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Services\EventBusService;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function index()
    {
        $campuses = Campus::all();
        return view('campuses.index', compact('campuses'));
    }

    public function create()
    {
        return view('campuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar'  => 'required|max:255',
            'name_en'  => 'required|max:255',
            'location' => 'nullable|max:500',
        ]);

        $campus = Campus::create($request->all());

        app(EventBusService::class)->dispatch('campus.created', [
            'campus_id' => $campus->id,
            'name_ar' => $campus->name_ar,
        ]);

        return redirect()->route('campuses.index')->with('success', 'تم إضافة الحرم الجامعي بنجاح!');
    }

    public function show(string $id)
    {
        $campus = Campus::with('buildings')->findOrFail($id);
        return view('campuses.show', compact('campus'));
    }

    public function edit(string $id)
    {
        $campus = Campus::findOrFail($id);
        return view('campuses.edit', compact('campus'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_ar'  => 'required|max:255',
            'name_en'  => 'required|max:255',
            'location' => 'nullable|max:500',
        ]);

        $campus = Campus::findOrFail($id);
        $campus->update($request->all());

        app(EventBusService::class)->dispatch('campus.updated', [
            'campus_id' => $campus->id,
            'name_ar' => $campus->name_ar,
        ]);

        return redirect()->route('campuses.index')->with('success', 'تم تحديث بيانات الحرم الجامعي بنجاح!');
    }

    public function destroy(string $id)
    {
        $campus = Campus::findOrFail($id);
        $campusId = $campus->id;
        $campus->delete();

        app(EventBusService::class)->dispatch('campus.deleted', [
            'campus_id' => $campusId,
        ]);

        return redirect()->route('campuses.index')->with('success', 'تم حذف الحرم الجامعي من النظام بنجاح!');
    }
}
