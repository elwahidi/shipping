<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence(rand(1,2)),
        'description'=>$faker->paragraph(rand(10,20)),
    ];
});
