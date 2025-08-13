<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>
<?= $this->include('layouts/sidenavbar_paciente') ?>

<div class="col border rounded ms-2 p-4">

    <br>

    <?php
    if($prescricao['count'] <= 0) {
        echo '
        <div class="alert alert-dark" role="alert">
            Nenhuma prescrição registrada.
        </div>
        ';
    }

    foreach($prescricao['array'] as $v) {
    ?>

        <div>

            <?php
            if(!isset($medicamento[$v['idPreschuap_Prescricao']])) {
            ?>
            <div class="alert alert-warning" role="alert">
                Nenhum medicamento cadastrado.
            </div>
            <?php
            }
            else {

                ?>
            <div class="alert alert-info" role="alert">
                <b>Prescrição #<?= $v['idPreschuap_Prescricao'] ?></b>
            </div>
                <?php

                foreach($medicamento[$v['idPreschuap_Prescricao']] as $m) {

                    if ( $m['idTabPreschuap_EtapaTerapia'] == 2 && (!empty(array_intersect(array_keys($_SESSION['Sessao']['Perfil']), [1,4,7]))) ) {
            ?>

            <div class="row">
                <div class="col-2 text-end">
                    <a class="btn btn-info btn-sm" id="click" href="<?= base_url('prescricao/etiqueta/editar/'.$m['idPreschuap_Prescricao_Medicamento']) ?>" role="button"><i class="fa-solid fa-edit"></i> Revisar</a>
                </div>    
                <div class="col"><b>Medicamento: <?= $m['Medicamento'].' - '.$m['EtapaTerapia'] ?></b></div>
            </div>

            <hr />

            <?php
                    }
                    elseif ( $m['idTabPreschuap_EtapaTerapia'] == 1 && (!empty(array_intersect(array_keys($_SESSION['Sessao']['Perfil']), [1,6,8]))) ) {

            ?>

            <div class="row">
                <div class="col-2 text-end">
                    <a class="btn btn-info btn-sm" id="click" href="<?= base_url('prescricao/etiqueta/editar/'.$m['idPreschuap_Prescricao_Medicamento']) ?>" role="button"><i class="fa-solid fa-edit"></i> Revisar</a>
                </div>    
                <div class="col"><b>Medicamento: <?= $m['Medicamento'].' - '.$m['EtapaTerapia'] ?></b></div>
            </div>

            <hr />

            <?php                        

                    }
                }
            }
            ?>

            </div>

            <div class="row">
                <div class="col">
                    <a class="btn btn-warning" id="click" onclick="history.back()" role="button"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                </div>
            </div>

        </div>

    <?php
    }
    ?>

</div>

<?= $this->endSection() ?>
