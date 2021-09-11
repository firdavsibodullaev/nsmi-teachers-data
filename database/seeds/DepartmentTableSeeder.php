<?php

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emfId = Faculty::query()->where('ShortNameUz', '=', 'EMF')->first()->Id;
        $kfId = Faculty::query()->where('ShortNameUz', '=', 'KF')->first()->Id;
        $kmfId = Faculty::query()->where('ShortNameUz', '=', 'KMF')->first()->Id;
        Department::query()->insert([
            [
                'FullNameUz' => 'Texnologik jarayonlarni avtomatlashtirish',
                'ShortNameUz' => 'TJA',
                'FacultyId' => $emfId,
            ],
            [
                'FullNameUz' => 'Mashinasozlik texnologiyasi',
                'ShortNameUz' => 'TM',
                'FacultyId' => $emfId,
            ],
            [
                'FullNameUz' => 'Elektro energetika',
                'ShortNameUz' => 'EE',
                'FacultyId' => $emfId,
            ],
            [
                'FullNameUz' => 'Konchilik ishi',
                'ShortNameUz' => 'KI',
                'FacultyId' => $kfId,
            ],
            [
                'FullNameUz' => 'Texnologik mashina va jihozlar',
                'ShortNameUz' => 'TMJ',
                'FacultyId' => $kfId,
            ],
            [
                'FullNameUz' => 'Iqtisodiyot',
                'ShortNameUz' => 'I',
                'FacultyId' => $kmfId,
            ],
        ]);
    }
}
