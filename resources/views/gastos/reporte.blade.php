<table>
    <tr>
        <td colspan="2">
            <img src="{{ public_path('/img/logo.png') }}" alt="Logo" height="90" />
        </td>
        <td colspan="7">
            <p>REPORTE DE GASTOS</p>
        </td>
    </tr>
</table>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #CCCCCC; font-weight: bold;">
            <th style="border: 1px solid #000; width: 30px;">Id</th>
            <th style="border: 1px solid #000; width: 100px;">Monto</th>
            <th style="border: 1px solid #000; width: 120px;">Usuario</th>
            <th style="border: 1px solid #000; width: 200px;">Descripción</th>
            <th style="border: 1px solid #000; width: 100px;">Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($gastos as $gasto)
            <tr>
                <td style="border: 1px solid #000; text-align: left">{{ $gasto->id }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $gasto->monto }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $gasto->usuario->name }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $gasto->descripcion }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $gasto->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
