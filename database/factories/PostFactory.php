<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
            return [
                "title" => $this->faker->sentence,
                "user_id" => 1,
                "url" => $this->faker->url,
                "description" => $this->faker->paragraph,
                "excerpt" => $this->faker->address,
                "image" => $this->faker->imageUrl(),
                "status" => 1,
                "format_id" => 1,
                "allow_comments" => 1,
                "disk" => "public",
                'custom_fields' => [ // Do not json_encode this as your model will handle the conversion
                    [
                        'name' => $this->faker->sentence,
                        'content' => $this->faker->sentence,
                    ]
                ]
            ];
    }
}
