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
        Schema::create('vendor_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade'); // Vendor ID
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade'); // Branch ID
            $table->foreignId('agent_id')->constrained('agents')->nullable(); // Agent who visited
            $table->dateTime('visit_date'); // Visit date and time
            $table->text('notes')->nullable(); // General notes
            $table->enum('visit_status', ['visited', 'closed', 'not_found', 'refused'])->default('visited'); // Visit status: visited/closed/not found/refused
            $table->enum('vendor_rating', ['very_interested', 'hesitant', 'refused', 'inappropriate'])->nullable(); // Vendor rating: very interested/hesitant/refused/inappropriate
            $table->string('audio_recording')->nullable(); // Optional audio recording file path
            $table->string('video_recording')->nullable(); // Optional video recording file path
            $table->text('agent_notes')->nullable(); // Notes visible to vendor
            $table->text('internal_notes')->nullable(); // Internal notes (not visible to vendor)
            $table->string('signature_image')->nullable(); // Signature image file path
            $table->string('gps_latitude')->nullable(); // GPS latitude at visit
            $table->string('gps_longitude')->nullable(); // GPS longitude at visit
            $table->enum('selected_package', ['basic', 'advanced', 'premium', 'free'])->nullable(); // Selected package
            $table->decimal('package_price', 10, 2)->nullable(); // Package price
            $table->timestamp('visit_end_at')->nullable(); // Visit end timestamp
            $table->string('met_person_name')->nullable(); // اسم المسؤول الذي قابله
            $table->enum('met_person_role', ['owner', 'manager', 'other'])->nullable(); // الدور: صاحب محل أو مدير أو آخر
            $table->boolean('delivery_service_requested')->nullable(); // طلب خدمة توصيل
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_visits');
    }
};
