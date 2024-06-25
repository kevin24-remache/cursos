<?= $this->extend('layouts/payments_layout'); ?>

<?= $this->section('title') ?>
Depósitos
<?= $this->endSection() ?>


<?= $this->section('css') ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url("dist/plugins/datatables/css/dataTables.bootstrap.min.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
        <h1 class="text-black">Depósitos</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><i class="fa fa-angle-right"></i>Depósitos</li>
        </ol>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="info-box">
            <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover" data-name="cool-table">
                    <thead>
                        <tr>
                            <th>Código de pago</th>
                            <th class="exclude-view">Cédula</th>
                            <th>Nombres</th>
                            <th>Evento</th>
                            <th>Categoría</th>
                            <th class="exclude-view">Dirección</th$>
                            <th class="exclude-view">Teléfono</th>
                            <th class="exclude-view">Email</th>
                            <th>Estado de pago</th>
                            <th>Precio a pagar</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($depositos as $key => $deposito):
                            $numAutorizacion = $deposito['num_autorizacion'];
                            helper('payment_status');
                            ?>
                            <tr data-id-pago="<?= $deposito["id_pago"] ?>" data-ic="<?= $deposito["ic"] ?>"
                                data-estado-pago="<?= $deposito["payment_status"] ?>"
                                data-codigo-pago="<?= $deposito["codigo_pago"] ?>"
                                data-nombres="<?= $deposito["full_name_user"] ?>"
                                data-evento="<?= $deposito["event_name"] ?>"
                                data-categoria="<?= $deposito["category_name"] ?>"
                                data-precio="<?= $deposito["monto_deposito"] ?>"
                                data-num-comprobante="<?= $deposito["num_comprobante"] ?>"
                                data-date-deposito="<?= $deposito["date_deposito"] ?>"
                                data-imagen="<?= base_url($deposito["comprobante_pago"]) ?>">
                                <td><?= $deposito["codigo_pago"] ?></td>
                                <td><?= $deposito["ic"] ?></td>
                                <td><?= $deposito["full_name_user"] ?></td>
                                <td><?= $deposito["event_name"] ?></td>
                                <td><?= $deposito["category_name"] ?></td>
                                <td><?= $deposito["address"] ?></td>
                                <td><?= $deposito["phone"] ?></td>
                                <td><?= $deposito["email"] ?></td>
                                <td><span
                                        class="<?= get_payment_deposit_status($deposito["status"]) ?>"><?= $deposito["status"] ?></span>
                                </td>
                                <td><?= $deposito["monto_deposito"] ?></td>
                                <td>
                                    <?php if ($deposito['status'] == 'Pendiente'): ?>
                                        <button class="btn btn-outline-success btn-pagar" data-toggle="modal" data-target="#"
                                            title="Confirmar deposito">
                                            <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Confirmar deposito
                                        </button>
                                    <?php elseif ($deposito['payment_status'] == 'Completado'): ?>
                                        <a class="btn btn-outline-danger"
                                            href="<?= base_url("punto/pago/pdf/$numAutorizacion") ?>" title="PDF">
                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF
                                        </a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- Modal-->
    <div class="modal fade" id="mi_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-2">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">PROCEDER CON EL PAGO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="<?= base_url("punto/pago/pago/x") ?>" id="formPago" method="post">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label>Nombre:</label>
                                        <input type="text" class="form-control" id="nombre" readonly>
                                    </div>
                                </div>
                                <input type="hidden" name="id" id="id_pago">
                                <input type="hidden" name="cedula" id="cedula">
                                <input type="hidden" name="estado_pago" id="estado_pago">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label>Evento:</label>
                                        <input type="text" class="form-control" id="evento" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label>Categoría:</label>
                                        <input type="text" class="form-control" id="categoria" readonly>
                                    </div>
                                    <div class="col">
                                        <label>Precio:</label>
                                        <input type="text" class="form-control" id="precio" name="precio" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label>Número de comprobante</label>
                                        <input type="text" class="form-control" id="num_comprobante"
                                            name="num_comprobante" readonly>
                                    </div>
                                    <div class="col">
                                        <label>Fecha del deposito:</label>
                                        <input type="text" class="form-control" id="date_deposito" name="date_deposito"
                                            readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div id="imagen-container" class="imagen-container bg-dark">
                                <div class="imagen-wrapper">
                                    <img id="imagen-deposito" src="" alt="Comprobante de depósito" class="img-zoomable">
                                </div>
                            </div>
                            <div class="zoom-controls mt-2">
                                <button id="zoom-in" class="btn btn-sm btn-primary">+</button>
                                <button id="zoom-out" class="btn btn-sm btn-primary">-</button>
                                <button id="zoom-reset" class="btn btn-sm btn-secondary">Reiniciar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" id="btnPagoIncompleto">Pago incompleto</button>
                    <button type="button" class="btn btn-danger" id="btnSoloRechazo">Rechazar</button>
                    <button form="formPago" type="submit" class="btn btn-primary">Continuar</button>
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para pagos incompletos -->
    <div class="modal fade" id="modalRechazo" tabindex="-1" role="dialog" aria-labelledby="modalRechazoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-2">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalRechazoLabel">Pago incompleto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formRechazo" action="<?= base_url("punto/pago/rechazar") ?>" method="post">
                        <input type="hidden" name="id_pago_rechazo" id="id_pago_rechazo">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="motivo_rechazo">Motivo de Rechazo:</label>
                                <textarea class="form-control" id="motivo_rechazo" name="motivo_rechazo" rows="4"
                                    required>El pago esta incompleto</textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary  btn-close" data-dismiss="modal">Cerrar</button>
                    <button form="formRechazo" type="submit" class="btn btn-danger">Enviar Rechazo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Nuevo Modal para motivo de rechazo y enviar a otra ruta -->
    <div class="modal fade" id="modalSoloRechazo" tabindex="-1" role="dialog" aria-labelledby="modalSoloRechazoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-2">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalSoloRechazoLabel">Motivo de Rechazo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formSoloRechazo" action="<?= base_url("punto/pago/rechazarOtraRuta") ?>" method="post">
                        <input type="hidden" name="id_pago_solo_rechazo" id="id_pago_solo_rechazo">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="motivo_solo_rechazo">Motivo de Rechazo:</label>
                                <textarea class="form-control" id="motivo_solo_rechazo" name="motivo_solo_rechazo"
                                    rows="4" required></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Cerrar</button>
                    <button form="formSoloRechazo" type="submit" class="btn btn-danger">Enviar Rechazo</button>
                </div>
            </div>
        </div>
    </div>



</div>
<style>
    .modal-lg {
        max-width: 90%;
    }

    .imagen-container {
        width: 100%;
        height: 400px;
        overflow: auto;
        position: relative;
        border: 1px solid #ddd;
    }

    .imagen-wrapper {
        min-height: 100%;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .img-zoomable {
        max-width: 100%;
        max-height: none;
        display: block;
        transition: transform 0.3s ease-out;
    }

    .zoom-controls {
        text-align: center;
    }
</style>
<?= $this->endSection() ?>



<?= $this->section('scripts') ?>

<!-- DataTable -->
<script src="<?= base_url("dist/plugins/datatables/jquery.dataTables.min.js") ?>"></script>
<script src="<?= base_url("dist/plugins/datatables/dataTables.bootstrap.min.js") ?>"></script>

<script>
    $(document).ready(function () {


        $("#example2").DataTable({
            columnDefs: [
                { targets: 'exclude-view', visible: false },
                {
                    className: 'dtr-control bg-white',
                }
            ],
            language: {
                buttons: {
                    sLengthMenu: "Mostrar _MENU_ resultados",
                    pageLength: {
                        _: "Mostrar %d resultados",
                    },
                },
                zeroRecords: "No hay coincidencias",
                info: "Mostrando _END_ resultados de _MAX_",
                infoEmpty: "No hay datos disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros totales)",
                search: "Buscar",
                emptyTable: "No existen registros",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Último",
                },
            },
            colReorder: true,
            responsive: false,
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "pageLength",
                    className: "",
                },

                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns" aria-hidden="true"></i> Columnas visibles',
                    columnText: function (dt, idx, title) {
                        return (idx + 1) + ': ' + title;
                    },

                    className: "bg-success",
                },
                // {
                //     extend: 'collection',
                //     text: '<i class="fa fa-download"></i> Exportar',
                //     buttons: [
                //         {
                //             extend: 'copyHtml5',
                //             text: '<i class="fa fa-files-o text-info"></i> Copiar',
                //             titleAttr: 'Copiar'
                //         },
                //         {
                //             extend: 'excelHtml5',
                //             text: '<i class="fa fa-file-excel-o text-success"></i> Excel',
                //             titleAttr: 'Excel'
                //         },
                //         {
                //             extend: 'csvHtml5',
                //             text: '<i class="fa fa-file-text-o text-primary"></i> CSV',
                //             titleAttr: 'CSV'
                //         },
                //         {
                //             extend: 'pdfHtml5',
                //             text: '<i class="fa fa-file-pdf-o text-red"></i> PDF',
                //             titleAttr: 'PDF'
                //         },
                //         {
                //             extend: 'colvis',
                //             text: 'Columnas visibles',
                //             columnText: function (dt, idx, title) {
                //                 // Verifica si la columna es la primera (índice 0) o tiene una clase específica
                //                 if (idx === 0 || dt.column(idx).nodes().to$().hasClass('clase-a-excluir')) {
                //                     return null; // Retorna null para excluir la columna de la lista
                //                 }
                //                 return (idx) + ': ' + title;
                //             }
                //         }
                //     ]
                // },

                // {
                //     text: '<i class="fa fa-lg fas fa-plus-circle"></i> Agregar',
                //     titleAttr: 'Agregar',
                //     className: 'bg-success text-white',
                //     action: function () {
                //         window.location.href = base_url + "admin/event/new";
                //     },
                // },
                // {
                //     text: '<i class="fa-lg fas fa-trash-restore"></i><p class="tooltip-text">Eliminados</p>',
                //     className: 'd-none',

                //     action: function () {
                //         $("#createEventModal").modal("show");
                //     },
                // },
            ],
            lengthMenu: [10, 25, 50, 100],
        });
        $(".btn-pagar").click(function () {
            var fila = $(this).closest("tr");
            var ic = fila.data("ic");
            var estadoPago = fila.data("estado-pago");
            var idPago = fila.data("id-pago");
            var codigoPago = fila.data("codigo-pago");
            var nombres = fila.data("nombres");
            var evento = fila.data("evento");
            var categoria = fila.data("categoria");
            var precio = fila.data("precio");
            var numComprobante = fila.data("num-comprobante");
            var dateDeposito = fila.data("date-deposito");
            var imagenRuta = fila.data("imagen");

            // Actualizar los campos del modal
            $("#cedula").val(ic);
            $("#estado_pago").val(estadoPago);
            $("#id_pago").val(idPago);
            $("#nombre").val(nombres);
            $("#evento").val(evento);
            $("#categoria").val(categoria);
            $("#precio").val(precio);
            $("#num_comprobante").val(numComprobante);
            $("#date_deposito").val(dateDeposito);
            $("#imagen-deposito").attr("src", imagenRuta);

            $("#mi_modal").modal('show');
        });
        function closeModal(modalId) {
            $(modalId).modal('hide');
        }

        // Manejar el evento del botón "Pago incompleto"
        $("#btnPagoIncompleto").click(function () {
            var idPago = $("#id_pago").val();

            closeModal("#mi_modal");
            $("#mi_modal").on('hidden.bs.modal', function () {
                // Pasar el ID del pago al nuevo modal
                $("#id_pago_rechazo").val(idPago);

                // Abrir el nuevo modal
                $("#modalRechazo").modal('show');

                // Remover el event handler para evitar llamadas múltiples
                $("#mi_modal").off('hidden.bs.modal');
            });
        });


        // Manejar el evento del botón "Rechazo"
        $("#btnSoloRechazo").click(function () {
            var idPago = $("#id_pago").val();

            closeModal("#mi_modal");
            $("#mi_modal").on('hidden.bs.modal', function () {
                // Pasar el ID del pago al nuevo modal
                $("#id_pago_solo_rechazo").val(idPago);

                // Abrir el nuevo modal
                $("#modalSoloRechazo").modal('show');

                // Remover el event handler para evitar llamadas múltiples
                $("#mi_modal").off('hidden.bs.modal');
            });
        });


        // Manejar el cierre del segundo modal
        $("#modalRechazo").on('hidden.bs.modal', function () {
            // Limpiar el contenido del modal si es necesario
            $("#id_pago_rechazo").val('');
            $("#motivo_rechazo").val('');
        });
        // Manejar el cierre del tercer modal
        $("#modalSoloRechazo").on('hidden.bs.modal', function () {
            // Limpiar el contenido del modal si es necesario
            $("#id_pago_solo_rechazo").val('');
            $("#motivo_solo_rechazo").val('');
        });

        // Agregar manejadores de eventos para los botones de cierre
        $('.close').click(function () {
            var modalId = $(this).closest('.modal').attr('id');
            closeModal('#' + modalId);
        });

        $('.btn-close').click(function () {
            var modalId = $(this).closest('.modal').attr('id');
            closeModal('#' + modalId);
        });
        // Funcionalidad de zoom
        var scale = 1;

        function setTransform() {
            $("#imagen-deposito").css("transform", `scale(${scale})`);
        }

        $("#zoom-in").click(function () {
            scale = Math.min(scale + 0.1, 3);
            setTransform();
        });

        $("#zoom-out").click(function () {
            scale = Math.max(scale - 0.1, 1);
            setTransform();
        });

        $("#zoom-reset").click(function () {
            scale = 1;
            setTransform();
            $("#imagen-container").scrollTop(0);
            $("#imagen-container").scrollLeft(0);
        });

        // Manejar el scroll con la rueda del ratón
        $("#imagen-container").on("wheel", function (e) {
            e.preventDefault();
            var delta = e.originalEvent.deltaY;
            $(this).scrollTop($(this).scrollTop() + delta);
        });

        // Arrastrar la imagen
        var isDragging = false;
        var startX, startY, scrollLeft, scrollTop;

        $("#imagen-container").on("mousedown", function (e) {
            isDragging = true;
            startX = e.pageX - $(this).offset().left;
            startY = e.pageY - $(this).offset().top;
            scrollLeft = $(this).scrollLeft();
            scrollTop = $(this).scrollTop();
        });

        $(document).on("mousemove", function (e) {
            if (!isDragging) return;
            e.preventDefault();
            var x = e.pageX - $("#imagen-container").offset().left;
            var y = e.pageY - $("#imagen-container").offset().top;
            var walkX = (x - startX) * 2;
            var walkY = (y - startY) * 2;
            $("#imagen-container").scrollLeft(scrollLeft - walkX);
            $("#imagen-container").scrollTop(scrollTop - walkY);
        });

        $(document).on("mouseup", function () {
            isDragging = false;
        });
    });
</script>

<?= $this->endSection() ?>