<table>
    <tr>
        <td colspan="2">
            <img src="{{ public_path('/img/logo.png') }}" alt="Logo" height="90" />
        </td>
        <td colspan="7">
            <p>REPORTE DE CAJA</p>
        </td>
    </tr>
</table>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #CCCCCC; font-weight: bold;">
            <th style="border: 1px solid #000; width: 30px;">Id</th>
            <th style="border: 1px solid #000; width: 100px;">F. Apertura</th>
            <th style="border: 1px solid #000; width: 100px;">Monto Inicial</th>
            <th style="border: 1px solid #000; width: 100px;">F. Cierre</th>
            <th style="border: 1px solid #000; width: 100px;">Compras</th>
            <th style="border: 1px solid #000; width: 100px;">Gastos</th>
            <th style="border: 1px solid #000; width: 100px;">Ventas</th>
            <th style="border: 1px solid #000; width: 100px;">Saldo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cajas as $caja)
            <tr>
                <td style="border: 1px solid #000; text-align: left">{{ $caja->id }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $caja->monto_inicial }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $caja->fecha_apertura }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $caja->fecha_cierre }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $caja->compras }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $caja->gastos }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $caja->ventas }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ number_format($caja->ventas - ($caja->gastos + $caja->compras), 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
