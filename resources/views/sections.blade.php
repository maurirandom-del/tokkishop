@extends('layouts.app')

@section('content')
<div class="container text-center">
  <img src="https://i.ibb.co/nM4H9N05/tokkibanner.gif" alt="banner animado tokkishop" class="bannertokki">
</div>

<div class="container py-4">
  @foreach($categorias as $categoria)
  @if($categoria->id_categoria == $categoria_id)
  <h1 class="text-center mb-5">{{ $categoria->nombre }}</h1>
  @endif
  @endforeach

  <div class="row g-4">
    @foreach ($productos as $producto)
    @if($producto->id_categoria == $categoria_id && $producto->stock >= 1)
      <div class="col-6 col-sm-6 col-md-4 col-lg-3">
        <div class="card">
          <div class="ratio ratio-1x1">
            <img src="{{ $producto->imagen_url }}" class="card-img-top rounded-0" alt="{{ $producto->nombre }}"> 
          </div>
          <form action="{{ route('favoritos.agregar', $producto->id_producto) }}" method="POST">
            @csrf
            <button class="btn btn-favorite fs-5">
              <i class="fa-solid fa-star"></i>
            </button>
          </form>

          <div class="card-body text-center">
            <h5 class="card-title">{{ $producto->nombre }}</h5>
            <p class="card-text text-muted">${{ number_format($producto->precio, 2) }}</p>

            <form action="{{ route('carrito.agregar', $producto->id_producto) }}" method="POST">
              @csrf
              <button class="btn btn-custom w-100 fs-4">
                Añadir al carrito
                <i class="ps-2 pt-1 fa-solid fa-cart-plus"></i>
              </button>
            </form>
          </div>
        </div>
      </div> 
      @endif  
    @endforeach
  </div>
</div>
@endsection