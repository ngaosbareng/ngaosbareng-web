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
        // Add user_id to books table with nullable first, then update
        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
        });

        // Assign existing books to first user (or create default user)
        $defaultUserId = \App\Models\User::first()?->id ?? \App\Models\User::create([
            'name' => 'Default User',
            'email' => 'default@example.com',
            'password' => bcrypt('password'),
        ])->id;

        \App\Models\Book::whereNull('user_id')->update(['user_id' => $defaultUserId]);

        // Make user_id not nullable
        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
        });

        // Add user_id to masail table with nullable first, then update
        Schema::table('masail', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
        });

        // Assign existing masail to default user
        \App\Models\Masail::whereNull('user_id')->update(['user_id' => $defaultUserId]);

        // Make user_id not nullable
        Schema::table('masail', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
        });

        // Remove role column from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove user_id from books table
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        // Remove user_id from masail table
        Schema::table('masail', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        // Add role column back to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('member');
        });
    }
};
