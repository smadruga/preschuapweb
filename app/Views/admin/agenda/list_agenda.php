<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>

<main class="container">
<br><br>
    <div class="alert alert-primary" role="alert">

        <div class="container text-center">
            <div class="row">
                <div class="col text-end">
                    <button type="button" class="btn btn-info btn-sm"><< Anterior</button>
                </div>
                <div class="col text-center">
                    <b>DATA: <?= $agenda['dataptbr'] ?></b>
                </div>
                <div class="col text-start">
                    <button type="button" class="btn btn-info btn-sm">Próximo>></button>
                </div>
            </div>
        </div>

    </div>

    <hr>

    <div class="alert alert-secondary text-center" role="alert">
        <b>TURNO: MANHÃ</b>
    </div>

    <table class="table table-bordered">
        <tr class="table-secondary text-center">
            <td>#</td>
            <td>Tipo</td>
            <td>Obs</td>            
            <td>Prontuário</td>
            <td>Nome</td>
            <td>Protocolo</td>
            <td>Medicamento</td>
            <td>Via</td>
            <td>Dose</td>
        </tr>
        <tbody>
            <?php

            $i=0;
            $sq=$inj=$ms=$int=$inc=0;
            foreach($agenda['agendamento']['M'] as $v) {

                $ant=$agn='';
                foreach($v as $x) {
                    
                    echo ($i > 0 && $x['idTabPreschuap_TipoAgendamento'] != $agn) ? '<tr><td colspan="9"><br></td></tr>' : NULL;   
                    if($ant != $x['idPreschuap_Agenda'].'#'.$x['idTabPreschuap_Protocolo']) {
                        $i++;
                        $th = ($x['idTabPreschuap_TipoAgendamento'] == 1) ? '<th>'.$i.'</th>' : '<th></th>';
                        
                        if($x['idTabPreschuap_TipoAgendamento']==1)
                            $sq++;
                        if($x['idTabPreschuap_TipoAgendamento']==2)
                            $inj++;
                        if($x['idTabPreschuap_TipoAgendamento']==3)
                            $ms++;
                        if($x['idTabPreschuap_TipoAgendamento']==4)
                            $int++;
                        if($x['idTabPreschuap_TipoAgendamento']==5)
                            $inc++;

                        echo '                     
                            <tr>
                                '.$th.'
                                <th>'.$x['badge'].'</th>
                                <th>'.$x['Observacoes'].'</th>
                                <th>'.$x['Prontuario'].'</th>
                                <th>'.$agenda['paciente'][$x['Prontuario']].'</th>
                                <th>'.$x['Protocolo'].'</th>
                                <th>'.$x['Medicamento'].'</th>
                                <th>'.$x['Codigo'].'</th>
                                <th>'.$x['Dose'].'</th>                                 
                            </tr>
                        ';
                        $ant=$x['idPreschuap_Agenda'].'#'.$x['idTabPreschuap_Protocolo'];
                        
                    }
                    else {
                        echo '
                            <tr>
                                <th colspan="6"></th>
                                <th>'.$x['Medicamento'].'</th>
                                <th>'.$x['Codigo'].'</th>
                                <th>'.$x['Dose'].'</th>                                 
                            </tr>
                        ';                        
                    }
                    $agn=$x['idTabPreschuap_TipoAgendamento'];
                    
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

    <hr>

    <div class="alert alert-secondary text-center" role="alert">
        <b>TURNO: TARDE</b>
    </div>

    <table class="table table-bordered">
        <tr class="table-secondary text-center">
            <td>#</td>
            <td>Tipo</td>
            <td>Obs</td>            
            <td>Prontuário</td>
            <td>Nome</td>
            <td>Protocolo</td>
            <td>Medicamento</td>
            <td>Via</td>
            <td>Dose</td>
        </tr>
        <tbody>
            <?php

            $i=0;
            $sq=$inj=$ms=$int=$inc=0;
            foreach($agenda['agendamento']['T'] as $v) {

                $ant=$agn='';
                foreach($v as $x) {
                    
                    echo ($i > 0 && $x['idTabPreschuap_TipoAgendamento'] != $agn) ? '<tr><td colspan="9"><br></td></tr>' : NULL;   
                    if($ant != $x['idPreschuap_Agenda'].'#'.$x['idTabPreschuap_Protocolo']) {
                        $i++;
                        $th = ($x['idTabPreschuap_TipoAgendamento'] == 1) ? '<th>'.$i.'</th>' : '<th></th>';
                        
                        if($x['idTabPreschuap_TipoAgendamento']==1)
                            $sq++;
                        if($x['idTabPreschuap_TipoAgendamento']==2)
                            $inj++;
                        if($x['idTabPreschuap_TipoAgendamento']==3)
                            $ms++;
                        if($x['idTabPreschuap_TipoAgendamento']==4)
                            $int++;
                        if($x['idTabPreschuap_TipoAgendamento']==5)
                            $inc++;

                        echo '                     
                            <tr>
                                '.$th.'
                                <th>'.$x['badge'].'</th>
                                <th>'.$x['Observacoes'].'</th>
                                <th>'.$x['Prontuario'].'</th>
                                <th>'.$agenda['paciente'][$x['Prontuario']].'</th>
                                <th>'.$x['Protocolo'].'</th>
                                <th>'.$x['Medicamento'].'</th>
                                <th>'.$x['Codigo'].'</th>
                                <th>'.$x['Dose'].'</th>                                 
                            </tr>
                        ';
                        $ant=$x['idPreschuap_Agenda'].'#'.$x['idTabPreschuap_Protocolo'];
                        
                    }
                    else {
                        echo '
                            <tr>
                                <th colspan="6"></th>
                                <th>'.$x['Medicamento'].'</th>
                                <th>'.$x['Codigo'].'</th>
                                <th>'.$x['Dose'].'</th>                                 
                            </tr>
                        ';                        
                    }
                    $agn=$x['idTabPreschuap_TipoAgendamento'];
                    
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

</main>

<?= $this->endSection() ?>
