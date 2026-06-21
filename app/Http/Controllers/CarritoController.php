<?php
namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        // Cargar productos con su información desde la relación
        $carrito = Auth::user()->carrito()->with('producto')->get();

        // Calcular el total
        $total = $carrito->sum(function($item) {
            if ($item->producto && $item->producto->precio) {
                return $item->producto->precio * $item->cantidad;
            }
            return 0;
        });

        return view('shoppingcart', compact('carrito', 'total'));
    }

    public function agregar($productoId)
    {
    $item = Carrito::firstOrCreate([
            'user_id' => Auth::id(),
            'producto_id' => $productoId,
        ], [
            'cantidad' => 0
        ]);
        $item->increment('cantidad');
        return back();
    }

    public function eliminar($id)
    {
        Carrito::where('id', $id)
               ->where('user_id', Auth::id())
               ->delete();

        return back();
    }

    public function vaciar()
    {
        Carrito::where('user_id', Auth::id())->delete();
        return back()->with('success', 'Carrito vaciado.');
    }
}
