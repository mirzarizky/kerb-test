<?php

namespace App\Actions;

use App\Models\Bay;
use Lorisleiva\Actions\Concerns\AsAction;

class FindAvailableBay
{
    use AsAction;

    public function handle(): Bay|null
    {
        $bay = Bay::where('is_occupied', false)->first();

        return $bay;
    }
}
