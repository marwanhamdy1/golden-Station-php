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
            $table->string('custom_role')->nullable()->after('met_person_role'); // Custom role as string
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_visits', function (Blueprint $table) {
            $table->dropColumn('custom_role');
        });
    }
};
