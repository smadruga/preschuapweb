<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>

<main class="container">
    <form method="post" action="<?= base_url('paciente/get_paciente') ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <?= $this->include('layouts/div_flashdata') ?>

        <div class="card">
            <div class="card-header">
                <b>Pesquisar Prescrição</b>
            </div>
            <div class="card-body has-validation">
                <div class="input-group mb-3">
                    <input type="text" id="Pesquisar" class="form-control <?php if($validation->getError('Pesquisar')): ?>is-invalid<?php endif ?>" autofocus name="Pesquisar" value="<?php echo set_value('Pesquisar'); ?>"/>
                    <button class="btn btn-info" id="submit" type="submit"><i class="fa-solid fa-search"></i> Pesquisar</button>
                    <?php if ($validation->getError('Pesquisar')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('Pesquisar') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-text">
                    Informe o número da prescrição.
                </div>
            </div>
        </div>

    </form>
</main>

<?= $this->endSection() ?>
