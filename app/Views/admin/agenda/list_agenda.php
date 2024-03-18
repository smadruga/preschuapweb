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
                            <input type="text" placeholder="DD/MM/AAAA" id="Data" class="form-control Data" autofocus name="Data" value="<?php echo $data['Data']; ?>" />
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

    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col">Horário</th>
                <th scope="col">Prontuário</th>
                <th scope="col">Nome</th>
                <th scope="col">Procedimento</th>
                <th scope="col">Equipe</th>
            </tr>   
        </thead>
        
        <?php
            $dtinicio   = date("Y-m-d H:i:s", mktime(7,0,0));
            $dtfim      = date("Y-m-d H:i:s", mktime(19,0,0));
            $date       = date('Y-m-d H:i:s', strtotime($dtinicio . ' + 0 minute'));
        ?>

        <tbody>
            <?php
                #<tr class="table-info">
                for($i=0; $date<$dtfim; $i+=10) {
                    $date = date('H:i:s', strtotime($dtinicio . ' + ' . $i . ' minute'));
            ?>
            <tr>
                <th scope="col"><?= $date ?></th>
                <th><?php echo $i ?></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <?php
                
                }
            ?>
        </tbody>
        
        <tfoot>
            <tr>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <div class="text-center">
        <a class="btn btn-warning" href="<?= base_url('paciente/find_paciente') ?>"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
        <br /><br />
    </div>
</main>

<?= $this->endSection() ?>
