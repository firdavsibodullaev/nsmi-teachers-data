<?php

use App\Constants\PostConstants;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculty = Faculty::query()->first();
        User::query()->create([
            'FirstName' => 'Firdavs',
            'LastName' => 'Ibodullayev',
            'Patronymic' => 'Qaxramon o\'g\'li',
            'Phone' => '998931588585',
            'Username' => 'firdavs3253',
            'Password' => bcrypt('firdavs99'),
            'Birth' => '1999-05-07',
            'FacultyId' => $faculty->Id,
            'DepartmentId' => $faculty->departments[0]->Id,
            'Post' => PostConstants::TEACHER
        ]);
    }
}
