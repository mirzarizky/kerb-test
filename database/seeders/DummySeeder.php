<?php

namespace Database\Seeders;

use App\Models\Bay;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = User::factory()->create(['email' => 'owner@email.com']);
        User::factory()->create(['email' => 'user@email.com']);
        User::factory()->create(['email' => 'user2@email.com']);

        Bay::factory()->count(3)->create(['user_id' => $owner]);
    }
}
