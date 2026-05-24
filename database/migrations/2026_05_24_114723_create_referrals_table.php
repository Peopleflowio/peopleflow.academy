<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('referred_id')->constrained('users')->onDelete('cascade');
            $table->string('code');
            $table->enum('status', ['pending','converted'])->default('pending');
            $table->unsignedInteger('reward_cents')->default(0);
            $table->timestamp('converted_at')->nullable();
            $table->timestamps();
        });

        // Add referral_code column to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('referral_code', 20)->unique()->nullable()->after('email');
        });
    }
    public function down(): void {
        Schema::dropIfExists('referrals');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('referral_code');
        });
    }
};
