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
        Schema::table('vendor_visits', function (Blueprint $table) {
            $table->string('google_maps_url')->nullable()->after('gps_longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_visits', function (Blueprint $table) {
            $table->dropColumn('google_maps_url');
        });
    }
};
