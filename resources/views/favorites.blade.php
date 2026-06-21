@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h1 class="text-center mb-5">Mis Favoritos</h1>

  @if($favoritos->count() > 0)
    <div class="row g-4">
      @foreach ($favoritos as $producto)
        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
          <div class="card">
            <div class="ratio ratio-1x1">
              <img src="{{ $producto->imagen_url }}" class="card-img-top rounded-0" alt="{{ $producto->nombre }}">
            </div>

            <!-- Botón para quitar de favoritos -->
            <form action="{{ route('favoritos.eliminar', $producto->id_producto) }}" method="POST" class="position-absolute top-0 end-0 m-2">
              @csrf
              @method('DELETE')
              <button class="btn btn-favorite-delate fs-5" title="Quitar de favoritos">
                <i class="fa-solid fa-star"></i>
              </button>
            </form>

            <div class="card-body text-center">
              <h5 class="card-title">{{ $producto->nombre }}</h5>
              <p class="card-text text-muted">${{ number_format($producto->precio, 2) }}</p>

              <!-- Botón para añadir al carrito -->
              <form action="{{ route('carrito.agregar', $producto->id_producto) }}" method="POST">
                @csrf
                <button class="btn btn-custom w-100 fs-5">
                  Añadir al carrito
                  <i class="ps-2 pt-1 fa-solid fa-cart-plus"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <div class="alert alert-info text-center fs-5 mt-4">
      No tienes productos favoritos todavía
    </div>
  @endif
</div>
@endsection
