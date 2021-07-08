<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogAppSeeder extends Seeder
{
   
    public function run()
    {
        DB::table('secaos')->insert([
            'nome'=> 'Engraçado',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('secaos')->insert([
            'nome'=> 'Comida',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('secaos')->insert([
            'nome'=> 'Animais',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('secaos')->insert([
            'nome'=> 'Incrivel',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('secaos')->insert([
            'nome'=> 'Filmes e Tv',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('secaos')->insert([
            'nome'=> 'HumorNegro',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
