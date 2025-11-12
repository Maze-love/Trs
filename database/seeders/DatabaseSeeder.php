<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
         // Accounts
        User::factory()->create([
            'name' => 'Aman',
            'email' => 'aman@gmail.com',
            'password'=>'123',
            'type'=>'Customer'
        ]);
         User::factory()->create([
            'name' => 'dom',
            'email' => 'dom@gmail.com',
            'password'=>'222',
            'type'=>'Customer'
        ]);
        // hotel managers
        User::factory()->create([
            'name' => 'Mere',
            'email' => 'mere@gmail.com',
            'password'=>'222',
            'type'=>'Manager'
        ]);

        User::factory()->create([
            'name' => 'Molly',
            'email' => 'molly@gmail.com',
            'password'=>'333',
            'type'=>'Manager'
        ]);
        
        User::factory()->create([
            'name' => 'Lorry',
            'email' => 'lorry@gmail.com',
            'password'=>'777',
            'type'=>'Manager'
        ]);
        
        User::factory()->create([
            'name' => 'Alex',
            'email' => 'alex@gmail.com',
            'password'=>'789',
            'type'=>'Admin'
        ]);

        User::factory()->create([
            'name' => 'Matt',
            'email' => 'matt@gmail.com',
            'password'=>'111',
            'type'=>'Travel_agent'
        ]);
    }
}
