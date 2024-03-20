<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>

<main class="container">
    
    <div>
        
        <div class="card">
            <form method="post" action="<?= base_url('agenda') ?>">
                <?= csrf_field() ?>
                <div class="card-body row">
                    <div class="col-2">
                        <label class="form-label"><b>Data <b class="text-danger">*</b></b></label>
                        <div class="input-group mb-3">
                            <input type="date" id="Data" class="form-control" 
                                autofocus name="Data" value="<?php echo $data['Data']; ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <label class="form-label"><b>Especialidade <b class="text-danger">*</b></b></label>
                        <div class="input-group mb-3">
                            <select class="form-select select2" id="Especialidade" name="Especialidade" data-placeholder="Selecione uma opção" 
                            data-allow-clear="1" data-placeholder="Selecione uma opção">
                                <option value="">Selecione uma opção</option>
                                <?php
                                foreach ($select['Especialidade']->getResultArray() as $val) {
                                    $selected = ($data['Especialidade'] == $val['seq']) ? 'selected' : '';
                                    echo '<option value="'.$val['seq'].'" '.$selected.'>'.$val['seq'].' - '.$val['nome_especialidade'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-1">
                        <label class="form-label"><b>Sala <b class="text-danger">*</b></b></label>
                        <div class="input-group mb-3">
                            <input type="int" id="Sala" class="form-control" maxlength="2" name="Sala" value="<?php echo $data['Sala']; ?>" />
                        </div>
                    </div>
                    <div class="col">
                        <label class="form-label"><b>Procedimento <b class="text-danger">*</b></b></label>
                        <div class="input-group mb-3">
                            <select class="form-select select2" id="Procedimento" name="Procedimento" data-placeholder="Selecione uma opção" 
                            data-allow-clear="1" data-placeholder="Selecione uma opção">
                                <option value="">Selecione uma opção</option>
                                <?php
                                foreach ($select['Procedimento']->getResultArray() as $val) {
                                    $selected = ($data['Procedimento'] == $val['seq']) ? 'selected' : '';
                                    echo '<option value="'.$val['seq'].'" '.$selected.'>'.$val['seq'].' - '.$val['descricao'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body row text-center">
                    <div class="col">
                        <button class="btn btn-info" id="submit" name="submit" value="1" type="submit"><i class="fa-solid fa-circle-chevron-right"></i> Confirmar</button>
                    </div>
                </div>
            </form>
        </div>
        <br /><br />
    </div>

    <?php

    if ($data['Data'] && $data['Especialidade'] && $data['Sala'] && $data['Procedimento']) {

    ?>

    <table class="table table-hover table-bordered">
        <thead>
            <?php

            echo '
            <tr>
                <th scope="col" class="text-center bg-secondary"></th>
                <th scope="col" class="text-center bg-secondary">DOM</th>
                <th scope="col" class="text-center bg-secondary">SEG</th>
                <th scope="col" class="text-center bg-secondary">TER</th>
                <th scope="col" class="text-center bg-secondary">QUA</th>
                <th scope="col" class="text-center bg-secondary">QUI</th>
                <th scope="col" class="text-center bg-secondary">SEX</th>
                <th scope="col" class="text-center bg-secondary">SÁB</th>
            </tr>  
            <tr>
                <th scope="col" class="text-center bg-secondary">HORÁRIO</th>                                
                <th scope="col" class="text-center bg-secondary">'.$cabecalho[0].'</th>
                <th scope="col" class="text-center bg-secondary">'.$cabecalho[1].'</th>
                <th scope="col" class="text-center bg-secondary">'.$cabecalho[2].'</th>
                <th scope="col" class="text-center bg-secondary">'.$cabecalho[3].'</th>
                <th scope="col" class="text-center bg-secondary">'.$cabecalho[4].'</th>
                <th scope="col" class="text-center bg-secondary">'.$cabecalho[5].'</th>
                <th scope="col" class="text-center bg-secondary">'.$cabecalho[6].'</th>
            </tr>            
            ';
            ?>
        </thead>
        
        <tbody>
            <?php

            $hrinicio   = date("H:i:s", mktime(7,0,0));
            $hrfim      = date("H:i:s", mktime(19,0,0));
            $hr         = date('H:i:s', strtotime($hrinicio . ' + 0 minute'));

            for($i=0; $hr<$hrfim; $i+=10) {
                $hr = date('H:i:s', strtotime($hrinicio . ' + ' . $i . ' minute'));

            ?>

            <tr>
                <th scope="col" class="bg-secondary"><?= $hr ?></th>
                
                <td><?= (isset($agenda['marcacoes'][$cabecalho['dt'][0]][$hr])) ? 
                    '<button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="
                    
                    <b>Prontuário:</b> '    . $agenda['marcacoes'][$cabecalho['dt'][0]][$hr]['prontuario'] .'<br/><br/>
                    <b>Especialidade:</b> ' . $agenda['marcacoes'][$cabecalho['dt'][0]][$hr]['especialidade'] .'<br/><br/>
                    <b>Procedimento:</b> '  . $agenda['marcacoes'][$cabecalho['dt'][0]][$hr]['procedimento'] .'<br/><br/>
                    <b>Equipe:</b> '        . $agenda['marcacoes'][$cabecalho['dt'][0]][$hr]['equipe'] .'<br/>
                
                    ">'                     . $agenda['marcacoes'][$cabecalho['dt'][0]][$hr]['nome'] : NULL ?></td>
                
                <td><?= (isset($agenda['marcacoes'][$cabecalho['dt'][1]][$hr])) ? 
                    '<button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="

                    <b>Prontuário:</b> '    . $agenda['marcacoes'][$cabecalho['dt'][1]][$hr]['prontuario'] .'<br/><br/>
                    <b>Especialidade:</b> ' . $agenda['marcacoes'][$cabecalho['dt'][1]][$hr]['especialidade'] .'<br/><br/>
                    <b>Procedimento:</b> '  . $agenda['marcacoes'][$cabecalho['dt'][1]][$hr]['procedimento'] .'<br/><br/>
                    <b>Equipe:</b> '        . $agenda['marcacoes'][$cabecalho['dt'][1]][$hr]['equipe'] .'<br/>
                
                    ">'                     . $agenda['marcacoes'][$cabecalho['dt'][1]][$hr]['nome'] : NULL ?></td>
                
                <td><?= (isset($agenda['marcacoes'][$cabecalho['dt'][2]][$hr])) ? 
                    '<button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="
                    
                    <b>Prontuário:</b> '    . $agenda['marcacoes'][$cabecalho['dt'][2]][$hr]['prontuario'] .'<br/><br/>
                    <b>Especialidade:</b> ' . $agenda['marcacoes'][$cabecalho['dt'][2]][$hr]['especialidade'] .'<br/><br/>
                    <b>Procedimento:</b> '  . $agenda['marcacoes'][$cabecalho['dt'][2]][$hr]['procedimento'] .'<br/><br/>
                    <b>Equipe:</b> '        . $agenda['marcacoes'][$cabecalho['dt'][2]][$hr]['equipe'] .'<br/>
                
                    ">'                     . $agenda['marcacoes'][$cabecalho['dt'][2]][$hr]['nome'] : NULL ?></td>
                
                <td><?= (isset($agenda['marcacoes'][$cabecalho['dt'][3]][$hr])) ? 
                    '<button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="
                    
                    <b>Prontuário:</b> '    . $agenda['marcacoes'][$cabecalho['dt'][3]][$hr]['prontuario'] .'<br/><br/>
                    <b>Especialidade:</b> ' . $agenda['marcacoes'][$cabecalho['dt'][3]][$hr]['especialidade'] .'<br/><br/>
                    <b>Procedimento:</b> '  . $agenda['marcacoes'][$cabecalho['dt'][3]][$hr]['procedimento'] .'<br/><br/>
                    <b>Equipe:</b> '        . $agenda['marcacoes'][$cabecalho['dt'][3]][$hr]['equipe'] .'<br/>
                
                    ">'                     . $agenda['marcacoes'][$cabecalho['dt'][3]][$hr]['nome'] : NULL ?></td>

                <td><?= (isset($agenda['marcacoes'][$cabecalho['dt'][4]][$hr])) ? 
                    '<button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="
                    
                    <b>Prontuário:</b> '    . $agenda['marcacoes'][$cabecalho['dt'][4]][$hr]['prontuario'] .'<br/><br/>
                    <b>Especialidade:</b> ' . $agenda['marcacoes'][$cabecalho['dt'][4]][$hr]['especialidade'] .'<br/><br/>
                    <b>Procedimento:</b> '  . $agenda['marcacoes'][$cabecalho['dt'][4]][$hr]['procedimento'] .'<br/><br/>
                    <b>Equipe:</b> '        . $agenda['marcacoes'][$cabecalho['dt'][4]][$hr]['equipe'] .'<br/>
                
                    ">'                     . $agenda['marcacoes'][$cabecalho['dt'][4]][$hr]['nome'] : NULL ?></td>

                <td><?= (isset($agenda['marcacoes'][$cabecalho['dt'][5]][$hr])) ? 
                    '<button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="
                    
                    <b>Prontuário:</b> '    . $agenda['marcacoes'][$cabecalho['dt'][5]][$hr]['prontuario'] .'<br/><br/>
                    <b>Especialidade:</b> ' . $agenda['marcacoes'][$cabecalho['dt'][5]][$hr]['especialidade'] .'<br/><br/>
                    <b>Procedimento:</b> '  . $agenda['marcacoes'][$cabecalho['dt'][5]][$hr]['procedimento'] .'<br/><br/>
                    <b>Equipe:</b> '        . $agenda['marcacoes'][$cabecalho['dt'][5]][$hr]['equipe'] .'<br/>
                
                    ">'                     . $agenda['marcacoes'][$cabecalho['dt'][5]][$hr]['nome'] : NULL ?></td>

                <td><?= (isset($agenda['marcacoes'][$cabecalho['dt'][6]][$hr])) ? 
                    '<button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="
                    
                    <b>Prontuário:</b> '    . $agenda['marcacoes'][$cabecalho['dt'][6]][$hr]['prontuario'] .'<br/><br/>
                    <b>Especialidade:</b> ' . $agenda['marcacoes'][$cabecalho['dt'][6]][$hr]['especialidade'] .'<br/><br/>
                    <b>Procedimento:</b> '  . $agenda['marcacoes'][$cabecalho['dt'][6]][$hr]['procedimento'] .'<br/><br/>
                    <b>Equipe:</b> '        . $agenda['marcacoes'][$cabecalho['dt'][6]][$hr]['equipe'] .'<br/>
                
                    ">'                     . $agenda['marcacoes'][$cabecalho['dt'][6]][$hr]['nome'] : NULL ?></td>
            </tr>

            <?php
            }
            ?>
        </tbody>        
        
    </table>

    <?php

    /*

            echo '
            <tr>
                <th scope="col" class="bg-secondary">'. $hr .'</th>
                <td>'. $cabecalho['dt'][0] . ' <> ' .$hr .'</td>
                <td>'. $agenda['marcacoes'][$cabecalho['dt'][1]]['07:00:00']['prontuario'] .'</td>    
                <td>'. $agenda['marcacoes'][$cabecalho['dt'][1]]['07:10:00']['prontuario'] .'</td>    
                <td>'. $agenda['marcacoes'][$cabecalho['dt'][1]]['07:20:00']['prontuario'] .'</td>    
                <td>'. $agenda['marcacoes'][$cabecalho['dt'][1]]['07:30:00']['prontuario'] .'</td>    
                <td>'. $agenda['marcacoes'][$cabecalho['dt'][1]]['07:40:00']['prontuario'] .'</td>    
                <td>'. isset($agenda['marcacoes'][$cabecalho['dt'][1]]['07:50:00']['prontuario']) ? 's' : 'n' .'</td>    
            </tr>
            ';

    <td>'. (isset($agenda['marcacoes'][$cabecalho['dt'][1]][$hr])) ? $agenda['marcacoes'][$cabecalho['dt'][1]][$hr]['prontuario'] : NULL .'</td>    


<td>'. $cabecalho['dt'][0] . ' <> ' .$hr .'</td>
                <td>'. $cabecalho['dt'][1] . ' <> ' .$hr .'</td>    
                <td>'. $cabecalho['dt'][2] . ' <> ' .$hr .'</td>
                <td>'. $cabecalho['dt'][3] . ' <> ' .$hr .'</td>
                <td>'. $cabecalho['dt'][4] . ' <> ' .$hr .'</td>
                <td>'. $cabecalho['dt'][5] . ' <> ' .$hr .'</td>
                <td>'. $cabecalho['dt'][6] . ' <> ' .$hr .'</td>

    <td>'. (isset($agenda['marcacoes'][$cabecalho['dt'][0]][$hr])) ? $agenda['marcacoes'][$cabecalho['dt'][0]][$hr] : NULL .'</td>
     <tr>
        <th scope="col" class="bg-secondary">'. $hr .'</th>
        <td>'. $i .'</td>
        <td>
            <a tabindex="0" class="btn btn-warning" role="button" data-bs-toggle="popover" 
                data-bs-trigger="focus" data-bs-title="NOME" html="true"
                data-bs-content="prontario: 313546 - especialidade: endoscopia - procedimento: faca neles - equipe: galera boa">27651613</a>
        </td>
        <td>
            <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="
                
                    <b>Nome:</b> fulana de tal<br/>
                    <b>Especialidade:</b> Endoscopia<br/>
                    <b>Procedimento:</b> faca na muringa<br/>
                    <b>Equipe:</b> todos habilitados<br/>
                
            ">
                27354168
            </button>
        </td>
        <td></td>
        <td></td>
    </tr>
    */
    }
    else {
        echo '
            <div class="alert alert-secondary text-center" role="alert">
                <b>Sem resultados.</b>
            </div>        
        ';
    }

    ?>

</main>

<?= $this->endSection() ?>
