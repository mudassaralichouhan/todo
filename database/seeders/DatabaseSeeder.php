<?php

namespace Database\Seeders;

use App\Models\ToDo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        \App\Models\User::factory()
            ->count(10)
            ->has(ToDo::factory()->count(50))
            ->create();
    }
}
