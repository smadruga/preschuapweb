<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>
<?= $this->include('layouts/sidenavbar_paciente') ?>

<main class="col">

    <form method="post" action="<?= base_url('tabela/list_tabela/') ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <div class="card">
            <div class="card-header">
                <b>Cadastrar nova Prescrição</b>
            </div>
            <div class="card-body has-validation">

            </div>
        </div>

    </form>

</main>

<?= $this->endSection() ?>
