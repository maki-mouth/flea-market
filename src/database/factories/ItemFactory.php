<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;

class ItemFactory extends Factory
{
    protected $model = Item::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(100, 10000),
            'user_id' => \App\Models\User::factory(),
            'image' => 'default.png',
            'condition_id' => \App\Models\Condition::factory(),
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
