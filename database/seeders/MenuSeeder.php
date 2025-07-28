<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $food = Category::create(['name' => 'Food']);
        $drink = Category::create(['name' => 'Drink']);
        $dessert = Category::create(['name' => 'Dessert']);

        Menu::create([
            'name' => 'Cheeseburger',
            'price' => 600,
            'category_id' => $food->id
        ]);

        Menu::create([
            'name' => 'Fried Chicken',
            'price' => 700,
            'category_id' => $food->id
        ]);

        Menu::create([
            'name' => 'Cola',
            'price' => 150,
            'category_id' => $drink->id
        ]);

        Menu::create([
            'name' => 'Orange Juice',
            'price' => 180,
            'category_id' => $drink->id
        ]);

        Menu::create([
            'name' => 'Chocolate Cake',
            'price' => 450,
            'category_id' => $dessert->id
        ]);

        Menu::create([
            'name' => 'Super Cake',
            'price' => 999,
            'category_id' => $dessert->id
        ]);
    }
}
