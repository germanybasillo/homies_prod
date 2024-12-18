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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
	    $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('ownername');
            $table->string('number');
            $table->string('billingnameprice');
            $table->string('paymentmethod');
            $table->string('total');
            $table->string('fee');
	    $table->string('room');
                       $table->string('bed');
            $table->decimal('roomMonthly', 10, 2)->nullable();
            $table->decimal('bedMonthly', 10, 2)->nullable();
	    
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
