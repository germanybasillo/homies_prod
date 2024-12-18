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
        Schema::create('selectbeds', function (Blueprint $table) {
	    $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bed_no');
            $table->string('description');
            $table->enum('bed_status', ['available', 'occupied'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selectbeds');
    }
};
