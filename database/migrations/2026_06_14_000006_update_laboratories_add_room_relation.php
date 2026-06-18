<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laboratories', function (Blueprint $table) {
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('set null')->after('id');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null')->after('room_id');
            $table->string('name_ar')->nullable()->after('department_id');
            $table->string('name_en')->nullable()->after('name_ar');
            $table->integer('capacity')->default(0)->after('name_en');
            $table->text('description')->nullable()->after('capacity');
            $table->boolean('is_active')->default(true)->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('laboratories', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['department_id']);
            $table->dropColumn(['room_id', 'department_id', 'name_ar', 'name_en', 'capacity', 'description', 'is_active']);
        });
    }
};
