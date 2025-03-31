<?= $this->extend('layouts/main_print') ?>
<?= $this->section('content') ?>

<div class="container border text-center bg-info" width="9px">
  <div class="row row-cols-3 border">
    <div class="col border">Column</div>
    <div class="col-6 border">Column</div>
    <div class="col-2 border">Column</div>
    <div class="col border">Column</div>
  </div>
</div>


<?= $this->endSection() ?>
