<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Department;
use App\Services\EventBusService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'department'])->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('students.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email',
            'password'      => 'required|string|min:8',
            'department_id' => 'required|exists:departments,id',
            'student_code'  => 'required|string|max:50|unique:students,student_code',
            'academic_year' => 'required|integer|min:1|max:10',
        ]);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        $student = Student::create([
            'user_id'       => $user->id,
            'department_id' => $request->department_id,
            'student_code'  => $request->student_code,
            'academic_year' => $request->academic_year,
        ]);

        $user->roles()->attach(3); // student role id = 3

        app(NotificationService::class)->send([
            'type' => 'email',
            'channel' => 'mail',
            'recipient' => $user->email,
            'subject' => 'مرحباً بك في النظام الجامعي UIMP',
            'body' => "مرحباً {$user->name}،\n\nتم إنشاء حسابك الجامعي بنجاح.\nبريدك الإلكتروني: {$user->email}\n\nشكراً لانضمامك.",
        ]);

        app(EventBusService::class)->dispatch('student.created', [
            'student_id' => $student->id,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('students.index')->with('success', 'تم إنشاء حساب الطالب وإضافته للنظام بنجاح!');
    }

    public function show(string $id)
    {
        $student = Student::with(['user', 'department'])->findOrFail($id);
        return view('students.show', compact('student'));
    }

    public function edit(string $id)
    {
        $student = Student::with('user')->findOrFail($id);
        $departments = Department::all();
        return view('students.edit', compact('student', 'departments'));
    }

    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password'      => 'nullable|string|min:8',
            'department_id' => 'required|exists:departments,id',
            'student_code'  => 'required|string|max:50|unique:students,student_code,' . $student->id,
            'academic_year' => 'required|integer|min:1|max:10',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $student->department_id = $request->department_id;
        $student->student_code = $request->student_code;
        $student->academic_year = $request->academic_year;
        $student->save();

        app(EventBusService::class)->dispatch('student.updated', [
            'student_id' => $student->id,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('students.index')->with('success', 'تم تحديث بيانات الطالب بنجاح!');
    }

    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;
        $studentId = $student->id;
        $userId = $user->id;
        $student->delete();
        if ($user) {
            $user->delete();
        }

        app(EventBusService::class)->dispatch('student.deleted', [
            'student_id' => $studentId,
            'user_id' => $userId,
        ]);

        return redirect()->route('students.index')->with('success', 'تم حذف حساب الطالب بالكامل من النظام!');
    }
}
