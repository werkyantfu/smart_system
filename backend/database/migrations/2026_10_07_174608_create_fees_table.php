<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->enum('fee_type', ['tuition', 'transport', 'cafeteria', 'library', 'uniform']);
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->enum('status', ['pending', 'paid', 'overdue', 'partial'])->default('pending');
            $table->timestamps();

            $table->index(['student_id', 'status']);
            $table->index('due_date');
        });
    }
    public function down(): void {
        Schema::dropIfExists('fees');
    }
};
