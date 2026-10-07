<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('student_id', 50);
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female']);
            $table->text('address')->nullable();
            $table->string('guardian_name');
            $table->string('guardian_phone', 20);
            $table->integer('grade_level');
            $table->string('section', 10)->nullable();
            $table->date('enrollment_date');
            $table->enum('status', ['enrolled', 'active', 'transferred', 'graduated'])->default('enrolled');
            $table->string('photo_url')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['school_id', 'student_id']);
            $table->index(['school_id', 'grade_level', 'section']);
            $table->index('guardian_phone');
        });
    }
    public function down(): void {
        Schema::dropIfExists('students');
    }
};
