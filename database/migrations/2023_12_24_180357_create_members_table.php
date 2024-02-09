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
            $table->foreignId('user_id')->constrained('users','id');
            $table->string('serial_no');
            $table->string('dob')->nullable();
            $table->string('address');
            $table->string('contact_no');
            $table->string('email')->nullable();
            $table->string('package')->nullable();//adding as fk form pricing
            $table->integer('shifts')->default(Shifts::Morning);
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
