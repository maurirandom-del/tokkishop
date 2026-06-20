@extends('layouts.app')
@section('content')
<div class="container mt-5">
  <div class="card shadow p-4" style="max-width: 1200px; margin: 0 auto;">
    @if(!$viewmode)
      <h1 class="text-center mb-4 text-dark">Editar Producto</h1>
    @else 
      <h1 class="text-center mb-4 text-dark">Producto  {{$producto->id_producto }}: {{ $producto->nombre }}</h1>
    @endif
    
    <form action="{{ $viewmode ? '#' : route('productos.update', $producto->id_producto) }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-center">
    @csrf
    @if(!$viewmode)
      @method('PUT')
    @endif

      <div class="col-md-4">
        <label for="nombre" class="form-label">Nombre del Producto</label>
        <input 
        type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" 
        {{ $viewmode ? 'readonly' : '' }}>
      </div>

      <div class="col-md-4">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="1" {{ $viewmode ? 'readonly' : '' }}>
            {{ old('descripcion', $producto->descripcion) }}
        </textarea>
      </div>

      <div class="col-md-4">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" class="form-control" id="precio" name="precio" step="0.01" value="{{ old('precio', 
        $producto->precio) }}" {{ $viewmode ? 'readonly' : '' }}>
      </div>

      <div class="col-md-4">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $producto->stock) }}" {{ $viewmode ? 'readonly' : '' }}>
      </div>

      <div class="col-md-4">
        <label for="id_talla" class="form-label">Talla</label>
        <select name="id_talla" id="id_talla" class="form-select" {{ $viewmode ? 'disabled' : '' }}>
          @foreach($tallas as $talla)
            <option value="{{$talla->id_talla}}" {{ $talla->id_talla == $producto->id_talla ? 'selected' : '' }}>
                {{$talla->talla}}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <label for="id_color" class="form-label">Color</label>
        <select name="id_color" id="id_color" class="form-select" {{ $viewmode ? 'disabled' : '' }}>
          @foreach($colores as $color)
            <option value="{{$color->id_color}}" {{ $color->id_color == $producto->id_color ? 'selected' : '' }}>
                {{$color->nombre}}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label for="id_categoria" class="form-label">Categoría</label>
        <select name="id_categoria" id="id_categoria" class="form-select" {{ $viewmode ? 'disabled' : '' }}>
          @foreach($categorias as $categoria)
            <option value="{{$categoria->id_categoria}}" {{$categoria->id_categoria==$producto->id_categoria ? 'selected' : '' }}>
                {{$categoria->nombre}}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label for="imagen_url" class="form-label">URL de la imagen del Producto</label>
        <input type="text" class="form-control" id="imagen_url" name="imagen_url" value="{{ old('imagen_url', $producto->imagen_url) }}" {{ $viewmode ? 'readonly' : '' }}>
      </div>

      <div class="col-12 d-flex justify-content-end mt-3">
        <a href="/admin/productos"><button type="button" class="btn btn-custom fs-3 me-3">Regresar</button></a>  
        @unless($viewmode)     
        <button type="submit" class="btn btn-custom fs-3">Guardar</button>
        @endunless
      </div>
    </form>
  </div>
</div>
@endsection