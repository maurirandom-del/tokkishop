<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $productos = Producto::all();
        return view('home', compact('productos'));
    }
    public function playeras(){
        $productos = Producto::all();
        $categoria_id = 3030;
        $categorias = Categoria::all();
        return view('sections', compact('productos','categoria_id','categorias'));
    }
    public function hoodies(){
        $productos = Producto::all();
        $categoria_id = 3031;
        $categorias = Categoria::all();
        return view('sections', compact('productos','categoria_id','categorias'));        
    }
    public function jeans(){
        $productos = Producto::all();
        $categoria_id = 3032;
        $categorias = Categoria::all();
        return view('sections', compact('productos','categoria_id','categorias'));        
    }
    public function gorras(){
        $productos = Producto::all();
        $categoria_id = 3033;
        $categorias = Categoria::all();
        return view('sections', compact('productos','categoria_id','categorias'));        
    }         
    public function accesorios(){
        $productos = Producto::all();
        $categoria_id = 3034;
        $categorias = Categoria::all();
        return view('sections', compact('productos','categoria_id','categorias'));        
    }   
}
