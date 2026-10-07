<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('employee_id', 50);
            $table->string('qualification');
            $table->string('specialization')->nullable();
            $table->date('hire_date');
            $table->decimal('salary', 10, 2)->nullable();
            $table->enum('status', ['active', 'on_leave', 'terminated'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['school_id', 'employee_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('teachers');
    }
};
