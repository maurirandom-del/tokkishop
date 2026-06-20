<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Talla;
use Illuminate\Http\Request;

class ProductManageController extends Controller
{
    public function index(){
        $productos = Producto::all();    
        return view('productmanagement', compact('productos'));
    }

        public function newproduct(){
        $productos = Producto::with(['categoria', 'color', 'talla'])->get();    
        $categorias = Categoria::all();
        $colores = Color::all();
        $tallas = Talla::all();
        
        return view('createproduct', compact('productos', 'categorias', 'colores', 'tallas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen_url' => 'required|string',
            'id_talla' => 'required|integer|exists:tallas,id_talla',
            'id_color' => 'required|integer|exists:colores,id_color',
            'id_categoria' => 'required|integer|exists:categorias,id_categoria'
        ]);

        Producto::create($validated);

        return redirect()->route('productos.index');
    }

        public function show($id)
    {
        $producto = Producto::with(['categoria', 'color', 'talla'])->findOrFail($id);

        $categorias = Categoria::all();
        $colores = Color::all();
        $tallas = Talla::all();

        $viewmode = true;

        return view('editproduct', compact('producto', 'categorias', 'colores', 'tallas', 'viewmode'));
    }

        public function edit($id)
    {
        $producto = Producto::with(['categoria', 'color', 'talla'])->findOrFail($id);

        $categorias = Categoria::all();
        $colores = Color::all();
        $tallas = Talla::all();

        $viewmode = false;

        return view('editproduct', compact('producto', 'categorias', 'colores', 'tallas', 'viewmode'));
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'id_talla' => 'required|integer|exists:tallas,id_talla',
            'id_color' => 'required|integer|exists:colores,id_color',
            'id_categoria' => 'required|integer|exists:categorias,id_categoria',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($validated);

        return redirect()->route('productos.index');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index');
    }
}