<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Direccion;
use App\Models\MetodoPago;
use App\Models\Compra;
use App\Models\CompraProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para realizar una compra.');
        }

        // Obtener items del carrito
        $carritoItems = Carrito::with('producto')
            ->where('user_id', Auth::id())
            ->get()
            ->filter(function($item) {
                return !is_null($item->producto);
            });

        if ($carritoItems->isEmpty()) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }

        // Obtener direcciones y métodos de pago del usuario owo
        $direcciones = Direccion::where('user_id', Auth::id())->get();
        $metodosPago = MetodoPago::where('user_id', Auth::id())->get();

        // Calcular totales
        $subtotal = $carritoItems->sum(function($item) {
            return $item->producto->precio * $item->cantidad;
        });
        
        $envio = $this->calcularCostoEnvio($direcciones->first());
        $impuestos = $this->calcularImpuestos($subtotal);
        $total = $subtotal + $envio + $impuestos;

        return view('checkout', compact(
            'carritoItems',
            'direcciones',
            'metodosPago',
            'subtotal',
            'envio',
            'impuestos',
            'total'
        ));
    }

    public function gestionarDirecciones()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para gestionar direcciones.');
        }

        $direcciones = Direccion::where('user_id', Auth::id())->get();
        return view('direcciones', compact('direcciones'));
    }

    public function mostrarTicket($idCompra)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $compra = Compra::with(['productos.producto', 'direccion', 'metodoPago', 'user'])
            ->where('id_compra', $idCompra)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('ticket-pdf', compact('compra'));
    }
    public function guardarDireccion(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            $request->validate([
                'calle' => 'required|string|max:200',
                'numero_exterior' => 'required|string|max:20',
                'numero_interior' => 'nullable|string|max:20',
                'colonia' => 'required|string|max:100',
                'ciudad' => 'required|string|max:100',
                'estado' => 'required|string|max:100',
                'codigo_postal' => 'required|string|max:10',
                'pais' => 'required|string|max:50',
                'referencias' => 'nullable|string|max:500',
                'es_principal' => 'sometimes|boolean'
            ]);

            // Verificar si es la primera dirección uwu
            $totalDirecciones = Direccion::where('user_id', Auth::id())->count();
            $esPrimeraDireccion = $totalDirecciones === 0;
            
            // Determinar si será principal OwO
            $esPrincipal = $esPrimeraDireccion ? true : ($request->boolean('es_principal'));

            if ($esPrincipal) {
                Direccion::where('user_id', Auth::id())->update(['es_principal' => false]);
            }

            // Crear la dirección
            $direccion = new Direccion();
            $direccion->user_id = Auth::id();
            $direccion->calle = $request->calle;
            $direccion->numero_exterior = $request->numero_exterior;
            $direccion->numero_interior = $request->numero_interior;
            $direccion->colonia = $request->colonia;
            $direccion->ciudad = $request->ciudad;
            $direccion->estado = $request->estado;
            $direccion->codigo_postal = $request->codigo_postal;
            $direccion->pais = $request->pais ?: 'México';
            $direccion->referencias = $request->referencias;
            $direccion->es_principal = $esPrincipal;
            $direccion->save();

            return back()->with('success', 'Dirección guardada exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar la dirección: ' . $e->getMessage())->withInput();
        }
    }

    public function establecerDireccionPrincipal($idDireccion)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Quitar principal de todas las direcciones
        Direccion::where('user_id', Auth::id())->update(['es_principal' => false]);
        
        // Establecer nueva dirección como principal
        Direccion::where('id_direccion', $idDireccion)
                 ->where('user_id', Auth::id())
                 ->update(['es_principal' => true]);

        return back()->with('success', 'Dirección principal actualizada.');
    }

    public function eliminarDireccion($idDireccion)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $direccion = Direccion::where('id_direccion', $idDireccion)
                             ->where('user_id', Auth::id())
                             ->first();

        if ($direccion && !$direccion->es_principal) {
            $direccion->delete();
            return back()->with('success', 'Dirección eliminada.');
        }

        return back()->with('error', 'No se puede eliminar la dirección principal.');
    }

    public function gestionarMetodosPago()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $metodosPago = MetodoPago::where('user_id', Auth::id())->get();
        return view('metodos-pago', compact('metodosPago'));
    }

    public function guardarMetodoPago(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'tipo' => 'required|in:tarjeta_credito,tarjeta_debito,paypal,transferencia',
            'titular' => 'required|string|max:150',
            'numero_tarjeta' => 'required_if:tipo,tarjeta_credito,tarjeta_debito|string|max:20',
            'fecha_vencimiento' => 'required_if:tipo,tarjeta_credito,tarjeta_debito|string|max:7',
            'cvv' => 'required_if:tipo,tarjeta_credito,tarjeta_debito|string|max:4',
            'es_principal' => 'sometimes|boolean'
        ]);

        // Si se marca como principal, quitar principal de otros métodos
        if ($request->boolean('es_principal')) {
            MetodoPago::where('user_id', Auth::id())->update(['es_principal' => false]);
        }

        // Guardar solo los últimos 4 dígitos de la tarjeta
        $numeroTarjeta = null;
        if ($request->numero_tarjeta) {
            $numeroTarjeta = substr(str_replace(' ', '', $request->numero_tarjeta), -4);
        }

        // Verificar si es el primer método de pago
        $totalMetodos = MetodoPago::where('user_id', Auth::id())->count();
        $esPrimerMetodo = $totalMetodos === 0;
        $esPrincipal = $esPrimerMetodo ? true : $request->boolean('es_principal');

        MetodoPago::create([
            'user_id' => Auth::id(),
            'tipo' => $request->tipo,
            'titular' => $request->titular,
            'numero_tarjeta' => $numeroTarjeta,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'cvv' => $request->cvv,
            'es_principal' => $esPrincipal,
        ]);

        return back()->with('success', 'Método de pago guardado exitosamente.');
    }

    public function establecerMetodoPagoPrincipal($idMetodoPago)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        MetodoPago::where('user_id', Auth::id())->update(['es_principal' => false]);
        
        MetodoPago::where('id_metodo_pago', $idMetodoPago)
                  ->where('user_id', Auth::id())
                  ->update(['es_principal' => true]);

        return back()->with('success', 'Método de pago principal actualizado.');
    }

    public function eliminarMetodoPago($idMetodoPago)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $metodoPago = MetodoPago::where('id_metodo_pago', $idMetodoPago)
                               ->where('user_id', Auth::id())
                               ->first();

        if ($metodoPago && !$metodoPago->es_principal) {
            $metodoPago->delete();
            return back()->with('success', 'Método de pago eliminado.');
        }

        return back()->with('error', 'No se puede eliminar el método de pago principal.');
    }

    public function historialCompras()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $compras = Compra::with('productos.producto')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('historial', compact('compras'));
    }

    private function calcularCostoEnvio()
    {
        return 80.00; 
    }

    private function calcularImpuestos($subtotal)
    {
        return $subtotal * 0.16; 
    }

    private function generarNumeroPedido()
    {
        return 'TOK' . date('YmdHis') . Str::random(6);
    }

    ///PDFDOM
    public function procesarCompra(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'id_direccion' => 'required|exists:direcciones,id_direccion',
            'id_metodo_pago' => 'required|exists:metodos_pago,id_metodo_pago',
            'notas' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Obtener items del carrito
            $carritoItems = Carrito::with('producto')
                ->where('user_id', Auth::id())
                ->get()
                ->filter(function($item) {
                    return !is_null($item->producto);
                });

            if ($carritoItems->isEmpty()) {
                throw new \Exception('El carrito está vacío.');
            }

            // Verificar stock de productos
            foreach ($carritoItems as $item) {
                if ($item->producto->stock < $item->cantidad) {
                    throw new \Exception("El producto {$item->producto->nombre} no tiene suficiente stock. Stock disponible: {$item->producto->stock}");
                }
            }

            // Calcular totales OWO
            $subtotal = $carritoItems->sum(function($item) {
                return $item->producto->precio * $item->cantidad;
            });
            
            $envio = $this->calcularCostoEnvio();
            $impuestos = $this->calcularImpuestos($subtotal);
            $total = $subtotal + $envio + $impuestos;

            // Crear la compra UWU
            $compra = new Compra();
            $compra->user_id = Auth::id();
            $compra->id_direccion = $request->id_direccion;
            $compra->id_metodo_pago = $request->id_metodo_pago;
            $compra->numero_pedido = $this->generarNumeroPedido();
            $compra->subtotal = $subtotal;
            $compra->envio = $envio;
            $compra->impuestos = $impuestos;
            $compra->total = $total;
            $compra->estado = 'pendiente';
            $compra->notas = $request->notas;
            $compra->save();

            // Crear registros en compras_productos y actualizar stock
            foreach ($carritoItems as $item) {
                CompraProducto::create([
                    'id_compra' => $compra->id_compra,
                    'producto_id' => $item->producto_id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->producto->precio,
                    'subtotal' => $item->producto->precio * $item->cantidad,
                ]);

                // Actualizar stock del producto
                $item->producto->decrement('stock', $item->cantidad);
            }

            // Vaciar el carrito
            Carrito::where('user_id', Auth::id())->delete();

            DB::commit();

            // Generar PDF
            $pdf = Pdf::loadView('ticket-pdf', compact('compra'));

            // Redirigir a la descarga del PDF 
            return redirect()->route('checkout.exito', $compra->id_compra);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar la compra: ' . $e->getMessage())->withInput();
        }
    }

    public function exitoCompra($idCompra)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $compra = Compra::with(['productos.producto', 'direccion', 'metodoPago', 'user'])
            ->where('id_compra', $idCompra)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('exito', compact('compra'));
    }

    public function descargarTicket($idCompra)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $compra = Compra::with(['productos.producto', 'direccion', 'metodoPago', 'user'])
            ->where('id_compra', $idCompra)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $pdf = Pdf::loadView('ticket-pdf', compact('compra'));

        return $pdf->download('ticket-' . $compra->numero_pedido . '.pdf');
    }

}
