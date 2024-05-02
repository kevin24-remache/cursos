<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- v4.0.0-alpha.6 -->
    <link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url("dist/css/style.css") ?>">
    <link rel="stylesheet" href="<?= base_url("dist/css/font-awesome/css/font-awesome.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("dist/css/et-line-font/et-line-font.css") ?>">
    <link rel="stylesheet" href="<?= base_url("dist/css/themify-icons/themify-icons.css") ?>">
</head>

<body class="hold-transition lockscreen">
    <div class="mb-4">
        <div class="error-page text-center mt-3">
            <div class="theadline">
                <img class=" img-fluid bg-white rounded-5 p-1 w-50" src="<?= base_url("assets/images/logo-ep.png"); ?>"
                    alt="">
            </div>
        </div>
        <div class="row mt-5 px-5 mx-5 justify-content-center">
            <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 p-3">
                <div class="card rounded-5">
                    <div class="card-header">
                        <h5 class="card-title text-start">Congreso facultad</h5>
                    </div>
                    <div class="card-body p-0">
                        <img id="imagen1" src="<?= base_url("assets/images/ejemplo_congreso.jpg"); ?>"
                            class="img-fluid imagen-pequena" alt="Imagen 1">
                    </div>
                    <div class="card-footer text-start rounded-5">
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalInscripcion"
                            data-evento="Congreso facultad">Inscribirse</button>

                    </div>
                </div>
            </div>
            <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 p-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-start">Congreso X</h5>
                    </div>
                    <div class="card-body p-0">
                        <img id="imagen2" src="<?= base_url("assets/images/ejemplo_congreso.jpg"); ?>"
                            class="img-fluid imagen-pequena" alt="Imagen 1">
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalInscripcion"
                            data-evento="Congreso X">Inscribirse</button>

                    </div>
                </div>
            </div>
            <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 p-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">Nombre del Evento</h5>
                    </div>
                    <div class="card-body p-0">
                        <img id="imagen3" src="<?= base_url("assets/images/ejemplo_congreso.jpg"); ?>"
                            class="img-fluid imagen-pequena" alt="Imagen 1">
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalInscripcion"
                            data-evento="Nombre del Evento">Inscribirse</button>

                    </div>
                </div>
            </div>
            <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 p-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">Congreso Z</h5>
                    </div>
                    <div class="card-body p-0">
                        <img id="imagen3" src="<?= base_url("assets/images/ejemplo_congreso.jpg"); ?>"
                            class="img-fluid imagen-pequena" alt="Imagen 1">
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalInscripcion"
                            data-evento="Congreso Z">Inscribirse</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de inscripción -->
    <div class="modal fade" id="modalInscripcion" tabindex="-1" aria-labelledby="modalInscripcionLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInscripcionLabel">Inscripción al Congreso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="procesar_inscripcion.php" method="POST">
                        <input type="hidden" id="evento" name="evento">
                        <div class="mb-3">
                            <label for="nombreEvento" class="form-label">Nombre del Evento</label>
                            <input type="text" class="form-control" id="nombreEvento" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="numeroCedula" class="form-label">Número de Cédula</label>
                            <input type="text" class="form-control" id="numeroCedula" name="numeroCedula" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Inscribirse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-image {
            width: 188px;
            height: 176px;
        }

        .imagen-pequena {
            cursor: pointer;
            width: 100%;
            height: 100%;
            /* Cambia el cursor al pasar sobre la imagen */
        }

        .imagen-grande {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .imagen-grande img {
            max-width: 90%;
            max-height: 90%;
        }
    </style>

    <div id="imagen-ampliada" class="imagen-grande" style="display: none;">
        <img src="" alt="Imagen ampliada">
    </div>

    <!-- Mueve el código JavaScript aquí -->
    <script>
        const imagenes = document.querySelectorAll('.imagen-pequena');
        const imagenAmpliada = document.getElementById('imagen-ampliada');
        const imagenAmpliadaImg = imagenAmpliada.querySelector('img');

        imagenes.forEach(imagen => {
            imagen.addEventListener('click', () => {
                imagenAmpliadaImg.src = imagen.src;
                imagenAmpliada.style.display = 'flex';
            });
        });

        // Cierra la imagen ampliada al hacer clic fuera de ella
        imagenAmpliada.addEventListener('click', () => {
            imagenAmpliada.style.display = 'none';
        });
        // Capturar el nombre del evento al abrir el modal
        var myModal = document.getElementById('modalInscripcion');
        myModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var evento = button.getAttribute('data-evento');
            var modalEvento = myModal.querySelector('#nombreEvento');
            modalEvento.value = evento;

            var hiddenEvento = myModal.querySelector('#evento');
            hiddenEvento.value = evento;
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- template -->
    <script src="<?= base_url("dist/js/niche.js") ?>"></script>
</body>

</html>