<?php

/** @var Factory $factory */

use App\Constants\FieldTypeConstants;
use App\Models\Field;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Field::class, function (Faker $faker) {
    return [
        'FullName' => $faker->sentence,
        'ShortName' => $faker->word,
        'Type' => $faker->randomElement(FieldTypeConstants::list())
    ];
});
