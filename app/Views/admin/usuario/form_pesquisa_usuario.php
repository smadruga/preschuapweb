<?= $this->extend('layouts/form') ?>
<?= $this->section('content_form') ?>

<div class="row">
    <div class="col">
        <label for="Pesquisa" class="form-label"><b>Usuário</b></label>
        <div class="input-group mb-3">
            <input type="Pesquisa" id="Pesquisa" class="form-control" autofocus>
            <button class="btn btn-info" type="submit"><i class="fa-solid fa-search"></i> Pesquisar</button>
        </div>
        <div class="form-text">
            Informe o CPF ou login/e-mail EBSERH do usuário
        </div>
    </div>
</div>

<?= $this->endSection() ?>
