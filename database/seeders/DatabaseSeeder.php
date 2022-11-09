<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Ida Putu Sucita Danuartha',
            'email' => 'danuart21@gmail.com',
            'password' => bcrypt('12345678'),
            'role_as' => 'admin'
        ]);

        Post::create([
            'category_id' => 1,
            'user_id' => 1,
            'title' => 'Postingan 1',
            'slug' => 'postingan-1',
            'content' => '<p>Halo <b>guys</b></p>',
            'thumbnail' => ''
        ]);

        Category::create([
            'name' => 'Olahraga',
        ]);

        Category::create([
            'name' => 'Pendidikan',
        ]);
    }
}
