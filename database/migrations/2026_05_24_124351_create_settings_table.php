<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            ['key' => 'referral_commission_percent', 'value' => '20', 'description' => 'Commission % paid to referrer on first purchase', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'referral_min_payout', 'value' => '3', 'description' => 'Minimum referrals before payout request allowed', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
    public function down(): void { Schema::dropIfExists('settings'); }
};
