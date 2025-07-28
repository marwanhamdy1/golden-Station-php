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
            // Drop the enum column and recreate as string to support custom values
            $table->dropColumn('met_person_role');
            $table->string('met_person_role', 100)->nullable()->after('met_person_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_visits', function (Blueprint $table) {
            // Revert back to enum
            $table->dropColumn('met_person_role');
            $table->enum('met_person_role', ['owner', 'manager', 'other'])->nullable()->after('met_person_name');
        });
    }
};
