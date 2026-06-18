<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('subsystems', 'metadata')) {
            Schema::table('subsystems', function (Blueprint $table) {
                $table->json('metadata')->nullable()->after('permissions');
            });
        }
    }

    public function down(): void
    {
        Schema::table('subsystems', function (Blueprint $table) {
            $table->dropColumn('metadata');
        });
    }
};
