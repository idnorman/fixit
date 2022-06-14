<?php

namespace Database\Factories;

use App\Models\PartnerService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PartnerService>
 */
class PartnerServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PartnerService::class;

    public function definition()
    {
        return [
            'price' => $this->faker->numberBetween('100000', '500000'),
            'partner_id' => $this->faker->random_int(1,10),
            'service_id' => $this->faker->random_int(1,4),
            'note'      => $this->faker->sentence(10)
        ];
    }
}
