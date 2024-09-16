<?= $this->extend('layouts/main_admin') ?>
<?= $this->section('content') ?>

<?php
$turnos = ['M' => 'MANHÃ', 'T' => 'TARDE'];
$totalTurnos = count($turnos);
$currentTurnoIndex = 0;
?>

<?php foreach ($turnos as $turno => $turnoNome): ?>
    <!-- Quebra de página antes de iniciar um novo turno, exceto antes do primeiro turno -->
    <?php if ($currentTurnoIndex > 0): ?>
        <div class="page-break"></div>
    <?php endif; ?>

    <table class="table table-bordered border-primary" style="width:270mm">
         <tbody>

            <tr>
                <td colspan="12" >
                    <div class="ms-1 me-1">
                        <div class="row">
                            <div class="col container">
                                <b>
                                    <div class="row">
                                        <div class="col-2 ps-3 pt-2 pb-2">
                                            <img src="<?= base_url('/assets/img/huap.png') ?>" width="50%" />
                                        </div>
                                        <div class="col pt-2 text-center">
                                            HOSPITAL UNIVERSITÁRIO ANTONIO PEDRO - HUAP<br />
                                            UNIDADE DE HEMATOLOGIA E ONCOLOGIA - UHON<br />
                                            <b><h4>AGENDAMENTOS DO DIA: <?= $agenda['data'] ?></h4></b>
                                        </div>
                                        <div class="col-2 ps-3 pt-4">
                                            <img src="<?= base_url('/assets/img/ebserh.png') ?>" width="100%" />
                                        </div>                                    
                                    </div>
                                </b>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
                
            <tr class="text-center">
                <td colspan="12">
                    <b>########### TURNO: <?= $turnoNome ?> ###########</b>
                </td>
            </tr>
            <tr class="text-center">
                <th>#</th>
                <th>Tipo</th>
                <th>Obs</th>            
                <th>Prontuário</th>
                <th>Nome</th>
                <th>Prescrição</th>
                <th>Protocolo</th>
                <th>Medicamento</th>
                <th>Via</th>
                <th>Dose</th>
            </tr>

            <?php
            if (!isset($agenda['agendamento'][$turno])) {
                $i = $sq = $inj = $ms = $int = $inc = 0;
            ?>
                <tr style="padding: 10px; border: 1px solid; text-align: center;">
                    <th class="border-0" colspan="13">
                        ------------------------------------
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        SEM AGENDAMENTOS
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        ------------------------------------ 
                    </th>   
                </tr>
            <?php
            } else {
                $counts = array_fill(1, 5, 0);
                $i = $sq = $inj = $ms = $int = $inc = 0;
                foreach ($agenda['agendamento'][$turno] as $v) {
                    $ant = $agn = '';
                    foreach ($v as $x) {
                        if ($i > 0 && $x['idTabPreschuap_TipoAgendamento'] != $agn) {
                            #echo '<tr><td colspan="10"><br></td></tr>';
                        }

                        if ($ant != $x['idPreschuap_Agenda'].'#'.$x['idTabPreschuap_Protocolo']) {
                            $i++;
                            $th = ($x['idTabPreschuap_TipoAgendamento'] == 1) ? '<th>'.$i.'</th>' : '<th></th>';

                            $counts[$x['idTabPreschuap_TipoAgendamento']]++;

                            if($x['idTabPreschuap_TipoAgendamento']==1) $sq++;
                            if($x['idTabPreschuap_TipoAgendamento']==2) $inj++;
                            if($x['idTabPreschuap_TipoAgendamento']==3) $ms++;
                            if($x['idTabPreschuap_TipoAgendamento']==4) $int++;
                            if($x['idTabPreschuap_TipoAgendamento']==5) $inc++;

                            echo "
                                
                                <tr style='padding: 10px; border: 1px solid; text-align: center;'>
                                    {$th}
                                    <th>{$x['badge']}</th>
                                    <th>".esc($x['Observacoes'])."</th>
                                    <th>".esc($agenda['paciente'][$x['Prontuario']]['prontuario'])."</th>
                                    <th>".esc($agenda['paciente'][$x['Prontuario']]['nome'])."</th>
                                    <th>#".esc($x['idPreschuap_Prescricao'])."</th>
                                    <th>".esc($x['Protocolo'])."</th>";
                                    if(!isset($agenda['oculto'][$x["idPreschuap_Agenda"]][$x["idTabPreschuap_Medicamento"]])) {
                                        echo "
                                            <th>".esc($x['Medicamento'])."</th>
                                            <th>".esc($x['Codigo'])."</th>
                                            <th>".esc($x['Dose'])."</th>
                                        ";
                                    }
                                    else {
                                        echo "
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                    ";
                                    }

                                echo "
                                </tr>
                            ";
                            $ant = $x['idPreschuap_Agenda'].'#'.$x['idTabPreschuap_Protocolo'];
                        } else {

                            if(!isset($agenda['oculto'][$x["idPreschuap_Agenda"]][$x["idTabPreschuap_Medicamento"]])) {
                            
                                echo '
                                    <tr style="padding: 10px; border: 1px solid; text-align: center;">
                                        <th colspan="7"></th>
                                        <th>'.esc($x['Medicamento']).'</th>
                                        <th>'.esc($x['Codigo']).'</th>
                                        <th>'.esc($x['Dose']).'</th>                                 
                                    </tr>
                                ';       
                            }                 
                        }
                        $agn = $x['idTabPreschuap_TipoAgendamento'];
                    }
                }
            }
            ?>
        
            <tr>
                <th colspan="10" class="text-center">
                    <table width="100%">
                        <tr>
                            <th><span class="badge bg-primary text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Salão de Quimioterapia"><i class="fa-solid fa-couch"></i></span> <?= $sq ?></th>
                            <th><span class="badge bg-success text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Injeção"><i class="fa-solid fa-syringe"></i></span> <?= $inj ?></th>
                            <th><span class="badge bg-warning text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Medicação de Suporte"><i class="fa-solid fa-pills"></i></span> <?= $ms ?></th>
                            <th><span class="badge bg-danger text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Internação"><i class="fa-solid fa-bed"></i></span> <?= $int ?></th>
                            <th><span class="badge bg-info text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Intratecal"><i class="fa-solid fa-house-medical"></i></span> <?= $inc ?></th>                        
                        </tr>
                    </table>                  
                </th>
            </tr>
            <tr>
                <th colspan="10" class="text-center">Total: <?= $i ?> agendamentos</th>
            </tr>

        </tbody>        

    </table>

    <br><br>

    <?php $currentTurnoIndex++; ?>
<?php endforeach; ?>

<?= $this->endSection() ?>
