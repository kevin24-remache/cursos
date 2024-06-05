<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url("assets/css/styles.css") ?>">
    <link rel="stylesheet" href="<?= base_url("dist/css/font-awesome/css/font-awesome.min.css") ?>">
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0" style="background-color: #d9d9d9;">
        <nav class="navbar navbar-dark" style="background-color: #0C244B;">
            <div class="container-fluid">
                <a class="navbar-brand" style="margin-left: 20px;" href="/login">
                    <H3>PROSERVI-UEB-EP</H3>
                </a>
            </div>
        </nav>
        <div class="mb-4">
            <div class="text-center">
                <img src="<?= base_url("assets/images/logo-ep.png"); ?>" alt="" height="100px">
            </div>
            <section class="container">
                <div class="row">
                    <?php foreach ($events as $key => $event): ?>
                        <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 p-3">
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
                    <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 p-3">
                        <div class="bg-white shadow">
                            <figure class="imagen__curso__content">
                                <img src="<?= base_url("assets/images/ejemplo_congreso.jpg") ?>" alt="Imagen del Curso"
                                    class="img-fluid imagen-pequena">
                            </figure>
                            <figure class="imagen__curso__content px-5">
                                <img src="<?= base_url("assets/images/logo_ueb.png") ?>" alt="Logo del curso"
                                    class="img-fluid">
                            </figure>

                            <section class="px-3">
                                <article style="width:100%;" class="date__start__content">
                                    Inicia el 31 de mayo de 2024
                                </article>

                                <section class="card__icons__container">
                                    <article>
                                        <p><i class="fa fa-clock-o"></i> DURACIÓN</p>
                                        <span>225 Horas</span>
                                    </article>

                                    <article>
                                        <p><i class="fa fa-users"></i> MODALIDAD</p>
                                        <span>Virtual</span>
                                    </article>
                                </section>

                                <section class="pt-3 pb-4">
                                    <button class="btn border border-danger mb-2 card__button text-danger" type="button"
                                        style="width:100%;">
                                        Más Información
                                    </button>
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#modalInscripcion" data-evento="Nombre del evento" type="button"
                                        style="width:100%;">
                                        Inscribirse
                                    </button>
                                </section>
                            </section>
                        </div>
                    </div>
                    <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 p-3">
                        <div class="bg-white shadow">
                            <figure class="imagen__curso__content">
                                <img src="<?= base_url("assets/images/ejemplo_congreso.jpg") ?>" alt="Imagen del Curso"
                                    class="img-fluid imagen-pequena">
                            </figure>
                            <figure class="imagen__curso__content px-5">
                                <img src="<?= base_url("assets/images/logo_ueb.png") ?>" alt="Logo del curso"
                                    class="img-fluid">
                            </figure>

                            <section class="px-3">
                                <article style="width:100%;" class="date__start__content">
                                    Inicia el 31 de mayo de 2024
                                </article>

                                <section class="card__icons__container">
                                    <article>
                                        <p><i class="fa fa-clock-o"></i> DURACIÓN</p>
                                        <span>225 Horas</span>
                                    </article>

                                    <article>
                                        <p><i class="fa fa-users"></i> MODALIDAD</p>
                                        <span>Virtual</span>
                                    </article>
                                </section>

                                <section class="pt-3 pb-4">
                                    <button class="btn border border-danger mb-2 card__button text-danger" type="button"
                                        style="width:100%;">
                                        Más Información
                                    </button>
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#modalInscripcion" data-evento="Nombre del evento" type="button"
                                        style="width:100%;">
                                        Inscribirse
                                    </button>
                                </section>
                            </section>
                        </div>
                    </div>
                    <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 p-3">
                        <div class="bg-white shadow">
                            <figure class="imagen__curso__content">
                                <img src="<?= base_url("assets/images/ejemplo_congreso.jpg") ?>" alt="Imagen del Curso"
                                    class="img-fluid imagen-pequena">
                            </figure>
                            <figure class="imagen__curso__content px-5">
                                <img src="<?= base_url("assets/images/logo_ueb.png") ?>" alt="Logo del curso"
                                    class="img-fluid">
                            </figure>

                            <section class="px-3">
                                <article style="width:100%;" class="date__start__content">
                                    Inicia el 31 de mayo de 2024
                                </article>

                                <section class="card__icons__container">
                                    <article>
                                        <p><i class="fa fa-clock-o"></i> DURACIÓN</p>
                                        <span>225 Horas</span>
                                    </article>

                                    <article>
                                        <p><i class="fa fa-users"></i> MODALIDAD</p>
                                        <span>Virtual</span>
                                    </article>
                                </section>

                                <section class="pt-3 pb-4">
                                    <button class="btn border border-danger mb-2 card__button text-danger" type="button"
                                        style="width:100%;">
                                        Más Información
                                    </button>
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#modalInscripcion" data-evento="Nombre del evento" type="button"
                                        style="width:100%;">
                                        Inscribirse
                                    </button>
                                </section>
                            </section>
                        </div>
                    </div>

                </div>
            </section>
        </div>

    </main>
    <style>
        /* estilo de iconos con texto */
        .card__icons__container {
            width: 100%;
            display: flex;
            justify-content: space-around;
        }

        /* iconos con texto */
        .card__icons__container article p {
            margin-bottom: .35rem;
            font-weight: 500;
            font-size: .7rem;
            color: #393939;
        }

        /* info de iconos */
        .card__icons__container article span {
            color: #514a4a;
            font-weight: 700;
            font-size: 1rem;
        }


        /* Fecha de Inicio */
        .date__start__content {
            background-color: #d9d9d9;
            border-radius: 10px;
            padding: .4rem;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #727272;
            font-weight: 500;
        }

        /* Imagen del Curso */
        .imagen__curso__content {
            width: 100%;
        }

        .imagen__curso__content>img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card__button {
            background-color: #fff;
            transition: box-shadow .2s;
        }


        .card__button:hover {
            box-shadow: 0px 0px 10px 0px rgba(255, 0, 0, 0.5);
            /* Agregué un sombreado rojo cuando el cursor está encima */
        }
    </style>

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
                            <input type="number" class="form-control" id="numeroCedula" name="numeroCedula" required>
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
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="numeroCedulaRegistro" class="form-label">Número de Cédula</label>
                            <input type="number" class="form-control" id="numeroCedulaRegistro" name="numeroCedula"
                                readonly>
                        </div>
                        <div class="float-start">
                            <!-- <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-outline-success" disabled>
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-success" onclick="cerrarYMostrarModal()">
                                    Regresar
                                </button>
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
                    <h5 class="modal-title" id="modalDetallesEventoLabel" style="color: #0C244B;"><span
                            id="titleEvent"></span></h5>

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
                            Una vez seleccionada la categoría del evento finaliza con la inscripción y se te enviara un
                            código a tu correo electrónico que deberás usarlo para realizar el pago
                        </div>
                        <div class="mb-3 row">
                            <input type="hidden" id="id_user">
                            <p>Usuario <span id="nombresPersona"></span> <span id="apellidosPersona"></span></p>
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

    <!-- Footer-->
    <footer class="bg-dark py-3 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small m-0 text-white">Copyright 2022 &copy; PROSERVI-UEB-EP | <a
                            href="https://www.softecsa.com" class="text-decoration-none link-light">Softec Apps
                            S.A.S</a></div>
                </div>
            </div>
        </div>
    </footer>
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
    <script src="<?= base_url("assets/js/home/home.js") ?>"></script>

    <!-- template -->
    <script src="<?= base_url("dist/js/niche.js") ?>"></script>

    <script src="<?= base_url("assets/js/sweetalert/sweetalert.min.js") ?>"></script>
</body>

</html>