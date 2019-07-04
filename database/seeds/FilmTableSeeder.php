<?php

use Illuminate\Database\Seeder;

class FilmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Film::class, 30)->create()->each(function($film) {
            $film->characters()->saveMany(factory(App\Models\Character::Class, 10)->make());
        });
    }
}
