<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="icon" href="<?= base_url("assets/images/icono.jpeg"); ?>" type="image/jpeg">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url("assets/css/styles.css") ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url("assets/css/home.css") ?>">
    <!-- Payphone -->
    <link rel="stylesheet" href="<?= base_url("assets/css/payphone.css") ?>">
    <!-- Preloader -->
    <link rel="stylesheet" href="<?= base_url("assets/css/preloader.css") ?>">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Preloader HTML -->
    <div id="preloader" style="display: none;">
        <div class="spinner"></div>
        <p class="loading-text">Cargando<span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>
        </p>
    </div>

    <style>
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
                <a class="navbar-brand col" style="margin-left: 20px;" href="">
                    <h3>PROSERVI-UEB-EP</h3>
                </a>

                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#modalVoucher"
                    type="button">
                    Consultar Voucher
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
                                <div class="bg-white shadow rounded-2">
                                    <figure class="p-1">
                                        <img src="<?= base_url("") . $event['image']; ?>" alt="Imagen del Curso"
                                            class="img-fluid imagen-pequena rounded-2 ">
                                    </figure>
                                    <figure class="text-center">
                                        <img src="<?= base_url("assets/images/logo_ueb.png") ?>" alt="Logo del curso"
                                            class="img-fluid" width="120px;">
                                    </figure>
                                    <section class="px-2">
                                        <article class="date__start__content">
                                            <?= $event['formatted_event_date'] ?>
                                        </article>
                                        <section class="card__icons__container">
                                            <?php if ($event['modality'] == 'Virtual' || $event['modality'] == 'Hibrida'): ?>
                                                <article class="text-center">
                                                    <p><i class="fa-regular fa-clock"></i> DURACIÓN</p>
                                                    <span><?= $event['event_duration'] ?> Horas</span>
                                                </article>
                                            <?php endif; ?>
                                            <article class="text-center">
                                                <p><i class="fa fa-users"></i> MODALIDAD</p>
                                                <span><?= $event['modality'] ?></span>
                                            </article>
                                        </section>
                                        <section class="pt-3 pb-1">
                                            <button class="btn btn-danger mb-2 btn-inscribirse" data-bs-toggle="modal"
                                                data-bs-target="#modalInscripcion" data-evento="<?= $event['event_name'] ?>"
                                                data-event-id="<?= $event['id'] ?>" type="button" style="width:100%;">
                                                Inscribirse
                                            </button>
                                            <button class="btn card__button mb-2" type="button" data-bs-toggle="modal"
                                                data-bs-target="#modalMetodo" style="width:100%;">
                                                Método de pago
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
                            <div class="input-group">
                                <div class="input-group-text"><i class="fas fa-id-card"></i></div>

                                <input type="text" class="form-control numTex" id="numeroCedula" name="numeroCedula" required>
                            </div>
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
                        <div class="row mb-3">
                            <div class="col">
                                <label for="numeroCedulaRegistro" class="form-label">Número de Cédula</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                                    <input type="text" class="form-control" id="numeroCedulaRegistro"
                                        name="numeroCedula" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <label for="nombres" class="form-label">Nombres</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    <input type="text" class="form-control" id="nombres" name="nombres" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                </div>
                            </div>
                            <div class="col">
                                <label for="telefono" class="form-label">Número de teléfono o celular</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-phone"></i></div>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col">
                                <label for="direccion" class="form-label">Dirección</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-map-marker-alt"></i></div>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="formRegistroUsuario" type="submit" class="btn btn-primary">Registrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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

    <!-- Modal de depósito -->
    <div class="modal fade" id="modalDeposito" tabindex="-1" aria-labelledby="modalDepositoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDepositoLabel">Registrar Depósito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form id="formDeposito" method="post" action="<?= base_url("deposito") ?>"
                                enctype="multipart/form-data">
                                <div class="row">
                                    <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                        <label for="codigoPagoDep" class="form-label">Código de pago <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fas fa-receipt"></i></div>
                                            <input type="text" class="form-control numTex" id="codigoPagoDep"
                                                name="codigoPago"
                                                value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'codigoPago') : '' ?>"
                                                required readonly>
                                        </div>
                                        <span class="text-danger">
                                            <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'codigoPago') : '' ?>
                                        </span>
                                    </div>
                                    <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                        <label for="depositoCedulaDep" class="form-label">Número de cédula <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                                            <input type="text" class="form-control numTex" id="depositoCedulaDep"
                                                name="depositoCedula"
                                                value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'depositoCedula') : '' ?>"
                                                required readonly>
                                        </div>
                                        <span class="text-danger">
                                            <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'depositoCedula') : '' ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                        <label for="comprobante" class="form-label">Número de comprobante <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa-solid fa-hashtag"></i></div>
                                            <input type="text" class="form-control numTex" id="comprobante"
                                                name="comprobante"
                                                value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'comprobante') : '' ?>"
                                                required>
                                        </div>
                                        <span class="text-danger">
                                            <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'comprobante') : '' ?>
                                        </span>
                                    </div>
                                    <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                        <label for="dateDeposito" class="form-label">Fecha del deposito <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                            <input type="date" class="form-control" id="dateDeposito"
                                                name="dateDeposito"
                                                value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'dateDeposito') : '' ?>"
                                                required>
                                        </div>
                                        <span class="text-danger">
                                            <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'dateDeposito') : '' ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="montoDeposito" class="form-label">Monto del Depósito</label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-dollar-sign"></i></div>
                                        <input type="text" class="form-control" id="montoDeposito" name="montoDeposito"
                                            value="<?= (isset($last_data) && ($last_action ?? null) == 'insert') ? display_data($last_data, 'montoDeposito') : '' ?>"
                                            readonly>
                                    </div>
                                    <p id="mensaje_estado" style="display: none;">Estado: <span
                                            class="text-danger"></span></p>
                                    <p id="mensaje_original" style="display: none;">Monto original: <span
                                            class="text-danger"></span></p>
                                    <p id="mensaje_pagado" style="display: none;">Monto pagado: <span
                                            class="text-danger"></span></p>
                                    <p id="mensaje_nuevo" style="display: none;">Nuevo monto a pagar: <span
                                            class="text-danger"></span></p>
                                </div>
                                <div class="mb-3">
                                    <label for="comprobantePago" class="form-label">Subir Comprobante de Pago <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fas fa-upload"></i></div>
                                        <input type="file" class="form-control" id="comprobantePago"
                                            name="comprobantePago" accept="image/*,application/pdf" required>
                                    </div>
                                    <span class="text-danger">
                                        <?= (isset($validation) && ($last_action ?? null) == 'insert') ? display_data($validation, 'comprobantePago') : '' ?>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 modal-dialog-scrollable">
                            <h6>Historial de Depósitos</h6>
                            <div id="tabla_depositos" style="max-height: 300px; overflow-y: auto;"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" form="formDeposito" class="btn btn-success me-1">Registrar Depósito</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Autorización-->
    <div class="modal fade" id="modalVoucher" tabindex="-1" aria-labelledby="modalVoucherLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVoucherLabel">Consultar Voucher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formVoucher" method="GET">
                        <div class="mb-3">
                            <label for="numero_auto" class="form-label">Número de autorización</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="fa-solid fa-hashtag"></i></div>
                                <input type="text" class="form-control" id="numero_auto" name="numero_auto">
                            </div>
                        </div>
                        <div class="float-end">
                            <button type="button" class="btn btn-success me-1"
                                onclick="submitVoucherForm()">Buscar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modalMetodo" tabindex="-1" aria-labelledby="modalMetodoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalMetodoLabel">Método de pago</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formMetodo">
                        <div class="row mb-3">
                            <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                <label for="codigoPagoMetodo" class="form-label">Código de pago <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-receipt"></i></div>
                                    <input type="text" class="form-control numTex" id="codigoPagoMetodo"
                                        name="codigoPago" value="" required>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6 col-lg-6 col-xl-6">
                                <label for="depositoCedulaMetodo" class="form-label">Número de cédula <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fas fa-id-card"></i></div>
                                    <input type="text" class="form-control numTex" id="depositoCedulaMetodo"
                                        name="depositoCedula" value="" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="container col">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="metodoPago" value="deposito" checked>
                                                <span>Registrar deposito</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="metodoPago" value="tarjeta">
                                                <span>Pago con tarjeta <img
                                                        src="<?= base_url('assets/images/iconoPayphone.webp') ?>"
                                                        alt="PayPhone Icon"
                                                        style="width: 20px; height: 20px; vertical-align: middle; margin-left: 1px;"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="float-end">
                            <button type="submit" class="btn btn-success me-1">Continuar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Payphone -->
    <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="payModalLabel">Realizar el Pago</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div>
                        <div id="pp-button"></div>
                    </div>
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
                    <div class="small m-0 text-white">Copyright 2024 &copy; PROSERVI-UEB-EP |
                        <a href="https://www.softecsa.com" class="text-decoration-none link-light">Softec Apps S.A.S</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Payphone -->
    <script type='module' src='https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.js'></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url("assets/js/home/main.js") ?>"></script>
    <script>
        // Función para mostrar la alerta SweetAlert2
        function showAlert(type, message, uniqueCode = null) {
            if (type === 'success') {
                Swal.fire({
                    title: "<strong>¡Éxito!</strong>",
                    icon: "success",
                    html: `<div>${message}</div>`,
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: `<i class="fa fa-thumbs-up"></i> Entendido`,
                    confirmButtonAriaLabel: "Thumbs up, great!",
                });
            }
            else if (type === 'error') {
                Swal.fire({
                    title: "<strong>Error</strong>",
                    icon: "error",
                    html: `<div>${message}</div>`,
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: `<i class="fa fa-thumbs-up"></i> Entendido`,
                });
            }
            else if (type === 'pdf') {
                Swal.fire({
                    title: "<strong>Completado</strong>",
                    icon: "success",
                    html: `
                    <div>${message}</div>
                    ${uniqueCode ? `<div class="mt-3"><a class="btn btn-outline-danger" href="<?= base_url("") ?>pdf/${uniqueCode}" target="_blank"><i class="fa-solid fa-receipt"></i> Voucher </a></div>` : ''}
                `,
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: `<i class="fa fa-thumbs-up"></i> Entendido`,
                });
            }
            else {
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
                <?php
                $type = $message[1];
                $msg = $message[0];
                $uniqueCode = isset($message[2]) ? $message[2] : null;
                ?>
                showAlert('<?= $type ?>', '<?= $msg ?>', '<?= $uniqueCode ?>');
            <?php endforeach; ?>
        <?php endif; ?>

        // Mostrar el modal de depósito si es necesario
        <?php if ('insert' == ($last_action ?? '')): ?>
            var myModal = new bootstrap.Modal(document.getElementById('modalDeposito'));
            myModal.show();
        <?php endif; ?>

        function submitVoucherForm() {
            var numeroAuto = document.getElementById('numero_auto').value.replace(/\s/g, '');

            // Elimina los primeros 13 dígitos
            numeroAuto = numeroAuto.slice(13);

            // Elimina los últimos 6 dígitos
            numeroAuto = numeroAuto.slice(0, -6);

            var url = '<?= base_url("pdf/") ?>' + numeroAuto;
            window.location.href = url;
        }
    </script>

    <script src="<?= base_url("assets/js/home/home.js") ?>"></script>

    <!-- template -->
    <script src="<?= base_url("dist/js/niche.js") ?>"></script>
    <script src="<?= base_url("assets/js/sweetalert/sweetalert.min.js") ?>"></script>
</body>

</html>