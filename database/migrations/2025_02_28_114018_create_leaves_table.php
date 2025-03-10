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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();  // Primary keys are automatically indexed

            $table->string('auth0_user_id');
            $table->index('auth0_user_id');
            // Indexed because:
            // - Foreign key equivalent
            // - Frequently used to find user's leaves
            // - Used in joins/relations

            $table->string('type');
            // No index needed if you have a small number of types
            // and don't frequently query by type alone

            $table->date('start_date');
            $table->index('start_date');
            // Indexed because:
            // - You'll likely search by date ranges
            // - Used in reports/filters
            // - Used for sorting

            $table->date('end_date');
            $table->index('end_date');
            // Same reasons as start_date

            $table->string('status')->default('pending');
            $table->index('status');
            // Indexed because:
            // - Frequently filtered (show all pending, approved, etc.)
            // - Small field, efficient to index
            // - Used in many queries

            $table->text('comments')->nullable();
            // Don't index because:
            // - Text fields are large
            // - Rarely searched
            // - If needed, use fulltext index for search

            $table->integer('days')->nullable();

            $table->string('justification_file_path')->nullable();
            // Don't index because:
            // - Only accessed when viewing specific record
            // - Not used in searches/filters

            $table->timestamps();
            // created_at might be worth indexing if you frequently
            // sort by creation date or do date-based queries
            // $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
