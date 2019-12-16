<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Section;
use Faker\Generator as Faker;

$factory->define(Section::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'name' => $faker->sentence(10),
        'description' => $faker->text(300),
        'logo' => $faker->sentence(5)
    ];
});
