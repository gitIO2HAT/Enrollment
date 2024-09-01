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
        Schema::create('suffix', function (Blueprint $table) {
            $table->id();
            $table->string('status',5);
            $table->timestamps();
        });
        DB::table('suffix')->insert([
            [
                'status' => 'Jr.',
            ],
            [
                'status' => 'Sr.',
            ],
            [
                'status' => 'I',
            ],
            [
                'status' => 'II',
            ],
            [
                'status' => 'III',
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suffix');
    }
};
