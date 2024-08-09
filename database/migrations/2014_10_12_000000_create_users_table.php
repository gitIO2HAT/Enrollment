<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->tinyInteger('user_type')->default(0);
            $table->string('password');
            $table->enum('sex', ['Male', 'Female', 'Other']);
            $table->string('admin_id', 20)->unique()->nullable(); // Add custom_id column here
            $table->enum('deleted', ['1', '2'])->default('1');
            $table->enum('civil_status', ['Single', 'Married', 'Widowed'])->nullable();
            $table->text('description')->nullable();
            $table->enum('questions', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'])->nullable();
            $table->string('answer')->nullable();
            $table->string('profile_pic', 255)->default('default.png');

            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert([
            [
                'name' => 'SuperAdmin',
                'username' => 'superadmin',
                'password' => '$2y$12$rtB0bLm5O.eHAz8czKUCwee.JBk1kziejszCU4FYP8TXobrQ5rLE2',
                'user_type' => 0,
                'profile_pic' => 'superadmin.png',
                'sex' => 'Other',
                'admin_id' => '2024-00001',
                'deleted' => '1',
                'civil_status' => 'Single',
                'questions' => '7',
                'answer' => 'usep',
                'fulladdress' => 'Usep Obrero',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
            // Add other users as needed
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
