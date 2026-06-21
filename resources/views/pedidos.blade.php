@extends('layouts.app')

@section('title', 'Gestión de Pedidos')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fa-solid fa-shopping-cart me-2"></i>Gestión de Pedidos</h1>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Volver al Dashboard
                </a>
            </div>
        </div>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Estadísticas --}}
    <div class="row mb-4 text-center">
        <div class="col-md-3">
            <div class="carrito-box p-3 shadow-sm">
                <h3 class="text-pink bebas-neue-regular">{{ $estadisticas['total'] }}</h3>
                <p class="text-muted mb-0 outfit-regular">Total Pedidos</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="carrito-box p-3 shadow-sm">
                <h3 class="text-warning bebas-neue-regular">{{ $estadisticas['pendientes'] }}</h3>
                <p class="text-muted mb-0 outfit-regular">Pendientes</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="carrito-box p-3 shadow-sm">
                <h3 class="text-success bebas-neue-regular">{{ $estadisticas['entregados'] }}</h3>
                <p class="text-muted mb-0 outfit-regular">Entregados</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="carrito-box p-3 shadow-sm">
                <h3 class="text-pink bebas-neue-regular">${{ number_format($estadisticas['ingresos_totales'], 2) }}</h3>
                <p class="text-muted mb-0 outfit-regular">Ingresos Totales</p>
            </div>
        </div>
    </div>

    {{-- Tabla de pedidos --}}
    <div class="carrito-box shadow-sm p-4">
        <div class="table-responsive">
            <table class="table-management-product" id="table-management-pedidos">
                <thead>
                    <tr>
                        <th># Pedido</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                    <tr>
                        <td><strong>{{ $pedido->numero_pedido }}</strong></td>
                        <td>
                            {{ $pedido->user->name }}<br>
                            <small class="text-muted">{{ $pedido->user->email }}</small>
                        </td>
                        <td><span class="product-price">${{ number_format($pedido->total, 2) }}</span></td>
                        <td>
                            <span class="badge 
                                @switch($pedido->estado)
                                    @case('pendiente') bg-warning @break
                                    @case('confirmado') bg-info text-dark @break
                                    @case('enviado') bg-primary @break
                                    @case('entregado') bg-success @break
                                @endswitch">
                                {{ ucfirst($pedido->estado) }}
                            </span>
                        </td>
                        <td>
                            {{ $pedido->created_at->format('d/m/Y') }}<br>
                            <small class="text-muted">{{ $pedido->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <div class="product-actions">
                                <button type="button" class="action-btn view-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#verPedido{{ $pedido->id_compra }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button type="button" class="action-btn edit-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#cambiarEstado{{ $pedido->id_compra }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $pedidos->links() }}
        </div>
    </div>
</div>

{{-- === Modales === --}}
@foreach($pedidos as $pedido)
<!-- Detalles del pedido -->
<div class="modal fade" id="verPedido{{ $pedido->id_compra }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#F61067; color:white;">
                <h5 class="modal-title"><i class="fa-solid fa-file-invoice me-2"></i>Pedido {{ $pedido->numero_pedido }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1)"></button>
            </div>
            <div class="modal-body outfit-regular">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-pink">Cliente</h6>
                        <p><strong>Nombre:</strong> {{ $pedido->user->name }}</p>
                        <p><strong>Email:</strong> {{ $pedido->user->email }}</p>
                        <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-pink">Pedido</h6>
                        <p><strong>Estado:</strong> 
                            <span class="badge 
                                @switch($pedido->estado)
                                    @case('pendiente') bg-warning @break
                                    @case('confirmado') bg-info text-dark @break
                                    @case('enviado') bg-primary @break
                                    @case('entregado') bg-success @break
                                @endswitch">
                                {{ ucfirst($pedido->estado) }}
                            </span>
                        </p>
                        <p><strong>Subtotal:</strong> ${{ number_format($pedido->subtotal, 2) }}</p>
                        <p><strong>Envío:</strong> ${{ number_format($pedido->envio, 2) }}</p>
                        <p><strong>Impuestos:</strong> ${{ number_format($pedido->impuestos, 2) }}</p>
                        <p><strong>Total:</strong> ${{ number_format($pedido->total, 2) }}</p>
                    </div>
                </div>

                @if($pedido->productos->count() > 0)
                <hr>
                <h6 class="text-pink">Productos</h6>
                <table class="table table-sm table-borderless">
                    <thead>
                        <tr class="text-pink">
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedido->productos as $productoPedido)
                        <tr>
                            <td>{{ $productoPedido->producto->nombre ?? 'No disponible' }}</td>
                            <td>{{ $productoPedido->cantidad }}</td>
                            <td>${{ number_format($productoPedido->precio_unitario, 2) }}</td>
                            <td>${{ number_format($productoPedido->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

                @if($pedido->notas)
                <hr>
                <h6 class="text-pink">Notas del Cliente</h6>
                <p class="text-muted">{{ $pedido->notas }}</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-delate" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Cambiar estado -->
<div class="modal fade" id="cambiarEstado{{ $pedido->id_compra }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#A491D3; color:white;">
                <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Cambiar Estado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1)"></button>
            </div>
            <div class="modal-body outfit-regular">
                <form action="{{ route('admin.pedidos.actualizar', $pedido->id_compra) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Estado actual:</label>
                        <p>
                            <span class="badge 
                                @switch($pedido->estado)
                                    @case('pendiente') bg-warning @break
                                    @case('confirmado') bg-info text-dark @break
                                    @case('enviado') bg-primary @break
                                    @case('entregado') bg-success @break
                                @endswitch">
                                {{ ucfirst($pedido->estado) }}
                            </span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nuevo estado:</label>
                        <select name="estado" class="form-select">
                            <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="confirmado" {{ $pedido->estado == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                            <option value="enviado" {{ $pedido->estado == 'enviado' ? 'selected' : '' }}>Enviado</option>
                            <option value="entregado" {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-delate" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom px-4">
                            <i class="fa-solid fa-save me-2 mt-1"></i>Actualizar Estado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
.text-pink {
    color: #F61067;
}
</style>
@endsection
@push('scripts')
    <script>
        let table = new DataTable('#table-management-pedidos', {
            responsive: true
        });
    </script>
@endpush