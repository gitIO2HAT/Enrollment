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
            $table->string('name',120);
            $table->string('username',30)->unique();
            $table->tinyInteger('user_type')->default(0);
            $table->string('password');
            $table->enum('sex', ['1', '2', '3']);
            $table->string('admin_id', 20)->unique()->nullable(); // Add custom_id column here
            $table->enum('deleted', ['1', '2'])->default('1');
            $table->text('role',30)->nullable();
            $table->enum('questions', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'])->nullable();
            $table->string('answer',30)->nullable();
            $table->string('profile_pic', 100)->default('default.png');

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
                'sex' => '3',
                'admin_id' => '2024-adm-001',
                'deleted' => '1',
                'questions' => '7',
                'answer' => 'usep',
                'role' => 'Usep Obrero',
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
