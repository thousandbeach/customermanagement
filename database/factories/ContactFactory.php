<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'birthday' => '05/14/1988',
        'company' => $faker->company,
    ];
});
