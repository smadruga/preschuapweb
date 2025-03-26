<?= $this->extend('layouts/main_admin') ?>
<?= $this->section('content') ?>

<?php
foreach($prescricao['array'] as $v) {
?>

<table class="table ms-1" style="width:270mm;font-size:70%;">
    <thead>
        <tr>
            <td class="border-0" colspan="19">

                <div class="ms-1 me-1">
                    <div class="row">
                        <div class="col-5 container border border-dark"><b>
                            <div class="row">
                                <div class="col-2 ps-3 pt-2">
                                    <img src="<?= base_url('/logo-hu.png') ?>" width="100%" /><br />
                                    <img src="<?= base_url('/logo-ebserh.png') ?>" width="100%" />
                                </div>
                                <div class="col pt-2">
                                    <?= mb_strtoupper(env('hu.nome')." - ".env('hu.abrev')) ?><br />
                                    <?= mb_strtoupper(env('hu.head.print')) ?><br />
                                </div>
                            </div>
                        </b></div>

                        <div class="col container border border-dark pt-2 border-start-0">
                            <div class="row">
                                <div class="col"><b>Prontuário: <?= $v['Prontuario'] ?></b></div>
                                <div class="col"><b>Prescrição Nº: #<?= $v['idPreschuap_Prescricao'] ?></b></div>
                            </div>
                            <div class="row">
                                <div class="col"><b>Paciente: <?= $_SESSION['Paciente']['nome'] ?></b></div>
                            </div>
                            <div class="row">
                                <div class="col"><b>Telefone: <?= $_SESSION['Paciente']['telefone'] ?></b></div>
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
                                <div class="col"><b>IMC:</b> <?= $v['IndiceMassaCorporal'] ?> kg/m²</div>
                                <div class="col"><b>SC:</b> <?= $v['SuperficieCorporal'] ?> m²</div>
                            </div>
                        </div>
                    </div>

                </div>

            </td>
        </tr>
        
        <?php

        if($v['idTabPreschuap_TipoAgendamento'] != 2 && $v['idTabPreschuap_TipoAgendamento'] != 3) {
            $data = ($v['Dieta']) ? $v['Dieta'] : "Não informado";

            echo '
                <tr>
                    <th class="border border-dark" colspan="12">
                        <span class="badge bg-primary fs-7"><i class="fa-solid fa-utensils"></i></span> <b>Dieta:</b> '.$data.'
                    </th>
                </tr>
            ';
        }


        $vem['v'] = $v;
        if( env('hu.layout.print') == 1 )
            echo view('admin/prescricao/print_layout_hub', $vem);
        else
            echo view('admin/prescricao/print_layout_huap', $vem);

        ?>
    </thead>
</table>

<?php
}
?>

<?= $this->endSection() ?>
