<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Registro</title>
    <style>
        body {
            font-family: Tahoma, Verdana, Segoe, sans-serif;
            background-color: #F5F5F5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
            background-color: #F5F5F5;
        }

        .header {
            background-color: #fff;
            border-bottom: 2px solid #0c244b;
            border-radius: 10px 10px 0 0;
        }

        .header h1 {
            color: #c3171b;
        }

        .content {
            border: 2px solid #0c244b;
            border-radius: 10px;
        }

        .content-d {
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 10px;
        }

        .logo {
            max-width: 152px;
        }

        h1 {
            color: #c3171b;
            margin: 0;
            font-size: 24px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table th,
        .details-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .highlight {
            color: blue;
            font-weight: bold;
        }

        .text-success {
            color: green;
        }

        .space {
            padding-bottom: 10%;
            background-color: #F5F5F5;
        }

        .footer {
            background-color: #0c244b;
            color: white;
            padding: 20px;
            text-align: center;
        }

        /* Estilos adaptados de Bootstrap */

        .row {
            width: 100%;
            display: table;
            table-layout: fixed;
            /* Emula el comportamiento de Flexbox para que las columnas se dividan equitativamente */
            border-spacing: 0;
            /* Elimina el espacio entre las celdas */
        }

        .col {
            display: table-cell;
            padding-right: 0.75rem;
            padding-left: 0.75rem;
            vertical-align: top;
            /* Asegura que el contenido de las columnas esté alineado al tope */
        }

        .col-1 {
            width: 8.333333%;
        }

        .col-2 {
            width: 16.666667%;
        }

        .col-3 {
            width: 25%;
        }

        .col-4 {
            width: 33.333333%;
        }

        .col-5 {
            width: 41.666667%;
        }

        .col-6 {
            width: 50%;
        }

        .col-7 {
            width: 58.333333%;
        }

        .col-8 {
            width: 66.666667%;
        }

        .col-9 {
            width: 75%;
        }

        .col-10 {
            width: 83.333333%;
        }

        .col-11 {
            width: 91.666667%;
        }

        .col-12 {
            width: 100%;
        }

        @media (max-width: 600px) {
            .header {
                text-align: center;
            }

            .header img {
                margin-bottom: 0px;
            }

            .header .bottom {
                border-bottom: 2px solid #0c244b;
            }

            .col {
                display: block;
                width: 100%;
            }
        }

        /* Padding general */

        .p-2 {
            padding: 0.5rem !important;
        }

        .pt-2,
        .py-2 {
            padding-top: 0.5rem !important;
        }

        .pb-2,
        .py-2 {
            padding-bottom: 0.5rem !important;
        }
    </style>
</head>

<body>
    <header>
        <img src="<?= ('public/assets/images/email/bg_top.jpg');?>" alt="bg-top" style="width: 100%;">
    </header>
    <main style="background-color: #F5F5F5;">

        <div class="container">
            <div class="space"></div>
            <div class="content">
                <div class="header row">
                    <div class="col bottom">
                        <img src="https://proserviueb.com/public/images/logo-ep.png" alt="Logo" class="logo">
                    </div>
                    <div class="col">
                        <h1 class="pt-2 pb-2">Comprobante de Registro</h1>
                    </div>
                </div>
                <div class="content-d">
                    <h2>Estimado(a) Cliente,
                        <?= $user ?>
                    </h2>
                    <p>Has sido inscrito exitosamente en el evento. A continuación, se detallan los datos de tu
                        inscripción:</p>
                    <table class="details-table">
                        <tr>
                            <th>Evento:</th>
                            <td>
                                <?= $evento ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Categoría:</th>
                            <td>
                                <?= $categoria ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Precio:</th>
                            <td class="text-success">$
                                <?= number_format($precio, 2) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Código de Pago:</th>
                            <td class="highlight">
                                <?= $codigoPago ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha Límite de Pago:</th>
                            <td class="highlight">
                                <?= $fechaLimitePago ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha de Emisión:</th>
                            <td>
                                <?= $fechaEmision ?>
                            </td>
                        </tr>
                    </table>
                    <p style="color: #c3171b; text-align: center;">
                        Realiza el pago antes de la fecha límite utilizando el código de pago proporcionado.
                    </p>
                    <p style="color: #c3171b; text-align: center;">Tu inscripción al evento no estará completa hasta que
                        verifiquemos correctamente tu pago.</p>
                    <hr>
                    <p style="text-align: center;">Gracias por tu participación.</p>
                </div>
            </div>
            <div class="space"></div>
        </div>

        <div class="footer">
            <div>
            </div>
            <p>© 2024 PROSERVI-UEB-EP | Softec Apps S.A.S. Todos los derechos reservados.</p>
        </div>

    </main>
</body>

</html>