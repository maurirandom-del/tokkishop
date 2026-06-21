{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Administrativo')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center mb-5">Panel Administrativo</h1>
            
            <div class="row">
                <!-- Gestión de Usuarios -->
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fa-solid fa-users fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Gestión de Usuarios</h5>
                            <p class="card-text">Administra los usuarios del sistema.</p>
                            <a href="{{ route('admin.usuarios') }}" class="btn btn-primary">Acceder</a>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Productos -->
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fa-solid fa-boxes fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Gestión de Productos</h5>
                            <p class="card-text">Gestiona el inventario de productos.</p>
                            <a href="{{ route('productos.index') }}" class="btn btn-success">Acceder</a>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Pedidos -->
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fa-solid fa-shopping-cart fa-3x text-info mb-3"></i>
                            <h5 class="card-title">Gestión de Pedidos</h5>
                            <p class="card-text">Revisa y gestiona los pedidos.</p>
                            <a href="{{ route('admin.pedidos') }}" class="btn btn-info">Acceder</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection