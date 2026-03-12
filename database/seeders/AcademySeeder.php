<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Academy\{Package, PackageModule, Lesson, LessonStep};
use Spatie\Permission\Models\Role;

class AcademySeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        Role::firstOrCreate(['name' => 'platform_admin']);
        Role::firstOrCreate(['name' => 'org_admin']);
        Role::firstOrCreate(['name' => 'learner']);

        // Create sample package
        $package = Package::create([
            'slug'         => 'core-hr-foundations',
            'title'        => 'Core HR Foundations',
            'description'  => 'Master staffing, employee records, and organizational structures.',
            'emoji_icon'   => '🏢',
            'price_cents'  => 29900,
            'currency'     => 'usd',
            'is_published' => true,
            'sort_order'   => 1,
        ]);

        $module = PackageModule::create([
            'package_id'  => $package->id,
            'title'       => 'Module 1 — Staffing Actions',
            'description' => 'Core employee lifecycle processes',
            'emoji_icon'  => '👥',
            'sort_order'  => 1,
        ]);

        $lessons = [
            ['Hire Employee — New Worker',  'staffing', 'intermediate', 1102],
            ['Terminate Employee',          'staffing', 'intermediate', 1330],
            ['Change Job',                  'staffing', 'beginner',     1185],
            ['Create Position',             'org',      'beginner',      930],
            ['Edit Position Restrictions',  'org',      'advanced',     1205],
        ];

        foreach ($lessons as $i => [$title, $type, $diff, $dur]) {
            $lesson = Lesson::create([
                'module_id'        => $module->id,
                'title'            => $title,
                'process_type'     => $type,
                'difficulty'       => $diff,
                'duration_seconds' => $dur,
                'is_published'     => $i < 4,
                'sort_order'       => $i + 1,
            ]);

            if ($i === 0) {
                LessonStep::insert([
                    ['lesson_id' => $lesson->id, 'title' => 'Navigate to Staffing', 'nav_path' => 'Menu → Staffing → Hire Employee', 'sort_order' => 1, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
                    ['lesson_id' => $lesson->id, 'title' => 'Enter Personal Information', 'nav_path' => null, 'sort_order' => 2, 'description' => 'Fill name, address, contact details.', 'created_at' => now(), 'updated_at' => now()],
                    ['lesson_id' => $lesson->id, 'title' => 'Assign Position', 'nav_path' => 'Position → Search → Select', 'sort_order' => 3, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
                    ['lesson_id' => $lesson->id, 'title' => 'Configure Compensation', 'nav_path' => 'Compensation → Assign', 'sort_order' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
                    ['lesson_id' => $lesson->id, 'title' => 'Submit for Approval', 'nav_path' => null, 'sort_order' => 5, 'description' => 'Route through approval chain.', 'created_at' => now(), 'updated_at' => now()],
                ]);
            }
        }

        $this->command->info('✓ Roles created: platform_admin, org_admin, learner');
        $this->command->info('✓ 1 package, 1 module, 5 lessons seeded');
    }
}
