<?php

namespace App\Helpers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BookingHelper
{
    /**
     * Check overlap antara booking baru dan conflict (yang span banyak hari).
     *
     * @param Carbon $start Booking baru mula
     * @param Carbon $end Booking baru habis
     * @param Carbon $conflictStart Conflict mula (dari DB)
     * @param Carbon $conflictEnd Conflict habis (dari DB)
     * @return bool
     */
    public static function isClash(Carbon $start, Carbon $end, Carbon $conflictStart, Carbon $conflictEnd): bool
    {
        // Ambil range harian conflict
        $period = CarbonPeriod::create($conflictStart->copy()->startOfDay(), $conflictEnd->copy()->startOfDay());

        foreach ($period as $day) {
            $dayStart = $day->copy()->setTime($conflictStart->hour, $conflictStart->minute);
            $dayEnd   = $day->copy()->setTime($conflictEnd->hour, $conflictEnd->minute);

            if ($day->isSameDay($conflictStart)) {
                $dayStart = $conflictStart;
            }
            if ($day->isSameDay($conflictEnd)) {
                $dayEnd = $conflictEnd;
            }

            // Check clash ikut hari yang sama
            if ($start->toDateString() === $day->toDateString()) {
                if ($start < $dayEnd && $end > $dayStart) {
                    return true;
                }
            }
        }

        return false;
    }
}
