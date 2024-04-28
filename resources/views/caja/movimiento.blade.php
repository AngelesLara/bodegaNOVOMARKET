@extends('layouts.app')

@section('title', 'Movimientos')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    @if (isset($error))
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                        <a href="{{ route('cajas.create') }}" class="btn btn-primary">ABRIR CAJA</a>
                    @else
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                <h5 class="card-title">Reporte Gráfico</h5>
                            </span>

                            <div class="float-right">
                                <form id="cerrarCajaForm" action="{{ route('cajas.update') }}" method="post">
                                    {{ method_field('PUT') }}
                                    @csrf
                                    <button class="btn btn-primary" type="button" onclick="confirmarCerrarCaja()">Cerrar
                                        Caja</button>
                                </form>
                            </div>
                        </div>

                        <div style="width: 100%; height: 300px;">
                            <canvas id="myChart"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @unless (isset($error))
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Monto Inicial', 'Compras', 'Gastos', 'Ventas Contado', 'Abono ventas',
                            'Saldo'
                        ],
                        datasets: [{
                            label: 'Movimientos',
                            data: [{{ $montoInicial }}, {{ $compras }}, {{ $gastos }},
                                {{ $ventas }}, {{ $abonoventa }},
                                {{ $saldo }}
                            ],
                            backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 50, 50)',
                                'rgb(100, 50, 235)',
                                'rgb(100, 200, 10)',
                                'rgb(0, 200, 10)',
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 50, 50)',
                                'rgb(100, 50, 235)',
                                'rgb(100, 200, 10)',
                                'rgb(0, 200, 10)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: {
                            display: false,
                            labels: {
                                fontColor: '#585757',
                                boxWidth: 40
                            }
                        },
                        tooltips: {
                            displayColors: false
                        }

                    }
                });
            @endunless
        });


        function confirmarCerrarCaja() {
            Swal.fire({
                title: "Cerrar Caja",
                text: "¿Estás seguro de que deseas cerrar la caja?",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, cerrar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cerrarCajaForm').submit();
                }
            });
        }
    </script>
@stop
