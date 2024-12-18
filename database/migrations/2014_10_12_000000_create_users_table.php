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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
	    $table->string('email')->unique();
            $table->string('document')->nullable();
            $table->string('valid_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
	    $table->enum('user_type', ['tenant', 'rental_owner', 'admin']); // Added 'admin'     
            $table->enum('status', ['pending', 'approaved'])->default('pending')->nullable(); 
	    $table->string('number')->nullable();
            $table->unsignedInteger('login_count')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
