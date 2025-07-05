<?php

namespace Database\Factories;

use App\Models\ShelterApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShelterApplicationFactory extends Factory
{
    protected $model = ShelterApplication::class;

    public function definition(): array
    {
        return [
            'organization_name' => $this->faker->company,
            'email'             => $this->faker->unique()->safeEmail,
            'phone'             => $this->faker->phoneNumber,
            'address'           => $this->faker->address,
            'proof_document'    => 'proof_documents/sample.pdf', // You can adjust this path
            'message'           => $this->faker->sentence,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }
}
