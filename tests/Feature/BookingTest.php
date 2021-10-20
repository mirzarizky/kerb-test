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

class BookingTest extends TestCase
{
    /** @test */
    public function user_can_book_a_bay()
    {
        // seed 3 available bays
        Bay::factory()->count(3)->create();

        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/booking')
            ->assertCreated();
        $this->assertDatabaseCount(app(Booking::class)->getTable(), 1);
    }

    /** @test */
    public function it_show_fully_booking_when_no_available_bay()
    {
        // seed 3 unavailable bays
        Bay::factory()->count(3)->occupied()->create();

        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/booking')
            ->assertNotFound()
            ->assertJson(['message' => 'Fully booked']);
    }
}
