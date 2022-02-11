<?= $this->extend('layouts/main_admin') ?>
<?= $this->section('content') ?>

<main class="container">

    <?= $this->include('layouts/div_flashdata') ?>

    <div class="container">
        <div class="row">

            <?= $this->renderSection('subcontent') ?>

        </div>
    </div>
</main>

<?= $this->endSection() ?>
