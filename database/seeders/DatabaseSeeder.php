<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إدخال الأدوار الافتراضية
        DB::table('roles')->insert([
            ['name' => 'sys_admin', 'display_name_ar' => 'مسؤول النظام', 'display_name_en' => 'System Admin'],
            ['name' => 'lab_supervisor', 'display_name_ar' => 'مشرف معمل', 'display_name_en' => 'Lab Supervisor'],
            ['name' => 'student', 'display_name_ar' => 'طالب', 'display_name_en' => 'Student'],
        ]);

        // 2. إدخال كليات تجريبية
        $facultyId = DB::table('faculties')->insertGetId([
            'code' => 'IT',
            'name_ar' => 'كلية تقنية المعلومات',
            'name_en' => 'Faculty of Information Technology',
        ]);

        // 3. إدخال أقسام تابع للكلية
        DB::table('departments')->insert([
            ['faculty_id' => $facultyId, 'code' => 'CS', 'name_ar' => 'قسم علوم الحاسب', 'name_en' => 'Computer Science'],
            ['faculty_id' => $facultyId, 'code' => 'SWE', 'name_ar' => 'قسم هندسة البرمجيات', 'name_en' => 'Software Engineering'],
        ]);
    }
}