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
        Schema::table('majors', function (Blueprint $table) {
            $table->foreignId('head_teacher_id')
                ->nullable()
                ->after('name')
                ->constrained('teachers')
                ->nullOnDelete();
            });
    }

    public function down(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            $table->dropForeign(['head_teacher_id']);
            $table->dropColumn('head_teacher_id');
        });
    }
};
