<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->string('category')->default('General');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default FAQs
        DB::table('faqs')->insert([
            ['question' => 'How do I access my enrolled courses?', 'answer' => 'After enrolling, go to your Dashboard and click on the course. All your enrolled courses appear in the Catalog with a "Continue" button.', 'category' => 'Getting Started', 'sort_order' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['question' => 'Can I download the course videos?', 'answer' => 'Videos are streamed directly and cannot be downloaded. You have lifetime access to watch them anytime online.', 'category' => 'Getting Started', 'sort_order' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['question' => 'How do I get my certificate?', 'answer' => 'Complete all lessons in a course package. Once 100% complete, a "Get Certificate" button appears on the course page. You can print or download it as PDF.', 'category' => 'Certificates', 'sort_order' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['question' => 'Can I share my certificate on LinkedIn?', 'answer' => 'Yes! Print or download your certificate as PDF and upload it to your LinkedIn profile under Licenses & Certifications.', 'category' => 'Certificates', 'sort_order' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['question' => 'How does the referral program work?', 'answer' => 'Share your unique referral link from the Referrals page. When someone registers and purchases a course using your link, you earn 20% commission on their first purchase.', 'category' => 'Referrals', 'sort_order' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['question' => 'When can I request a payout?', 'answer' => 'You need a minimum of 3 converted referrals before requesting a payout. Once eligible, go to Referrals and click Request Payout. Payments are processed within 5 business days.', 'category' => 'Referrals', 'sort_order' => 6, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['question' => 'What payment methods are accepted?', 'answer' => 'We accept all major credit and debit cards via Stripe. Payments are processed securely and you receive an enrollment confirmation email immediately.', 'category' => 'Payments', 'sort_order' => 7, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['question' => 'Can I get a refund?', 'answer' => 'Please contact us at academy@peopleflow.io within 7 days of purchase if you are not satisfied. We review refund requests on a case by case basis.', 'category' => 'Payments', 'sort_order' => 8, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['question' => 'How do I retake a quiz?', 'answer' => 'You can retake quizzes unlimited times. Go to your course page and click Take Quiz. Your best score will be used for your certificate.', 'category' => 'Quizzes', 'sort_order' => 9, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['question' => 'Who do I contact for support?', 'answer' => 'Email us at academy@peopleflow.io and we will get back to you within 24 hours on business days.', 'category' => 'Support', 'sort_order' => 10, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
    public function down(): void { Schema::dropIfExists('faqs'); }
};
