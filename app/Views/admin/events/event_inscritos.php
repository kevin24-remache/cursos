<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('title') ?>
Inscritos en <?= $event['event_name'] ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<!-- Select 2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Inscritos en: <?= $event['event_name'] ?></h1>

        <body data-event-id="<?= $event['id'] ?>"></body>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/events') ?>">Eventos</a></li>
            <li><i class="fa fa-angle-right"></i> Inscritos</li>
        </ol>
    </div>
    <div class="content">
        <div class="info-box">
            <h6>Filtros</h6>
            <form id="filterForm" action="" method="">
                <div class="row mb-2">
                    <div class="col-3">

                        <select id="statusSelect" name="status" class="form-control select2">
                            <option value="">Todos los estados</option>
                            <?php foreach ($paymentStatuses as $status): ?>
                                <option value="<?= $status ?>" <?= $selectedStatus == $status ? 'selected' : '' ?>>
                                    <?= getPaymentStatusText($status) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <select id="categorySelect" name="category" class="form-control select2">
                            <option value="">Todas las categorías</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= $selectedCategory == $category['id'] ? 'selected' : '' ?>>
                                    <?= $category['category_name'] ?> - $<?= $category['cantidad_dinero'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <select id="metodoPagoSelect" name="metodoPago" class="form-control select2">
                            <option value="">Todos los métodos de pago</option>
                            <?php foreach ($metodosPago as $metodo): ?>
                                <option value="<?= $metodo['id'] ?>" <?= $selectedMetodo == $metodo['id'] ? 'selected' : '' ?>>
                                    <?= $metodo['method_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="date" id="fechaRegistro" name="fechaRegistro" class="form-control"
                            value="<?= $selectedDate ?? '' ?>">
                    </div>

                </div>
            </form>
            <hr>
            <div class="table-responsive">
                <table id="eventInscriptions" class="table datatable table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Cédula</th>
                            <th>Categoría</th>
                            <th>Método de pago</th>
                            <th>Estado de Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inscriptions as $inscription): ?>
                            <tr>
                                <td><?= $inscription['full_name_user'] ?></td>
                                <td><?= $inscription['ic'] ?></td>
                                <td><?= $inscription['cantidad_dinero'] ?></td>
                                <td><?= $inscription['metodo_pago'] ?></td>
                                <td><span
                                        class="<?= style_estado($inscription['payment_status']) ?> rounded p-1"><?= getPaymentStatusText($inscription['payment_status']) ?></span>
                                </td>
                                <td>
                                    <button class="js-mytooltip btn btn-outline-warning btn-edit"
                                        data-mytooltip-custom-class="align-center" data-mytooltip-direction="top"
                                        data-mytooltip-theme="warning" data-mytooltip-content="Editar" data-toggle="modal"
                                        data-target="#editModal" data-id="<?= $inscription['id'] ?>"
                                        data-name="<?= $inscription['full_name_user'] ?>"
                                        data-ic="<?= $inscription['ic'] ?>"
                                        data-category="<?= $inscription['category_name'] ?>">
                                        <i class="fa fa-lg fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- Modal de Edición -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Inscripción</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/inscriptions/update') ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="form-group">
                            <label for="edit-name">Nombre</label>
                            <input type="text" class="form-control" id="edit-name" name="full_name_user">
                        </div>
                        <div class="form-group">
                            <label for="edit-ic">Cédula</label>
                            <input type="text" class="form-control" id="edit-ic" name="ic">
                        </div>
                        <div class="form-group">
                            <label for="edit-category">Categoría</label>
                            <input type="text" class="form-control" id="edit-category" name="category_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    const PaymentStatus = Object.freeze({
        Pendiente: 1,
        Completado: 2,
        Fallido: 3,
        EnProceso: 4,
        Incompleto: 5,
        Rechazado: 6
    });
    function getPaymentStatusText(status) {
        switch (parseInt(status)) {
            case PaymentStatus.Pendiente:
                return 'Pendiente';
            case PaymentStatus.Completado:
                return 'Completado';
            case PaymentStatus.Fallido:
                return 'Fallido';
            case PaymentStatus.EnProceso:
                return 'EnProceso';
            case PaymentStatus.Incompleto:
                return 'Incompleto';
            case PaymentStatus.Rechazado:
                return 'Rechazado';
            default:
                return 'Desconocido';
        }
    }

    function style_estado(estado_pago) {
        switch (parseInt(estado_pago)) {
            case PaymentStatus.Pendiente:
                return 'label label-primary p-1';
            case PaymentStatus.Completado:
                return 'label label-success p-1';
            case PaymentStatus.Fallido:
                return 'label label-danger p-1';
            case PaymentStatus.EnProceso:
                return 'label label-info p-1';
            case PaymentStatus.Incompleto:
                return 'label label-warning text-black p-1';
            case PaymentStatus.Rechazado:
                return 'label label-danger p-1';
            default:
                return '';
        }
    }// Código para actualizar la tabla
    function updateTable() {
        let status = $('#statusSelect').val();
        let category = $('#categorySelect').val();
        let metodoPago = $('#metodoPagoSelect').val();
        let fechaRegistro = $('#fechaRegistro').val(); // Capturar la fecha de registro
        let eventId = $('body').data('event-id');

        $.ajax({
            url: `${base_url}admin/event/inscritos/${eventId}`,
            method: 'POST',
            data: {
                status: status,
                category: category,
                metodoPago: metodoPago,
                fechaRegistro: fechaRegistro // Añadir la fecha de registro a los datos enviados
            },
            dataType: 'json',
            success: function (response) {
                let table = $('#eventInscriptions').DataTable();
                table.clear();
                response.data.forEach(function (inscription) {
                    table.row.add([
                        inscription.full_name_user,
                        inscription.ic,
                        `${inscription.cantidad_dinero}`,
                        `${inscription.metodo_pago}`, // Mostrar método de pago
                        `<span class="${style_estado(inscription.payment_status)}">${getPaymentStatusText(inscription.payment_status)}</span>`,
                        `<button class="js-mytooltip btn btn-outline-warning btn-edit" data-mytooltip-custom-class="align-center" data-mytooltip-direction="top" data-mytooltip-theme="warning" data-mytooltip-content="Editar" data-toggle="modal" data-target="#editModal" data-id="${inscription.id}" data-name="${inscription.full_name_user}" data-ic="${inscription.ic}" data-category="${inscription.category_name}">
                        <i class="fa fa-lg fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                    </button>`
                    ]);
                });
                $('.js-mytooltip').myTooltip('destroy');
                $('.js-mytooltip').myTooltip();
                table.draw();
                bindEditButtonEvents();
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }




    function bindEditButtonEvents() {
        $('.btn-edit').off('click').on('click', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var ic = $(this).data('ic');
            var category = $(this).data('category');
            $('#edit-id').val(id);
            $('#edit-name').val(name);
            $('#edit-ic').val(ic);
            $('#edit-category').val(category);
        });
    }


    $(document).ready(function () {
        bindEditButtonEvents(); // Vincula los eventos inicialmente

        // Nuevo código para manejar los filtros
        $('#statusSelect, #categorySelect, #metodoPagoSelect, #fechaRegistro').on('change', function () {
            updateTable();
        });

    });

    $('.select2').select2();



</script>

<?= $this->endSection() ?>