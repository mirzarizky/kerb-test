<?php

namespace Tests\Feature;

use App\Models\Bay;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

use function PHPUnit\Framework\assertJson;

class BookingPriceTest extends TestCase
{
    /** @test */
    public function user_can_get_their_booking_price()
    {
        /** @var User */
        $user = User::factory()->create();
        /** @var Booking */
        $booking = Booking::factory()->create([
            'start_time' => now(),
            'user_id'    => $user,
            'bay_id'     => Bay::factory()->occupied()->create(),
        ]);

        Sanctum::actingAs($user);

        $this->getJson("/api/booking/price/{$booking->getKey()}")
            ->assertOk()
            ->assertJson([
                'price' => 0,
            ]);

        // time travel to next 1 hour
        $this->travelTo(now()->addHour());
        $this->getJson("/api/booking/price/{$booking->getKey()}")
            ->assertOk()
            ->assertJson([
                'price' => 20,
            ]);

        // time travel to next 1+1 hour
        $this->travelTo(now()->addHour());
        $this->getJson("/api/booking/price/{$booking->getKey()}")
            ->assertOk()
            ->assertJson([
                'price' => 60,
            ]);

        // time travel to next 1+1+1 hour
        $this->travelTo(now()->addHour());
        $this->getJson("/api/booking/price/{$booking->getKey()}")
            ->assertOk()
            ->assertJson([
                'price' => 240,
            ]);

        // time travel to next 1+1+1+1 hour
        $this->travelTo(now()->addHour());
        $this->getJson("/api/booking/price/{$booking->getKey()}")
            ->assertOk()
            ->assertJson([
                'price' => 300,
            ]);
    }

    /** @test */
    public function user_cannot_check_price_others_booking()
    {
        /** @var User */
        $currentUser = User::factory()->create();
        /** @var Booking */
        $booking = Booking::factory()->create([
            'user_id' => User::factory()->create(), // other user
            'bay_id'  => Bay::factory()->occupied()->create(),
        ]);

        Sanctum::actingAs($currentUser);

        $this->getJson("/api/booking/price/{$booking->getKey()}")
            ->assertForbidden();
    }

    /** @test */
    public function user_cannot_check_price_paid_booking()
    {
        /** @var User */
        $currentUser = User::factory()->create();
        /** @var Booking */
        $booking = Booking::factory()
            ->paid()
            ->create([
                'user_id' => User::factory()->create(), // other user
                'bay_id'  => Bay::factory()->occupied()->create(),
            ]);

        Sanctum::actingAs($currentUser);

        $this->getJson("/api/booking/price/{$booking->getKey()}")
            ->assertForbidden();
    }
}
