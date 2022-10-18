<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       // $views = $this->faker->numberBetween($min = 100, $max=300);

        return [
            'category_id' => Category::all()->random()->id,
            'title' => $this->faker->name,
            'image' => $this->faker->imageUrl($width = 140, $height=300),
            'description' => $this->faker->sentence,
            'views' => 0,
            'date' => $this->faker->date
        ];
    }
}
