<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use App\Models\College;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   // تأكدي من عمل الـ use للموديل في الأعلى

public function index()
{
    // جلب كل الكليات المخزنة في جدول faculties عبر موديل College
    $faculties = College::all();

    // تمرير البيانات لصفحة العرض (التي سننشئها بعد قليل)
    return view('faculties.index', compact('faculties'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('faculties.create'); //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // التحقق من صحة البيانات المدخلة (Validation)
    $request->validate([
        'code'    => 'required|unique:faculties,code|max:10',
        'name_ar' => 'required|max:255',
        'name_en' => 'required|max:255',
    ]);

    // تخزين البيانات عبر الموديل
    $faculty = new College();
    $faculty->code = $request->code;
    $faculty->name_ar = $request->name_ar;
    $faculty->name_en = $request->name_en;
    $faculty->save();

    // إعادة توجيه المستخدم لصفحة الجدول الرئيسية مع رسالة نجاح
    return redirect()->route('faculties.index')->with('success', 'تم إضافة الكلية بنجاح!');
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
    {$faculty = College::findOrFail($id);
    return view('faculties.edit', compact('faculty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'code'    => 'required|max:10|unique:faculties,code,' . $id,
        'name_ar' => 'required|max:255',
        'name_en' => 'required|max:255',
    ]);

    $faculty = College::findOrFail($id);
    $faculty->code = $request->code;
    $faculty->name_ar = $request->name_ar;
    $faculty->name_en = $request->name_en;
    $faculty->save();

    return redirect()->route('faculties.index')->with('success', 'تم تحديث بيانات الكلية بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {// جلب الكلية وحذفها فوراً
    $faculty = College::findOrFail($id);
    $faculty->delete();

    // إعادة التوجيه لصفحة الجدول مع رسالة نجاح
    return redirect()->route('faculties.index')->with('success', 'تم حذف الكلية من النظام بنجاح!');
    }
}
