<?php

namespace App\Services;

use App\Models\Package;
use Carbon\Carbon;

class BillingDateService
{
    public function __construct(
        private PackagePricingService $pricing
    ) {}

    public function advanceNextBillingDate(Carbon $currentDueDate, string $billingCycle, ?int $packageDuration = null): Carbon
    {
        $nextDate = $currentDueDate->copy();

        return match ($billingCycle) {
            'daily' => $nextDate->addDay(),
            'weekly' => $nextDate->addWeek(),
            'monthly' => $nextDate->addMonth(),
            'full' => $nextDate->addDays($packageDuration ?? 30),
            default => $nextDate,
        };
    }

    public function isPeriodOver(
        Carbon $nextBillingDate,
        Carbon $endDate,
        string $billingCycle
    ): bool {
        $cutoffDate = $this->getCutoffDate($endDate, $billingCycle);
        return $nextBillingDate->greaterThanOrEqualTo($cutoffDate);
    }

    public function getCutoffDate(Carbon $endDate, string $billingCycle): Carbon
    {
        $toleranceDays = $this->pricing->getToleranceDays($billingCycle);
        return $endDate->copy()->subDays($toleranceDays);
    }

    public function getEndDate(Carbon $joinDate, Package $package): Carbon
    {
        return $joinDate->copy()->addDays($package->duration);
    }
}
