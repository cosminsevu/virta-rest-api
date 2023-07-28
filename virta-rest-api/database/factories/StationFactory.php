<?php

namespace Database\Factories;

use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

class StationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Station::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word, // Generate a random station name
            'latitude' => $this->faker->latitude, // Generate a random latitude
            'longitude' => $this->faker->longitude, // Generate a random longitude
            'company_id' => rand(1, 10), // Generate a random company ID (assuming there are 10 companies)
            'address' => $this->faker->address, // Generate a random address
            
        ];
    }
}