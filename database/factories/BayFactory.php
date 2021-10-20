<?php

namespace Database\Factories;

use App\Models\Bay;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bay::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),

            'name'        => $this->faker->word(),
            'is_occupied' => false,
        ];
    }

    public function occupied()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_occupied' => true,
            ];
        });
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Bay $bay) {
            if ($bay->is_occupied) {
                Booking::factory()
                    ->make(['bay_id' => $bay->id]);
            }
        })->afterCreating(function (Bay $bay) {
            if ($bay->is_occupied) {
                Booking::factory()
                    ->create(['bay_id' => $bay->id]);
            }
        });
    }
}
