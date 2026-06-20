@extends('layouts.app')
@section('content')
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <h1 style="text-align: center; margin-bottom: 20px; color: #333;">Gestión de Productos</h1>        
        <table class="table-management-product">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                <tr>
                    <td class="product-image-cell">
                        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="img-product" width="150" height="150">
                    </td>
                    <td class="product-name">{{ $producto->nombre }}</td>
                    <td class="product-description">{{ $producto->descripcion }}</td>
                    <td class="product-price">{{ $producto->precio }}</td>
                    <td><span class="product-stock stock-high">{{ $producto->stock }}</span></td>
                    <td>
                        <div class="product-actions">
                            <a href="{{ route('productos.show', $producto->id_producto) }}"><button class="action-btn view-btn"><i class="fa-solid fa-eye"></i></button></a>
                            <a href="{{ route('productos.edit', $producto->id_producto) }}"><button class="action-btn edit-btn"><i class="fa-solid fa-pen"></i></button></a>
                            <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn"
                                        onclick="return confirm('¿Seguro que quieres eliminar este producto?')">
                                    <i class="fa-solid fa-x"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <a href="/admin/subir-producto"><button class="btn btn-custom fs-3">Agregar Producto</button></a> 
        </div>
</div>
@endsection