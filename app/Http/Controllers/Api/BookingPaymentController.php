<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class BookingPaymentController extends Controller
{
    public function __invoke(Booking $booking)
    {
        abort_if($booking->user_id != auth()->id(), 403);

        if (!$booking->isPaid()) {
            $booking->load(['bay']);

            DB::transaction(function () use ($booking) {
                $booking->paid_at = now();
                $booking->bay->is_occupied =  false;
                $booking->push();
            });
        }

        return new BookingResource($booking->load(['bay']));
    }
}
