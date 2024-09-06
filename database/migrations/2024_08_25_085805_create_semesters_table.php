<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->string('status',12);
            $table->timestamps();
        });
        DB::table('semesters')->insert([
            [
                'status' => '1st Semester',
            ],
            [
                'status' => '2nd Semester',
            ],
            [
                'status' => 'Off Semester',
            ],
            [
                'status' => 'N/A',
            ],


        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
