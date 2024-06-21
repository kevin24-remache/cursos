<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url("assets/css/styles.css") ?>">
    <link rel="stylesheet" href="<?= base_url("dist/css/font-awesome/css/font-awesome.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/home.css") ?>">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Preloader HTML -->
    <div id="preloader" style="display: none;">
        <div class="spinner"></div>
    </div>
    <style>
        #preloader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .no-events {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            text-align: center;
            font-size: 1.5rem;
            color: #555;
            background-color: #f8f9fa;
            border-radius: 10px;
        }

        .no-events h2 {
            color: #0C244B;
        }

        .no-events p {
            color: #888;
        }
    </style>
    <main class="flex-grow-1" style="background-color: #d9d9d9;">
        <nav class="navbar navbar-dark" style="background-color: #0C244B;">
            <div class="container-fluid">
                <a class="navbar-brand col" style="margin-left: 20px;" href="/login">
                    <h3>PROSERVI-UEB-EP</h3>
                </a>

                <button class="btn btn-outline-light col" data-bs-toggle="modal" data-bs-target="#modalDeposito"
                    type="button" style="width:100%;">
                    Realizar Depósito
                </button>
            </div>
        </nav>
        <div class="mb-4">
            <div class="text-center">
                <img src="<?= base_url("assets/images/logo-ep.png"); ?>" alt="" height="100px">
            </div>
            <section class="container flex-grow-1 d-flex">
                <div class="row flex-grow-1">
                    <?php if (empty($events)): ?>
                        <div class="no-events pt-3">
                            <div>
                                <h2>No hay eventos registrados</h2>
                                <p>Actualmente no hay eventos disponibles. Por favor, vuelve más tarde.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($events as $key => $event): ?>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 p-3">
                                <div class="bg-white shadow">
                                    <figure class="p-1">
                                        <img src="<?= base_url("") . $event->image; ?>" alt="Imagen del Curso"
                                            class="img-fluid imagen-pequena rounded-2 ">
                                    </figure>
                                    <figure class="text-center">
                                        <img src="<?= base_url("assets/images/logo_ueb.png") ?>" alt="Logo del curso"
                                            class="img-fluid" width="120px;">
                                    </figure>
                                    <section class="px-3">
                                        <article class="date__start__content">
                                            <?= $event->formatted_event_date ?>
                                        </article>
                                        <section class="card__icons__container">
                                            <?php if ($event->formatted_modality !== 'Presencial'): ?>
                                                <article>
                                                    <p><i class="fa fa-clock-o"></i> DURACIÓN</p>
                                                    <span>225 Horas</span>
                                                </article>
                                            <?php endif; ?>
                                            <article>
                                                <p><i class="fa fa-users"></i> MODALIDAD</p>
                                                <span><?= $event->formatted_modality ?></span>
                                            </article>
                                        </section>
                                        <section class="pt-3 pb-4">
                                            <button class="btn border border-danger mb-2 card__button text-danger"
                                                data-bs-toggle="modal" data-bs-target="#modalInfo" type="button"
                                                style="width:100%;">
                                                Más Información
                                            </button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalInscripcion" data-evento="<?= $event->event_name ?>"
                                                data-event-id="<?= $event->id ?>" type="button" style="width:100%;">
                                                Inscribirse
                                            </button>
                                        </section>
                                    </section>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif; ?>
                    <style>
                        @media (min-width: 550px) and (max-width: 767.98px) {
                            .col-12.col-sm-12 {
                                flex: 0 0 50%;
                                max-width: 50%;
                            }
                        }
                    </style>
                </div>
            </section>
        </div>
    </main>
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
                    <form id="formInscripcion">
                        <input type="hidden" id="eventoId" name="eventoId">
                        <div class="mb-3">
                            <label for="nombreEvento" class="form-label">Nombre del Evento</label>
                            <input type="text" class="form-control" id="nombreEvento" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="numeroCedula" class="form-label">Número de Cédula</label>
                            <input type="text" class="form-control" id="numeroCedula" name="numeroCedula" required>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-success me-1">Inscribirse</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de registro de usuario -->
    <div class="modal fade" id="modalRegistroUsuario" tabindex="-1" aria-labelledby="modalRegistroUsuarioLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRegistroUsuarioLabel">Registro de Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formRegistroUsuario">
                        <div class="mb-3">
                            <label for="numeroCedulaRegistro" class="form-label">Número de Cédula</label>
                            <input type="text" class="form-control" id="numeroCedulaRegistro" name="numeroCedula"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Número de teléfono o celular</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="direccion" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="float-start">
                            <!-- <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-success" onclick="registrarUsuario()">Registrar</button>
                                <button type="button" class="btn btn-success" onclick="cerrarYMostrarModal()">Regresar</button>
                            </div> -->
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary me-1">Registrar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de detalles del evento -->
    <div class="modal fade" id="modalDetallesEvento" tabindex="-1" aria-labelledby="modalDetallesEventoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetallesEventoLabel" style="color: #0C244B;">
                        <span id="titleEvent"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formDetallesEvento">
                        <div class="mb-3">
                            <label for="descripcionEvento" class="form-label">Descripción del Evento</label>
                            <textarea class="form-control" id="descripcionEvento" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Seleccione la categoría</label>
                            <div id="categoria"></div>
                        </div>
                        <div class="alert alert-success" role="alert">
                            <p>Estudiante: <span id="nombresPersona" class="text-primary"></span> <span
                                    id="apellidosPersona" class="text-primary"></span></p>
                            Cuando finalices se te enviara un
                            código a tu correo electrónico: <span id="emailPersona" class="text-primary"></span> que
                            deberás usarlo para realizar el pago
                        </div>
                        <div class="mb-3 row">
                            <input type="hidden" id="id_user">
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-success me-1">Finalizar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de información -->
    <div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalInfoLabel">Congreso para la carrera de [Nombre de la carrera]</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Descripción corta del congreso aquí.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de depósito -->
    <div class="modal fade" id="modalDeposito" tabindex="-1" aria-labelledby="modalDepositoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDepositoLabel">Realizar Depósito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formDeposito" method="post" action="<?= base_url("deposito") ?>"
                        enctype="multipart/form-data">

                        <div class="row">
                            <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                <label for="codigoPago" class="form-label">Código de pago <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="codigoPago" name="codigoPago" value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'codigoPago') : '' ?>" required>
                                <span class="text-danger">
                                <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'codigoPago') : '' ?>
                            </span>
                            </div>
                            <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                <label for="depositoCedula" class="form-label">Número de cédula <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="depositoCedula" name="depositoCedula" value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'depositoCedula') : '' ?>" required>
                                    <span class="text-danger">
                                <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'depositoCedula') : '' ?>
                                </span>
                            </div>
                        </div>
                        <div class="row">

                            <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                <label for="comprobante" class="form-label">Número de comprobante <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="comprobante" name="comprobante" value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'comprobante') : '' ?>" required>
                                <span class="text-danger">
                                <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'comprobante') : '' ?>
                                </span>
                            </div>
                            <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                <label for="dateDeposito" class="form-label">Fecha del deposito <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="dateDeposito" name="dateDeposito" value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'dateDeposito') : '' ?>" required>
                                <span class="text-danger">
                                <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'dateDeposito') : '' ?>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="montoDeposito" class="form-label">Monto del Depósito</label>
                            <input type="text" class="form-control" id="montoDeposito" name="montoDeposito" value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'montoDeposito') : '' ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="comprobantePago" class="form-label">Subir Comprobante de Pago <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="comprobantePago" name="comprobantePago"
                                accept="image/*,application/pdf" required>

                                <span class="text-danger">
                                <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'comprobantePago') : '' ?>
                                </span>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-success me-1">Realizar Depósito</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="imagen-ampliada" class="imagen-grande" style="display: none;">
        <img src="" alt="Imagen ampliada">
    </div>

    <!-- Footer-->
    <footer class="bg-dark py-3 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small m-0 text-white">Copyright 2022 &copy; PROSERVI-UEB-EP |
                        <a href="https://www.softecsa.com" class="text-decoration-none link-light">Softec Apps S.A.S</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Aquí incluye el SDK de Firebase -->
    <script src="https://www.gstatic.com/firebasejs/8.2.9/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.2.9/firebase-database.js"></script>
    <!-- Si estás utilizando la base de datos en tiempo real -->
    <!-- Luego, incluye tu archivo de configuración -->
    <script src="https://www.gstatic.com/firebasejs/8.2.9/firebase-firestore.js"></script>
    <script src="<?php echo base_url('assets/js/firebase.js'); ?>"></script>

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
            var eventId = button.getAttribute('data-event-id');

            var modalEvento = myModal.querySelector('#nombreEvento');
            modalEvento.value = evento;

            var hiddenEventoId = myModal.querySelector('#eventoId');
            hiddenEventoId.value = eventId;
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if ('insert' == "<?= $last_action ?? '' ?>") {
            var myModal = new bootstrap.Modal(document.getElementById('modalDeposito'))
            myModal.show()
        }
    </script>
    <script>
        // Función para mostrar la alerta SweetAlert2
        function showAlert(type, message) {
            if (type === 'success') {
                Swal.fire({
                    title: "<strong>¡Éxito!</strong>",
                    icon: "success",
                    html: `<div>${message}</div>`,
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: `<i class="fa fa-thumbs-up"></i> ¡Genial!`,
                    confirmButtonAriaLabel: "Thumbs up, great!",
                });
            } else {
                Swal.fire({
                    icon: type,
                    title: message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            }
        }

        // Verificar si hay mensajes de éxito, advertencia o error
        <?php if (session()->has('flashMessages')): ?>
            <?php foreach (session('flashMessages') as $message): ?>
                <?php $type = $message[1]; ?>
                <?php $msg = $message[0]; ?>
                showAlert('<?= $type ?>', '<?= $msg ?>');
            <?php endforeach; ?>
        <?php endif; ?>
    </script>
    <script src="<?= base_url("assets/js/home/home.js") ?>"></script>

    <!-- template -->
    <script src="<?= base_url("dist/js/niche.js") ?>"></script>
    <script src="<?= base_url("assets/js/sweetalert/sweetalert.min.js") ?>"></script>
</body>

</html>