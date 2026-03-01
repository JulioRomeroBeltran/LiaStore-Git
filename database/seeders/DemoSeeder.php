<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Producto;
use App\Models\Talla;
use App\Models\Color;
use App\Models\Estilo;
use App\Models\TipoPrenda;
use App\Models\Inventario;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin user ─────────────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@liastore.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('demo1234'),
                'role'     => 'admin',
            ]
        );

        // ── Tallas ────────────────────────────────────────────────────────────
        $tallas = collect(['XS', 'S', 'M', 'L', 'XL'])->map(
            fn($t) => Talla::firstOrCreate(['nombre' => $t])
        );

        // ── Colores ───────────────────────────────────────────────────────────
        $coloresData = [
            ['nombre' => 'Negro',   'codigo' => '000000'],
            ['nombre' => 'Blanco',  'codigo' => 'FFFFFF'],
            ['nombre' => 'Rojo',    'codigo' => 'FF0000'],
            ['nombre' => 'Azul',    'codigo' => '0000FF'],
            ['nombre' => 'Rosa',    'codigo' => 'FFC0CB'],
            ['nombre' => 'Verde',   'codigo' => '00FF00'],
        ];
        $colores = collect($coloresData)->map(
            fn($c) => Color::firstOrCreate(['nombre' => $c['nombre']], ['codigo' => $c['codigo']])
        );

        // ── Estilos ───────────────────────────────────────────────────────────
        $estilosData = ['Casual', 'Formal', 'Deportivo', 'Elegante'];
        $estilos = collect($estilosData)->map(
            fn($e) => Estilo::firstOrCreate(['nombre' => $e])
        );

        // ── Tipos de prenda ───────────────────────────────────────────────────
        $tiposData = ['Vestido', 'Blusa', 'Suéter', 'Top'];
        $tipos = collect($tiposData)->map(
            fn($t) => TipoPrenda::firstOrCreate(['nombre_tipo' => $t])
        );

        // ── Productos ─────────────────────────────────────────────────────────
        $productos = [
            [
                'nombre'      => 'Vestido Azul Midi',
                'descripcion' => 'Elegante vestido midi en tono azul, ideal para ocasiones especiales.',
                'precio'      => 899.00,
                'imagen'      => 'vestidoazul.jpg',
                'stock'       => 10,
            ],
            [
                'nombre'      => 'Vestido Blanco',
                'descripcion' => 'Vestido blanco de corte recto, perfecto para el día a día.',
                'precio'      => 749.00,
                'imagen'      => 'vestidoblanco.jpg',
                'stock'       => 8,
            ],
            [
                'nombre'      => 'Vestido Corto Negro',
                'descripcion' => 'Mini vestido negro clásico, versátil y sofisticado.',
                'precio'      => 650.00,
                'imagen'      => 'vestidocortonegro.jpg',
                'stock'       => 12,
            ],
            [
                'nombre'      => 'Vestido Midi Floral',
                'descripcion' => 'Vestido largo con estampado midi, elegancia en cada paso.',
                'precio'      => 980.00,
                'imagen'      => 'vestidomidi.jpg',
                'stock'       => 6,
            ],
            [
                'nombre'      => 'Vestido Negro Clásico',
                'descripcion' => 'El infaltable vestido negro, combinable con cualquier accesorio.',
                'precio'      => 720.00,
                'imagen'      => 'vestidonegro.jpg',
                'stock'       => 15,
            ],
            [
                'nombre'      => 'Vestido Negro Noche',
                'descripcion' => 'Vestido negro de noche con detalles elegantes.',
                'precio'      => 1050.00,
                'imagen'      => 'vestidonegro2.jpg',
                'stock'       => 5,
            ],
            [
                'nombre'      => 'Vestido Rojo Pasión',
                'descripcion' => 'Vibrante vestido rojo que no pasa desapercibido.',
                'precio'      => 850.00,
                'imagen'      => 'vestidorojo.jpeg',
                'stock'       => 7,
            ],
            [
                'nombre'      => 'Vestido Rosa Primavera',
                'descripcion' => 'Delicado vestido rosa, ideal para la temporada de primavera.',
                'precio'      => 790.00,
                'imagen'      => 'vestidorosa1.jpg',
                'stock'       => 9,
            ],
            [
                'nombre'      => 'Vestido Verde Esmeralda',
                'descripcion' => 'Vestido en tono esmeralda, fresco y llamativo.',
                'precio'      => 820.00,
                'imagen'      => 'vestidoverde.jpg',
                'stock'       => 8,
            ],
            [
                'nombre'      => 'Top con Tirantes Negro',
                'descripcion' => 'Top básico con tirantes, combina con todo.',
                'precio'      => 320.00,
                'imagen'      => 'tirantesnegro.jpg',
                'stock'       => 20,
            ],
            [
                'nombre'      => 'Top con Tirantes Rosa',
                'descripcion' => 'Top con tirantes en rosa, ligero y cómodo.',
                'precio'      => 320.00,
                'imagen'      => 'tirantesrosa.jpg',
                'stock'       => 18,
            ],
            [
                'nombre'      => 'Suéter Acanalado',
                'descripcion' => 'Suéter de punto acanalado, perfecto para el clima frío.',
                'precio'      => 560.00,
                'imagen'      => 'sueters.jpeg',
                'stock'       => 14,
            ],
        ];

        foreach ($productos as $data) {
            $producto = Producto::firstOrCreate(
                ['nombre' => $data['nombre']],
                [
                    'descripcion' => $data['descripcion'],
                    'precio'      => $data['precio'],
                    'imagen'      => $data['imagen'],
                ]
            );

            // Inventario
            if ($producto->inventarios()->count() === 0) {
                Inventario::create([
                    'producto_id'        => $producto->id,
                    'cantidad_disponible' => $data['stock'],
                ]);
            }

            // Tallas (todas)
            $producto->tallas()->syncWithoutDetaching($tallas->pluck('id'));

            // Colores (asignar según imagen)
            $nombre = strtolower($data['nombre']);
            $colorIds = [];
            if (str_contains($nombre, 'negro'))  $colorIds[] = $colores->firstWhere('nombre', 'Negro')?->id;
            if (str_contains($nombre, 'blanco') || str_contains($nombre, 'white')) $colorIds[] = $colores->firstWhere('nombre', 'Blanco')?->id;
            if (str_contains($nombre, 'rojo'))   $colorIds[] = $colores->firstWhere('nombre', 'Rojo')?->id;
            if (str_contains($nombre, 'azul'))   $colorIds[] = $colores->firstWhere('nombre', 'Azul')?->id;
            if (str_contains($nombre, 'rosa'))   $colorIds[] = $colores->firstWhere('nombre', 'Rosa')?->id;
            if (str_contains($nombre, 'verde'))  $colorIds[] = $colores->firstWhere('nombre', 'Verde')?->id;
            if (!empty($colorIds)) {
                $producto->colores()->syncWithoutDetaching(array_filter($colorIds));
            }

            // Tipo de prenda
            $tipo = null;
            if (str_contains($nombre, 'vestido')) $tipo = $tipos->firstWhere('nombre_tipo', 'Vestido');
            if (str_contains($nombre, 'top') || str_contains($nombre, 'tirante')) $tipo = $tipos->firstWhere('nombre_tipo', 'Top');
            if (str_contains($nombre, 'suéter') || str_contains($nombre, 'sueter')) $tipo = $tipos->firstWhere('nombre_tipo', 'Suéter');
            if ($tipo) $producto->tipos_prenda()->syncWithoutDetaching([$tipo->id]);

            // Estilo
            $estilo = str_contains($nombre, 'noche') || str_contains($nombre, 'clásico')
                ? $estilos->firstWhere('nombre', 'Elegante')
                : $estilos->firstWhere('nombre', 'Casual');
            if ($estilo) $producto->estilos()->syncWithoutDetaching([$estilo->id]);
        }
    }
}
