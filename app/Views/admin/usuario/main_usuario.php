<?= $this->extend('layouts/main_admin') ?>
<?= $this->section('content') ?>

<main class="container">
    <?php if(session()->getFlashdata('success')) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?php echo session()->getFlashdata('success') ?>
        </div>
    <?php } elseif(session()->getFlashdata('failed')) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?php echo session()->getFlashdata('failed') ?>
        </div>
    <?php } ?>

    <div class="container">
        <div class="row">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-primary rounded" style="width: 280px;">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5"><?= $data->Nome ?></span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link" aria-current="page">
                            Perfil
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            Desativar
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col border rounded ms-2 p-4">
                Column
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>
