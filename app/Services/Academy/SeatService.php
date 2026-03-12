<?php
namespace App\Services\Academy;
use App\Models\{Purchase, SeatLicense, User, Organization, AdminAuditLog};
use App\Models\Academy\Package;
class SeatService
{
    public function __construct(private EntitlementService $entitlement) {}
    public function createSeats(Purchase $purchase): void
    {
        $seats = [];
        for ($i = 0; $i < $purchase->seat_count; $i++) {
            $seats[] = [
                'purchase_id'     => $purchase->id,
                'organization_id' => $purchase->organization_id,
                'package_id'      => $purchase->package_id,
                'user_id'         => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }
        SeatLicense::insert($seats);
    }
    public function assignSeat(Organization $org, Package $package, User $user): SeatLicense
    {
        $existing = SeatLicense::query()
            ->where('organization_id', $org->id)
            ->where('package_id', $package->id)
            ->where('user_id', $user->id)
            ->whereNull('revoked_at')
            ->first();
        if ($existing) return $existing;
        $seat = SeatLicense::query()
            ->where('organization_id', $org->id)
            ->where('package_id', $package->id)
            ->whereNull('user_id')
            ->whereNull('revoked_at')
            ->lockForUpdate()
            ->first();
        if (!$seat) throw new \RuntimeException('No available seats for this package.');
        $seat->update(['user_id' => $user->id, 'assigned_at' => now()]);
        $this->entitlement->invalidateCache($user->id, $package->id);
        return $seat;
    }
    public function revokeSeat(SeatLicense $seat): void
    {
        $userId    = $seat->user_id;
        $packageId = $seat->package_id;
        $seat->update(['revoked_at' => now()]);
        if ($userId) $this->entitlement->invalidateCache($userId, $packageId);
    }
    public function availableSeats(Organization $org, Package $package): int
    {
        return SeatLicense::query()
            ->where('organization_id', $org->id)
            ->where('package_id', $package->id)
            ->whereNull('user_id')
            ->whereNull('revoked_at')
            ->count();
    }
}
