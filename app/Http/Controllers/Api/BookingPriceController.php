<?php

namespace App\Http\Controllers\Api;

use App\Actions\CalculatePriceByHour;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BookingPriceController extends Controller
{
    public function __invoke(Booking $booking)
    {
        abort_if($booking->user_id != auth()->id(), 403);
        abort_if($booking->isPaid(), 403, 'Booking already paid.');

        $price = CalculatePriceByHour::run($booking->start_time);

        return Response::json([
            'price' => $price
        ]);
    }
}
