<?php
namespace App\Services\Academy;
use App\Models\Academy\Package;
use App\Models\SeatLicense;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
class EntitlementService
{
    public function hasAccess(User $user, Package $package): bool
    {
        $cacheKey = "entitlement:{$user->id}:{$package->id}";
        return Cache::remember($cacheKey, now()->addMinutes(5), fn() =>
            SeatLicense::query()
                ->where('user_id', $user->id)
                ->where('package_id', $package->id)
                ->whereNull('revoked_at')
                ->exists()
        );
    }
    public function invalidateCache(int $userId, int $packageId): void
    {
        Cache::forget("entitlement:{$userId}:{$packageId}");
    }
    public function accessiblePackageIds(User $user): array
    {
        return SeatLicense::query()
            ->where('user_id', $user->id)
            ->whereNull('revoked_at')
            ->pluck('package_id')
            ->toArray();
    }
}
