<?php

namespace App\Http\Controllers\Api;

use App\Actions\FindAvailableBay;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        /** @var \App\Models\Bay|null */
        $bay = FindAvailableBay::run();

        abort_if(!$bay, 404, 'Fully booked');

        // to avoid race condition we use atomic locks
        // @see https://laravel.com/docs/8.x/cache#atomic-locks
        $lock = Cache::lock("bay.{$bay->getKey()}", 10);

        try {
            $lock->block(5);

            $booking = DB::transaction(function () use ($bay) {
                $newBooking = Booking::create([
                    'bay_id'  => $bay->id,
                    'user_id' => auth()->id(),

                    'start_time' => now(),
                    'paid_at'    => null,
                ]);

                $bay->fill(['is_occupied' => true])
                    ->save();

                return $newBooking;
            });
        } catch (LockTimeoutException $e) {
            return;
        } finally {
            optional($lock)->release();
        }

        return Response::json(new BookingResource($booking), 201);
    }
}
