<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserCompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'cnpj' => '12345678901234',
            'company_name' => $this->faker->company,
            'fantasy_name' => $this->faker->company,
            'municipal_registration' => '1234567890',
            'state_registration' => '1234567890',
        ];
    }
}
