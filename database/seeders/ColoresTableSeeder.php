<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Datos de los colores
        $colores = [
            ['nombre' => 'Rojo', 'codigo' => 'FF0000'],
            ['nombre' => 'Azul', 'codigo' => '0000FF'],
            ['nombre' => 'Verde', 'codigo' => '00FF00'],
            ['nombre' => 'Blanco', 'codigo' => 'FFFFFF'],
            ['nombre' => 'Negro', 'codigo' => '000000'],
            ['nombre' => 'Rosa', 'codigo' => 'FFC0CB'],
            ['nombre' => 'Gris', 'codigo' => '808080'],
            ['nombre' => 'Amarillo', 'codigo' => 'FFFF00'],
        ];

        // Insertar los colores en la base de datos
        foreach ($colores as $color) {
            Color::create($color);
        }
    }
}
