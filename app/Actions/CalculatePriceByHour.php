<?php

namespace App\Actions;

use Illuminate\Support\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class CalculatePriceByHour
{
    use AsAction;

    public function handle(Carbon $start_time): int
    {
        $duration = $start_time->floatDiffInHours(now());

        if (!$duration || $duration < 0) {
            throw new \InvalidArgumentException('not supported');
        }

        if ($duration > 0 && $duration < 1) {
            return 0;
        } elseif ($duration > 1 && $duration < 2) {
            return 20;
        } elseif ($duration > 2 && $duration < 3) {
            return 60;
        } elseif ($duration > 3 && $duration < 4) {
            return 240;
        } else { // ($duration > 4)
            return 300;
        }
    }
}
