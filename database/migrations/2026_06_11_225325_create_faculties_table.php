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
    Schema::create('faculties', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // رمز الكلية مثل: IT, ENG
        $table->string('name_ar'); // كلية تقنية المعلومات
        $table->string('name_en');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};
