<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Barcodes PDF</title>
    <style>
        /* Estilos CSS para las columnas */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 10px; /* Ajusta el espaciado interno según sea necesario */
        }
    </style>
</head>
<body>
    <table>
        @foreach ($barcodes as $index => $barcode)
           <tr>
               <td>
                   <div class="barcode-container">
                       {!! $barcode['barcode'] !!}
                       <span>{{ $barcode['codigo'] }}</span>
                   </div>
               </td>
           </tr>
        @endforeach
    </table>
</body>
</html>
