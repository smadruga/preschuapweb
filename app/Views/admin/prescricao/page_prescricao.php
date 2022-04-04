<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>
<?= $this->include('layouts/sidenavbar_paciente') ?>

<div class="col border rounded ms-2 p-4">

    <div class="card">
        <div class="card-header">
            <b>Escolha uma opção</b>
        </div>
        <div class="card-body has-validation">
            <a class="btn btn-info" href="<?= base_url('prescricao/create_prescricao/') ?>" role="button"><i class="fa-solid fa-circle-plus"></i> Nova Prescrição</a>
            <a class="btn btn-info" href="#" role="button"><i class="fa-solid fa-copy"></i> Copiar última Prescrição</a>
            <a class="btn btn-info" href="#" role="button"><i class="fa-solid fa-repeat"></i> Continuar último Tratamento</a>
        </div>
    </div>

</div>


<?= $this->endSection() ?>
