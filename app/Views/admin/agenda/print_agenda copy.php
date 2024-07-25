<?= $this->extend('layouts/main_admin') ?>
<?= $this->section('content') ?>

<?php foreach (['M' => 'MANHÃ', 'T' => 'TARDE'] as $turno => $turnoNome): ?>

<table class="table ms-1 table-bordered border-dark" style="width:270mm">
    <thead>
        <tr>
            <td class="border-0" colspan="12">
                <div class="ms-1 me-1">
                    <div class="row">
                        <div class="col container border border-dark">
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

        <tr style="padding: 10px; border: 1px solid; text-align: center;">
            <td colspan="12">
                <b>######### TURNO: <?= $turnoNome ?> #########</b>
            </td>
        </tr>

        <tr style="padding: 10px; border: 1px solid; text-align: center;">
            <th>#</th>
            <th>Tipo</th>
            <th>Obs</th>            
            <th>Prontuário</th>
            <th>Nome</th>
            <th>Protocolo</th>
            <th>Medicamento</th>
            <th>Via</th>
            <th>Dose</th>
        </tr>

    </thead>

    <tbody>
    



        <?php
        if (!isset($agenda['agendamento'][$turno])) {
            $i = $sq = $inj = $ms = $int = $inc = 0;
        ?>
            <tr style="padding: 10px; border: 1px solid; text-align: center;">
                <td class="border-0" colspan="12">
                    <div class="alert alert-warning text-center" role="alert">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        SEM AGENDAMENTOS
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </td>   
            </tr>
        <?php
        } else {
            $counts = array_fill(1, 5, 0);
            $i = $sq = $inj = $ms = $int = $inc = 0;
            foreach ($agenda['agendamento'][$turno] as $v) {
                $ant = $agn = '';
                foreach ($v as $x) {
                    if ($i > 0 && $x['idTabPreschuap_TipoAgendamento'] != $agn) {
                        echo '<tr><td colspan="9"><br></td></tr>';
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
                                <th>".esc($x['Prontuario'])."</th>
                                <th>".esc($agenda['paciente'][$x['Prontuario']])."</th>
                                <th>".esc($x['Protocolo'])."</th>
                                <th>".esc($x['Medicamento'])."</th>
                                <th>".esc($x['Codigo'])."</th>
                                <th>".esc($x['Dose'])."</th>                                 
                            </tr>
                        ";
                        $ant = $x['idPreschuap_Agenda'].'#'.$x['idTabPreschuap_Protocolo'];
                    } else {
                        echo '
                            <tr style="padding: 10px; border: 1px solid; text-align: center;">
                                <th colspan="6"></th>
                                <th>'.esc($x['Medicamento']).'</th>
                                <th>'.esc($x['Codigo']).'</th>
                                <th>'.esc($x['Dose']).'</th>                                 
                            </tr>
                        ';                        
                    }
                    $agn = $x['idTabPreschuap_TipoAgendamento'];
                }
            }
        }
        ?>
    
    </tbody>        
        
    <tfoot>
        <tr>
            <th colspan="9" class="text-center">
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
            <th colspan="9" class="text-center">Total: <?= $i ?> agendamentos</th>
        </tr>
    </tfoot>
</table>

<?php endforeach; ?>

<br><br>

<?= $this->endSection() ?>
