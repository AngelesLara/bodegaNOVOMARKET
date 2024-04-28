<table>
    <tr>
        <td colspan="2">
            <img src="{{ public_path('/img/logo.png') }}" alt="Logo" height="90" />
        </td>
        <td colspan="7">
            <p>REPORTE DE COTIZACIONES</p>
        </td>
    </tr>
</table>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #CCCCCC; font-weight: bold;">
            <th style="border: 1px solid #000; width: 30px;">Id</th>
            <th style="border: 1px solid #000; width: 200px;">Cliente</th>
            <th style="border: 1px solid #000; width: 100px;">Telefono</th>
            <th style="border: 1px solid #000; width: 120px;">Monto</th>
            <th style="border: 1px solid #000; width: 120px;">Fecha/hora</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cotizaciones as $cotizacion)
            <tr>
                <td style="border: 1px solid #000; text-align: left">{{ $cotizacion->id }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $cotizacion->cliente->nombre }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $cotizacion->cliente->telefono }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $cotizacion->total }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $cotizacion->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
