<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $roles = [
            [
           'name' => 'Administrator'
            ],
            [
           'name' => 'Team Leader'
            ],
            [
           'name' => 'Member'
            ],
            [
           'name' => 'Not Verified'
            ]
       ];

       foreach ($roles as $role) {
           Role::create($role);
       }
    }
}
