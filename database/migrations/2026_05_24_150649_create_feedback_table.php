<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('rating_overall')->nullable();
            $table->integer('rating_content')->nullable();
            $table->integer('rating_platform')->nullable();
            $table->boolean('would_recommend')->nullable();
            $table->text('liked')->nullable();
            $table->text('improve')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('feedback'); }
};
