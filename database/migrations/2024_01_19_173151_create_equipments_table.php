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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->default('defaultequipment.jpg')->nullable();
            $table->string('serial_no');
            $table->decimal('weight', 8, 2)->nullable();
            $table->integer('qty')->nullable();
            $table->integer('maintenance_period')->nullable();
            $table->string('maintenance_type')->nullable();
            $table->date('upcoming_date')->nullable();
            $table->foreignId('gym_id')->constrained('users','id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
