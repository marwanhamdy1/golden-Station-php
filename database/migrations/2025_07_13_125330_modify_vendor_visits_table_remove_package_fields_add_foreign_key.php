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
            // Remove the old package fields
            $table->dropColumn(['selected_package', 'package_price']);

            // Add the new foreign key
            $table->foreignId('package_id')->nullable()->constrained('packages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_visits', function (Blueprint $table) {
            // Remove the foreign key
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');

            // Add back the old fields
            $table->enum('selected_package', ['basic', 'advanced', 'premium', 'free'])->nullable();
            $table->decimal('package_price', 10, 2)->nullable();
        });
    }
};
