<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class),
        'body' => $faker->sentence(),
        'image' => 'img.jpg',
    ];
});
