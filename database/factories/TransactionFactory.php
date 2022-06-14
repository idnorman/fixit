<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date'  => Carbon::now()->subMinutes(rand(1, 55)),
            'note'  => $this->faker->sentence(10),
            'is_accepted' => $this->faker->randomElements(['waiting','accepted','rejected','finished']),
            'is_paid'   => $this->faker->random_int(0,1),
            'user_id'   => $this->faker->random_int()
            
        ];
    }
}
