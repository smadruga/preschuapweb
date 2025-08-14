<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>
<?= $this->include('layouts/sidenavbar_paciente') ?>

<main class="col">

    <form method="post" target="_blank" action="<?= base_url('prescricao/etiqueta/imprimir') ?>">

        <div class="card">

            <div class="card-body has-validation row g-3">

                <div class="col-md-12">
                    <label for="Dose" class="form-label"><b>Nome:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Nome" class="form-control" name="Nome" readonly value="<?= $medicamento['Nome'] ?>" />
                    </div>
                </div>

            </div>

            <div class="card-body has-validation row g-3">

                <div class="col-md-4">
                    <label for="Dose" class="form-label"><b>Prontuário:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Prontuario" class="form-control" name="Prontuario" readonly
                            value="<?= $medicamento['Prontuario'] ?>" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="Ajuste" class="form-label"><b>Data de Nascimento:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="DtNasc" class="form-control" name="DtNasc" readonly value="<?= $medicamento['DtNasc'] ?>" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="Dose" class="form-label"><b>Unidade:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Unidade" class="form-control" name="Unidade"/>
                    </div>
                </div>                                

            </div>


            <div class="card-body has-validation row g-3">

                <div class="col-md-8">
                    <label for="Dose" class="form-label"><b>Medicamento:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Medicamento" class="form-control" name="Medicamento" readonly
                            value="<?= $medicamento['Medicamento'] ?>" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="Calculo" class="form-label"><b>Prescrição:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Prescricao" class="form-control" name="Prescricao" readonly
                            value="#<?= $medicamento['idPreschuap_Prescricao'] ?>" />
                    </div>
                </div>                

            </div>


            <div class="card-body has-validation row g-3">

                <div class="col-md-4">
                    <label for="Dose" class="form-label"><b>Dose:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Dose" class="form-control" name="Dose" value="<?= number_format($medicamento['Dose'], 2, ',', '.').' '.$medicamento['Representacao'] ?>" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="Ajuste" class="form-label"><b>Dose do Volume(ml):</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="DoseVol" class="form-control" name="DoseVol" />
                    </div>
                </div>                
                <div class="col-md-4">
                    <label for="Calculo" class="form-label"><b>Diluente:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Diluente" class="form-control" name="Diluente" value="<?= $medicamento['Diluente'] ?>" />
                    </div>
                </div>
            </div>


            <div class="card-body has-validation row g-3">

                <div class="col-md-4">
                    <label for="Dose" class="form-label"><b>Volume Diluente(ml):</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="VolDiluente" class="form-control" name="VolDiluente"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="Ajuste" class="form-label"><b>Volume Final(ml):</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="VolFinal" class="form-control" name="VolFinal" />
                    </div>
                </div>                
                <div class="col-md-4">
                    <label for="Calculo" class="form-label"><b>Via de Administração:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="ViaAdminist" class="form-control" name="ViaAdminist" value="<?= $medicamento['Codigo'] ?>" />
                    </div>
                </div>
            </div>


            <div class="card-body has-validation row g-3">

                <div class="col-md-4">
                    <label for="Dose" class="form-label"><b>Fotosensível:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Fotosensivel" class="form-control" name="Fotosensivel"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="Ajuste" class="form-label"><b>Refrigerar:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Refrigerar" class="form-control" name="Refrigerar" />
                    </div>
                </div>                
                <div class="col-md-4">
                    <label for="Calculo" class="form-label"><b>Equipo:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Equipo" class="form-control" name="Equipo" />
                    </div>
                </div>
            </div>


            <div class="card-body has-validation row g-3">

                <div class="col-md-4">
                    <label for="Dose" class="form-label"><b>Vesicante:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Vesicante" class="form-control" name="Vesicante"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="Ajuste" class="form-label"><b>Irritante:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Irritante" class="form-control" name="Irritante" />
                    </div>
                </div>                
                <div class="col-md-4">
                    <label for="Calculo" class="form-label"><b>Infusão:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Infusao" class="form-control" name="Infusao" value="<?= $medicamento['TempoInfusao'] ?>" />
                    </div>
                </div>
            </div>


            <div class="card-body has-validation row g-3">

                <div class="col-md-4">
                    <label for="Dose" class="form-label"><b>Data de Preparo:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Preparo" class="form-control" name="Preparo"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="Ajuste" class="form-label"><b>Validade de Temperatura Ambiente:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="ValTmpAmb" class="form-control" name="ValTmpAmb" />
                    </div>
                </div>                
                <div class="col-md-4">
                    <label for="Calculo" class="form-label"><b>Validade de Refrigeração:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="ValRefrig" class="form-control" name="ValRefrig" />
                    </div>
                </div>
            </div>


            <div class="card-body has-validation row g-3">

                <div class="col-md-12">
                    <label for="Dose" class="form-label"><b>OBS:</b></label>
                    <div class="input-group mb-3">
                        <input type="text" id="Obs" class="form-control" name="Obs"/>
                    </div>
                </div>

            </div>

            <input type="hidden" name="idPreschuap_Prescricao_Medicamento" value="<?= $medicamento['idPreschuap_Prescricao_Medicamento'] ?>">
            <input type="hidden" name="idTabPreschuap_Medicamento" value="<?= $medicamento['idTabPreschuap_Medicamento'] ?>">


            <div class="card-body has-validation row g-3">

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Imprimir</button>
                    <a class="btn btn-warning" id="click" onclick="history.back()" role="button"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                </div>

            </div>


        </div>

    </form>

</main>

<?= $this->endSection() ?>
