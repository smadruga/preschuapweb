<?= $this->extend('layouts/main_admin') ?>
<?= $this->section('content') ?>

<main class="container">
    <form method="post" action="<?= base_url('admin/get_user') ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <?php if(session()->getFlashdata('success')) { ?>
        <div class="alert alert-success alert-dismissible">
            <?php echo session()->getFlashdata('success') ?>
        </div>
        <?php } elseif(session()->getFlashdata('failed')) { ?>
        <div class="alert alert-danger alert-dismissible">
            <?php echo session()->getFlashdata('failed') ?>
        </div>
        <?php } ?>

        <div class="card">
            <div class="card-header">
                <b>Importar Usuário AD/EBSERH</b>
            </div>
            <div class="card-body has-validation">
                <label for="Pesquisar" class="form-label"><b>Usuário</b></label>
                <div class="input-group mb-3">
                    <input type="text" id="Pesquisar" class="form-control <?php if($validation->getError('Pesquisar')): ?>is-invalid<?php endif ?>" autofocus name="Pesquisar" value="<?php echo set_value('Pesquisar'); ?>"/>
                    <button class="btn btn-info" type="submit"><i class="fa-solid fa-search"></i> Pesquisar</button>
                    <?php if ($validation->getError('Pesquisar')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('Pesquisar') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-text">
                    Informe o CPF ou login/e-mail EBSERH do usuário
                </div>
            </div>
        </div>

    </form>
</main>

<?= $this->endSection() ?>
