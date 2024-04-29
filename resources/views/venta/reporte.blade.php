<table>
    <tr>
        <td colspan="2">
            <img src="{{ public_path('/img/novologo.png') }}" alt="Logo" height="90" />
        </td>
        <td colspan="7">
            <p>REPORTE DE VENTAS</p>
        </td>
    </tr>
</table>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #CCCCCC; font-weight: bold;">
            <th style="border: 1px solid #000; width: 30px;">Id</th>
            <th style="border: 1px solid #000; width: 150px;">Cliente</th>
            <th style="border: 1px solid #000; width: 100px;">Telefono</th>
            <th style="border: 1px solid #000; width: 80px;">Método</th>
            <th style="border: 1px solid #000; width: 120px;">Forma Pago</th>
            <th style="border: 1px solid #000; width: 80px;">Monto</th>
            <th style="border: 1px solid #000; width: 80px;">Pago con</th>
            <th style="border: 1px solid #000; width: 80px;">Cambio</th>
            <th style="border: 1px solid #000; width: 150px;">Fecha/Hora</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ventas as $venta)
            <tr>
                <td style="border: 1px solid #000; text-align: left">{{ $venta->id }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $venta->cliente->nombre }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $venta->cliente->telefono }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $venta->metodo }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $venta->formapago->nombre }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $venta->total }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $venta->pago_con }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $venta->pago_con - $venta->total }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $venta->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
