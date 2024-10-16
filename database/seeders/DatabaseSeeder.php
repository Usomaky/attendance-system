<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
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
        // Creating Courses
        Course::factory(1)->create([
            'name' => 'admin',
            'status' => 'active',
        ]);

        Course::factory(1)->create([
            'name' => 'frontend web dev',
            'status' => 'active',
        ]);

        Course::factory()->create([
            'name' => 'backend web dev',
            'status' => 'active',
        ]);

        // Creating Users
        User::factory(1)->create([
            'name' => 'John Doe',
            'course_id' => 1,
            'role' => 'admin',
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::factory(1)->create([
            'name' => 'Jane Doe',
            'course_id' => 2,
            'role' => 'facilitator',
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Anony Doe',
            'course_id' => 2,
            'role' => 'student',
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Emily Smith',
            'course_id' => 2,
            'role' => 'student',
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Emily Naz',
            'course_id' => 2,
            'role' => 'student',
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
    }
}
