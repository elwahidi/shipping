<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) {
            DB::table('post_category')->insert([
            'post_Uuid'=>App\Post::all()->random()->Uuid,
            'category_Uuid'=>App\Category::all()->random()->Uuid,
            ]);
        }
    }
}
