<table>
    <tr>
        <td colspan="2">
            <img src="{{ public_path('/img/logo.png') }}" alt="Logo" height="90" />
        </td>
        <td colspan="7">
            <p>REPORTE DE PROVEEDORES</p>
        </td>
    </tr>
</table>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #CCCCCC; font-weight: bold;">
            <th style="border: 1px solid #000; width: 30px;">Id</th>
            <th style="border: 1px solid #000; width: 100px;">N° Ident. Fiscal</th>
            <th style="border: 1px solid #000; width: 200px;">Nombre</th>
            <th style="border: 1px solid #000; width: 120px;">Correo</th>
            <th style="border: 1px solid #000; width: 120px;">Teléfono</th>
            <th style="border: 1px solid #000; width: 80px;">Direccion</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($proveedores as $proveedor)
            <tr>
                <td style="border: 1px solid #000; text-align: left">{{ $proveedor->id }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $proveedor->identidad }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $proveedor->nombre }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $proveedor->correo }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $proveedor->telefono }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $proveedor->direccion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
