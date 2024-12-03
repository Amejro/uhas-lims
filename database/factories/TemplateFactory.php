<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\DosageForm;
use App\Models\Template;
use App\Models\Test;
use App\Models\User;

class TemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Template::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'content' => '{}',
            'test_id' => Test::factory(),
            'dosage_form_id' => DosageForm::factory(),
            'user_id' => User::factory(),
        ];
    }
}
