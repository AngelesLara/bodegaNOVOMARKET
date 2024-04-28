@extends('layouts.app')

@section('title', 'Gastos')

@section('content')
    <div class="row">
        <div class="col-sm-12">

            <div class="mb-2 btn-group" role="group" aria-label="Button group">
                @can('gastos.create')
                    <a href="{{ route('gastos.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i>
                    </a>
                @endcan
                @can('gastos.reportes')
                    <a href="{{ route('gastos.pdf') }}" target="_blank" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i>
                    </a>
                    <a href="{{ route('gastos.excel') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i>
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
                            id="tblGastos">
                            <thead class="thead">
                                <tr>
                                    <th>ID</th>
                                    <th>Monto</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Foto</th>
                                    <th>Acciones</th>
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
        var editUrl = "{{ route('gastos.edit', ['gasto' => 0]) }}";
        var deleteUrl = "{{ route('gastos.destroy', ['gasto' => 0]) }}";
        document.addEventListener("DOMContentLoaded", function() {

            new DataTable('#tblGastos', {
                responsive: true,
                fixedHeader: true,
                ajax: {
                    url: '{{ route('gastos.list') }}',
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'monto'
                    },
                    {
                        data: 'usuario'
                    },
                    {
                        // Agregar columna para acciones
                        data: 'created_at',
                        render: function(data, type, row, meta) {
                            if (type === 'display') {
                                // Formatear la fecha en el formato deseado
                                return new Date(data).toLocaleString();
                            }
                            return data;
                        }
                    },
                    {
                        data: 'descripcion'
                    },
                    {
                        data: 'foto',
                        render: function(data, type, row) {
                            // Verificar si hay una ruta de imagen
                            if (data) {
                                return `<img class="img-thumbnail" src="${data}" alt="Foto">`;
                            } else {
                                return 'Sin foto';
                            }
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<a class="btn btn-sm btn-primary" href="${editUrl.replace('0', row.id)}"><i class="fas fa-edit"></i></a>` +
                                '<button class="btn btn-sm btn-danger" onclick="deleteGasto(' +
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


        // Función para eliminar un gasto
        function deleteGasto(gastoId) {
            Swal.fire({
                title: "Eliminar",
                text: "¿Estás seguro de que quieres eliminar este gasto?",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.querySelector('#deleteForm');
                    form.action = deleteUrl.replace('0', gastoId);
                    // Enviar el formulario
                    form.submit();
                }
            });
        }
    </script>
@stop
