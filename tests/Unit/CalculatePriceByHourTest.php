<?php

namespace Tests\Unit;

use App\Actions\CalculatePriceByHour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalculatePriceByHourTest extends TestCase
{
    /** @test */
    public function action_class_exists()
    {
        $this->assertTrue(class_exists(CalculatePriceByHour::class));
    }

    /** @test */
    public function calculate_price()
    {
        $start_time = now();

        $this->travelTo(now()->addMinutes(45));
        $price = CalculatePriceByHour::run($start_time);
        $this->assertEquals(0, $price);
        $this->travelBack();

        $this->travelTo(now()->addMinutes(65));
        $price = CalculatePriceByHour::run($start_time);
        $this->assertEquals(20, $price);
        $this->travelBack();

        $this->travelTo(now()->addHours(3));
        $price = CalculatePriceByHour::run($start_time);
        $this->assertEquals(240, $price);
        $this->travelBack();

        $this->travelTo(now()->addHours(6));
        $price = CalculatePriceByHour::run($start_time);
        $this->assertEquals(300, $price);
    }
}
