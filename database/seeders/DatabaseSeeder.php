<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Study\Database\Seeders\StudyDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StudyDatabaseSeeder::class
        ]);
    }
}
