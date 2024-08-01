<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>

<main class="container">
    <div class="alert" role="alert" >

        <table class="table">
            <thead>

                <tr>
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
                        $m = '12';
                        $y = '2024';
                        $x = $y.'-'.$m.'-'.$d;
                                                
                        $dataorigem = new DateTime($x);
                        $mo = $dataorigem->format('m');
                        
                        $j=$k=0;
                        #enquanto a data do mês for válida
                        for($i=0; $i < 36; $i++) {
                            
                            $data = new DateTime($x);
                            $data->modify('+'.$j.' days');
                            $ds = $data->format('w'); #4

                            #/*
                            #enquanto o dia for válido
                            if ($i >= $ds && $mo == $data->format('m')) {

                                echo '
                                <td>
                                    <div class="card">
                                        <div class="card-header text-center">
                                            '.$data->format('d').'
                                        </div>
                                        <div class="card-body">
                                            1<br>
                                            2<br>
                                            3<br>
                                            4<br>
                                            5<br>
                                        </div>
                                        <div class="card-footer text-body-secondary text-center">
                                            Total
                                        </div>
                                    </div>
                                </td>';
                                echo ($ds == '6') ? '</tr><tr>' : NULL;
                                
                                $j++;

                            }
                            else {
                                
                                echo "<td></td>";

                            }

                        }


                    ?>
                
                </tr>

            </tbody> 

            <tfoot>

            </tfoot>
        </table>
        
    </div>
</main>

<?= $this->endSection() ?>
