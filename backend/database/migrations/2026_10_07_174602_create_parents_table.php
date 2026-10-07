<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('phone', 20);
            $table->enum('relation', ['father', 'mother', 'guardian']);
            $table->string('occupation')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();

            $table->index('phone');
        });
    }
    public function down(): void {
        Schema::dropIfExists('parents');
    }
};
