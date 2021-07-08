<?php

namespace Database\Factories\BlogApp;

use App\Models\BlogApp\BlogPosts;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

class BlogPostsFactory extends Factory
{

    protected $model = BlogPosts::class;

    public function definition()
    {
        return [
            'user_id' => '1',
            'titulo' => $this->faker->name(),
            'secao_id' => $this->faker->numberBetween(1, 6),
            'conteudo' => $this->faker->text(500),
            'tags' => 'Gerado Factory tinker',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
