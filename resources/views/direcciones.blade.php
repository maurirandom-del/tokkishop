{{-- resources/views/checkout/direcciones.blade.php --}}
@extends('layouts.app')

@section('title', 'Mis Direcciones')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5">Mis Direcciones de Envío</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Formulario para agregar dirección -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-plus me-2"></i>Agregar Nueva Dirección
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.direcciones.guardar') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="calle">Calle *</label>
                                    <input type="text" class="form-control" id="calle" name="calle" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="numero_exterior">No. Ext. *</label>
                                    <input type="text" class="form-control" id="numero_exterior" name="numero_exterior" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="numero_interior">No. Interior (opcional)</label>
                            <input type="text" class="form-control" id="numero_interior" name="numero_interior">
                        </div>

                        <div class="form-group">
                            <label for="colonia">Colonia *</label>
                            <input type="text" class="form-control" id="colonia" name="colonia" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad *</label>
                                    <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado">Estado *</label>
                                    <input type="text" class="form-control" id="estado" name="estado" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="codigo_postal">Código Postal *</label>
                            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" required>
                        </div>

                        <div class="form-group">
                            <label for="pais">País *</label>
                            <input type="text" class="form-control" id="pais" name="pais" value="México" required>
                        </div>

                        <div class="form-group">
                            <label for="referencias">Referencias (opcional)</label>
                            <textarea class="form-control" id="referencias" name="referencias" rows="2" placeholder="Entre calles, puntos de referencia..."></textarea>
                        </div>

                        @if($direcciones->count() > 0)
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="es_principal" name="es_principal" value="1">
                                <label class="form-check-label" for="es_principal">Establecer como dirección principal</label>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fa-solid fa-save me-2"></i>Guardar Dirección
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista de direcciones existentes -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-list me-2"></i>Mis Direcciones ({{ $direcciones->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($direcciones->count() > 0)
                        @foreach($direcciones as $direccion)
                            <div class="card mb-3 {{ $direccion->es_principal ? 'border-primary' : '' }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        @if($direccion->es_principal)
                                            <span class="badge badge-primary">Principal</span>
                                        @else
                                            <span class="badge badge-secondary">Secundaria</span>
                                        @endif
                                        
                                        @if(!$direccion->es_principal)
                                            <form action="{{ route('checkout.direcciones.establecer-principal', $direccion->id_direccion) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="fa-solid fa-star me-1"></i>Hacer Principal
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    
                                    <h6 class="card-title">{{ $direccion->calle }} #{{ $direccion->numero_exterior }}</h6>
                                    <p class="card-text mb-1">
                                        @if($direccion->numero_interior)
                                            Int. {{ $direccion->numero_interior }}<br>
                                        @endif
                                        {{ $direccion->colonia }}<br>
                                        {{ $direccion->ciudad }}, {{ $direccion->estado }}<br>
                                        C.P. {{ $direccion->codigo_postal }}, {{ $direccion->pais }}
                                    </p>
                                    @if($direccion->referencias)
                                        <small class="text-muted">
                                            <strong>Referencias:</strong> {{ $direccion->referencias }}
                                        </small>
                                    @endif
                                    
                                    <div class="mt-3">
                                        @if(!$direccion->es_principal)
                                            <form action="{{ route('checkout.direcciones.eliminar', $direccion->id_direccion) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta dirección?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa-solid fa-trash me-1"></i>Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fa-solid fa-home fa-2x mb-3"></i>
                            <p>No tienes direcciones guardadas</p>
                            <small class="text-info">La primera dirección que agregues será establecida como principal automáticamente</small>
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('checkout.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Volver al Checkout
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
