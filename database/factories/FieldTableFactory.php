<?php

/** @var Factory $factory */

use App\Models\Field;
use App\Models\FieldTable;
use App\Models\Table;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(FieldTable::class, function (Faker $faker) {
    $table = Table::query()->inRandomOrder()->first();
    $field = Field::query()->inRandomOrder()->first();
    return [
        'TableId' => $table->Id,
        'FieldId' => $field->Id
    ];
});
