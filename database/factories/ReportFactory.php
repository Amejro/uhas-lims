<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Report;
use App\Models\Sample;
use App\Models\User;

class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sample_id' => Sample::factory(),
            'report_date' => $this->faker->dateTime(),
            'user_id' => User::factory(),
        ];
    }
}
