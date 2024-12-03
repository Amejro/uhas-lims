<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\DosageForm;
use App\Models\Producer;
use App\Models\Sample;
use App\Models\StorageLocation;
use App\Models\User;

class SampleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sample::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'collection_date' => $this->faker->dateTime(),
            'active_ingredient' => $this->faker->word(),
            'delivered_by' => $this->faker->word(),
            'deliverer_contact' => $this->faker->word(),
            'indication' => $this->faker->word(),
            'status' => $this->faker->randomElement(["collected","in_progress","completed"]),
            'dosage' => $this->faker->word(),
            'date_of_manufacture' => $this->faker->dateTime(),
            'expiry_date' => $this->faker->dateTime(),
            'batch_number' => $this->faker->word(),
            'serial_code' => $this->faker->word(),
            'storage_location_id' => StorageLocation::factory(),
            'dosage_form_id' => DosageForm::factory(),
            'user_id' => User::factory(),
            'producer_id' => Producer::factory(),
            'total_cost' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
