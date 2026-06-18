<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Subsystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $collegesCount = $this->safeCount('faculties');
        $departmentsCount = $this->safeCount('departments');
        $employeesCount = $this->safeCount('employees');
        $studentsCount = $this->safeCount('students');
        $buildingsCount = $this->safeCount('buildings');
        $roomsCount = $this->safeCount('rooms');
        $laboratoriesCount = $this->safeCount('laboratories');
        $subsystemsCount = $this->safeCount('subsystems');

        // جلب آخر 10 عمليات أمنية
        $recentLogs = AuditLog::latest()->take(10)->get();
        
        // تعديل العمود ليتوافق مع الـ ERD الخاص بكم (status = 'active') بدلاً من is_active
        $activeSubsystems = Subsystem::where('status', 'active')->get();

        return view('dashboard', compact(
            'collegesCount', 'departmentsCount', 'employeesCount',
            'studentsCount', 'buildingsCount', 'roomsCount',
            'laboratoriesCount', 'subsystemsCount',
            'recentLogs', 'activeSubsystems'
        ));
    }

    /**
     * دالة حساب الأعداد بشكل آمن لمنع انهيار الصفحة
     */
    private function safeCount(string $table): int
    {
        if (!Schema::hasTable($table)) return 0;
        try {
            return DB::table($table)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
}