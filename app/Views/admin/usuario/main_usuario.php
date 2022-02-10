<?= $this->extend('layouts/main_admin') ?>
<?= $this->section('content') ?>

<main class="container">

    <?= $this->include('layouts/div_flashdata') ?>

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
