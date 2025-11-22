<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $cats=[
            'Adventures',
            'Cultural',
            'Historical',
            'WildLife',
            'Educational',
        ];
        foreach ($cats as $key) {
            # code...
            Category::create([
                'name'=>$key
            ]);
        }
    }
}
