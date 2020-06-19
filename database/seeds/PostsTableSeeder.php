<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\User;
use Faker\Generator as Faker;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 30; $i++) {
            $post = new Post;
            $user = User::inRandomOrder()->first(); //seleziono un user randomico
            $post->user_id = $user->id; //al campo user_id dei post assegno l'id dello user randomico
            $post->user->name = $faker->name();
            $post->title = $faker->sentence(6, true);
            $post->body = $faker->paragraph(5, true);
            $post->save();
        }
    }
}
