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

    <table class="table table-striped table-bordered">
        <tr>
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
            foreach($agenda['agendamento']['M'] as $v) {
                #$opt = 'class="clickable-row" data-href="' . base_url('paciente/show_paciente/'.$v['codigo']) . '"';

                foreach($v as $x) {
                    echo '
                    <tr>
                        <th>'.$i.'</th>
                        <th>'.$x['idTabPreschuap_TipoAgendamento'].'</th>
                        <th>'.$x['Observacoes'].'</th>
                        <th>'.$x['Prontuario'].'</th>
                        <th>'.$agenda['paciente'][$x['Prontuario']].'</th>
                        <th>'.$x['Protocolo'].'</th>
                        <th>'.$x['Medicamento'].'</th>
                        <th>'.$x['Codigo'].'</th>
                        <th>'.$x['Dose'].'</th>                                 
                    </tr>
                    ';
                }
                $i++;
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="9" class="text-center">Total: <?= $i ?> resultados.</th>
            </tr>
        </tfoot>        
    </table>

    <hr>

    <div class="alert alert-secondary text-center" role="alert">
        <b>TURNO: TARDE</b>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <td>#</td>
            <td>Obs</td>
            <td>Tipo</td>
            <td>Prontuário</td>
            <td>Nome</td>
            <td>Protocolo</td>
            <td>Medicamento</td>
            <td>Via</td>
            <td>Dose</td>
        </tr>
    </table>

</main>

<?= $this->endSection() ?>
