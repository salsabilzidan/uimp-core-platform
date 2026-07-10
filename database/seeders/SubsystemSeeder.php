<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subsystem;

class SubsystemSeeder extends Seeder
{
    public function run(): void
    {
        Subsystem::firstOrCreate(
            ['api_key' => 'vFDyK1G0eEXliMfTJcqa5wYQ74gY5jB3Np0j5bLZ'],
            [
                'name' => 'instruments management and booking system',
                'slug' => 'instruments-management-and-booking-system',
                'is_active' => true,
                'permissions' => ['students.read', 'employees.read', 'rooms.read'],
            ]
        );
    }
}