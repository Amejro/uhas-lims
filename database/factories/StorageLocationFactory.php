<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\StorageLocation;

class StorageLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StorageLocation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'room' => $this->faker->word(),
            'freezer' => $this->faker->word(),
            'shelf' => $this->faker->word(),
        ];
    }
}
