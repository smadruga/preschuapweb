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

                <div class="row">
                    <div class="col">
                        <label for="Item" class="form-label"><b>Protocolo</b> <b class="text-danger">*</b></label>
                        <div class="input-group mb-3">
                            <input <?= $opt['disabled'] ?> type="text" id="Item" <?= $opt['disabled'] ?> class="form-control <?php if($validation->getError('Item')): ?>is-invalid<?php endif ?>" autofocus name="Item" value="<?php echo $data['Item']; ?>"/>

                            <?php if ($validation->getError('Item')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('Item') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col">
                        <label for="Aplicabilidade" class="form-label"><b>Aplicabilidade</b> <b class="text-danger">*</b></label>
                        <div class="input-group mb-3">

                            <select <?= $opt['disabled'] ?> class="form-select <?php if($validation->getError('Aplicabilidade')): ?>is-invalid<?php endif ?>" id="Aplicabilidade"
                                name="Aplicabilidade" data-placeholder="Selecione uma opção" data-allow-clear="1">
                                <option></option>
                                <?php
                                foreach ($select['Aplicabilidade'] as $val) {
                                    $selected = ($data['Aplicabilidade'] == $val) ? 'selected' : '';
                                    echo '<option value="'.$val.'" '.$selected.'>'.$val.'</option>';
                                }
                                ?>
                            </select>

                            <?php if ($validation->getError('Aplicabilidade')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('Aplicabilidade') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </form>

</main>

<?= $this->endSection() ?>
