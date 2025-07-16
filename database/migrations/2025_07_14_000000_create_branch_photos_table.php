<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branch_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->string('photo'); // مسار الصورة
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_photos');
    }
};
