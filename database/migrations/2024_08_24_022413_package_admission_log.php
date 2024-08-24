<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_admission_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained('members', 'id');
            $table->foreignId('gym_id')->nullable()->constrained('users', 'id');
            $table->foreignId('package_id')->nullable()->constrained('pricing', 'id');
            $table->decimal('admission_price', 8, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_admission_log');
    }
};