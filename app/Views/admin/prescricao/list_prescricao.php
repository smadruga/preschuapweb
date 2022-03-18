<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>
<?= $this->include('layouts/sidenavbar_paciente') ?>

<div class="col border rounded ms-2 p-4">

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

    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?= $v['idPreschuap_Prescricao'] ?>">
                <button class="accordion-button collapsed bg-info text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $v['idPreschuap_Prescricao'] ?>" aria-expanded="true" aria-controls="collapse<?= $v['idPreschuap_Prescricao'] ?>">
                    <b>Prescrição #<?= $v['idPreschuap_Prescricao'] ?></b>
                </button>
            </h2>
            <div id="collapse<?= $v['idPreschuap_Prescricao'] ?>" class="accordion-collapse" aria-labelledby="heading<?= $v['idPreschuap_Prescricao'] ?>">
                <div class="accordion-body">
                    <div>
                        <a class="btn btn-primary" onclick="window.open(this.href).print(); return false" href="<?= base_url('prescricao/print_prescricao/'.$v['idPreschuap_Prescricao']) ?>" target="_blank" role="button"><i class="fa-solid fa-print"></i> Imprimir</a>
                        <button class="btn btn-primary" type="submit">Button</button>
                        <input class="btn btn-primary" type="button" value="Input">
                        <input class="btn btn-primary" type="submit" value="Submit">
                        <input class="btn btn-primary" type="reset" value="Reset">
                    </div>

                    <hr />

                    <div class="container">
                        <div class="row">
                            <div class="col"><b>Data da Marcação:</b> <?= $v['DataMarcacao'] ?></div>
                            <div class="col"><b>Data da Prescrição:</b> <?= $v['DataPrescricao'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>Dia:</b> <?= $v['Dia'] ?></div>
                            <div class="col"><b>Ciclo:</b> <?= $v['Ciclo'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>Total de Ciclos:</b> <?= $v['CiclosTotais'] ?> ciclo(s)</div>
                            <div class="col"><b>Entre Ciclos:</b> <?= $v['EntreCiclos'] ?> dia(s)</div>
                        </div>

                        <div class="row">
                            <div class="col"><b>CID Categoria:</b> <?= $v['Categoria'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>CID Subcategoria:</b> <?= $v['Subcategoria'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>Aplicabilidade:</b> <?= $v['Aplicabilidade'] ?></div>
                            <div class="col"><b>Tipo de Terapia:</b> <?= $v['TipoTerapia'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>Peso:</b> <?= $v['Peso'] ?> Kg</div>
                            <div class="col"><b>Altura:</b> <?= $v['Altura'] ?> cm</div>
                        </div>

                        <div class="row">
                            <div class="col"><b>Creatinina Serica:</b> <?= $v['CreatininaSerica'] ?></div>
                            <div class="col"><b>Alergia:</b> <?= $v['Alergia'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>Serviço:</b> <?= $v['DescricaoServico'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>Reações Adversas:</b> <?= nl2br($v['ReacaoAdversa']) ?></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>Informações Complementares:</b> <?= nl2br($v['InformacaoComplementar']) ?></div>
                        </div>

                        <br />

                        <div class="row">
                            <div class="col"><b>Médico(a) Prescritor(a):</b> <?= $v['Nome'] ?></div>
                        </div>

                        <hr />
                            <div class="text-center">
                                <b>
                                    <b>PROTOCOLO:</b> <?= $v['Protocolo'] ?><br />
                                    Medicamentos
                                </b>
                            </div>
                        <hr />

                        <?php
                        foreach($medicamento[$v['idPreschuap_Prescricao']] as $m) {
                        ?>
                        <div class="row">
                            <div class="col"><b>Medicamento: <?= $m['Medicamento'] ?></b></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>Ordem de Infusão:</b> <?= $m['OrdemInfusao'] ?></div>
                            <div class="col"><b>Etapa da Terapia:</b> <?= $m['EtapaTerapia'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>Dose:</b> <?= $m['Dose'] ?></div>
                            <div class="col"><b>Ajuste:</b> <?= $m['Ajuste'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>Cálculo:</b> <?= $m['Calculo'] ?></div>
                            <div class="col"><b>Via de Administração:</b> <?= $m['ViaAdministracao'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>Diluente:</b> <?= $m['Diluente'] ?></div>
                            <div class="col"><b>Volume:</b> <?= $m['Volume'] ?></div>
                        </div>

                        <div class="row">
                            <div class="col"><b>TempoInfusão:</b> <?= $m['TempoInfusao'] ?></div>
                            <div class="col"><b>Posologia:</b> <?= $m['Posologia'] ?></div>
                        </div>

                        <hr />
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <br />

    <?php
    }
    ?>

</div>

<?= $this->endSection() ?>
