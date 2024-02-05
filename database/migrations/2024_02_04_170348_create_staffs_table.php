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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->default('defaultimage.jpg')->nullable();
            $table->foreignId('gym_id')->constrained('users','id');
            $table->string('serial_no');
            $table->string('dob')->nullable();
            $table->string('address');
            $table->string('contact_no');
            $table->string('position');
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};
