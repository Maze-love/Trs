<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Manager;
use App\Models\Destination;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hotel::factory(2)->create();

        Destination::factory(3)->create();

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
        
        // // hotel managers
        $manager1= Manager::factory()->create([
            'name' => 'Mere',
            'email' => 'mere@gmail.com',
            'password'=>'222',
            'type'=>'Manager'
        ]);

        $manager2= Manager::factory()->create([
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

        // //TravelAgent
        User::factory()->create([
            'name' => 'Matt',
            'email' => 'matt@gmail.com',
            'password'=>'111',
            'type'=>'Travel_agent'
        ]);
        
        // //Admin
        User::factory()->create([
            'name' => 'Alex',
            'email' => 'alex@gmail.com',
            'password'=>'789',
            'type'=>'Admin'
        ]);


        Hotel::factory()
                ->for($manager1)->create(
                    [
                        'name'=>'Grand Plaza Dubai',
                        'contact_info'=>fake()->word(),
                        'description'=>fake()->sentence(),
                        'ratings'=>fake()->numberBetween(1,4),
                    ]
                );
        Hotel::factory()
                ->for($manager2)->create(
                    [
                        'name'=>'Hotel Trivago',
                        'contact_info'=>fake()->word(),
                        'description'=>fake()->sentence(),
                        'ratings'=>fake()->numberBetween(1,4),
                    ]
                );




        
        $this->call(CategorySeeder::class);

    }
}
