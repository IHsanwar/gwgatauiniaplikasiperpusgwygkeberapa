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
        Schema::table('borrowings', function (Blueprint $table) {
            // Change enum values
            $table->enum('status', ['pending','pending_borrowing', 'borrowed', 'pending_return', 'returned'])
                  ->default('pending_borrowing')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'returned'])
                  ->default('pending')
                  ->change();
        });
    }
};