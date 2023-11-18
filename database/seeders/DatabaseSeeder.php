<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(StationsTableSeeder::class);
        \App\Models\Bus::factory(10)->create();
        \App\Models\Trip::factory(10)->create();
        \App\Models\Seat::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' =>Hash::make('1234567890')
        ]);
    }
}
