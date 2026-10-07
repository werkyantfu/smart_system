<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->string('name', 100);
            $table->integer('grade_level');
            $table->string('section', 10);
            $table->integer('capacity')->default(40);
            $table->timestamps();

            $table->unique(['school_id', 'grade_level', 'section']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('classes');
    }
};
