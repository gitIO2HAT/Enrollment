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
        Schema::create('year_level', function (Blueprint $table) {
            $table->id();
            $table->string('status',10);
            $table->timestamps();
        });
        DB::table('year_level')->insert([
            [
                'status' => '1st Year',
            ],
            [
                'status' => '2nd Year',
            ],
            // Add other year levels as needed
            [
                'status' => '3rd Year',
            ],
            [
                'status' => '4th Year',
            ],
            [
                'status' => '5th Year',
            ],
            [
                'status' => 'Graduated',
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('year_level');
    }
};
