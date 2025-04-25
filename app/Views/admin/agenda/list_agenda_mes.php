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
                <div class="col-4 text-center">
                    <form method="post" action="<?= base_url('agenda/show_agenda_mes') ?>">
                        <div class="input-group">
                            <input type="month" name="month" class="form-control" value="<?= esc($agenda['month']) ?>" required onchange="this.form.submit()">
                        </div>
                    </form>
                </div>
                <div class="col text-start">
                    <!-- Link para a próxima página -->
                    <a href="<?= esc($agenda['ProxUrl']) ?>" class="btn btn-info" role="button" aria-label="Próximo" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Próximo">
                        <i class="fa-solid fa-forward"></i>
                    </a>
                </div>

                <div class="col-2 text-center btn-group" role="group" aria-label="Basic example">
                    <a href="<?= base_url('agenda/show_agenda_mes/') ?>" class="btn btn-info" role="button" aria-label="Próximo" style="text-decoration:none">
                        <i class="fa-solid fa-person-walking-arrow-loop-left"></i> Hoje
                    </a>
                </div>

            </div>
        </div>
    </div>
    
    <div class="alert" role="alert">
        <table class="table">
            <thead class="border border-2 border-dark">
                <tr class="text-center">
                    <th>DOM</th>
                    <th>SEG</th>
                    <th>TER</th>
                    <th>QUA</th>
                    <th>QUI</th>
                    <th>SEX</th>
                    <th>SÁB</th>               
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php

                        $dataorigem = new DateTime("$ano-$mes-1");
                        $mo = $dataorigem->format('m');
                        $j = 0;

                        for ($i = 0; $i < 36; $i++) {
                            $data = clone $dataorigem;
                            $data->modify("+$j days");
                            $ds = $data->format('w');

                            if ($i >= $ds && $mo == $data->format('m')) {

                                $sq     = (isset($agenda[$data->format('Y-m-d')][1])) ? $agenda[$data->format('Y-m-d')][1] : 0;
                                $inj    = (isset($agenda[$data->format('Y-m-d')][2])) ? $agenda[$data->format('Y-m-d')][2] : 0;
                                $ms     = (isset($agenda[$data->format('Y-m-d')][3])) ? $agenda[$data->format('Y-m-d')][3] : 0;
                                $int    = (isset($agenda[$data->format('Y-m-d')][4])) ? $agenda[$data->format('Y-m-d')][4] : 0;
                                $inc    = (isset($agenda[$data->format('Y-m-d')][5])) ? $agenda[$data->format('Y-m-d')][5] : 0;
                                $total  = (isset($agenda[$data->format('Y-m-d')]['Total'])) ? $agenda[$data->format('Y-m-d')]['Total'] : 0;

                                $dia = $data->format('Y-m-d');
                                $destaque = ($data->format('Y-m-d') == date('Y-m-d')) ? "btn-warning" : "btn-info";

                                echo "
                                <td>
                                    <div class='card'>
                                        <div class='card-header text-center'>
                                            <a href='".esc(site_url('agenda/index/'.$data->format('Y-m-d')))."' class='btn ".$destaque." text-decoration-none' role='button'>
                                                ".$data->format('d')."
                                            </a>
                                        </div>
                                        <div class='card-body'>
                                            <table class='col-12'>

                                                <tr>
                                                    <td class='col text-center'>
                                                        <span class='badge bg-primary text-white' data-bs-toggle='tooltip' data-bs-placement='top' 
                                                        data-bs-title='Salão de Quimioterapia'><i class='fa-solid fa-couch'></i></span>
                                                    </td> 
                                                    <td class='col'>
                                                        ".$sq."
                                                    </td> 
                                                </tr>

                                                <tr>
                                                    <td class='col text-center'>
                                                        <span class='badge bg-success text-white' data-bs-toggle='tooltip' data-bs-placement='top' 
                                                            data-bs-title='Injeção'><i class='fa-solid fa-syringe'></i></span>
                                                    </td> 
                                                    <td class='col'>
                                                        ".$inj."
                                                    </td> 
                                                </tr>

                                                <tr>
                                                    <td class='col text-center'>
                                                        <span class='badge bg-warning text-white' data-bs-toggle='tooltip' data-bs-placement='top' 
                                                            data-bs-title='Medicação de Suporte'><i class='fa-solid fa-pills'></i></span>
                                                    </td> 
                                                    <td class='col'>
                                                        ".$ms."
                                                    </td> 
                                                </tr>

                                                <tr>
                                                    <td class='col text-center'>
                                                        <span class='badge bg-danger text-white' data-bs-toggle='tooltip' data-bs-placement='top' 
                                                            data-bs-title='Internação'><i class='fa-solid fa-bed'></i></span>
                                                    </td>
                                                    <td class='col'>
                                                         ".$int."
                                                    </td>
                                                </tr>
                                                    
                                                <tr>
                                                    <td class='col text-center'>
                                                        <span class='badge bg-info text-white' data-bs-toggle='tooltip' data-bs-placement='top' 
                                                            data-bs-title='Intratecal'><i class='fa-solid fa-house-medical'></i></span>
                                                    </td>   
                                                    <td class='col'>
                                                        ".$inc."
                                                    </td>
                                                </tr>

                                            </table>
                                            
                                        </div>
                                        <div class='card-footer text-body-secondary text-center'>
                                            Total:  ".($sq+$inj+$ms+$int+$inc)."
                                        </div>
                                    </div>
                                </td>";
                                echo ($ds == '6') ? '</tr><tr>' : NULL;
                                $j++;
                            } else {
                                echo "<td></td>";
                            }
                        }
                    ?>
                </tr>
            </tbody>
        </table>
    </div>
</main>

<?= $this->endSection() ?>
