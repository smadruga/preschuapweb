<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>
<?= $this->include('layouts/sidenavbar_paciente') ?>

<main class="col">

    <form method="post" action="<?= base_url('prescricao/print_etiqueta/') ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <div class="card">
            <div class="card-header <?= $opt['bg'] ?> text-white">
                <b><?= $opt['title'] ?></b>
            </div>
            <div class="card-body has-validation row g-3">

                <div class="col-md-4">
                    <label for="Dose<?= $i ?>" class="form-label"><b>Dose do Protocolo</b> <b class="text-danger">*</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Dose<?= $i ?>" disabled
                            class="form-control <?php if($validation->getError('Dose'.$i)): ?>is-invalid<?php endif ?>"
                            name="Dose<?= $i ?>" value="<?php echo $dose[0] ?>"/>
                        <span class="input-group-text" id="basic-addon2"><?php echo $dose[1] ?></span>
                        <?php if ($validation->getError('Dose'.$i)): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('Dose'.$i) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="Ajuste<?= $i ?>" class="form-label"><b>Ajuste</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Ajuste<?= $i ?>" <?= $opt['disabled'] ?>
                            class="form-control <?php if($validation->getError('Ajuste'.$i)): ?>is-invalid<?php endif ?>"
                            maxlength="9" name="Ajuste<?= $i ?>" placeholder="Apenas números" onkeyup="ajuste(<?= $i ?>)"
                            
                            value="<?php echo $data['input'][$i]['Ajuste']; ?>"/>

                        <?php if ($validation->getError('Ajuste'.$i)): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('Ajuste'.$i) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>                
                <div class="col-md-4">
                    <label for="Calculo<?= $i ?>" class="form-label"><b>Cálculo Final</b> <b class="text-danger">*</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Calculo<?= $i ?>" readonly
                            class="form-control <?php if($validation->getError('Calculo'.$i)): ?>is-invalid<?php endif ?>"
                            maxlength="10" name="Calculo<?= $i ?>" value="<?php echo $m['Calculo'] ?>"/>
                        <span class="input-group-text" id="basic-addon2"><?php echo $u[0] ?></span>
                        <?php if ($validation->getError('Calculo'.$i)): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('Calculo'.$i) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="col-md-12">
                    <?= $opt['button'] ?>
                    <a class="btn btn-warning" id="click" href="<?= base_url('prescricao/manage_prescricao/editar/'.$data['prescricao']['idPreschuap_Prescricao']) ?>" role="button"><i class="fa-solid fa-arrow-left"></i> Voltar</a>

                    <a class="btn btn-secondary" href="<?= base_url('prescricao/list_prescricao/') ?>"><i class="fa-solid fa-ban"></i> Cancelar</a>
                </div>


            </div>
        </div>

    </form>

</main>

<?= $this->endSection() ?>
