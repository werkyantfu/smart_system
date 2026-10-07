<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('exam_id')->nullable(); // ← FK አስወግደን
            $table->decimal('score', 5, 2);
            $table->string('grade', 2)->nullable();
            $table->string('term', 20)->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'exam_id']);
            $table->index(['student_id', 'term']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('marks');
    }
};
