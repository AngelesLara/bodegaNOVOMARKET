<!DOCTYPE html>
<html>

<head>
    <title>Reporte ticket</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .ticket {
            width: 140pt;
            padding: 1px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 0px;
        }

        .logo img {
            max-width: 50px;
            height: auto;
        }

        .business-info {
            text-align: center;
            font-size: 14px;
        }

        .ticket-details {
            margin-top: 20px;
            padding-top: 10px;
        }

        .ticket-details h3 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .ticket-details p {
            font-size: 12px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 1px;
            text-align: left;
            font-size: 11px;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="business-info">
            <h3>{{ $company->nombre }}</h3>
            <p>{{ $company->direccion }}</p>
            <p>{{ $company->telefono }}</p>
            <p>{{ $company->correo }}</p>
        </div>
        ==================================
        <div class="ticket-details">
            <p>Folio: {{ $abono->id }}</p>
            <p>Credito N°: {{ $abono->creditoventa->id }}</p>
            <p>Fecha/Hora: {{ $abono->creditoventa->created_at }}</p>
        
            ==================================
            <p>Cliente: {{ $abono->creditoventa->venta->cliente->nombre }}</p>
            <p>Teléfono: {{ $abono->creditoventa->venta->cliente->telefono }}</p>
            <p>Dirección: {{ $abono->creditoventa->venta->cliente->direccion }}</p>
            ==================================
            <p>abono: {{ $abono->monto }}</p>
            <p>Fecha: {{ $abono->created_at }}</p>
            <p>Forma Pago: {{ $abono->formapago->nombre }}</p>
            <h5>Abonado: {{ number_format($abonado, 2) }}</h5>
            <h5>Restante: {{ number_format($abono->creditoventa->venta->total - $abonado, 2) }}</h5>
            <h5>Total: {{ number_format($abono->creditoventa->venta->total, 2) }}</h5>
        </div>
    </div>
</body>

</html>
@php
    header('Content-type: application/pdf');
@endphp
