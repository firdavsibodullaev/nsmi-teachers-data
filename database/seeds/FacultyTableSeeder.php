<?php

use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faculty::query()->insert([
            [
                'FullNameUz' => 'Energo-mexanika fakulteti',
                'ShortNameUz' => 'EMF'
            ],
            [
                'FullNameUz' => 'Konchilik fakulteti',
                'ShortNameUz' => 'KF'
            ],
            [
                'FullNameUz' => 'Kimyo-metallurgiya fakulteti',
                'ShortNameUz' => 'KMF'
            ],
        ]);
    }
}
