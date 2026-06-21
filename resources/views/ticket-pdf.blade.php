{{-- resources/views/checkout/ticket-pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket de Compra - {{ $compra->numero_pedido }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .ticket {
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .empresa {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .titulo {
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
        }
        .info {
            margin: 5px 0;
        }
        .info strong {
            display: inline-block;
            width: 100px;
        }
        .tabla {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        .tabla th, .tabla td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .tabla th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .totales {
            margin-top: 10px;
            border-top: 2px dashed #000;
            padding-top: 10px;
        }
        .total-line {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }
        .total-final {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
            border-top: 2px dashed #000;
            padding-top: 10px;
        }
        .qr-code {
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <div class="empresa"><img src="{{ asset('images/Tokkilogo.png') }}" alt="">TOKKI SHOP</div>
            <div>Tienda Oficial de Merchandising</div>
            <div>www.tokkishop.com</div>
            <div>info@tokkishop.com</div>
        </div>

        <div class="titulo">TICKET DE COMPRA</div>
        
        <div class="info">
            <strong>Pedido:</strong> {{ $compra->numero_pedido }}
        </div>
        <div class="info">
            <strong>Fecha:</strong> {{ $compra->created_at->format('d/m/Y H:i') }}
        </div>
        <div class="info">
            <strong>Cliente:</strong> {{ $compra->user->name }}
        </div>
        <div class="info">
            <strong>Estado:</strong> {{ ucfirst($compra->estado) }}
        </div>

        <table class="tabla">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cant</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($compra->productos as $producto)
                <tr>
                    <td>{{ $producto->producto->nombre }}</td>
                    <td style="text-align: center;">{{ $producto->cantidad }}</td>
                    <td style="text-align: right;">${{ number_format($producto->precio_unitario, 2) }}</td>
                    <td style="text-align: right;">${{ number_format($producto->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totales">
            <div class="total-line">
                <span>Subtotal:</span>
                <span>${{ number_format($compra->subtotal, 2) }}</span>
            </div>
            <div class="total-line">
                <span>Envío:</span>
                <span>${{ number_format($compra->envio, 2) }}</span>
            </div>
            <div class="total-line">
                <span>Impuestos:</span>
                <span>${{ number_format($compra->impuestos, 2) }}</span>
            </div>
            <div class="total-line total-final">
                <span>TOTAL:</span>
                <span>${{ number_format($compra->total, 2) }}</span>
            </div>
        </div>

        @if($compra->direccion)
        <div style="margin-top: 10px;">
            <strong>Dirección de Envío:</strong><br>
            {{ $compra->direccion->calle }} #{{ $compra->direccion->numero_exterior }}
            @if($compra->direccion->numero_interior)
                Int. {{ $compra->direccion->numero_interior }}
            @endif<br>
            {{ $compra->direccion->colonia }}, {{ $compra->direccion->ciudad }}<br>
            {{ $compra->direccion->estado }}, C.P. {{ $compra->direccion->codigo_postal }}
        </div>
        @endif

        @if($compra->metodoPago)
        <div style="margin-top: 10px;">
            <strong>Método de Pago:</strong><br>
            {{ $compra->metodoPago->tipoTexto }}<br>
            {{ $compra->metodoPago->titular }}
            @if($compra->metodoPago->numero_tarjeta)
                <br>**** **** **** {{ $compra->metodoPago->numero_tarjeta }}
            @endif
        </div>
        @endif

        @if($compra->notas)
        <div style="margin-top: 10px;">
            <strong>Notas:</strong><br>
            {{ $compra->notas }}
        </div>
        @endif

        <div class="footer">
            <div>¡Gracias por su compra!</div>
            <div>Conserve este ticket para cualquier aclaración</div>
            <div>Teléfono: +52 55 1234 5678</div>
            <div>{{ now()->format('d/m/Y H:i:s') }}</div>
        </div>
    </div>
</body>
</html>