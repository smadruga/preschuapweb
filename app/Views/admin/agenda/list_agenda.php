<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>

<main class="container">

    <div class="alert alert-primary" role="alert" >
        <div class="container text-center" >
            <div class="row">
                <div class="col text-end">
                    <!-- Link para a página anterior -->
                    <a href="<?= esc($agenda['AntUrl']) ?>" class="btn btn-info" role="button" aria-label="Anterior" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Anterior">
                        <i class="fa-solid fa-backward"></i>
                    </a>
                </div>
                <div class="col-3 text-center">
                    <form method="post" action="<?= base_url('agenda/index') ?>">
                        <div class="input-group">
                            <input type="date" name="data" class="form-control" value="<?= esc($agenda['databd']) ?>" required onchange="this.form.submit()">
                        </div>
                    </form>
                </div>
                <div class="col text-start">
                    <!-- Link para a próxima página -->
                    <a href="<?= esc($agenda['ProxUrl']) ?>" class="btn btn-info" role="button" aria-label="Próximo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Próximo">
                        <i class="fa-solid fa-forward"></i>
                    </a>
                </div>

                <div class="col-3 text-center btn-group" role="group" aria-label="Basic example">
                    <a href="<?= base_url('agenda/show_agenda_mes') ?>" class="btn btn-info" role="button" aria-label="Próximo" style="text-decoration:none">
                        <i class="fa-solid fa-calendar-day"></i> Mês
                    </a>
                    <a href="<?= base_url('agenda/index') ?>" class="btn btn-info" role="button" aria-label="Próximo" style="text-decoration:none">
                        <i class="fa-solid fa-person-walking-arrow-loop-left"></i> Hoje
                    </a>
                    <a href="<?= base_url('agenda/print_agenda/'.$agenda['databd']) ?>" target="_blank" class="btn btn-info" role="button" aria-label="Próximo" style="text-decoration:none">
                        <i class="fa-solid fa-print"></i> Imprimir
                    </a>
                </div>

            </div>
        </div>
    </div>

    <hr>

    <?php foreach (['M' => 'MANHÃ', 'T' => 'TARDE'] as $turno => $turnoNome): ?>
        <div class="alert alert-secondary text-center" colspan='14' role="alert">
            <b>TURNO: <?= $turnoNome ?></b>
        </div>

        <table class="table table-bordered">
            <tr class="table-secondary text-center">
                <td>#</td>
                <td>Tipo</td>
                <td>Obs</td> 
                <?php if (!empty(array_intersect(array_keys($_SESSION['Sessao']['Perfil']), [1,6]))) { ?>
                <td><i class="fa-regular fa-trash-can"></i></td>
                <td><i class="fa-solid fa-pen-to-square"></i></td>
                <td><i class="fa-solid fa-eye"></i></td>    
                <?php } ?>
                <td>Prontuário</td>
                <td>Nome</td>
                <td>Prescrição</td>
                <td>Protocolo</td>
                <td>Medicamento</td>
                <td>Via</td>
                <td>Dose</td>
                <?php if (!empty(array_intersect(array_keys($_SESSION['Sessao']['Perfil']), [1,6]))) { ?>
                <td><i class="fa-solid fa-eye-slash"></i></td>
                <?php } ?>
            </tr>
            <tbody>
                <?php

                    if (!isset($agenda['agendamento'][$turno])) {
                        $i=$sq=$inj=$ms=$int=$inc=0;
                    ?>
                        <div class="alert alert-warning text-center" role="alert">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                                SEM AGENDAMENTOS
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                    <?php
                    }
                    else {
                        $counts = array_fill(1, 5, 0);
                        $i=$sq=$inj=$ms=$int=$inc=0;
                        foreach ($agenda['agendamento'][$turno] as $v) {
                            $ant = $agn = '<i class="fa-regular fa-trash-can"></i>';
                            foreach ($v as $x) {
                                /*
                                if ($i > 0 && $x['idTabPreschuap_TipoAgendamento'] != $agn) {
                                    echo '<tr><td colspan="'.$cs1.'"><br></td></tr>';
                                }
                                */
                                if ((!empty(array_intersect(array_keys($_SESSION['Sessao']['Perfil']), [1,6])))) { 
                                    $bt1 = "
                                        <th>
                                            <a href='#' class='btn btn-outline-danger btn-sm' role='button' aria-label='Excluir'
                                                data-bs-toggle='modal' data-bs-target='#confirmDeleteModal' 
                                                data-id='".$x['idPreschuap_Agenda']."' data-date='".$agenda['databd']."'
                                                data-bs-title='Excluir agendamento'>
                                                <i class='fa-regular fa-trash-can'></i>
                                            </a>
                                        </th>

                                        <th>
                                            <a href='".base_url('agenda/agenda_prescricao/'.$x['idPreschuap_Prescricao'].'/'.$x['idPreschuap_Agenda'].'/'.$agenda['paciente'][$x['Prontuario']]['codigo'])." '
                                                class='btn btn-outline-warning btn-sm' role='button' aria-label='Excluir' data-bs-toggle='tooltip' 
                                                data-bs-placement='top' data-bs-title='Editar agendamento'>
                                                <i class='fa-solid fa-pen-to-square'></i>
                                            </a>
                                        </th>
                                        <th>
                                            <a href=".base_url('agenda/hide_medicamento/'.$agenda['databd'].'/'.$x['idPreschuap_Agenda'].'/1/')." 
                                                class='btn btn-outline-info btn-sm' role='button' aria-label='Excluir' data-bs-toggle='tooltip' 
                                                data-bs-placement='top' data-bs-title='Reexibir todos medicamentos'>
                                                <i class='fa-solid fa-eye'></i>
                                            </a>
                                        </th>                                          
                                    ";
                                    
                                    $bt2 = "
                                        <th>
                                            <a href=".base_url('agenda/hide_medicamento/'.$agenda['databd'].'/'.$x['idPreschuap_Agenda'].'/0/'.$x['idTabPreschuap_Medicamento'])." 
                                                class='btn btn-outline-info btn-sm' role='button' aria-label='Ocultar' data-bs-toggle='tooltip' 
                                                data-bs-placement='top' data-bs-title='Ocultar medicamento'>
                                                <i class='fa-solid fa-eye-slash'></i>
                                            </a>
                                        </th>                                            
                                    ";

                                    $thth = '<th></th>';

                                    $cs1 = 14;
                                    $cs2 = 10;
                                }
                                else {
                                    $thth = $bt1 = $bt2 = "";
                                    $cs1 = 10;
                                    $cs2 = 7;                                        
                                }

                                if ($ant != $x['idPreschuap_Agenda'].'#'.$x['idTabPreschuap_Protocolo']) {
                                    $i++;
                                    $th = ($x['idTabPreschuap_TipoAgendamento'] == 1) ? '<th>'.$i.'</th>' : '<th></th>';

                                    $counts[$x['idTabPreschuap_TipoAgendamento']]++;

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
                                    
                                    #<tr><td colspan='".$cs1."'><br></td></tr>    
                                    echo "                       
                                        <tr>
                                            {$th}
                                            <th>{$x['badge']}</th>
                                            <th>".esc($x['Observacoes'])."</th>
                                            ".$bt1."
                                            <th>
                                                <a href=".base_url('paciente/show_paciente/'.$agenda['paciente'][$x['Prontuario']]['codigo'])."
                                                    data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Abrir Perfil' 
                                                     style='text-decoration:none'>
                                                    ".esc($agenda['paciente'][$x['Prontuario']]['prontuario'])."
                                                </a>
                                            </th>
                                            <th>".esc($agenda['paciente'][$x['Prontuario']]['nome'])."</th>
                                            <th>#".esc($x['idPreschuap_Prescricao'])."</th>
                                            <th>".esc($x['Protocolo'])."</th>";
                                    if(!isset($agenda['oculto'][$x["idPreschuap_Agenda"]][$x["idTabPreschuap_Medicamento"]])) {
                                        echo "
                                            <th>".esc($x['Medicamento'])."</th>
                                            <th>".esc($x['Codigo'])."</th>
                                            <th>".esc($x['Dose'])."</th>
                                            ".$bt2."
                                            ";
                                    }
                                    else {
                                        echo "
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            ".$thth."
                                        ";
                                    }
                                    echo "
                                        </tr>
                                    ";
                                    $ant = $x['idPreschuap_Agenda'].'#'.$x['idTabPreschuap_Protocolo'];
                                } else {
                                    
                                    if(!isset($agenda['oculto'][$x["idPreschuap_Agenda"]][$x["idTabPreschuap_Medicamento"]])) {
                                    
                                        echo '
                                            <tr>
                                                <th colspan="'.$cs2.'"></th>
                                                <th>'.esc($x['Medicamento']).'</th>
                                                <th>'.esc($x['Codigo']).'</th>
                                                <th>'.esc($x['Dose']).'</th>  
                                                '.$bt2.' 
                                            </tr>
                                        ';

                                    }

                                }
                                $agn = $x['idTabPreschuap_TipoAgendamento'];
                            }
                        }
                    }
                ?>
            </tbody>        
            <tfoot>
                <tr>
                    <th colspan="14" class="text-center">
                        <table width="100%">
                            <tr>
                                <th><span class="badge bg-primary text-white" data-bs-toggle="tooltip" data-bs-placement="top" 
                                    data-bs-title="Salão de Quimioterapia"><i class="fa-solid fa-couch"></i></span> <?= $sq ?></th>
                                <th><span class="badge bg-success text-white" data-bs-toggle="tooltip" data-bs-placement="top" 
                                    data-bs-title="Injeção"><i class="fa-solid fa-syringe"></i></span> <?= $inj ?></th>
                                <th><span class="badge bg-warning text-white" data-bs-toggle="tooltip" data-bs-placement="top" 
                                    data-bs-title="Medicação de Suporte"><i class="fa-solid fa-pills"></i></span> <?= $ms ?></th>
                                <th><span class="badge bg-danger text-white" data-bs-toggle="tooltip" data-bs-placement="top" 
                                    data-bs-title="Internação"><i class="fa-solid fa-bed"></i></span> <?= $int ?></th>
                                <th><span class="badge bg-info text-white" data-bs-toggle="tooltip" data-bs-placement="top" 
                                    data-bs-title="Intratecal"><i class="fa-solid fa-house-medical"></i></span> <?= $inc ?></th>                        
                            </tr>
                        </table>                  
                    </th>
                </tr>
                <tr>
                    <th colspan="14" class="text-center">Total: <?= $i ?> agendamentos</th>
                </tr>
            </tfoot>        
        </table>

        <br><br>
               
    <?php endforeach; ?>

</main>

<!-- Modal de confirmação -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        Você tem certeza que deseja excluir este agendamento?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Excluir</a>
      </div>
    </div>
  </div>
</div>


<?= $this->endSection() ?>
