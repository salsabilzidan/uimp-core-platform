<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\College;
use App\Services\EventBusService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('faculty')->get();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $faculties = College::all();
        return view('departments.create', compact('faculties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'code'       => 'required|max:10|unique:departments,code',
            'name_ar'    => 'required|max:255',
            'name_en'    => 'required|max:255',
        ]);

        $dept = Department::create($request->all());

        app(EventBusService::class)->dispatch('department.created', [
            'department_id' => $dept->id,
            'code' => $dept->code,
            'name_ar' => $dept->name_ar,
            'faculty_id' => $dept->faculty_id,
        ]);

        return redirect()->route('departments.index')->with('success', 'تم إضافة القسم العلمي بنجاح!');
    }

    public function show(string $id)
    {
        $department = Department::with('faculty')->findOrFail($id);
        return view('departments.show', compact('department'));
    }

    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
        $faculties = College::all();
        return view('departments.edit', compact('department', 'faculties'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'code'       => 'required|max:10|unique:departments,code,' . $id,
            'name_ar'    => 'required|max:255',
            'name_en'    => 'required|max:255',
        ]);

        $dept = Department::findOrFail($id);
        $dept->update($request->all());

        app(EventBusService::class)->dispatch('department.updated', [
            'department_id' => $dept->id,
            'code' => $dept->code,
            'name_ar' => $dept->name_ar,
            'faculty_id' => $dept->faculty_id,
        ]);

        return redirect()->route('departments.index')->with('success', 'تم تحديث بيانات القسم بنجاح!');
    }

    public function destroy(string $id)
    {
        $dept = Department::findOrFail($id);
        $deptId = $dept->id;
        $dept->delete();

        app(EventBusService::class)->dispatch('department.deleted', [
            'department_id' => $deptId,
        ]);

        return redirect()->route('departments.index')->with('success', 'تم حذف القسم العلمي بنجاح!');
    }
}
