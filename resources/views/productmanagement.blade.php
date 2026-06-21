@extends('layouts.app')
@section('content')
@role('admin')

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center ms-5">
                <h1><i class="fa-solid fa-boxes me-2"></i>Gestión de Productos</h1>
                <a href="{{ route('admin.dashboard') }}" class="btn me-5 btn-outline-secondary">Volver</a>
            </div>
        </div>
    </div>

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 10px;">    
        <table class="table-management-product" id="table-management-product">
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
                            <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" class="form-delete" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="action-btn delete-btn btn-delete">
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
@endrole
@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Excel -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#table-management-product').DataTable({
        // Español
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        
        // 50 elementos por página
        pageLength: 50,
        
        // Ordenar por Producto (columna 1)
        order: [[1, 'asc']],
        
        // Botón Excel
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: 'Exportar Excel',
                className: 'btn btn-success'
            }
        ],
        
        columnDefs: [
            {
                targets: [2],
                visible: false
            }
        ]
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Activamos SweetAlert en cualquier botón de eliminar
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            let form = this.closest('form');

            Swal.fire({
                title: "¿Eliminar producto?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

});
</script>

@endpush