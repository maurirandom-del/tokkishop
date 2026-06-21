@extends('layouts.app')

@section('title', 'Checkout - Finalizar Compra')

@push('styles')
<style>
/* Estilos personalizados para Quill */
.ql-editor {
    min-height: 120px;
    font-size: 14px;
}

.ql-toolbar.ql-snow {
    border-top: 1px solid #ccc;
    border-left: 1px solid #ccc;
    border-right: 1px solid #ccc;
    border-bottom: none;
}

.ql-container.ql-snow {
    border: 1px solid #ccc;
    border-top: none;
    border-radius: 0 0 0.375rem 0.375rem;
}

#editor {
    height: 150px;
}
</style>
@endpush

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-5"><i class="fa-solid fa-cart-shopping me-2"></i>Finalizar Compra</h1>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show text-center">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">
        <!-- IZQUIERDA: FORMULARIO -->
        <div class="col-lg-8">
            <form action="{{ route('checkout.procesar') }}" method="POST" id="checkout-form">
                @csrf

                <!-- DIRECCIÓN DE ENVÍO -->
                <div class="carrito-box mb-4 p-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        <h5 class="text-pink"><i class="fa-solid fa-truck me-2"></i>Dirección de Envío</h5>
                        <a href="{{ route('checkout.direcciones') }}" class="btn btn-custom fs-5 btn-sm px-3">
                            <i class="fa-solid fa-pen mt-1 me-2 ms-0"></i>Editar
                        </a>
                    </div>

                    @if($direcciones->count() > 0)
                        @foreach($direcciones as $direccion)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="id_direccion"
                                       id="direccion{{ $direccion->id_direccion }}"
                                       value="{{ $direccion->id_direccion }}"
                                       {{ $direccion->es_principal ? 'checked' : '' }} required>
                                <label class="form-check-label" for="direccion{{ $direccion->id_direccion }}">
                                    <strong>{{ $direccion->calle }} #{{ $direccion->numero_exterior }}</strong>
                                    @if($direccion->numero_interior)
                                        Int. {{ $direccion->numero_interior }}
                                    @endif
                                    <br>
                                    {{ $direccion->colonia }}, {{ $direccion->ciudad }}, {{ $direccion->estado }}
                                    <br>
                                    C.P. {{ $direccion->codigo_postal }}
                                    @if($direccion->es_principal)
                                        <span class="badge bg-success ms-2">Principal</span>
                                    @endif
                                </label>
                            </div>
                            <hr>
                        @endforeach
                    @else
                        <div class="alert alert-warning">
                            <p class="mb-2">No tienes direcciones guardadas.</p>
                            <a href="{{ route('checkout.direcciones') }}" class="btn btn-custom btn-sm">
                                <i class="fa-solid fa-plus me-2"></i>Agregar Mi Primera Dirección
                            </a>
                        </div>
                    @endif
                </div>

                <!-- MÉTODO DE PAGO -->
                <div class="carrito-box mb-4 p-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        <h5 class="text-pink"><i class="fa-solid fa-credit-card me-2"></i>Método de Pago</h5>
                        <a href="{{ route('checkout.metodos-pago') }}" class="btn btn-custom btn-sm px-3 fs-5">
                            <i class="fa-solid fa-pen mt-1 me-2 ms-0"></i>Editar
                        </a>
                    </div>

                    @if($metodosPago->count() > 0)
                        @foreach($metodosPago as $metodo)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="id_metodo_pago"
                                       id="metodo{{ $metodo->id_metodo_pago }}"
                                       value="{{ $metodo->id_metodo_pago }}"
                                       {{ $metodo->es_principal ? 'checked' : '' }} required>
                                <label class="form-check-label" for="metodo{{ $metodo->id_metodo_pago }}">
                                    <strong>
                                        @switch($metodo->tipo)
                                            @case('tarjeta_credito')
                                                <i class="fa-solid fa-credit-card me-1"></i>Tarjeta de Crédito
                                                @break
                                            @case('tarjeta_debito')
                                                <i class="fa-solid fa-credit-card me-1"></i>Tarjeta de Débito
                                                @break
                                            @case('paypal')
                                                <i class="fa-brands fa-paypal me-1"></i>PayPal
                                                @break
                                            @default
                                                <i class="fa-solid fa-building-columns me-1"></i>Transferencia
                                        @endswitch
                                    </strong>
                                    <br>{{ $metodo->titular }}
                                    @if($metodo->numero_tarjeta)
                                        <br>Tarjeta: **** **** **** {{ $metodo->numero_tarjeta }}
                                    @endif
                                    @if($metodo->es_principal)
                                        <span class="badge bg-success ms-2">Principal</span>
                                    @endif
                                </label>
                            </div>
                            <hr>
                        @endforeach
                    @else
                        <div class="alert alert-warning">
                            <p class="mb-2">No tienes métodos de pago guardados.</p>
                            <a href="{{ route('checkout.metodos-pago') }}" class="btn btn-custom btn-sm">
                                <i class="fa-solid fa-plus me-2"></i>Agregar Mi Primer Método de Pago
                            </a>
                        </div>
                    @endif
                </div>

                <!-- NOTAS ADICIONALES -->
                <div class="carrito-box mb-4 p-3 shadow-sm">
                    <h5 class="text-pink mb-3"><i class="fa-solid fa-note-sticky me-2"></i>Notas Adicionales</h5>
                    
                    <!-- Contenedor para Quill -->
                    <div id="editor-container">
                        <div id="editor"></div>
                    </div>
                    
                    <!-- Campo hidden para enviar el contenido HTML -->
                    <input type="hidden" name="notas" id="notas-content">
                    
                    <small class="text-muted">Opcional: Estas notas serán enviadas al vendedor.</small>
                </div>
            </form>
        </div>

        <!-- DERECHA: RESUMEN -->
        <div class="col-lg-4">
            <div class="carrito-box p-3 shadow-sm sticky-top" style="top: 20px;">
                <h5 class="text-pink border-bottom pb-2 mb-3">
                    <i class="fa-solid fa-receipt me-2"></i>Resumen del Pedido
                </h5>

                <h6 class="fw-bold">Productos:</h6>
                <div class="mb-3" style="max-height: 200px; overflow-y: auto;">
                    @foreach($carritoItems as $item)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <small class="d-block">{{ $item->producto->nombre }}</small>
                            <small class="text-muted">Cantidad: {{ $item->cantidad }}</small>
                        </div>
                        <small>${{ number_format($item->producto->precio * $item->cantidad, 2) }}</small>
                    </div>
                    @endforeach
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span><span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Envío:</span><span>${{ number_format($envio, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Impuestos:</span><span>${{ number_format($impuestos, 2) }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fs-5 fw-bold mb-3">
                    <span>Total:</span><span>${{ number_format($total, 2) }}</span>
                </div>

                <button type="submit" form="checkout-form"
                        class="btn btn-custom fs-3 w-100 py-2 mt-2"
                        {{ $direcciones->count() == 0 || $metodosPago->count() == 0 ? 'disabled' : '' }}>
                    <i class="fa-solid fa-lock me-2 mt-1"></i>Confirmar Compra
                </button>

                @if($direcciones->count() == 0 || $metodosPago->count() == 0)
                <div class="alert alert-warning mt-3 text-center">
                    <small>
                        <i class="fa-solid fa-exclamation-triangle me-1"></i>
                        Para continuar necesitas:
                        @if($direcciones->count() == 0)
                            <strong>una dirección de envío</strong>
                        @endif
                        @if($direcciones->count() == 0 && $metodosPago->count() == 0)
                            y
                        @endif
                        @if($metodosPago->count() == 0)
                            <strong>un método de pago</strong>
                        @endif
                    </small>
                </div>
                @endif

                <div class="text-center mt-3">
                    <a href="{{ route('carrito.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa-solid fa-arrow-left me-2"></i>Volver al Carrito
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Quill
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                ['clean']
            ]
        },
        placeholder: 'Instrucciones especiales para la entrega, horarios preferidos, etc...',
    });

    // Actualizar el campo hidden con el contenido HTML cuando el formulario se envía
    document.getElementById('checkout-form').addEventListener('submit', function() {
        const editorContent = quill.root.innerHTML;
        document.getElementById('notas-content').value = editorContent;
    });

    // También actualizar el campo hidden cuando el editor cambie
    quill.on('text-change', function() {
        const editorContent = quill.root.innerHTML;
        document.getElementById('notas-content').value = editorContent;
    });
});
</script>
@endpush