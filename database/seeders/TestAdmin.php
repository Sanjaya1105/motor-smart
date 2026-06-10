<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TestAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['name' => 'TestAdmin'],
            [
                'email' => 'testadmin@example.com',
                'password' => 'xN8@sW3!pQ9$vF2&',
            ],
        );
    }
}
