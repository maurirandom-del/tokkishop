{{-- resources/views/checkout/exito.blade.php --}}
@extends('layouts.app')

@section('title', '¡Compra Exitosa!')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fa-solid fa-circle-check fa-5x text-success"></i>
                    </div>

                    <h1 class="display-4 text-success mb-3">¡Compra Exitosa!</h1>
                    <p class="lead mb-4">
                        Tu pedido <strong>{{ $compra->numero_pedido }}</strong> ha sido procesado correctamente.
                    </p>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Total Pagado</h6>
                                    <h4 class="text-success">${{ number_format($compra->total, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Estado</h6>
                                    <span class="badge bg-warning fs-6">{{ ucfirst($compra->estado) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                        <a href="{{ route('checkout.descargar-ticket', $compra->id_compra) }}" 
                           class="btn btn-primary btn-lg me-md-2">
                            <i class="fa-solid fa-download me-2"></i>Descargar Ticket PDF
                        </a>

                        <a href="{{ route('checkout.ticket', $compra->id_compra) }}" 
                           class="btn btn-outline-primary btn-lg me-md-2">
                            <i class="fa-solid fa-eye me-2"></i>Ver Detalles
                        </a>

                        <a href="{{ route('home') }}" class="btn btn-success btn-lg">
                            <i class="fa-solid fa-home me-2"></i>Seguir Comprando
                        </a>
                    </div>

                    <!-- Información extra OWO -->
                    <div class="mt-5">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">¿Qué sigue?</h6>
                            <ul class="list-unstyled mb-0">
                                <li>Recibirás un correo de confirmación</li>
                                <li>Tu pedido será procesado en 24-48 horas</li>
                                <li>Te contactaremos si hay algún problema</li>
                                <li>El cargo aparecerá en tu estado de cuenta</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection