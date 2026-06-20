@extends('layouts.app')
@section('content')
<div class="container mt-5">
  <div class="card shadow p-4" style="max-width: 1200px; margin: 0 auto;">
    <h1 class="text-center mb-4 text-dark">Agregar Nuevo Producto</h1>

    <form action="{{ route('subir.producto') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-center">
      @csrf

      <div class="col-md-4">
        <label for="nombre" class="form-label">Nombre del Producto</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>

      <div class="col-md-4">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="1" required></textarea>
      </div>

      <div class="col-md-4">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
      </div>

      <div class="col-md-4">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" required>
      </div>

      <div class="col-md-4">
        <label for="id_talla" class="form-label">Talla</label>
        <select name="id_talla" id="id_talla" class="form-select">
          <option value="">Seleccionar talla</option>
          @foreach($tallas as $talla)
            <option value="{{$talla->id_talla}}">{{$talla->talla}}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-4">
        <label for="id_color" class="form-label">Color</label>
        <select name="id_color" id="id_color" class="form-select">
          <option value="">Seleccionar color</option>
          @foreach($colores as $color)
            <option value="{{$color->id_color}}">{{$color->nombre}}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label for="id_categoria" class="form-label">Categoría</label>
        <select name="id_categoria" id="id_categoria" class="form-select">
          <option value="">Seleccionar categoría</option>
          @foreach($categorias as $categoria)
            <option value="{{$categoria->id_categoria}}">{{$categoria->nombre}}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label for="imagen_url" class="form-label">URL de la imagen del Producto</label>
        <input type="text" class="form-control" id="imagen_url" name="imagen_url" required>
      </div>

      <div class="col-12 d-flex justify-content-end mt-3">
        <a href="/admin/productos"><button type="button" class="btn btn-custom fs-3 me-3">Regresar</button></a>        
        <button type="submit" class="btn btn-custom fs-3">Subir Producto</button>
      </div>
    </form>
  </div>
</div>
@endsection