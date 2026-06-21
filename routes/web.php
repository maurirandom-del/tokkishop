<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductManageController;
use App\Http\Controllers\FavoritosController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportesController;
use App\Exports\UsersExport; 
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/tokki/playeras', [HomeController::class, 'playeras'])->name('playeras.index');
Route::get('/tokki/hoodies', [HomeController::class, 'hoodies'])->name('hoodies.index');
Route::get('/tokki/jeans', [HomeController::class, 'jeans'])->name('jeans.index');
Route::get('/tokki/gorras', [HomeController::class, 'gorras'])->name('gorras.index');
Route::get('/tokki/accesorios', [HomeController::class, 'accesorios'])->name('accesorios.index');


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back();
})->name('login.custom');


Route::get('/check-requirements', function() {
    $data = [
        'PHP Version' => phpversion(),
        'Laravel Version' => app()->version(),
        'Extensions' => [
            'zip' => extension_loaded('zip'),
            'xml' => extension_loaded('xml'),
            'gd' => extension_loaded('gd'),
            'iconv' => function_exists('iconv'),
            'simplexml' => extension_loaded('simplexml'),
            'xmlreader' => extension_loaded('xmlreader'),
            'zlib' => extension_loaded('zlib'),
        ]
    ];
    
    return response()->json($data);
});

Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
    
})->name('logout');

    Route::middleware('auth')->group(function () {

    // Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::get('/admin/pedidos', [AdminController::class, 'pedidos'])->name('admin.pedidos');
    
    // Admin Productos CRUD
    Route::get('/admin/productos', [ProductManageController::class, 'index'])->name('productos.index');
    Route::get('/admin/subir-producto', [ProductManageController::class, 'newproduct'])->name('crear.producto');
    Route::post('/subir-producto', [ProductManageController::class, 'store'])->name('subir.producto');
    Route::get('/productos/{id}/edit', [ProductManageController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [ProductManageController::class, 'update'])->name('productos.update');
    Route::get('/admin/productos/{id}/show', [ProductManageController::class, 'show'])->name('productos.show');
    Route::delete('/admin/productos/{id}', [ProductManageController::class, 'destroy'])->name('productos.destroy');

    //Acciones Usuarios y Pedidos
    Route::put('/usuarios/{id}', [AdminController::class, 'actualizarUsuario'])->name('admin.usuarios.actualizar');
    Route::put('/pedidos/{id}', [AdminController::class, 'actualizarPedido'])->name('admin.pedidos.actualizar');

    // Favoritos
    Route::get('/favoritos', [FavoritosController::class, 'index'])->name('favoritos.index');
    Route::post('/favoritos/{id}', [FavoritosController::class, 'agregar'])->name('favoritos.agregar');
    Route::delete('/favoritos/{id}', [FavoritosController::class, 'eliminar'])->name('favoritos.eliminar');

    // Carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');

    //Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/procesar', [CheckoutController::class, 'procesarCompra'])->name('checkout.procesar');
    Route::get('/checkout/exito/{id}', [CheckoutController::class, 'exitoCompra'])->name('checkout.exito');
    Route::get('/checkout/ticket/{id}', [CheckoutController::class, 'mostrarTicket'])->name('checkout.ticket');
    Route::get('/checkout/descargar-ticket/{id}', [CheckoutController::class, 'descargarTicket'])->name('checkout.descargar-ticket');
    
    // Direcciones e.e
    Route::get('/checkout/direcciones', [CheckoutController::class, 'gestionarDirecciones'])->name('checkout.direcciones');
    Route::post('/checkout/direcciones', [CheckoutController::class, 'guardarDireccion'])->name('checkout.direcciones.guardar');
    
    // Métodos de pago
    Route::get('/checkout/metodos-pago', [CheckoutController::class, 'gestionarMetodosPago'])->name('checkout.metodos-pago');
    Route::post('/checkout/metodos-pago', [CheckoutController::class, 'guardarMetodoPago'])->name('checkout.metodos-pago.guardar');

    Route::post('/checkout/direcciones/{id}/principal', [CheckoutController::class, 'establecerDireccionPrincipal'])->name('checkout.direcciones.establecer-principal');
    Route::delete('/checkout/direcciones/{id}', [CheckoutController::class, 'eliminarDireccion'])->name('checkout.direcciones.eliminar');
    
    // Métodos de pago - gestión adicional
    Route::post('/checkout/metodos-pago/{id}/principal', [CheckoutController::class, 'establecerMetodoPagoPrincipal'])->name('checkout.metodos-pago.establecer-principal');
    Route::delete('/checkout/metodos-pago/{id}', [CheckoutController::class, 'eliminarMetodoPago'])->name('checkout.metodos-pago.eliminar');

    //Graficas
    Route::get('/reportes/ventas-mes', [ReportesController::class, 'ventasPorMes']);
    
    Route::get('/export', function () {
        return Excel::download(new UsersExport(), 'usuarios-' . date('Y-m-d') . '.xlsx');
    })->name('export.usuarios');

}); 
