@extends('layouts.app')

@section('title', 'Nueva cotización')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mb-2">
                <a href="{{ route('cotizacion.show') }}" class="btn btn-primary btn-sm" data-placement="left">
                    {{ __('Listar cotizaciones') }}
                </a>
            </div>
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary"><i class="fas fa-search"></i></span>
                                </div>
                                <input id="buscarCliente" class="form-control" type="text" placeholder="Buscar Cliente">
                                <input id="id_cliente" class="form-control" type="hidden">
                            </div>
                            <span id="errorBusqueda" class="text-danger"></span>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary"><i class="fas fa-phone"></i></span>
                                </div>
                                <input id="tel_cliente" class="form-control" placeholder="Telefono" type="text" disabled>
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary"><i class="fas fa-home"></i></span>
                                </div>
                                <input id="dir_cliente" class="form-control" type="text" placeholder="Direccion"
                                    disabled>
                            </div>
                        </div>
                    </div>

                    @livewire('product-cotizacion')

                    <button class="btn btn-primary fixed-button" id="btnCotizacion" type="button">Generar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script>
        var cotizacionUrl = "{{ route('cotizacion.index') }}";
        var ticketUrl = "{{ route('cotizacion.ticket', ['id' => 0]) }}";
        const btnCotizacion = document.querySelector('#btnCotizacion');
        document.addEventListener('DOMContentLoaded', function() {
            $("#buscarCliente").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('cotizacion.cliente') }}",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            if (data.length === 0) {
                                errorBusqueda.textContent = "No se encontraron resultados.";
                            } else {
                                errorBusqueda.textContent = '';
                            }
                            response(data);
                        }
                    });
                },
                minLength: 2, // Número mínimo de caracteres para mostrar sugerencias
                select: function(event, ui) {
                    id_cliente.value = ui.item.id;
                    tel_cliente.value = ui.item.telefono,
                        dir_cliente.value = ui.item.direccion
                }
            });
            btnCotizacion.addEventListener('click', function() {
                if (id_cliente.value == '') {
                    Swal.fire({
                        title: "Respuesta",
                        text: 'El cliente es requerido',
                        icon: 'warning'
                    });
                } else {
                    Swal.fire({
                        title: "Mensaje?",
                        text: "Esta seguro de procesar la cotizacion!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, procesar!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(cotizacionUrl, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id_cliente: id_cliente.value
                                    })
                                })
                                .then(response => {
                                    return response.json();
                                })
                                .then(data => {
                                    Swal.fire({
                                        title: "Respuesta",
                                        text: data.title,
                                        icon: data.icon
                                    });
                                    if (data.icon == 'success') {
                                        setTimeout(() => {
                                            window.open(
                                                `${ticketUrl.replace('0', data.ticket)}`,
                                                '_blank');
                                            window.location.reload();
                                        }, 1500);
                                    } else {

                                    }
                                })
                                .catch(error => {
                                    // Manejar errores
                                    console.error('Error: ', error);
                                });
                        }
                    });
                }

            })
        })
    </script>
@stop
