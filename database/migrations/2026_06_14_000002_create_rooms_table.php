<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_en');
            $table->integer('floor')->default(0);
            $table->integer('capacity')->default(0);
            $table->string('type')->default('lecture'); // lecture, lab, office, meeting, auditorium
            $table->boolean('is_lab')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
