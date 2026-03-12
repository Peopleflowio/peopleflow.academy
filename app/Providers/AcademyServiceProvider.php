<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Services\Academy\{EntitlementService, VideoUrlService, ProgressService, SeatService, ContentService};
class AcademyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(EntitlementService::class);
        $this->app->singleton(VideoUrlService::class);
        $this->app->singleton(ProgressService::class);
        $this->app->singleton(SeatService::class, function ($app) {
            return new SeatService($app->make(EntitlementService::class));
        });
        $this->app->singleton(ContentService::class, function ($app) {
            return new ContentService($app->make(VideoUrlService::class));
        });
    }
    public function boot(): void {}
}
