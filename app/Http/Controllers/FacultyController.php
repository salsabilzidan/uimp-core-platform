<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Services\EventBusService;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = College::all();
        return view('faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('faculties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'    => 'required|unique:faculties,code|max:10',
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
        ]);

        $college = College::create($request->all());

        app(EventBusService::class)->dispatch('faculty.created', [
            'faculty_id' => $college->id,
            'code' => $college->code,
            'name_ar' => $college->name_ar,
        ]);

        return redirect()->route('faculties.index')->with('success', 'تم إضافة الكلية بنجاح!');
    }

    public function show(string $id)
    {
        $faculty = College::findOrFail($id);
        return view('faculties.show', compact('faculty'));
    }

    public function edit(string $id)
    {
        $faculty = College::findOrFail($id);
        return view('faculties.edit', compact('faculty'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'code'    => 'required|max:10|unique:faculties,code,' . $id,
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
        ]);

        $faculty = College::findOrFail($id);
        $faculty->update($request->all());

        app(EventBusService::class)->dispatch('faculty.updated', [
            'faculty_id' => $faculty->id,
            'code' => $faculty->code,
            'name_ar' => $faculty->name_ar,
        ]);

        return redirect()->route('faculties.index')->with('success', 'تم تحديث بيانات الكلية بنجاح!');
    }

    public function destroy(string $id)
    {
        $faculty = College::findOrFail($id);
        $facultyId = $faculty->id;
        $faculty->delete();

        app(EventBusService::class)->dispatch('faculty.deleted', [
            'faculty_id' => $facultyId,
        ]);

        return redirect()->route('faculties.index')->with('success', 'تم حذف الكلية من النظام بنجاح!');
    }
}
