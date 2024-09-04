<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Transacción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .transaction-details {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .transaction-details h4 {
            margin-bottom: 20px;
        }

        .transaction-details .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .transaction-details .detail-item span {
            font-weight: bold;
        }

        .transaction-details .detail-item .value {
            font-weight: normal;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* Esto alinea verticalmente el texto y la imagen */
        }

        .container h4 {
            margin: 0;
            /* Elimina el margen predeterminado si lo tiene */
        }

        .container img {
            max-width: 100px;
            /* Ajusta el tamaño de la imagen según sea necesario */
            height: auto;
            /* Mantiene la proporción de la imagen */
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark mb-5" style="background-color: #0C244B;">
        <div class="container-fluid">
            <a class="navbar-brand col" style="margin-left: 20px;" href="">
                <h3>PROSERVI-UEB-EP</h3>
            </a>

            <a href="<?= base_url('/') ?>" class="btn btn-outline-light" type="button">
                <i class="fa-solid fa-house"></i> Inicio
            </a>
        </div>
    </nav>
    <div class="transaction-details mb-5">
        <div class="container">
            <h4>Detalles de la Transacción</h4>
            <div><img src="<?= base_url('assets/images/iconoPayphone.webp') ?>" alt=""></div>
        </div>

        <hr>
        <div class="detail-item">
            <span>ID de Autorización:</span>
            <span class="value"><?= $authorization_code ?></span>
        </div>
        <div class="detail-item">
            <span>Email:</span>
            <span class="value"><?= $email ?></span>
        </div>
        <div class="detail-item">
            <span>Estado de la Transacción:</span>
            <span class="value"><?= $transaction_status ?></span>
        </div>
        <div class="detail-item">
            <span>Monto:</span>
            <span class="value">$<?= ($amount / 100) ?></span>
        </div>
        <div class="detail-item">
            <span>Tipo de Tarjeta:</span>
            <span class="value"><?= $card_type ?></span>
        </div>
        <div class="detail-item">
            <span>Últimos Dígitos:</span>
            <span class="value"><?= $last_digits ?></span>
        </div>
        <div class="detail-item">
            <span>Teléfono:</span>
            <span class="value"><?= $phone_number ?></span>
        </div>
        <div class="detail-item">
            <span>Fecha:</span>
            <span class="value"><?= $transaction_date ?></span>
        </div>
        <div class="detail-item">
            <span>ID de la Transacción:</span>
            <span class="value"><?= $transaction_id ?></span>
        </div>
        <div class="detail-item">
            <span>Documento:</span>
            <span class="value"><?= $document ?></span>
        </div>

        <div class="detail-item">
            <span>Nombre del Comercio:</span>
            <span class="value"><?= $store_name ?></span>
        </div>
        <div class="detail-item">
            <span>Región:</span>
            <span class="value"><?= $region_iso ?></span>
        </div>
        <div class="detail-item">
            <span>Tipo de Transacción:</span>
            <span class="value"><?= $transaction_type ?></span>
        </div>
        <div class="detail-item">
            <span>Mensaje:</span>
            <span class="value"><?= $message ?? 'N/A' ?></span>
        </div>
        <div class="detail-item">
            <span>Referencia:</span>
            <span class="value"><?= $reference ?></span>
        </div>
        <hr>
        <div class="text-center">
            <?php
            if (isset($numAutorizacion["num_autorizacion"])):
                ?>
                <a target="_blank" href="<?= base_url('pdf/' . $numAutorizacion['num_autorizacion'] ?? 'error') ?>"
                    class="btn btn-outline-danger"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                <?php
            endif ?>
        </div>
    </div>
</body>

</html>