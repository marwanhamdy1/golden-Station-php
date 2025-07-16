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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('owner_name'); // اسم صاحب النشاط
            $table->string('commercial_name'); // الاسم التجاري
            $table->string('commercial_registration_number')->nullable(); // رقم الهوية أو السجل التجاري
            $table->string('mobile');
            $table->string('whatsapp')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('instagram')->nullable();
            $table->string('email')->nullable();
            $table->string('location_url')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->enum('activity_type', ['wholesale', 'retail', 'both'])->nullable();
            $table->date('activity_start_date')->nullable();
            $table->enum('has_commercial_registration', ['yes', 'no', 'not_sure'])->nullable();
            $table->boolean('has_online_platform')->nullable();
            $table->text('previous_platform_experience')->nullable();
            $table->text('previous_platform_issues')->nullable();
            $table->boolean('has_product_photos')->nullable();
            $table->text('notes')->nullable();
            $table->string('shop_front_image')->nullable();
            $table->string('commercial_registration_image')->nullable();
            $table->string('id_image')->nullable();
            $table->string('other_attachments')->nullable();
            $table->text('natural_photos')->nullable(); // صور طبيعية
            $table->text('license_photos')->nullable(); // صور الرخصة
            $table->string('license_number')->nullable(); // رقم الرخصة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
