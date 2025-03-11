    <tr>
        <th class="border border-dark">#</th>
        <th class="border border-dark">Etapa Terapia</th>
        <th class="border border-dark">Medicamento</th>
        <th class="border border-dark">Dose do Protocolo</th>
        <th class="border border-dark">Cálculo Final</th>
        <th class="border border-dark">Via</th>
        <th class="border border-dark">Diluente</th>
        <th class="border border-dark">Vol. (ml)</th>
        <th class="border border-dark">Tempo Infusão</th>
        <th class="border border-dark">Posologia</th>
        <th class="border border-dark col-3">Aprazamento</th>
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
        <td class="border border-dark"><?= $m['Calculo'] ?></td>
        <td class="border border-dark"><?= $m['ViaAdministracao'] ?></td>
        <td class="border border-dark"><?= $m['Diluente'] ?></td>
        <td class="border border-dark"><?= ($m['Volume'] == '0,00' || !$m['Volume'] ) ? NULL : $m['Volume'] . 'ml' ?></td>
        <td class="border border-dark"><?= $m['TempoInfusao'] ?></td>
        <td class="border border-dark"><?= $m['Posologia'] ?></td>
        <td class="border border-dark"></td>
    </tr>

    <?php
    }
    ?>

    <tr>
        <td class="border-0" colspan="12">

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
                            <div class="col"><b>Tipo de Agendamento:</b> <?= $v['TipoAgendamento'] ?></div>
                            <!--<div class="col"><b>Dieta:</b> <?= $v['Dieta'] ?></div>-->
                        </div>                        
                        <!--<div class="row">
                            <div class="col"><b>Unidade de Internação:</b> --- </div>
                        </div>-->
                        <br />
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 border border-dark">
                        <div class="col"><b>Informações Complementares:</b>
                            <?= ($v['InformacaoComplementar']) ? '<br>'.nl2br($v['InformacaoComplementar']) : NULL ?>
                            <?php
                            $ajuste = NULL;
                            foreach($medicamento[$v['idPreschuap_Prescricao']] as $m) {
                                $motivo = ($m['MotivoAjusteDose']) ? ' - Motivo: '.$m['MotivoAjusteDose'] : NULL;
                                if($m['Ajuste2'] && $m['TipoAjuste'] == 'substituicao')
                                    $ajuste .= '<br /> Cálculo Final de ' . $m['Medicamento'] . ' substituído por ' . $m['Ajuste2'] . $motivo;
                                elseif($m['Ajuste2'] && $m['TipoAjuste'] == 'porcentagem')
                                    $ajuste .= '<br /> Cálculo Final de ' . $m['Medicamento'] . ' ajustado em ' . $m['Ajuste2'] . $motivo;
                            }
                            echo ($ajuste) ? '<br />AJUSTES: ' . $ajuste : NULL;
                            ?>
                        </div>
                    </div>
                    <div class="col border border-dark border-start-0">
                        <div class="col"><b>Observações do Protocolo:</b> <?= $v['Observacoes'] ?><br /><br /></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 border border-dark border-top-0">
                        <div class="col"><b>Alergias:</b> <?= ($v['Alergia']) ? '<br>'.nl2br($v['Alergia']) : NULL ?></div>
                    </div>
                    <div class="col-4 border border-dark border-top-0 border-start-0">
                        <div class="col"><b>Reações Adversas Anteriores:</b> <?= ($v['ReacaoAdversa']) ? '<br>'.nl2br($v['ReacaoAdversa']) : NULL ?></div>
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
