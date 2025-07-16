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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->string('name');
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('location_url')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->foreignId('agent_id')->nullable()->constrained('agents')->onDelete('set null');
            $table->string('signboard_photo')->nullable(); // صورة يافطة المحل
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
