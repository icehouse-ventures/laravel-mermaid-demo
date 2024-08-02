<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entity>
 */
class EntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Fund', 'Company', 'PreferredStock', 'ConvertibleNote', 'Dividend'];

        return [
            'name' => $this->faker->company,
            'type' => $this->faker->randomElement($types),
            'parent_id' => null, // Relationships are specified by the seeder
        ];
    }
}
