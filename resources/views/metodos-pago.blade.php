{{-- resources/views/checkout/metodos-pago.blade.php --}}
@extends('layouts.app')

@section('title', 'Métodos de Pago')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5">Mis Métodos de Pago</h1>
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
        <!-- Formulario para agregar método de pago -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-credit-card me-2"></i>Agregar Método de Pago
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.metodos-pago.guardar') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="tipo">Tipo de Pago *</label>
                            <select class="form-control" id="tipo" name="tipo" required>
                                <option value="">Seleccionar tipo...</option>
                                <option value="tarjeta_credito">Tarjeta de Crédito</option>
                                <option value="tarjeta_debito">Tarjeta de Débito</option>
                                <option value="paypal">PayPal</option>
                                <option value="transferencia">Transferencia Bancaria</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="titular">Nombre del Titular *</label>
                            <input type="text" class="form-control" id="titular" name="titular" required>
                        </div>

                        <!-- Campos para tarjetas (se muestran solo si selecciona tarjeta) -->
                        <div id="campos-tarjeta" style="display: none;">
                            <div class="form-group">
                                <label for="numero_tarjeta">Número de Tarjeta *</label>
                                <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" 
                                       placeholder="1234 5678 9012 3456" maxlength="19">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_vencimiento">Fecha de Vencimiento *</label>
                                        <input type="text" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" 
                                               placeholder="MM/AA" maxlength="5">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cvv">CVV *</label>
                                        <input type="text" class="form-control" id="cvv" name="cvv" 
                                               placeholder="123" maxlength="4">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="es_principal" name="es_principal" value="1">
                            <label class="form-check-label" for="es_principal">Establecer como método de pago principal</label>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fa-solid fa-save me-2"></i>Guardar Método de Pago
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista de métodos de pago existentes -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-credit-card me-2"></i>Mis Métodos de Pago
                    </h5>
                </div>
                <div class="card-body">
                    @if($metodosPago->count() > 0)
                        @foreach($metodosPago as $metodo)
                            <div class="card mb-3 {{ $metodo->es_principal ? 'border-success' : '' }}">
                                <div class="card-body">
                                    @if($metodo->es_principal)
                                        <span class="badge badge-success mb-2">Principal</span>
                                    @endif
                                    <h6 class="card-title">
                                        @if($metodo->tipo == 'tarjeta_credito')
                                            <i class="fa-solid fa-credit-card me-2"></i>Tarjeta de Crédito
                                        @elseif($metodo->tipo == 'tarjeta_debito')
                                            <i class="fa-solid fa-credit-card me-2"></i>Tarjeta de Débito
                                        @elseif($metodo->tipo == 'paypal')
                                            <i class="fa-brands fa-paypal me-2"></i>PayPal
                                        @else
                                            <i class="fa-solid fa-building-columns me-2"></i>Transferencia
                                        @endif
                                    </h6>
                                    <p class="card-text mb-1">
                                        <strong>Titular:</strong> {{ $metodo->titular }}<br>
                                        @if($metodo->numero_tarjeta)
                                            <strong>Tarjeta:</strong> **** **** **** {{ $metodo->numero_tarjeta }}<br>
                                            <strong>Vence:</strong> {{ $metodo->fecha_vencimiento }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fa-solid fa-credit-card fa-2x mb-3"></i>
                            <p>No tienes métodos de pago guardados</p>
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

<script>
document.getElementById('tipo').addEventListener('change', function() {
    const camposTarjeta = document.getElementById('campos-tarjeta');
    const esTarjeta = this.value === 'tarjeta_credito' || this.value === 'tarjeta_debito';
    
    camposTarjeta.style.display = esTarjeta ? 'block' : 'none';
    
    // Hacer requeridos o no los campos de tarjeta
    const campos = ['numero_tarjeta', 'fecha_vencimiento', 'cvv'];
    campos.forEach(campo => {
        const input = document.getElementById(campo);
        input.required = esTarjeta;
    });
});

// Formatear número de tarjeta
document.getElementById('numero_tarjeta')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
    let formattedValue = value.match(/.{1,4}/g)?.join(' ');
    e.target.value = formattedValue || value;
});

// Formatear fecha de vencimiento
document.getElementById('fecha_vencimiento')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^0-9]/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    e.target.value = value;
});
</script>
@endsection