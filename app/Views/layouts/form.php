<?= $this->extend('layouts/main_admin') ?>
<?= $this->section('content') ?>

<br />
<main class="container border p-3">
    <form method="post" action="encontrar">
        <?= csrf_field() ?>
        <?php $validation =  \Config\Services::validation(); ?>

        <?php if(session()->getFlashdata('success')) { ?>
        <div class="alert alert-success alert-dismissible">
            <?php echo session()->getFlashdata('success') ?>
        </div>
        <?php } elseif(session()->getFlashdata('failed')) { ?>
        <div class="alert alert-danger alert-dismissible">
            <?php echo session()->getFlashdata('failed') ?>
        </div>
        <?php } ?>

        <?= $this->renderSection('content_form') ?>

	</form>
</main>

<?= $this->endSection() ?>
