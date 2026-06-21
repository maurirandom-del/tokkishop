{{-- Gestión de Usuarios con estilo TokkiShop --}}
@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fa-solid fa-users me-2"></i>Gestión de Usuarios</h1>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Volver</a>
            </div>
        </div>
    </div>

    <div class="card carrito-box shadow-sm p-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table-management-product" id="table-management-users">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        <tr>
                            <td class="product-name">{{ $usuario->name }}</td>
                            <td class="product-description">{{ $usuario->email }}</td>
                            <td>
                                @foreach($usuario->roles as $role)
                                    <span class="badge 
                                        {{ $role->name == 'admin' ? 'bg-success' : 'bg-primary' }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                <div class="product-actions">
                                    <button type="button" class="action-btn edit-btn"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalUser{{ $usuario->id }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ===== Modales OWO ===== -->
@foreach($usuarios as $usuario)
<div class="modal fade" id="modalUser{{ $usuario->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#F61067; color:#fff;">
                <h5 class="modal-title">
                    <i class="fa-solid fa-user-gear me-2"></i>Editar {{ $usuario->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1)"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.usuarios.actualizar', $usuario->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Rol:</label>
                        <select name="role" class="form-select">
                            <option value="user" {{ $usuario->hasRole('user') ? 'selected' : '' }}>Usuario</option>
                            <option value="admin" {{ $usuario->hasRole('admin') ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-custom px-4">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
@push('scripts')
    <script>
        let table = new DataTable('#table-management-users', {
            responsive: true
        });
    </script>
@endpush