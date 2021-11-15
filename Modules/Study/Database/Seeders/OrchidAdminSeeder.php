<?php

namespace Modules\Study\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\User;

class OrchidAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = env('ORCHID_ADMIN_NAME', 'admin');
        $email = env('ORCHID_ADMIN_EMAIL', 'admin');
        $password = env('ORCHID_ADMIN_PASSWORD', 'admin');
        if(!User::whereEmail($email)->exists()) {
            \Artisan::call("orchid:admin $name $email $password");
        }
    }
}
