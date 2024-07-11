<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>
<?= $this->include('layouts/sidenavbar_paciente') ?>

<main class="col">

    <form method="post" action="<?= base_url('prescricao/manage_prescricao/') ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <div class="card">
            <div class="card-header bg-info">
                Formulário de Agendamento
            </div>
            <div class="card-body has-validation row g-3">
                <div class="col-md-12">
                    <b>Prescrição: #<?php echo $data['prescricao']['idPreschuap_Prescricao']; ?></b>
                    <br><b>Protocolo:</b> <?php echo $data['prescricao']['Protocolo']; ?></b>
                    <br><b>Tipo de Agendamento:</b> <?php echo $data['prescricao']['idPreschuap_Prescricao']; ?></b>
                </div>
                
                <hr>

                <div class="col-md-4">
                    <label for="DataPrescricao" class="form-label">Data do Agendamento <b class="text-danger">*</b></label>
                    <div class="input-group mb-3">
                        <input type="date" placeholder="DD/MM/AAAA" id="DataPrescricao" maxlength="10"
                            class="form-control Data" 
                            autofocus name="DataPrescricao" />

                    </div>
                </div>

                <hr />


            </div>
        </div>

    </form>

</main>

<?= $this->endSection() ?>
