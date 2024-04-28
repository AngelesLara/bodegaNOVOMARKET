@extends('layouts.app')

@section('title', 'Historial cotización')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @can('cotizacion.reportes')
                <div class="mb-2 btn-group" role="group" aria-label="Button group">

                    <a href="{{ route('cotizaciones.pdf') }}" target="_blank" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i>
                    </a>
                    <a href="{{ route('cotizaciones.excel') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i>
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
                            id="tblCotizacions">
                            <thead class="thead">
                                <tr>
                                    <th>Id</th>
                                    <th>Monto</th>
                                    <th>Cliente</th>
                                    <th>Fecha/Hora</th>
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
        @method('PUT')
    </form>
@stop

@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script>
        var ticketUrl = "{{ route('cotizacion.ticket', ['id' => 0]) }}";
        var anularUrl = "{{ route('cotizacion.eliminar', ['id' => 0]) }}";
        document.addEventListener("DOMContentLoaded", function() {
            new DataTable('#tblCotizacions', {
                responsive: true,
                fixedHeader: true,
                ajax: {
                    url: '{{ route('cotizaciones.list') }}',
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'nombre'
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
                        // Agregar columna para acciones
                        data: null,
                        render: function(data, type, row) {
                            // Agregar botones de editar y eliminar
                            return `<a class="btn btn-sm btn-danger" target="_blank" href="${ticketUrl.replace('0', row.id)}">Ticket</a>` +
                                `<a class="btn btn-sm btn-warning" onclick="anularCotizacion(${row.id})" href="#">Eliminar</a>`;
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

        function anularCotizacion(cotizacionId) {
            Swal.fire({
                title: "Anular",
                text: "¿Estás seguro de eliminar la cotizacion?",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.querySelector('#deleteForm');
                    form.action = anularUrl.replace('0', cotizacionId);
                    // Enviar el formulario
                    form.submit();
                }
            });
        }
    </script>
@stop
