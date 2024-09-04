<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <!-- Preloader -->
    <link rel="stylesheet" href="<?= base_url("assets/css/preloader.css") ?>">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .error-message {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .error-message h4 {
            margin-bottom: 20px;
            color: #dc3545;
        }

        .error-message p {
            margin-bottom: 20px;
            color: #6c757d;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Preloader HTML -->
    <div id="preloader" style="display: none;">
        <div class="spinner"></div>
        <p class="loading-text">Cargando<span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>
        </p>
    </div>
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

    <div class="error-message">
        <h4>Error</h4>
        <p>No se encontró ningún pago aprobado a través de Payphone.</p>
        <a href="<?= base_url('/') ?>" class="btn btn-outline-primary"><i class="fa-solid fa-arrow-left"></i> Volver al
            Inicio</a>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            window.onbeforeunload = function () {
                showPreloader();
            };

            window.onload = function () {
                hidePreloader();
            };

            function showPreloader() {
                document.getElementById("preloader").style.display = "flex";
            }

            function hidePreloader() {
                document.getElementById("preloader").style.display = "none";
            }

        });
    </script>
</body>

</html>