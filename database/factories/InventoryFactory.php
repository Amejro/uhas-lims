<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Inventory;
use App\Models\StorageLocation;
use App\Models\User;

class InventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inventory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'unit' => $this->faker->word(),
            'total_quantity' => $this->faker->numberBetween(-10000, 10000),
            'reorder_level' => $this->faker->numberBetween(-10000, 10000),
            'expiry_date' => $this->faker->dateTime(),
            'status' => $this->faker->randomElement(["available",""]),
            'has_variant' => $this->faker->boolean(),
            'inventory_variant' => '{}',
            'storage_location_id' => StorageLocation::factory(),
            'user_id' => User::factory(),
        ];
    }
}
