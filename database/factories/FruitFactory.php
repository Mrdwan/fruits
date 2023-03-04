<?php

namespace Database\Factories;

use App\Models\FruitFamily;
use Illuminate\Database\Eloquent\Factories\Factory;

class FruitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'genus' => $this->faker->word(),
            'order' => $this->faker->word(),
            'carbohydrates' => $this->faker->randomFloat(),
            'protein' => $this->faker->randomFloat(),
            'fat' => $this->faker->randomFloat(),
            'calories' => $this->faker->randomFloat(),
            'sugar' => $this->faker->randomFloat(),
            'is_favorited' => false,
            'fruit_family_id' => FruitFamily::factory()->createOne()
        ];
    }
}
