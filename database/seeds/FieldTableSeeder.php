<?php

use App\Models\FieldTable;
use Illuminate\Database\Seeder;

class FieldTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(FieldTable::class, 50)->create();
    }
}
