@extends('layouts.app')

@section('title', 'Historial ventas')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @can('venta.reportes')
                <div class="mb-2">
                    <a href="{{ route('venta.reportPdf') }}" class="btn btn-danger btn-sm" target="_blank">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                    <a href="{{ route('venta.reportExcel') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Excel
                    </a>
                </div>
            @endcan
            <div class="card">
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert fade_success .fade">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert fade_error .fade">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display responsive nowrap" width="100%"
                            id="tblVentas">
                            <thead class="thead">
                                <tr>
                                    <th>Id</th>
                                    <th>Monto</th>
                                    <th>Cliente</th>
                                    <th>Método</th>
                                    <th>Forma Pago</th>
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
    <style>
        .dt-buttons button {
            background: white;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script>
        var ticketUrl = "{{ route('venta.ticket', ['id' => 0]) }}";
        var anularUrl = "{{ route('venta.anular', ['id' => 0]) }}";
        document.addEventListener("DOMContentLoaded", function() {
            new DataTable('#tblVentas', {
                responsive: true,
                ajax: {
                    url: '{{ route('sales.list') }}',
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'cliente'
                    },
                    {
                        data: 'metodo'
                    },
                    {
                        data: 'formapago'
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
                            return `<a class="btn btn-sm btn-danger" target="_blank" href="${ticketUrl.replace('0', row.id)}"><i class="fas fa-print"></i></a>` +
                                `<a class="btn btn-sm btn-warning" onclick="anularVenta(${row.id})" href="#"><i class="fas fa-trash"></i></a>`;
                        }

                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
                },
                dom: "<'row'<'col-sm-12 text-center'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'>,'PQlfrtip' ",
                buttons: [{
                        //Botón para Excel
                        extend: 'excelHtml5',
                        footer: true,
                        text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
                    },
                    //Botón para PDF
                    {
                        extend: 'pdfHtml5',
                        download: 'open',
                        footer: true,
                        text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    //Botón para print
                    {
                        extend: 'print',
                        footer: true,
                        text: '<span class="badge bg-purple"><i class="fas fa-print"></i></span>'
                    },
                    //Botón para cvs
                    {
                        extend: 'csvHtml5',
                        footer: true,
                        text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
                    },
                    {
                        extend: 'colvis',
                        text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
                        postfixButtons: ['colvisRestore']
                    }
                ],
                searchPanes: {
                    columns: [3, 4]
                },
                order: [
                    [0, 'desc']
                ]
            });
        });

        function anularVenta(ventaId) {
            Swal.fire({
                title: "Anular",
                text: "¿Estás seguro de anular la venta?",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, anular!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.querySelector('#deleteForm');
                    form.action = anularUrl.replace('0', ventaId);
                    // Enviar el formulario
                    form.submit();
                }
            });
        }
    </script>
@stop
