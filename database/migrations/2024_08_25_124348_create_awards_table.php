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
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->string('status',17);
            $table->timestamps();
        });
        DB::table('awards')->insert([
            [
                'status' => 'Magna Cum Laude',
            ],
            [
                'status' => 'Summa Cum Laude',
            ],
            [
                'status' => 'Cum Laude',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awards');
    }
};
