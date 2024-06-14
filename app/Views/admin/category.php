<?= $this->extend('layouts/admin_layout'); ?>

<?= $this->section('title') ?>
Categorías
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1 class="text-black">Categorías</h1>
        <ol class="breadcrumb">
            <li><a href="#">Casa</a></li>
            <li class="sub-bread"><i class="fa fa-angle-right"></i>Categoría</li>
            <li><i class="fa fa-angle-right"></i> Lista</li>
        </ol>
    </div>

    <div class="content">
        <div class="info-box">
            <div class="table-responsive">
                <table id="category" class="table table-hover table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre de la categoría</th>
                            <th>Valor por la categoría</th>
                            <th>Descripción de la categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $key => $category) :?>
                        <tr>
                            <td><?= $category["category_name"]?></td>
                            <td><?= $category["cantidad_dinero"]?></td>
                            <td><?= $category["short_description"]?></td>
                            <td></td>
                        </tr>
                        <?php endforeach;?>
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