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
        Schema::create('exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->foreignId('masail_id')->constrained()->cascadeOnDelete();
            $table->foreignId('discussion_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_correct')->nullable(); // true if the discussion is related to masail, false if not, null if not answered yet
            $table->boolean('user_answer')->nullable(); // user's answer: true = related, false = not related
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_answers');
    }
};
