@extends('layouts.app')

@section('title', 'Abonos')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mb-2">
                <div class="btn-group" role="group" aria-label="Button group">
                    <a href="{{ route('creditoventa.index') }}" class="btn btn-info btn-sm" data-placement="left">
                        {{ __('Creditos') }}
                    </a>
                    @if ($credito->venta->total - $abonado > 1)
                        <a href="#" class="btn btn-primary btn-sm" onclick="abonoCredito()">
                            {{ __('Abonar') }}
                        </a>
                    @endif

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-primary">Credito N°: {{ $credito->id }}</li>
                                <li class="list-group-item list-group-item-secondary">Fecha: {{ $credito->created_at }}
                                </li>
                                <li class="list-group-item list-group-item-success">Monto: {{ $credito->venta->total }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-primary">Cliente:
                                    {{ $credito->venta->cliente->nombre }}</li>
                                <li class="list-group-item list-group-item-secondary">Telefono:
                                    {{ $credito->venta->cliente->telefono }}
                                </li>
                                <li class="list-group-item list-group-item-success">Dirección:
                                    {{ $credito->venta->cliente->direccion }}</li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    @if ($abonos->isEmpty())
                        <p>No hay registros disponibles.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover display responsive nowrap" width="100%"
                                id="tblCreditos">
                                <thead class="thead">
                                    <tr>
                                        <th>Id</th>
                                        <th>Monto</th>
                                        <th>Forma Pago</th>
                                        <th>Usuario</th>
                                        <th>Fecha/Hora</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($abonos as $abono)
                                        <tr>
                                            <td>{{ $abono->id }}</td>
                                            <td>{{ $abono->monto }}</td>
                                            <td>{{ $abono->formapago->nombre }}</td>
                                            <td>{{ $abono->usuario->name }}</td>
                                            <td>{{ $abono->created_at }}</td>
                                            <td><a href="{{ route('creditoventa.ticket', $abono->id) }}" target="_blank"
                                                    class="btn btn-danger btn-sm">Ticket</a></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>Total</td>
                                        <td><b>{{ number_format($abonado, 2) }}</b></td>
                                        <td colspan="4" class="text-center"><b>Restante:
                                                {{ number_format($credito->venta->total - $abonado, 2) }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    {{ $abonos->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="modalAbono" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <h3>Abono</h3>
                    </h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="id_credito" value="{{ $credito->id }}">
                        <div class="col-md-12 mb-2">
                            <label>Cliente <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary"><i class="fas fa-user"></i></span>
                                </div>
                                <input id="cliente" class="form-control" type="text" placeholder="Cliente" readonly>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Teléfono <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary"><i class="fas fa-phone"></i></span>
                                </div>
                                <input id="telefono" class="form-control" type="text" placeholder="Telefono" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Total <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary"><i class="fas fa-dollar-sign"></i></span>
                                </div>
                                <input id="total" class="form-control" type="text" readonly placeholder="0.00">
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Abonado <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary"><i class="fas fa-dollar-sign"></i></span>
                                </div>
                                <input id="abonado" class="form-control" type="text" readonly placeholder="0.00">
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Restante <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary"><i class="fas fa-dollar-sign"></i></span>
                                </div>
                                <input id="restante" class="form-control" type="text" readonly placeholder="0.00">
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Abono <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary"><i class="fas fa-dollar-sign"></i></span>
                                </div>
                                <input id="monto" class="form-control" type="number" step="0.01" min="0.01"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="forma">Forma Pago <span class="text-danger">*</span></label>
                            <select id="forma" class="form-control">
                                <option value="">Seleccionar</option>
                                @foreach ($formapagos as $formapago)
                                    <option value="{{ $formapago->id }}">{{ $formapago->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" id="btnProcesar" type="button">Completar</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection

@section('js')
    <script>
        var ticketUrl = "{{ route('creditoventa.ticket', ['id' => 0]) }}";
        var detalleUrl = "{{ route('creditoventa.detalle', ['id' => 0]) }}";
        const cliente = document.querySelector('#cliente');
        const telefono = document.querySelector('#telefono');
        const total = document.querySelector('#total');
        const abonado = document.querySelector('#abonado');
        const restante = document.querySelector('#restante');
        const monto = document.querySelector('#monto');
        const forma = document.querySelector('#forma');
        const id_credito = document.querySelector('#id_credito');
        const btnProcesar = document.querySelector('#btnProcesar');
        document.addEventListener("DOMContentLoaded", function() {
            btnProcesar.addEventListener('click', function() {
                if (id_credito.value == '' || monto.value == '' || forma.value == '') {
                    Swal.fire({
                        position: "top-end",
                        icon: 'warning',
                        title: 'Todo los campos son requeridos',
                        showConfirmButton: false,
                        timer: 1500,
                        toast: true
                    });
                } else {
                    Swal.fire({
                        title: "Abonar",
                        text: "¿Estás seguro de abonar?",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, abonar!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch("{{ route('creditoventa.registrarAbono') }}", {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        monto: monto.value,
                                        forma: forma.value,
                                        id_credito: id_credito.value,
                                    })
                                })
                                .then(response => {
                                    return response.json();
                                })
                                .then(data => {
                                    Swal.fire({
                                        position: "top-end",
                                        icon: data.icon,
                                        title: data.title,
                                        showConfirmButton: false,
                                        timer: 1500,
                                        toast: true
                                    });
                                    if (data.icon === 'success') {

                                        setTimeout(() => {
                                            window.open(
                                                `${ticketUrl.replace('0', data.ticket)}`,
                                                '_blank');
                                            window.location.reload();
                                        }, 1500);
                                    }
                                })
                                .catch(error => {
                                    // Manejar otros errores
                                    console.log('Error al abonar crédito:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Hubo un problema al procesar el abono.'
                                    });
                                });

                        }
                    });
                }

            });
        });

        function abonoCredito() {
            fetch(detalleUrl.replace('0', {{ $credito->id }}), {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(
                            `HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    cliente.value = data.cliente.nombre;
                    telefono.value = data.cliente.telefono;
                    total.value = data.credito.total;
                    abonado.value = data.credito.abonado;
                    restante.value = data.credito.restante;
                    monto.value = data.credito.restante;
                    monto.setAttribute('max', data.credito.restante);
                    $('#modalAbono').modal('show');
                })
                .catch(error => {
                    // Manejar otros errores
                    console.log('Error al abonar crédito:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema'
                    });
                });

        }
    </script>
@stop
