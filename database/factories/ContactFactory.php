<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Contact::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'name' => $faker->name,
        'email' => $faker->email,
        'birthday' => '05/14/1988',
        'company' => $faker->company,
    ];
});
