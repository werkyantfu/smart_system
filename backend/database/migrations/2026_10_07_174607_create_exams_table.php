<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('term', 20);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->index(['school_id', 'term']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('exams');
    }
};
