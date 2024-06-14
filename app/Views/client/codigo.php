<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Comprobante de Registro</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details-table th,
        .details-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .important {
            color: red;
            font-weight: bold;
        }

        .highlight {
            color: blue;
            font-weight: bold;
        }

        .highlight-cell {
            color: blue;
            font-weight: bold;
        }
        .text-success{
            color: green;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Comprobante de Registro</h2>
        </div>
        <p>Estimado(a) <strong><?=$user?></strong>,</p>
        <p>Has sido inscrito exitosamente en el evento. A continuación, se detallan los datos de tu inscripción:</p>
        <table class="details-table">
            <tr>
                <th>Evento:</th>
                <td><?= $evento ?></td>
            </tr>
            <tr>
                <th>Categoría:</th>
                <td><?= $categoria ?></td>
            </tr>
            <tr>
                <th>Precio:</th>
                <td class="text-success">$<?= number_format($precio, 2) ?></td>
            </tr>
            <tr>
                <th class="highlight">Código de Pago:</th>
                <td class="highlight-cell"><?= $codigoPago ?></td>
            </tr>
            <tr>
                <th class="highlight">Fecha Límite de Pago:</th>
                <td class="highlight-cell"><?= $fechaLimitePago ?></td>
            </tr>
            <tr>
                <th>Fecha de Emisión:</th>
                <td><?= $fechaEmision ?></td>
            </tr>
        </table>
        <p class="important">Por favor, acércate a realizar el pago antes de la fecha límite utilizando el código de
            pago proporcionado.<br> Es <span class="important">necesario</span> completar el pago para que el proceso de
            registro se complete.</p>
        <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
        <hr>
        <div class="footer">
            <p>Gracias por tu participación.</p>
        </div>
    </div>
</body>

</html>