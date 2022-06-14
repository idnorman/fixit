<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Partner::class;

    public function definition()
    {

        $users = User::select('id')->where('role', 'partner')->get()->pluck();

        return [
            'name'  => $this->faker->company(),
            'description' => $this->faker->sentence(10),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'user_id' => $this->faker->random_int(1,10)
        ];
    }
}
