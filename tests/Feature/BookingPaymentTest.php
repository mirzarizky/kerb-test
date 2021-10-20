<?php

namespace Tests\Feature;

use App\Models\Bay;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookingPaymentTest extends TestCase
{
    /** @test */
    public function user_can_pay_booking()
    {
        /** @var User */
        $user = User::factory()->create();
        /** @var Bay */
        $bay = Bay::factory()->occupied()->create();
        /** @var Booking */
        $booking = Booking::factory()->create([
            'user_id' => $user,
            'bay_id'  => $bay
        ]);

        Sanctum::actingAs($user);

        // assert booking is not paid yet
        $this->assertEquals(false, $booking->isPaid());
        // assert bay is occupied
        $this->assertEquals(true, $bay->is_occupied);
        // perform payment
        $this->postJson("/api/booking/pay/{$booking->getKey()}")
            ->assertOk();
        // assert booking was paid
        $this->assertEquals(true, ($booking->fresh())->isPaid());
        // assert bay is not occupied
        $this->assertEquals(false, ($bay->fresh())->is_occupied);
    }

    /** @test */
    public function user_cannot_pay_others_booking()
    {
        /** @var User */
        $currentUser = User::factory()->create();
        /** @var Booking */
        $booking = Booking::factory()->create([
            'user_id' => User::factory()->create(), // other user
            'bay_id'  => Bay::factory()->occupied()->create(),
        ]);

        Sanctum::actingAs($currentUser);

        $this->postJson("/api/booking/pay/{$booking->getKey()}")
            ->assertForbidden();
    }
}
