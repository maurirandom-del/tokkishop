<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Producto;
use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect('/')->with('error', 'Acceso no autorizado.');
        }

        $stats = [
            'totalUsuarios' => User::count(),
            'totalProductos' => Producto::count(),
            'totalPedidos' => Compra::count(),
            'pedidosPendientes' => Compra::where('estado', 'pendiente')->count(),
        ];

        return view('dashboard', $stats);
    }

    public function usuarios()
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect('/')->with('error', 'Acceso no autorizado.');
        }

        $usuarios = User::with('roles')->orderBy('created_at', 'desc')->paginate(10);
        $roles = Role::all(); // Obtener todos los roles
        
        // Pasar ambas variables a la vista
        return view('usuarios', compact('usuarios', 'roles'));
    }

    public function actualizarUsuario(Request $request, $id)
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect('/')->with('error', 'Acceso no autorizado.');
        }

        $usuario = User::findOrFail($id);
        $usuario->syncRoles([$request->role]);

        return back()->with('success', 'Rol de usuario actualizado correctamente.');
    }

    public function pedidos()
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect('/')->with('error', 'Acceso no autorizado.');
        }

        $pedidos = Compra::with(['user', 'productos.producto'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Estadísticas para la vista
        $estadisticas = [
            'total' => Compra::count(), // ✅ ESTA FALTABA
            'pendientes' => Compra::where('estado', 'pendiente')->count(),
            'entregados' => Compra::where('estado', 'entregado')->count(),
            'ingresos_totales' => Compra::sum('total'),
        ];

        return view('pedidos', compact('pedidos', 'estadisticas'));
    }

    public function actualizarPedido(Request $request, $id)
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect('/')->with('error', 'Acceso no autorizado.');
        }

        $pedido = Compra::findOrFail($id);
        $pedido->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado del pedido actualizado correctamente.');
    }

}