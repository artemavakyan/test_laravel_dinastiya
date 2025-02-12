<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $user = User::first();

        $articles = [];

        for ($i = 0; $i < 10; $i++) {
            $articles[] = Article::create([
                'title' => $faker->sentence(6),
                'content' => $faker->paragraph(3, true),
                'user_id' => $user->id,
                'rating' => $faker->numberBetween(1, 5)
            ]);
        }

        for ($i = 0; $i < 50; $i++) {
            Comment::create([
                'article_id' => $articles[array_rand($articles)]->id,
                'name' => $faker->name(),
                'content' => $faker->sentence(15),
                'rating' => $faker->numberBetween(1,5)
            ]);
        }
    }
}
