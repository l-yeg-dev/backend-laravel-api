<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        \App\Models\Source::insert([
            ['name' => 'The Guardian'],
            ['name' => 'OpenNews'],
            ['name' => 'BBCNews']
        ]);

        \App\Models\Category::insert([
            ['name' => 'Government'],
            ['name' => 'Entertainment'],
            ['name' => 'Daily']
        ]);

        \App\Models\Author::insert([
            ['name' => 'Adam Sheffer'],
            ['name' => 'John Doe'],
            ['name' => 'Ernesto Clear']
        ]);

        \App\Models\Article::factory(3)->create();
    }
}
