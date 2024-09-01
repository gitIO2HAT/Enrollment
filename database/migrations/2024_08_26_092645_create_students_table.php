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
            $table->string('student_Id',10)->unique();
            $table->string('firstname', 30);
            $table->string('lastname',30);
            $table->string('middlename',30)->nullable();
            $table->unsignedBigInteger('suffix')->nullable();
            $table->unsignedBigInteger('collegeId');
            $table->unsignedBigInteger('courseId');
            $table->unsignedBigInteger('majorId');
            $table->unsignedBigInteger('year_level');
            $table->unsignedBigInteger('semester');
            $table->year('academic_year_start');
            $table->year('academic_year_end');
            $table->unsignedBigInteger('academic_award')->nullable();
            $table->enum('deleted',['1','2'])->default(1);
            $table->enum('sex',['1','2','3']);
            $table->timestamps();

            $table->foreign('collegeId')->references('id')->on('colleges')->onDelete('cascade');
            $table->foreign('courseId')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('majorId')->references('id')->on('majors')->onDelete('cascade');
            $table->foreign('year_level')->references('id')->on('year_level')->onDelete('cascade');
            $table->foreign('semester')->references('id')->on('semesters')->onDelete('cascade');
            $table->foreign('academic_award')->references('id')->on('awards')->onDelete('cascade');
            $table->foreign('suffix')->references('id')->on('suffix')->onDelete('cascade');
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
