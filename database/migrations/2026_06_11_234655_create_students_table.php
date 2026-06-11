<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ربطه بحسابه
    $table->foreignId('department_id')->constrained()->onDelete('cascade'); // القسم الدراسي
    $table->string('student_code')->unique(); // الرقم الدراسي/القيد
    $table->integer('academic_year'); // السنة الدراسية
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
