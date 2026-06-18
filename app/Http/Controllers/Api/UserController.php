<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use App\Models\Student;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate($request->per_page ?? 50);

        return response()->json($users);
    }

    public function show(string $id)
    {
        $user = User::with('roles')->findOrFail($id);

        $profile = null;
        if ($user->roles->contains('name', 'student')) {
            $profile = Student::with('department')->where('user_id', $user->id)->first();
        } elseif ($user->roles->contains('name', 'employee') || $user->roles->contains('name', 'lab_supervisor')) {
            $profile = Employee::with('department')->where('user_id', $user->id)->first();
        }

        return response()->json([
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    public function students(Request $request)
    {
        $query = Student::with(['user', 'department']);

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        return response()->json($query->paginate($request->per_page ?? 50));
    }

    public function employees(Request $request)
    {
        $query = Employee::with(['user', 'department']);

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        return response()->json($query->paginate($request->per_page ?? 50));
    }
}
