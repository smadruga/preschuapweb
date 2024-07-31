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
                        
                        $d = '1';
                        $m = '2';
                        $y = '2024';
                        $x = $y.'-'.$m.'-'.$d;
                        
                        $data = new DateTime($x);
                        $d = $data->format('w');
                        
                        $j=0;
                        #enquanto a data do mês for válida
                        for($i=0; $i < 31; $i++) {

                            $data = new DateTime($x);
                            $data->modify('+'.$j.' days');
                            $d = $data->format('w');
                            #/*
                            #enquanto o dia for válido
                            if ($i >= $d && $m == $data->format('m')) {

                                echo "<td>".$i.' - '.$d.' <#i.ds d#> '.$data->format('d').' m#> '.$data->format('m')."</td>";
                                echo ($d == '6') ? '</tr><tr>' : NULL;
                                
                                $j++;

                            }
                            else
                                echo "<td>.$i.</td>";
                            #*/

                            /*if ($d == 6 && $m < $data->format('m'))
                                echo '<tr><td>OLAOLAOLA</td></tr>';*/

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
