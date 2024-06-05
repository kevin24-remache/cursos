<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('title') ?>
Eventos
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    /* .page-item.active .page-link {
    cursor: pointer;
    z-index: 2;
    color: #fff;
    background-color: #0C244B;
    border-color: #0C244B;
} */
</style>
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1 class="text-black">Eventos</h1>
        <ol class="breadcrumb">
            <li><a href="#">Casa</a></li>
            <li class="sub-bread"><i class="fa fa-angle-right"></i> Eventos</li>
            <li><i class="fa fa-angle-right"></i> Lista</li>
        </ol>
    </div>

    <div class="content">
        <div class="info-box">
            <div class="table-responsive">
                <table id="example" class="table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>Nombre del evento + imagen</th>
                            <th>Descripción del evento</th>
                            <th>Fecha del evento</th>
                            <th>Dirección del evento</th>
                            <th>Categorías del evento</th>
                            <th>Fecha de inicio de la inscripción</th>
                            <th>Fecha de finalización de la inscripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $key => $event): ?>
                            <tr>
                                <td></td>
                                <td>

                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="avatar-wrapper mr-3">
                                            <div class="avatar rounded-2">
                                                <img src="<?= base_url("") . $event["image"] ?>" alt="C"
                                                    class="rounded-circle img-fluid">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="text-nowrap text-heading fw-medium"><?= $event["event_name"] ?></span>
                                            <small class="text-truncate d-none d-sm-block">
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td><?= $event["short_description"] ?></td>
                                <td><?= $event["event_date"] ?></td>
                                <td><?= $event["address"] ?></td>
                                <td></td>
                                <td><?= $event["registrations_start_date"] ?></td>
                                <td><?= $event["registrations_end_date"] ?></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script src="<?= base_url("assets/js/datatables.js") ?>"></script>
<?= $this->endSection() ?>