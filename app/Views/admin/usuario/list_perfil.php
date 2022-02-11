<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>

<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-primary rounded" style="width: 280px;">
    <?= $this->include('layouts/sidenavbar_usuario') ?>
</div>

<div class="col border rounded ms-2 p-4">
    teste
</div>

<?= $this->endSection() ?>
