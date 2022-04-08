<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>
<?= $this->include('layouts/sidenavbar_paciente') ?>

<main class="col">

    <form method="post" action="<?= base_url('prescricao/manage_prescricao/') ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <div class="card">
            <div class="card-header <?= $opt['bg'] ?> text-white">
                <b><?= $opt['title'] ?></b>
            </div>
            <div class="card-body has-validation">



                <hr />
                <?= $opt['button'] ?>
                <a class="btn btn-warning" href="javascript:history.go(-1)"><i class="fa-solid fa-arrow-left"></i> Voltar</a>

            </div>
        </div>

    </form>

</main>

<?= $this->endSection() ?>
