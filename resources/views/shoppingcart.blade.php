@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row">

    <!-- 🛍️ Catálogo principal -->
    <div class="col-12 col-lg-9 p-4">
      <div class="container py-4">
        <h1 class="text-center mb-5 bebas-neue-regular"><i class="fa-solid fa-cart-shopping me-2"></i>Carrito de Compras</h1>

        {{-- Mensajes de sesión --}}
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        {{-- Si hay productos en el carrito --}}
        @if($carrito->count() > 0)
          <div class="row g-4">
            @foreach ($carrito as $item)
              @if($item->producto)
              <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow-sm h-100">
                  <div class="ratio ratio-1x1">
                    <img src="{{ $item->producto->imagen_url }}" 
                         class="card-img-top rounded-0" 
                         alt="{{ $item->producto->nombre }}">
                  </div>
                  <div class="card-body text-center d-flex flex-column">
                    <h5 class="card-title outfit-regular fw-semibold">{{ $item->producto->nombre }}</h5>
                    <p class="card-text text-muted mb-1">${{ number_format($item->producto->precio, 2) }}</p>
                    <p class="text-secondary mb-2">Cantidad: {{ $item->cantidad }}</p>
                    <div class="mt-auto">
                      <form action="{{ route('carrito.eliminar', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-delate w-100 fs-5" onclick="return confirm('¿Eliminar este producto del carrito?')">
                          <i class="fa-solid fa-trash me-2"></i>Eliminar
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              @endif
            @endforeach
          </div>

        {{-- Si el carrito está vacío --}}
        @else
          <div class="alert alert-info text-center fs-5 py-4">
            <div class="mb-3">
              <i class="fas fa-shopping-cart fa-3x text-muted"></i>
            </div>
            Tu carrito está vacío 💨
            <div class="mt-3">
              <a href="{{ route('home') }}" class="btn btn-custom btn-lg px-4">
                <i class="fa-solid fa-arrow-left me-2"></i>Seguir Comprando
              </a>
            </div>
          </div>
        @endif
      </div>
    </div>

    <!-- 🧾 Aside derecho del carrito -->
    <aside class="col-12 col-lg-3 p-4 carrito-aside">
      <div class="carrito-box shadow p-4 sticky-top" style="top: 20px;">
        <h2 class="text-center mb-4 bebas-neue-regular text-pink">
          <i class="fa-solid fa-receipt me-2"></i>Resumen del Carrito
        </h2>

        @if($carrito->count() > 0)
          <ul class="carrito-lista outfit-regular mb-3">
            @foreach ($carrito as $item)
              @if($item->producto)
              <li class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-truncate" style="max-width: 65%;" title="{{ $item->producto->nombre }}">
                  {{ $item->producto->nombre }}
                </span>
                <span class="text-nowrap fw-semibold">
                  ${{ number_format($item->producto->precio * $item->cantidad, 2) }}
                </span>
              </li>
              @endif
            @endforeach
          </ul>

          <hr>
          <div class="d-flex justify-content-between fs-5 mb-3">
            <strong>Total</strong>
            <strong class="text-pink">${{ number_format($total, 2) }}</strong>
          </div>
          
          <!-- Botón de checkout -->
          <a href="{{ route('checkout.index') }}" class="btn btn-custom w-100 fs-4 mb-3 py-2">
            <i class="fa-solid fa-credit-card me-2 mt-1"></i>Finalizar Compra
          </a>

          <div class="text-center">
            <small class="text-muted">
              <i class="fa-solid fa-truck me-1"></i>Envío calculado en checkout
            </small>
          </div>

        @else
          <div class="text-center text-muted mt-3 py-4">
            <i class="fa-solid fa-cart-shopping fa-2x mb-3"></i>
            <p class="mb-0">Sin productos en el carrito</p>
          </div>
        @endif
      </div>
    </aside>
  </div>
</div>

{{-- Pequeño CSS adicional para coherencia TokkiShop --}}
<style>
.text-pink {
  color: #F61067;
}
</style>
@endsection
