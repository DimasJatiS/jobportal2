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
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->enum('type', ['Full-time', 'Part-time', 'Internship'])->default('Full-time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table__job_vacancy', function (Blueprint $table) {
            //
        });
    }
};
