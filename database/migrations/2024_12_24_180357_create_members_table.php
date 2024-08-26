<?php

use App\Enums\Shifts;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->foreignId('gym_id')->constrained('users','id');
            $table->string('serial_no');
            $table->string('dob')->nullable();
            $table->string('address');
            $table->string('contact_no');
            $table->string('email')->nullable();
            $table->enum('shifts', ['Morning', 'Day', 'Evening'])->default('Morning');
            $table->foreignId('pricing_id')->nullable()->constrained('pricing','id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
