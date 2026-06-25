<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 10px; }

        /* Contenedor del encabezado */
        .header-container {
            width: 100%;
            text-align: center;
            position: relative;
            margin-bottom: 30px;
        }

        /* Logo posicionado absolutamente a la derecha */
        .logo {
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
        }

        /* Estilos de la tabla de datos */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th {
            background-color: #374151;
            color: white;
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        td { padding: 6px; border: 1px solid #ddd; }
    </style>
</head>
<body>

    <div class="header-container">
        <img src="{{ public_path('img/logo sistema de ventas.png') }}" class="logo">

        <div style="padding-top: 10px;">
            <h1 style="margin: 0; font-size: 22px;">Reporte de Inventario</h1>
            <p style="margin: 5px 0 0 0; font-size: 12px;">Erick Systems - Fecha de emisión: {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Cód. Barra</th>
                <th>Nombre</th>
                <th>P. Compra</th>
                <th>P. Venta</th>
                <th>Stock</th>
                <th>Min</th>
                <th>Max</th>
                <th>Unidad</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->categoria->nombre ?? 'N/A' }}</td>
                <td>{{ $p->codigo_producto }}</td>
                <td>{{ $p->codigo_barra }}</td>
                <td>{{ $p->nombre_producto }}</td>
                <td>${{ number_format($p->precio_compra, 2) }}</td>
                <td>${{ number_format($p->precio_venta, 2) }}</td>
                <td>{{ $p->stock_actual }}</td>
                <td>{{ $p->stock_minimo }}</td>
                <td>{{ $p->stock_maximo }}</td>
                <td>{{ $p->unidad_medida }}</td>
                <td>{{ $p->estado ? 'Activo' : 'Inactivo' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
