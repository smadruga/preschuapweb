<?= $this->extend('layouts/main_print') ?>
<?= $this->section('content') ?>

<div class="zebra-label">
    <div class="tabela">
        <div class="row">
            <div class="celula">Produto</div>
            <div class="celula">Lote</div>
            <div class="celula">Validade</div>
        </div>
        <div class="row">
            <div class="celula">Caneta Azul</div>
            <div class="celula">A123</div>
            <div class="celula">12/2025</div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>
