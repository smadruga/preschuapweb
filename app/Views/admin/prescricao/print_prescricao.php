<?= $this->extend('layouts/main_admin') ?>
<?= $this->section('content') ?>

<?php
foreach($prescricao['array'] as $v) {
?>

<table class="table ms-1" style="width:270mm;font-size:80%;">
    <thead>
        <tr>
            <td class="border-0" colspan="11">

                <div class="ms-1 me-1">
                    <div class="row">
                        <div class="col-6 container border border-dark"><b>
                            <div class="row">
                                <div class="col-2 p-1 align-middle">
                                    <img src="<?= base_url('/assets/img/huap.png') ?>" width="80%" /><br />
                                    <img src="<?= base_url('/assets/img/ebserh.png') ?>" width="80%" />
                                </div>
                                <div class="col pt-2">
                                    HOSPITAL UNIVERSITÁRIO ANTONIO PEDRO - HUAP<br />
                                    DIVISÃO DE GESTÃO DO CUIDADO - DGC<br />
                                    UNIDADE DE HEMATOLOGIA E CANCEROLOGIA<br />
                                    PRESCRIÇÃO MÉDICA DO PACIENTE
                                </div>
                            </div>
                        </b></div>

                        <div class="col-6 container border border-dark pt-2 border-start-0">
                            <div class="row">
                                <div class="col"><b>Prontuário: <?= $v['Prontuario'] ?></b></div>
                            </div>
                            <div class="row">
                                <div class="col"><b>Paciente: <?= $_SESSION['Paciente']['nome'] ?></b></div>
                            </div>
                            <div class="row">
                                <div class="col-5"><b>Nascimento:</b> <?= $_SESSION['Paciente']['dt_nascimento'] ?></div>
                                <div class="col"><b>Idade:</b> <?= $_SESSION['Paciente']['idade'] ?></div>
                                <div class="col"><b>Ciclo:</b> <?= $v['Ciclo'] ?></div>
                                <div class="col"><b>Dia:</b> <?= $v['Dia'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col"><b>Peso:</b> <?= $v['Peso'] ?> Kg</div>
                                <div class="col"><b>Altura:</b> <?= $v['Altura'] ?> cm</div>
                                <div class="col"><b>IMC:</b> <?= $func->calc_imc($v['Peso'],$v['Altura']) ?></div>
                                <div class="col"><b>SC:</b> <?= $func->calc_sc($v['Peso'],$v['Altura']) ?> m²</div>
                            </div>
                        </div>
                    </div>

                </div>

            </td>
        </tr>

        <tr>
            <th class="border border-dark">Ordem Infusão</th>
            <th class="border border-dark">Etapa Terapia</th>
            <th class="border border-dark">Medicamento</th>
            <th class="border border-dark">Dose</th>
            <th class="border border-dark">Ajuste</th>
            <th class="border border-dark">Cálculo (mg)</th>
            <th class="border border-dark">Via</th>
            <th class="border border-dark">Diluente</th>
            <th class="border border-dark">Volume (ml)</th>
            <th class="border border-dark">Tempo Infusão</th>
            <th class="border border-dark">Posologia</th>
        </tr>

    </thead>

    <tbody>

        <?php
        foreach($medicamento[$v['idPreschuap_Prescricao']] as $m) {
        ?>

        <tr>
            <td class="border border-dark"><?= $m['OrdemInfusao'] ?></td>
            <td class="border border-dark"><?= $m['EtapaTerapia'] ?></td>
            <td class="border border-dark"><?= $m['Medicamento'] ?></td>
            <td class="border border-dark"><?= $m['Dose'] ?></td>
            <td class="border border-dark"><?= $m['Ajuste'] ?></td>
            <td class="border border-dark"><?= $m['Calculo'] ?></td>
            <td class="border border-dark"><?= $m['ViaAdministracao'] ?></td>
            <td class="border border-dark"><?= $m['Diluente'] ?></td>
            <td class="border border-dark"><?= $m['Volume'] ?></td>
            <td class="border border-dark"><?= $m['TempoInfusao'] ?></td>
            <td class="border border-dark"><?= $m['Posologia'] ?></td>
        </tr>

        <?php
        }
        ?>

        <tr>
            <td class="border-0" colspan="11">

                <div class="ms-1 me-1">
                    <div class="row">
                        <div class="col container border border-dark border-bottom-0">
                            <div class="row">
                                <div class="col"><b>CID-Categoria:</b> <?= $v['Categoria'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col"><b>CID-Subcategoria:</b> <?= $v['Subcategoria'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col"><b>Aplicabilidade:</b> <?= $v['Aplicabilidade'] ?></div>
                                <div class="col"><b>Protocolo:</b> <?= $v['Protocolo'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col"><b>Data da Prescrição:</b> <?= $v['DataPrescricao'] ?></div>
                                <div class="col"><b>Tipo de Terapia:</b> <?= $v['TipoTerapia'] ?></div>
                                <div class="col"><b>Total de Ciclos:</b> <?= $v['CiclosTotais'] ?></div>
                                <div class="col"><b>Entre Ciclos:</b> <?= $v['EntreCiclos'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col"><b>Unidade de Internação:</b> --- </div>
                            </div>
                            <br />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 border border-dark">
                            <div class="col"><b>Reações Adversas Anteriores:</b> <?= nl2br($v['ReacaoAdversa']) ?></div>
                        </div>
                        <div class="col border border-dark border-start-0">
                            <div class="col"><b>Observações do Protocolo:</b> <?= $v['Observacoes'] ?><br /><br /></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 border border-dark border-top-0">
                            <div class="col"><b>Alergia:</b> <?= $v['Alergia'] ?></div>
                        </div>
                        <div class="col-4 border border-dark border-top-0 border-start-0">
                            <div class="col"><b>Informações Complementares:</b> <?= nl2br($v['InformacaoComplementar']) ?></div>
                        </div>
                        <div class="col border border-dark border-top-0 border-start-0">
                            <div class="col">
                                <b>Médico(a) Prescritor(a):</b> <?= $v['Nome'] ?><br />
                                <b>Conselho:</b> <?= $prescricao['conselho'] ?><br /><br />
                            </div>
                        </div>
                    </div>
                </div>

            </td>
        </tr>

    </tbody>

    <tfoot>

    </tfoot>

</table>

<?php
}
?>

<?= $this->endSection() ?>
