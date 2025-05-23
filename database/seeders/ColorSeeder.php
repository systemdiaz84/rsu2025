<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $c1 = new Color();
        $c1->name = 'Blanco';
        $c1->save();

        $c2 = new Color();
        $c2->name = 'Rojo';
        $c2->save();

        $c3 = new Color();
        $c3->name = 'Negro';
        $c3->save();
    }
}
