<?php

namespace Database\Factories;

use App\Models\Bay;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'bay_id'  => Bay::factory(),
            'user_id' => User::factory(),

            'start_time' => now(),
            'paid_at'    => null,
        ];
    }

    public function paid()
    {
        return $this->state(function (array $attributes) {
            return [
                'paid_at' => now(),
            ];
        });
    }
}
