<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Color;
use App\Models\Talla;
use App\Models\Categoria;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
    $colores = [
        ['id_color' => 1000, 'nombre' => 'Blanco'],
        ['id_color' => 1001, 'nombre' => 'Negro'],
        ['id_color' => 1002, 'nombre' => 'Rojo'],
        ['id_color' => 1003, 'nombre' => 'Naranja'],
        ['id_color' => 1004, 'nombre' => 'Amarillo'],
        ['id_color' => 1005, 'nombre' => 'Verde'],
        ['id_color' => 1006, 'nombre' => 'Azul'],
        ['id_color' => 1007, 'nombre' => 'Morado'],
        ['id_color' => 1008, 'nombre' => 'Rosa'],
        ['id_color' => 1009, 'nombre' => 'Café'],
        ['id_color' => 1010, 'nombre' => 'Beige'],
        ['id_color' => 1011, 'nombre' => 'Gris'],
    ];

   $tallas = [
        ['id_talla' => 2020, 'talla' => 'XS'],
        ['id_talla' => 2021, 'talla' => 'S'],
        ['id_talla' => 2022, 'talla' => 'M'],
        ['id_talla' => 2023, 'talla' => 'L'],
        ['id_talla' => 2024, 'talla' => 'XL'],
        ['id_talla' => 2025, 'talla' => 'XXL'],
        ['id_talla' => 2026, 'talla' => 'Unitalla'],
    ];
    
    
    $categorias = [
        ['id_categoria' => 3030, 'nombre' => 'Playeras', 'descripcion' => 'Playeras y camisetas'],
        ['id_categoria' => 3031, 'nombre' => 'Hoodies', 'descripcion' => 'Sudaderas con capucha'],
        ['id_categoria' => 3032, 'nombre' => 'Jeans', 'descripcion' => 'Pantalones de mezclilla'],
        ['id_categoria' => 3033, 'nombre' => 'Gorras', 'descripcion' => 'Gorras y sombreros'],
        ['id_categoria' => 3034, 'nombre' => 'Accessorios', 'descripcion' => 'Accesorios y complementos'],
    ];

        Color::insert($colores);
        Talla::insert($tallas);
        Categoria::insert($categorias);


        Producto::create([
        'nombre' => 'Playera básica beige',
        'descripcion' => 'Playera de algodón 100% básica',
        'precio' => 199.99,
        'stock' => 50,
        'id_talla' => 2022,
        'id_color' => 1010, 
        'id_categoria' => 3030,
        'imagen_url' => 'https://i.ibb.co/VpQQfBfW/Captura-de-pantalla-2025-10-01-111827.png'
    ]);
    
    }
}
