<?php

namespace Modules\Study\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class StudyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            OrchidAdminSeeder::class,
            LessonElementTypeSeederTableSeeder::class
        ]);
    }
}
