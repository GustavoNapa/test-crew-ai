<?php

namespace Database\Seeders;

use App\Models\Team;
use Database\Factories\TeamFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new Team())->factory()->create([
            'user_id' => 1
        ]);
    }
}
