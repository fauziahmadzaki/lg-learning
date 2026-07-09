<?php

namespace App\Services;

use App\Models\Package;

class PackagePricingService
{
    public function calculateAmount(Package $package, string $billingCycle): float
    {
        $isDailyRate = $package->duration < 30;

        return match ($billingCycle) {
            'daily' => $isDailyRate ? $package->price : ceil($package->price / 30),
            'weekly' => $isDailyRate ? ($package->price * 7) : ceil($package->price / 4),
            'monthly' => $isDailyRate ? ($package->price * 30) : $package->price,
            'full' => $isDailyRate
                ? $package->price * $package->duration
                : $package->price * max(1, ceil($package->duration / 30)),
            default => $package->price,
        };
    }

    public function calculateAmountWithRemainingDays(
        Package $package,
        string $billingCycle,
        ?int $remainingDays = null
    ): float {
        $amount = $this->calculateAmount($package, $billingCycle);

        if ($remainingDays === null) {
            return $amount;
        }

        $cycleDays = match ($billingCycle) {
            'monthly' => 30,
            'weekly' => 7,
            'daily' => 1,
            default => 30,
        };

        if ($remainingDays >= $cycleDays) {
            return $amount;
        }

        return $remainingDays <= 0 ? 0 : ceil($amount / $cycleDays * $remainingDays);
    }

    public function getCycleDays(string $billingCycle): int
    {
        return match ($billingCycle) {
            'monthly' => 30,
            'weekly' => 7,
            'daily' => 1,
            default => 30,
        };
    }

    public function getToleranceDays(string $billingCycle): int
    {
        $cycleDays = $this->getCycleDays($billingCycle);
        return $cycleDays === 1 ? 0 : (int) ceil($cycleDays * 0.2);
    }

    public function getMaxBills(Package $package, string $billingCycle): int
    {
        return match ($billingCycle) {
            'daily' => (int) ceil($package->duration),
            'weekly' => (int) ceil($package->duration / 7),
            'monthly' => (int) ceil($package->duration / 30),
            default => 999,
        };
    }

    public function isFullCycle(string $billingCycle): bool
    {
        return $billingCycle === 'full';
    }

    public function isDailyRate(Package $package): bool
    {
        return $package->duration < 30;
    }
}
