<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>
<?= $this->include('layouts/sidenavbar_paciente') ?>

<main class="col">

    <form method="post" action="<?= base_url('agenda/agenda_prescricao/') ?>">
        <?= csrf_field() ?>
        <?php $validation = \Config\Services::validation(); ?>

        <div class="card">
            <div class="card-header bg-primary text-white">
                Formulário de Agendamento
            </div>
            <div class="card-body has-validation row g-3">
                <div class="col-md-12">
                    <b>Prescrição: #<?php echo $data['prescricao']['idPreschuap_Prescricao']; ?></b>
                    <br><b>Protocolo:</b> <?php echo $data['prescricao']['Protocolo']; ?></b>
                    <br><b>Tipo de Agendamento:</b> <?php echo $data['prescricao']['badge'].' '.$data['prescricao']['TipoAgendamento']; ?></b>
                                                
                </div>
                
                <hr>
                
                
                    <div class="col-md-4">
                        <label for="DataAgendamento" class="form-label">Data do Agendamento <b class="text-danger">*</b></label>
                        <div class="input-group mb-3">
                            <input type="date" id="DataAgendamento" <?= $opt['disabled'] ?> maxlength="10"
                                class="form-control <?php if($validation->getError('DataAgendamento')): ?>is-invalid<?php endif ?>"
                                autofocus name="DataAgendamento" value="<?php echo $data['DataAgendamento']; ?>"/>
                            <?php if ($validation->getError('DataAgendamento')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('DataAgendamento') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                
                
                
                    <div class="col-md-2">
                        <label for="Turno" class="form-label">Turno <b class="text-danger">*</b></label>
                        
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Turno" value="M" id="Turno">
                                <label class="form-check-label" for="Turno">
                                    Manhã
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="Turno" value="T" id="Turno">
                                <label class="form-check-label" for="Turno">
                                    Tarde
                                </label>
                            </div>
                        
                    </div>
                

                <div class="col-md-6">
                    <label for="Observacoes" class="form-label">Observações <b class="text-danger">*</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Observacoes" <?= $opt['disabled'] ?>
                            class="form-control <?php if($validation->getError('Observacoes')): ?>is-invalid<?php endif ?>"
                            name="Observacoes" value="<?php echo $data['Observacoes']; ?>" maxlength="20"/>
                        <?php if ($validation->getError('Observacoes')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('Observacoes') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>             

                <hr />

                <div class="col-md-12">
                    <input type="hidden" name="idPreschuap_Prescricao" id="idPreschuap_Prescricao" value="<?= $data['prescricao']['idPreschuap_Prescricao'] ?>" />
                    <button class="btn btn-primary" id="submit" name="submit" value="1" type="submit">
                        <i class="fa-solid fa-calendar-check"></i> Salvar e Concluir
                    </button>
                    <button class="btn btn-info" id="submit" name="submit" value="2" type="submit">
                        <i class="fa-solid fa-calendar-plus"></i> Salvar e Novo Agendamento
                    </button>                    
                </div>

            </div>
        </div>

    </form>

</main>

<?= $this->endSection() ?>
