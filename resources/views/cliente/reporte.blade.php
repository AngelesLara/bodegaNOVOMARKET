<table>
    <tr>
        <td colspan="2">
            <img src="{{ public_path('/img/novologo.png') }}" alt="Logo" height="90" />
        </td>
        <td colspan="7">
            <p>REPORTE DE CLIENTES</p>
        </td>
    </tr>
</table>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #CCCCCC; font-weight: bold;">
            <th style="border: 1px solid #000; width: 30px;">Id</th>
            <th style="border: 1px solid #000; width: 200px;">Nombre</th>
            <th style="border: 1px solid #000; width: 120px;">Correo</th>
            <th style="border: 1px solid #000; width: 100px;">Teléfono</th>
            <th style="border: 1px solid #000; width: 180px;">Direccion</th>
            <th style="border: 1px solid #000; width: 100px;">Limite Crédito</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cliente)
            <tr>
                <td style="border: 1px solid #000; text-align: left">{{ $cliente->id }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $cliente->nombre }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $cliente->correo }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $cliente->telefono }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $cliente->direccion }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $cliente->credito }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
