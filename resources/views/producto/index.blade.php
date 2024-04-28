@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mb-2 btn-group" role="group" aria-label="Button group">
                @can('productos.create')
                    <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i>
                    </a>
                @endcan
                @can('productos.reportes')
                    <a href="{{ route('productos.pdf') }}" target="_blank" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i>
                    </a>
                    <a href="{{ route('productos.excel') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i>
                    </a>
                    <a href="{{ route('productos.barcode') }}" target="_blank" class="btn btn-secondary btn-sm">
                        <i class="fas fa-barcode"></i>
                    </a>
                @endcan
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ $message }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display responsive nowrap" width="100%"
                            id="tblProducts">
                            <thead class="thead">
                                <tr>
                                    <th>Id</th>
                                    <th>Codigo</th>
                                    <th>Producto</th>
                                    <th>P. compra</th>
                                    <th>P. venta</th>
                                    <th>Stock</th>
                                    <th>Categoria</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="deleteForm" action="#" method="post">
        @csrf
        @method('DELETE')
    </form>
@stop

@section('css')
    <link href="DataTables/datatables.min.css" rel="stylesheet">
@endsection

@section('js')
    <script src="DataTables/datatables.min.js"></script>
    <script>
        var editUrl = "{{ route('productos.edit', ['producto' => 0]) }}";
        var deleteUrl = "{{ route('productos.destroy', ['producto' => 0]) }}";
        document.addEventListener("DOMContentLoaded", function() {
            new DataTable('#tblProducts', {
                responsive: true,
                fixedHeader: true,
                dom: 'Pfrtip', // Agrega los elementos necesarios para SearchPane
                searchPanes: {
                    columns: [6]
                },
                ajax: {
                    url: '{{ route('products.list') }}',
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'codigo'
                    },
                    {
                        data: 'producto'
                    },
                    {
                        data: 'precio_compra'
                    },
                    {
                        data: 'precio_venta'
                    },
                    {
                        data: 'stock'
                    },
                    {
                        data: 'categoria'
                    },
                    {
                        data: 'foto',
                        render: function(data, type, row) {
                            return data ? '<img src="storage/' + data +
                                '" alt="Imagen del Producto" style="max-width: 100px; max-height: 100px;">' :
                                'Sin imagen';
                        }
                    },
                    {
                        // Agregar columna para acciones
                        data: null,
                        render: function(data, type, row) {
                            // Agregar botones de editar y eliminar
                            return `<a class="btn btn-sm btn-primary" href="${editUrl.replace('0', row.id)}"><i class="fas fa-edit"></i></a>` +
                                '<button class="btn btn-sm btn-danger" onclick="deleteProduct(' +
                                row.id + ')"><i class="fas fa-trash"></i></button>';
                        }
                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
                },
                order: [
                    [0, 'desc']
                ]
            });
        });

        // Función para eliminar un producto
        function deleteProduct(productId) {
            Swal.fire({
                title: "Eliminar",
                text: "¿Estás seguro de que quieres eliminar este producto?",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.querySelector('#deleteForm');
                    form.action = deleteUrl.replace('0', productId);
                    // Enviar el formulario
                    form.submit();
                }
            });
        }
    </script>
@stop
