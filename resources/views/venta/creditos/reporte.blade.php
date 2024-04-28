<table>
    <tr>
        <td colspan="2">
            <img src="{{ public_path('/img/logo.png') }}" alt="Logo" height="90" />
        </td>
        <td colspan="7">
            <p>REPORTE DE CREDITOS</p>
        </td>
    </tr>
</table>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #CCCCCC; font-weight: bold;">
            <th style="border: 1px solid #000; width: 30px;">Id</th>
            <th style="border: 1px solid #000; width: 150px;">Cliente</th>
            <th style="border: 1px solid #000; width: 100px;">Telefono</th>
            <th style="border: 1px solid #000; width: 100px;">Monto</th>
            <th style="border: 1px solid #000; width: 80px;">Abonado</th>
            <th style="border: 1px solid #000; width: 120px;">Restante</th>
            <th style="border: 1px solid #000; width: 150px;">Fecha/Hora</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($creditos as $credito)
            <tr>
                <td style="border: 1px solid #000; text-align: left">{{ $credito['id']}}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $credito['nombre'] }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $credito['telefono'] }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $credito['total'] }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $credito['abonado'] }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $credito['restante'] }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $credito['fecha'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
