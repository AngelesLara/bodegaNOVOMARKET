@extends('layouts.app')

@section('title', 'Categorias')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @can('categorias.create')
                <div class="mb-2">
                    <a href="{{ route('categorias.create') }}" class="btn btn-primary btn-sm" data-placement="left">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            @endcan

            <div class="card">
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ $message }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display responsive nowrap" width="100%"
                            id="tblCategories">
                            <thead class="thead">
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
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
        var editUrl = "{{ route('categorias.edit', ['categoria' => 0]) }}";
        var deleteUrl = "{{ route('categorias.destroy', ['categoria' => 0]) }}";
        document.addEventListener("DOMContentLoaded", function() {
            new DataTable('#tblCategories', {
                responsive: true,
                fixedHeader: true,
                ajax: {
                    url: '{{ route('categories.list') }}',
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        // Agregar columna para acciones
                        data: null,
                        render: function(data, type, row) {
                            // Agregar botones de editar y eliminar
                            return `<a class="btn btn-sm btn-primary" href="${editUrl.replace('0', row.id)}"><i class="fas fa-edit"></i></a>` +
                                '<button class="btn btn-sm btn-danger" onclick="deleteCategory(' +
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

        // Función para eliminar un categoria
        function deleteCategory(catId) {
            Swal.fire({
                title: "Eliminar",
                text: "¿Estás seguro de que quieres eliminar este categoria?",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.querySelector('#deleteForm');
                    form.action = deleteUrl.replace('0', catId);
                    // Enviar el formulario
                    form.submit();
                }
            });
        }
    </script>
@stop
