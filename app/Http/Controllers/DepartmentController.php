<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department; // تأكدي من مراجعة اسم الموديل عندكِ لو كان Department
use App\Models\College;



class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {// جلب الأقسام مع الكلية المرتبطة بيها لمنع ثقل السيرفر (Eager Loading)
    // ملاحظة: تأكدي أن هناك دالة علاقة داخل موديل Department اسمها faculty أو college
    $departments = Department::with('faculty')->get(); 

    return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = College::all(); // جلب كل الكليات ليعرضها في القائمة المنسدلة
    return view('departments.create', compact('faculties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
    $request->validate([
        'faculty_id' => 'required|exists:faculties,id', // التأكد أن الكلية موجودة فعلاً
        'code'       => 'required|max:10|unique:departments,code',
        'name_ar'    => 'required|max:255',
        'name_en'    => 'required|max:255',
    ]);

    // التخزين
    $dept = new Department();
    $dept->faculty_id = $request->faculty_id;
    $dept->code = $request->code;
    $dept->name_ar = $request->name_ar;
    $dept->name_en = $request->name_en;
    $dept->save();

    return redirect()->route('departments.index')->with('success', 'تم إضافة القسم العلمي بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
    $faculties = College::all(); // لجلب الكليات لغرض الاختيار منها
    return view('departments.edit', compact('department', 'faculties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'faculty_id' => 'required|exists:faculties,id',
        'code'       => 'required|max:10|unique:departments,code,' . $id,
        'name_ar'    => 'required|max:255',
        'name_en'    => 'required|max:255',
    ]);

    $dept = Department::findOrFail($id);
    $dept->faculty_id = $request->faculty_id;
    $dept->code = $request->code;
    $dept->name_ar = $request->name_ar;
    $dept->name_en = $request->name_en;
    $dept->save();

    return redirect()->route('departments.index')->with('success', 'تم تحديث بيانات القسم بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {$dept = Department::findOrFail($id);
    $dept->delete();

    return redirect()->route('departments.index')->with('success', 'تم حذف القسم العلمي بنجاح!');
}
    }

