<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ticket.css">
    <title>Ticket de Venta</title>

</head>
<body>

    <div class="ticket-modal">
        <div class="modal-header">
            <h2>Ticket de Venta</h2>
            <span class="close-icon">&times;</span>
        </div>

        <div class="ticket-body">
            
            <div class="company-info">
                <div class="company-name">MI EMPRESA</div>
                <div class="company-details">
                    RFC: ABC123456789<br>
                    Calle Principal #123, Col. Centro<br>
                    Tel: (555) 123-4567
                </div>
            </div>

            <div class="dashed-line"></div>

            <div class="info-row">
                <span class="info-label">Ticket #:</span>
                <span class="info-value">1</span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha:</span>
                <span class="info-value">21 de noviembre de 2025</span>
            </div>
            <div class="info-row">
                <span class="info-label">Hora:</span>
                <span class="info-value">1:30:14</span>
            </div>
            <div class="info-row">
                <span class="info-label">Cliente:</span>
                <span class="info-value">Juan Pérez</span>
            </div>

            <div class="dashed-line"></div>

            <div style="margin-bottom: 10px; font-weight: bold; color:#000;">Detalle de Venta</div>

            <div class="product-item">
                <div class="product-name">Laptop Dell</div>
                <div class="product-calc">
                    <span>2 x $850.00</span>
                    <span>$1700.00</span>
                </div>
            </div>
            <div class="dashed-line"></div>

            <div class="total-row">
                <span>Subtotal:</span>
                <span>$1700.00</span>
            </div>
            <div class="total-row">
                <span>IVA (16%):</span>
                <span>$272.00</span>
            </div>
            <div class="total-row total-final">
                <span>TOTAL:</span>
                <span>$1972.00</span>
            </div>

            <div class="dashed-line"></div>

            <div class="ticket-footer">
                ¡Gracias por su compra!<br>
                Este ticket no es un comprobante fiscal<br><br>
                www.miempresa.com<br>
                info@miempresa.com
            </div>

        </div>

        <div class="modal-actions">
            <button class="btn btn-print" onclick="window.print()">Imprimir Ticket</button>
            <button class="btn btn-close">Cerrar</button>
        </div>
    </div>

</body>
</html>