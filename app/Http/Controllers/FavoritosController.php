<?php


namespace App\Http\Controllers;

use App\Models\Favoritos;
use Illuminate\Support\Facades\Auth;

class FavoritosController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $favoritos = Auth::user()->favoritos()
            ->with(['categoria', 'color', 'talla'])
            ->get()
            ->filter(function($producto) {
                return $producto instanceof \App\Models\Producto; 
            });
            
        return view('favorites', compact('favoritos'));
    }

    public function agregar($productoId)
    {
        Auth::user()->favoritos()->syncWithoutDetaching([$productoId]);

        return back();
    }

    public function eliminar($productoId)
    {
        Auth::user()->favoritos()->detach($productoId);

        return back();
    }
}
