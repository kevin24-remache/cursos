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
                    <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 p-3">
                        <div class="bg-white shadow">
                            <figure class="p-1">
                                <img src="<?= base_url("assets/images/ejemplo_congreso.jpg") ?>" alt="Imagen del Curso"
                                    class="img-fluid imagen-pequena rounded-2 ">
                            </figure>
                            <figure class="text-center">
                                <img src="<?= base_url("assets/images/logo_ueb.png") ?>" alt="Logo del curso"
                                    class="img-fluid" width="120px;">
                            </figure>

                            <section class="px-3">
                                <article class="date__start__content">
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
                                    <button class="btn border border-danger mb-2 card__button text-danger" data-bs-toggle="modal" data-bs-target="#modalInfo"  type="button"
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

<!-- Modal de información -->
<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="modalInfoLabel"
    aria-hidden="true">
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