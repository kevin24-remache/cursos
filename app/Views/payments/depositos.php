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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($depositos as $key => $deposito):
                            $numAutorizacion = $deposito['num_autorizacion'];
                            helper('payment_status');
                            ?>
                            <tr data-id-pago="<?= $deposito["id_pago"] ?>"
                                data-ic="<?= $deposito["ic"] ?>"
                                data-estado-pago="<?= $deposito["payment_status"] ?>"
                                data-precio="<?= $deposito['cantidad_dinero']?>"
                                data-codigo-pago="<?= $deposito["codigo_pago"] ?>"
                                data-nombres="<?= $deposito["full_name_user"] ?>"
                                data-evento="<?= $deposito["event_name"] ?>"
                                data-categoria="<?= $deposito["category_name"] ?>"
                                data-email="<?= $deposito["email"] ?>"
                                >
                                <td><?= $deposito["codigo_pago"] ?></td>
                                <td><?= $deposito["ic"] ?></td>
                                <td><?= $deposito["full_name_user"] ?></td>
                                <td><?= $deposito["event_name"] ?></td>
                                <td><?= $deposito["category_name"] ?></td>
                                <td><?= $deposito["address"] ?></td>
                                <td><?= $deposito["phone"] ?></td>
                                <td><?= $deposito["email"] ?></td>
                                <td><span
                                        class="<?= get_payment_deposit_status($deposito["payment_status"]) ?>"><?= $deposito["payment_status"] ?></span>
                                </td>
                                <td>
                                    <?php if ($deposito['payment_status'] == '4'): ?>
                                        <button class="btn btn-outline-success btn-pagar" data-toggle="modal" data-target="#"
                                            title="Confirmar deposito">
                                            <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Depositos
                                        </button>
                                         <a href="<?= base_url('punto/pago/deposito/'.$deposito["id_pago"])?>" class="btn btn-outline-info" title="Todos los depósitos">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Todos los depósitos
                                        </a>
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
    <style>
        #depositosTable {
            width: 100% !important;
        }

        #depositosTable tbody tr {
            cursor: pointer;
        }

        #example2 {
            width: 100% !important;
        }
    </style>
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
                            <form action="<?= base_url("punto/pago/aprobar_deposito") ?>" id="formPago" method="post">
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
                            </form>

                            <div class="table-responsive">
                                <h5>Historial de depósitos</h5>
                                <table id="depositosTable" class="table table-bordered table-hover rounded-3"
                                    style="border: 3px solid #001a35;">
                                    <thead class="bg-blue">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Los datos se cargarán aquí dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
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
                    <form id="formRechazo" action="<?= base_url("punto/pago/pago_incompleto") ?>" method="post">
                        <input type="hidden" name="id_pago_rechazo" id="id_pago_rechazo"
                            value="<?= (isset($last_data) && ($last_action ?? null) == 'update') ? display_data($last_data, 'id_pago_rechazo') : '' ?>">
                        <input type="hidden" name="email" class="email_rechazo_incompleto"
                            value="<?= (isset($last_data) && ($last_action ?? null) == 'update') ? display_data($last_data, 'email') : '' ?>">
                        <div class="row mb-3">
                            <div class="form-group col">
                                <label for="names">Nombres</label>
                                <div class="input-group">
                                    <div class="input-group-addon text-success"><i class="fa fa-user-o"></i></div>
                                    <input class="form-control names" id="names_rechazo_incompleto" name="names"
                                        type="text"
                                        value="<?= (isset($last_data) && ($last_action ?? null) == 'update') ? display_data($last_data, 'names') : '' ?>"
                                        readonly required>

                                </div>
                                <span class="text-danger">
                                    <?= (isset($validation) && ($last_action ?? null) == 'update') ? display_data($validation, 'names') : '' ?>
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="motivo_rechazo">Motivo de Rechazo:</label>
                                <textarea class="form-control" id="motivo_rechazo" name="motivo_rechazo"
                                    rows="4"><?= (isset($last_data) && ($last_action ?? null) == 'update') ? display_data($last_data, 'motivo_rechazo') : '' ?></textarea>
                                <span class="text-danger">
                                    <?= (isset($validation) && ($last_action ?? null) == 'update') ? display_data($validation, 'motivo_rechazo') : '' ?>
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group col">
                                <label for="precio_pagar">Precio a pagar</label>
                                <div class="input-group">
                                    <div class="input-group-addon text-success">$</div>
                                    <input class="form-control" id="precio_pagar" name="precio_pagar" type="text"
                                        value="<?= (isset($last_data) && ($last_action ?? null) == 'update') ? display_data($last_data, 'precio_pagar') : '' ?>"
                                        readonly required>
                                </div>
                                <span class="text-danger">
                                    <?= (isset($validation) && ($last_action ?? null) == 'update') ? display_data($validation, 'precio_pagar') : '' ?>
                                </span>
                            </div>
                            <div class="form-group col">
                                <label for="precio_pagado">Precio pagado:</label>
                                <div class="input-group">
                                    <div class="input-group-addon text-success">$</div>
                                    <input class="form-control" id="precio_pagado" name="precio_pagado" type="text"
                                        value="<?= (isset($last_data) && ($last_action ?? null) == 'update') ? display_data($last_data, 'precio_pagado') : '' ?>"
                                        required>
                                </div>
                                <span class="text-danger">
                                    <?= (isset($validation) && ($last_action ?? null) == 'update') ? display_data($validation, 'precio_pagado') : '' ?>
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">

                            <div class="form-group col">
                                <label for="valor_pendiente">Valor pendiente:</label>
                                <div class="input-group">
                                    <div class="input-group-addon text-success">$</div>
                                    <input class="form-control" id="valor_pendiente" name="valor_pendiente" type="text"
                                        value="<?= (isset($last_data) && ($last_action ?? null) == 'update') ? display_data($last_data, 'valor_pendiente') : '' ?>"
                                        readonly required>
                                </div>
                                <span class="text-danger">
                                    <?= (isset($validation) && ($last_action ?? null) == 'update') ? display_data($validation, 'valor_pendiente') : '' ?>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary  btn-close" data-dismiss="modal">Cerrar</button>
                    <button form="formRechazo" type="submit" class="btn btn-danger">Enviar email</button>
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
                        <input type="hidden" name="email" id="email_rechazo" class="email_rechazo_incompleto">

                        <div class="row mb-3">
                            <div class="form-group col">
                                <label for="names">Nombres</label>
                                <div class="input-group">
                                    <div class="input-group-addon text-success"><i class="fa fa-user-o"></i></div>
                                    <input class="form-control names" id="names_rechazo" name="names" type="text"
                                        readonly required>
                                </div>
                            </div>
                        </div>
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
        // Inicialización de DataTable
        $("#example2").DataTable({
            columnDefs: [
                { targets: 'exclude-view', visible: false },
                { className: 'dtr-control bg-white' }
            ],
            language: {
                buttons: {
                    sLengthMenu: "Mostrar _MENU_ resultados",
                    pageLength: { _: "Mostrar %d resultados" },
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
                { extend: "pageLength", className: "" },
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns" aria-hidden="true"></i> Columnas visibles',
                    columnText: function (dt, idx, title) {
                        return (idx + 1) + ': ' + title;
                    },
                    className: "bg-success",
                },
            ],
            lengthMenu: [10, 25, 50, 100],
        });

        // Función para actualizar el valor pendiente
        function actualizarValorPendiente() {
            let precioPagar = parseFloat($("#precio_pagar").val()) || 0;
            let precioPagado = parseFloat($("#precio_pagado").val()) || 0;
            let valorPendiente = Math.max(precioPagar - precioPagado, 0).toFixed(2);
            $("#valor_pendiente").val(valorPendiente);
        }

        // Evento para cuando se cambia el valor de precio_pagado
        $("#precio_pagado").on('input', actualizarValorPendiente);

        // Función para calcular la suma de los depósitos completados
        function calcularSumaDepositos() {
            let suma = 0;
            $('#depositosTable').DataTable().rows().every(function () {
                let data = this.data();
                if (data.estado === 'Completado') {
                    suma += parseFloat(data.monto_deposito);
                }
            });
            return suma.toFixed(2);
        }

        // Función para cerrar modales
        function closeModal(modalId) {
            $(modalId).modal('hide');
            $(modalId).find('input, textarea, select').val('');
        }

        // Evento para el botón de pagar
        $(".btn-pagar").click(function () {
            var fila = $(this).closest("tr");
            var ic = fila.data("ic");
            var estadoPago = fila.data("estado-pago");
            var idPago = fila.data("id-pago");
            var nombres = fila.data("nombres");
            var evento = fila.data("evento");
            var categoria = fila.data("categoria");
            var precio = fila.data("precio");
            var email = fila.data("email");
            var imagenRuta = fila.data("imagen");

            // Actualizar los campos del modal
            $("#cedula").val(ic);
            $("#estado_pago").val(estadoPago);
            $("#id_pago").val(idPago);
            $("#nombre").val(nombres);
            $("#evento").val(evento);
            $("#categoria").val(categoria);
            $("#precio").val(precio);
            $(".email_rechazo_incompleto").val(email);
            $(".names").val(nombres);
            $("#imagen-deposito").attr("src", imagenRuta);

            // Hacer la llamada fetch para obtener los datos del depósito
            fetch(`<?= base_url('punto/pago/obtener_depositos/') ?>${idPago}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if ($.fn.DataTable.isDataTable('#depositosTable')) {
                        $('#depositosTable').DataTable().destroy();
                    }

                    $('#depositosTable').DataTable({
                        data: data,
                        columns: [
                            { data: 'fecha_deposito', title: 'Fecha' },
                            {
                                data: 'monto_deposito',
                                title: 'Monto',
                                render: function (data, type, row) {
                                    return '$' + parseFloat(data).toFixed(2);
                                }
                            },
                            { data: 'estado', title: 'Estado' },
                            { data: 'url_comprobante', visible: false }
                        ],
                        searching: false,
                        paging: false,
                        info: false,
                        ordering: false,
                        lengthChange: false,
                        language: {
                            search: "Buscar:",
                            zeroRecords: "No se encontraron registros coincidentes",
                            emptyTable: "No hay datos disponibles en la tabla"
                        }
                    });

                    let sumaDepositos = calcularSumaDepositos();
                    $("#precio_pagado").val(sumaDepositos);
                    actualizarValorPendiente();

                    $("#mi_modal").modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al cargar los datos de depósitos. Por favor, intente de nuevo.');
                });
        });

        // Evento para seleccionar una fila en la tabla de depósitos
        $('#depositosTable tbody').on('click', 'tr', function () {
            var table = $('#depositosTable').DataTable();
            var data = table.row(this).data();
            if (data) {
                $('#imagen-deposito').attr('src', data.url_comprobante);
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            }
        });

        // Evento para el botón de pago incompleto
        $("#btnPagoIncompleto").click(function () {
            let idPago = $("#id_pago").val();
            let precio = $("#precio").val();

            closeModal("#mi_modal");
            $("#mi_modal").on('hidden.bs.modal', function () {
                $("#id_pago_rechazo").val(idPago);
                $("#precio_pagar").val(precio);
                $("#modalRechazo").modal('show');
                $("#mi_modal").off('hidden.bs.modal');
                actualizarValorPendiente();
            });
        });

        // Evento para el botón de solo rechazo
        $("#btnSoloRechazo").click(function () {
            var idPago = $("#id_pago").val();

            closeModal("#mi_modal");
            $("#mi_modal").on('hidden.bs.modal', function () {
                $("#id_pago_solo_rechazo").val(idPago);
                $("#modalSoloRechazo").modal('show');
                $("#mi_modal").off('hidden.bs.modal');
            });
        });

        // Manejar el cierre de los modales
        $("#modalRechazo, #modalSoloRechazo").on('hidden.bs.modal', function () {
            $(this).find('input, textarea').val('');
        });

        // Agregar manejadores de eventos para los botones de cierre
        $('.close, .btn-close').click(function () {
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
            $("#imagen-container").scrollTop(0).scrollLeft(0);
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
            $("#imagen-container").scrollLeft(scrollLeft - walkX).scrollTop(scrollTop - walkY);
        });

        $(document).on("mouseup", function () {
            isDragging = false;
        });
    });
</script>

<?= $this->endSection() ?>