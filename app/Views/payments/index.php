<?= $this->extend('layouts/payments_layout'); ?>

<?= $this->section('title') ?>
Pagos
<?= $this->endSection() ?>


<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Pagos</h1>
        <ol class="breadcrumb">
            <li><a href="#">Casa</a></li>
            <li><i class="fa fa-angle-right"></i> Panel</li>
        </ol>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="info-box"> <span class="info-box-icon bg-aqua"><i class="icon-briefcase"></i></span>
                    <div class="info-box-content"> <span class="info-box-number">1234</span> <span
                            class="info-box-text">New
                            Projects</span> </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="info-box"> <span class="info-box-icon bg-green"><i class="icon-pencil"></i></span>
                    <div class="info-box-content"> <span class="info-box-number">456</span> <span
                            class="info-box-text">Pending Project</span></div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="info-box"> <span class="info-box-icon bg-yellow"><i class="icon-wallet"></i></span>
                    <div class="info-box-content"> <span class="info-box-number">$41234</span> <span
                            class="info-box-text">Total Cost</span></div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="info-box"> <span class="info-box-icon bg-red"><i class="icon-layers"></i></span>
                    <div class="info-box-content"> <span class="info-box-number">$81234</span> <span
                            class="info-box-text">Total Earnings</span></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-xlg-9">
                <div class="info-box">
                    <div class="d-flex flex-wrap">
                        <div>
                            <h5 class="text-black">Yearly Earning</h5>
                        </div>
                        <div class="ml-auto">
                            <ul class="list-inline">
                                <li class="text-aqua"> <i class="fa fa-circle"></i> Sales</li>
                                <li class="text-blue"> <i class="fa fa-circle"></i> Earning ($)</li>
                            </ul>
                        </div>
                    </div>
                    <div id="earning"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>
<?= $this->endSection() ?>



<?= $this->section('scripts') ?>
    <!-- Morris JavaScript -->
    <script src="<?= base_url("dist/plugins/raphael/raphael-min.js") ?>"></script>
    <script src="<?= base_url("dist/plugins/morris/morris.js") ?>"></script>
    <script src="<?= base_url("dist/plugins/functions/dashboard1.js") ?>"></script>
<?= $this->endSection() ?>