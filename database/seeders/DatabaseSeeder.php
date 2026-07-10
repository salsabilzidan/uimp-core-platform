<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {$this->call([
    SubsystemSeeder::class,
]);
        // 1. الأدوار
        $roles = [
            ['name' => 'sys_admin', 'display_name_ar' => 'مسؤول النظام', 'display_name_en' => 'System Admin'],
            ['name' => 'lab_supervisor', 'display_name_ar' => 'مشرف معمل', 'display_name_en' => 'Lab Supervisor'],
            ['name' => 'student', 'display_name_ar' => 'طالب', 'display_name_en' => 'Student'],
            ['name' => 'employee', 'display_name_ar' => 'موظف', 'display_name_en' => 'Employee'],
        ];
        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(['name' => $role['name']], $role);
        }

        // 2. الصلاحيات
        $permissions = [
            ['name' => 'dashboard.view', 'display_name_ar' => 'لوحة التحكم', 'display_name_en' => 'Dashboard', 'module' => 'dashboard'],
            ['name' => 'faculties.view', 'display_name_ar' => 'مشاهدة الكليات', 'display_name_en' => 'View Faculties', 'module' => 'faculties'],
            ['name' => 'departments.view', 'display_name_ar' => 'مشاهدة الأقسام', 'display_name_en' => 'View Departments', 'module' => 'departments'],
            ['name' => 'employees.view', 'display_name_ar' => 'مشاهدة الموظفين', 'display_name_en' => 'View Employees', 'module' => 'employees'],
            ['name' => 'students.view', 'display_name_ar' => 'مشاهدة الطلاب', 'display_name_en' => 'View Students', 'module' => 'students'],
            ['name' => 'buildings.view', 'display_name_ar' => 'مشاهدة المباني', 'display_name_en' => 'View Buildings', 'module' => 'buildings'],
            ['name' => 'rooms.view', 'display_name_ar' => 'مشاهدة القاعات', 'display_name_en' => 'View Rooms', 'module' => 'rooms'],
            ['name' => 'laboratories.view', 'display_name_ar' => 'مشاهدة المعامل', 'display_name_en' => 'View Laboratories', 'module' => 'laboratories'],
            ['name' => 'campuses.view', 'display_name_ar' => 'مشاهدة الحرم الجامعي', 'display_name_en' => 'View Campuses', 'module' => 'campuses'],
            ['name' => 'subsystems.view', 'display_name_ar' => 'مشاهدة الأنظمة الفرعية', 'display_name_en' => 'View Subsystems', 'module' => 'subsystems'],
            ['name' => 'audit-logs.view', 'display_name_ar' => 'سجل التدقيق', 'display_name_en' => 'Audit Logs', 'module' => 'audit-logs'],
        ];
        foreach ($permissions as $perm) {
            DB::table('permissions')->updateOrInsert(['name' => $perm['name']], $perm);
        }

        // 3. حساب المسؤول
        $admin = DB::table('users')->where('email', 'admin@uimp.edu')->first();
        if (!$admin) {
            $adminId = DB::table('users')->insertGetId([
                'name' => 'مدير النظام',
                'email' => 'admin@uimp.edu',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('user_roles')->insert([
                'user_id' => $adminId, 'role_id' => 1,
                'created_at' => now(), 'updated_at' => now(),
            ]);
            foreach ($permissions as $perm) {
                $dbPerm = DB::table('permissions')->where('name', $perm['name'])->first();
                if ($dbPerm) {
                    DB::table('user_permissions')->insert([
                        'user_id' => $adminId, 'permission_id' => $dbPerm->id,
                        'created_at' => now(), 'updated_at' => now(),
                    ]);
                }
            }
            $admin = DB::table('users')->where('email', 'admin@uimp.edu')->first();
        }

        // 4. الرتب الأكاديمية
        $ranks = [
            ['name_ar' => 'أستاذ دكتور', 'name_en' => 'Professor', 'level' => 5],
            ['name_ar' => 'أستاذ مشارك', 'name_en' => 'Associate Professor', 'level' => 4],
            ['name_ar' => 'أستاذ مساعد', 'name_en' => 'Assistant Professor', 'level' => 3],
            ['name_ar' => 'محاضر', 'name_en' => 'Lecturer', 'level' => 2],
            ['name_ar' => 'معيد', 'name_en' => 'Teaching Assistant', 'level' => 1],
        ];
        foreach ($ranks as $rank) {
            DB::table('academic_ranks')->updateOrInsert(['name_ar' => $rank['name_ar']], $rank);
        }

        // 5. كليات
        $facultyId = null;
        $faculty = DB::table('faculties')->where('code', 'IT')->first();
        if (!$faculty) {
            $facultyId = DB::table('faculties')->insertGetId([
                'code' => 'IT', 'name_ar' => 'كلية تقنية المعلومات', 'name_en' => 'Faculty of Information Technology',
            ]);
            DB::table('faculties')->insert([
                ['code' => 'ENG', 'name_ar' => 'كلية الهندسة', 'name_en' => 'Faculty of Engineering'],
                ['code' => 'SCI', 'name_ar' => 'كلية العلوم', 'name_en' => 'Faculty of Science'],
                ['code' => 'MED', 'name_ar' => 'كلية الطب', 'name_en' => 'Faculty of Medicine'],
            ]);
        } else {
            $facultyId = $faculty->id;
        }

        // 6. أقسام
        if ($facultyId && !DB::table('departments')->where('code', 'CS')->first()) {
            DB::table('departments')->insert([
                ['faculty_id' => $facultyId, 'code' => 'CS', 'name_ar' => 'قسم علوم الحاسب', 'name_en' => 'Computer Science'],
                ['faculty_id' => $facultyId, 'code' => 'SWE', 'name_ar' => 'قسم هندسة البرمجيات', 'name_en' => 'Software Engineering'],
                ['faculty_id' => $facultyId, 'code' => 'AI', 'name_ar' => 'قسم الذكاء الاصطناعي', 'name_en' => 'Artificial Intelligence'],
            ]);
        }

        // 7. البرامج الأكاديمية
        if ($facultyId && !DB::table('programs')->where('code', 'CS-BSC')->first()) {
            DB::table('programs')->insert([
                ['code' => 'CS-BSC', 'name_ar' => 'بكالوريوس علوم الحاسب', 'name_en' => 'BSc Computer Science', 'faculty_id' => $facultyId, 'duration_years' => 4],
                ['code' => 'SWE-BSC', 'name_ar' => 'بكالوريوس هندسة البرمجيات', 'name_en' => 'BSc Software Engineering', 'faculty_id' => $facultyId, 'duration_years' => 4],
                ['code' => 'AI-BSC', 'name_ar' => 'بكالوريوس الذكاء الاصطناعي', 'name_en' => 'BSc Artificial Intelligence', 'faculty_id' => $facultyId, 'duration_years' => 4],
            ]);
        }

        // 8. الحرم الجامعي
        $campusId = null;
        if (!DB::table('campuses')->where('name_ar', 'الحرم الرئيسي')->first()) {
            $campusId = DB::table('campuses')->insertGetId([
                'name_ar' => 'الحرم الرئيسي', 'name_en' => 'Main Campus', 'location' => 'وسط المدينة',
            ]);
            DB::table('campuses')->insert([
                ['name_ar' => 'الحرم الشرقي', 'name_en' => 'East Campus', 'location' => 'الجهة الشرقية'],
            ]);
        } else {
            $campusId = DB::table('campuses')->where('name_ar', 'الحرم الرئيسي')->first()->id;
        }

        // 9. مباني
        if ($campusId && !DB::table('buildings')->where('code', 'A')->first()) {
            $buildingId = DB::table('buildings')->insertGetId([
                'campus_id' => $campusId, 'code' => 'A', 'name_ar' => 'المبنى الرئيسي (أ)', 'name_en' => 'Main Building (A)',
                'location' => 'الجهة الشمالية', 'floors' => 5,
            ]);
            DB::table('buildings')->insert([
                ['campus_id' => $campusId, 'code' => 'B', 'name_ar' => 'مبنى المعامل (ب)', 'name_en' => 'Laboratories Building (B)', 'location' => 'الجهة الشرقية', 'floors' => 3],
                ['campus_id' => $campusId, 'code' => 'C', 'name_ar' => 'مبنى الإدارة', 'name_en' => 'Administration Building', 'location' => 'الجهة الجنوبية', 'floors' => 4],
            ]);

            // 10. قاعات
            DB::table('rooms')->insert([
                ['building_id' => $buildingId, 'code' => 'A101', 'name_ar' => 'قاعة 101', 'name_en' => 'Room 101', 'floor' => 1, 'capacity' => 50, 'type' => 'lecture', 'is_lab' => false],
                ['building_id' => $buildingId, 'code' => 'A102', 'name_ar' => 'قاعة 102', 'name_en' => 'Room 102', 'floor' => 1, 'capacity' => 30, 'type' => 'lecture', 'is_lab' => false],
                ['building_id' => $buildingId, 'code' => 'B201', 'name_ar' => 'معمل حاسب 1', 'name_en' => 'Computer Lab 1', 'floor' => 2, 'capacity' => 25, 'type' => 'lab', 'is_lab' => true],
            ]);
        }

        // 11. قوالب الإشعارات
        if (!DB::table('notification_templates')->where('key', 'welcome')->first()) {
            DB::table('notification_templates')->insert([
                [
                    'key' => 'welcome',
                    'subject_ar' => 'مرحباً بك في النظام',
                    'subject_en' => 'Welcome to the System',
                    'body_ar' => 'مرحباً {name}،\n\nتم إنشاء حسابك في النظام الجامعي.\nالبريد الإلكتروني: {email}\n\nشكراً لانضمامك.',
                    'body_en' => 'Hello {name},\n\nYour account has been created.\nEmail: {email}\n\nThank you for joining.',
                    'channels' => json_encode(['email']),
                ],
                [
                    'key' => 'password_reset',
                    'subject_ar' => 'إعادة تعيين كلمة المرور',
                    'subject_en' => 'Password Reset',
                    'body_ar' => 'عزيزي {name}،\n\nلقد طلبت إعادة تعيين كلمة المرور.\nرمز التحقق: {code}\n\nشكراً.',
                    'body_en' => 'Dear {name},\n\nYou requested a password reset.\nVerification code: {code}\n\nThank you.',
                    'channels' => json_encode(['email']),
                ],
            ]);
        }
    }
}