<table>
    <tr>
        <td colspan="2">
            <img src="{{ public_path('/img/novologo.png') }}" alt="Logo" height="90" />
        </td>
        <td colspan="7">
            <p>REPORTE DE PRODUCTOS</p>
        </td>
    </tr>
</table>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #CCCCCC; font-weight: bold;">
            <th style="border: 1px solid #000; width: 30px;">Id</th>
            <th style="border: 1px solid #000; width: 100px;">Código</th>
            <th style="border: 1px solid #000; width: 200px;">Producto</th>
            <th style="border: 1px solid #000; width: 120px;">Precio Compra</th>
            <th style="border: 1px solid #000; width: 120px;">Precio Venta</th>
            <th style="border: 1px solid #000; width: 80px;">Stock</th>
            <th style="border: 1px solid #000; width: 100px;">Categoria</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $producto)
            <tr>
                <td style="border: 1px solid #000; text-align: left">{{ $producto->id }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $producto->codigo }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $producto->producto }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $producto->precio_compra }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $producto->precio_venta }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $producto->stock }}</td>
                <td style="border: 1px solid #000; text-align: left">{{ $producto->categoria->nombre }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
