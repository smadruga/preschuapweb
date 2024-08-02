<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>

<main class="container">
    <div class="alert" role="alert">
        <table class="table">
            <thead>
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
                        $d = '01';
                        $m = '07';
                        $y = '2024';
                        $dataorigem = new DateTime("$y-$m-$d");
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

                                echo "
                                <td>
                                    <div class='card'>
                                        <div class='card-header text-center'>
                                            ".$data->format('d')."
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
                                            Total:  ".$total."
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
