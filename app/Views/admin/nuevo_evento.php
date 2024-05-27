<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('title') ?>
Agregar eventos
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<!-- Select 2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- dropify -->
<link rel="stylesheet" href="<?= base_url("dist/plugins/dropify/dropify.min.css");?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="content-wrapper bg-white">
    <div class="content-header sty-one shadow">
        <h1 class="text-black">Nuevo evento</h1>
        <ol class="breadcrumb">
            <li><a href="#">Casa</a></li>
            <li class="sub-bread"><i class="fa fa-angle-right"></i> Eventos</li>
            <li><i class="fa fa-angle-right"></i> Nuevo evento</li>
        </ol>
    </div>


    <!-- Main content -->

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-gray ">
                        <h5 class="text-dark m-b-0">Agregar un evento</h5>
                    </div>
                    <div class="card-body">

                        <form action="<?= base_url("admin/event/add") ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Nombre del evento</label>
                                        <input class="form-control" name="event_name" placeholder=""
                                            value="<?= isset($last_data) ? display_data($last_data, 'event_name') : '' ?>"
                                            type="text">
                                        <span
                                            class="text-danger"><?= isset($validation) ? display_data($validation, 'event_name') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Fecha del evento</label>
                                        <input class="form-control" name="event_date" placeholder="" type="date"
                                            value="<?= isset($last_data) ? display_data($last_data, 'event_date') : '' ?>">
                                        <span
                                            class="text-danger"><?= isset($validation) ? display_data($validation, 'event_date') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Dirección del evento</label>
                                        <input class="form-control" name="address" placeholder="" type="text"
                                            value="<?= isset($last_data) ? display_data($last_data, 'address') : '' ?>">
                                        <span
                                            class="text-danger"><?= isset($validation) ? display_data($validation, 'address') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Categorías del evento</label>

                                        <select id="id_cat" class="form-control select2 " name="id_cat" style="100%">
                                            <?php foreach ($categories as $key => $category) :?>
                                                <option value="">Seleccione una categoría</option>
                                            <option value="<?=$category["id"]?>"><?=$category["category_name"]?></option>
                                            <?php endforeach?>
                                        </select>
                                        <span class="text-danger"><?= isset($validation) ? display_data($validation, 'id_cat') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Fecha de inicio de la inscripción</label>
                                        <input class="form-control" name="registrations_start_date"
                                            placeholder="Company" type="date"
                                            value="<?= isset($last_data) ? display_data($last_data, 'event_start_date') : '' ?>">
                                        <span
                                            class="text-danger"><?= isset($validation) ? display_data($validation, 'event_start_date') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Fecha de finalización de la inscripción</label>
                                        <input class="form-control" name="registrations_end_date" placeholder=""
                                            type="date"
                                            value="<?= isset($last_data) ? display_data($last_data, 'event_end_date') : '' ?>">
                                        <span
                                            class="text-danger"><?= isset($validation) ? display_data($validation, 'event_end_date') : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Descripción del evento</label>
                                        <textarea class="form-control" name="short_description" id="" rows="10"
                                            placeholder=""><?= isset($last_data) ? display_data($last_data, 'short_description') : '' ?></textarea>
                                        <span
                                            class="text-danger"><?= isset($validation) ? display_data($validation, 'short_description') : '' ?></span>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <label>Imagen del evento</label>
                                    <input type="file" id="input-file-now form-control" class="dropify" name="image"
                                        accept="image/jpeg, image/png"
                                        value="<?= isset($last_data) ? display_data($last_data, 'image') : '' ?>" />
                                    <span
                                        class="text-danger"><?= isset($validation) ? display_data($validation, 'image') : '' ?></span>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<!-- Select 2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- dropify -->
<script src="<?= base_url("dist/plugins/dropify/dropify.min.js") ?>"></script>
<script>
    $(document).ready(function () {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function (event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function (event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function (event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function (e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
        $('.select2').select2();
    });
</script>

<?= $this->endSection() ?>