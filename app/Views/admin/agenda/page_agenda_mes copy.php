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
                        $m = '02';
                        $y = '2024';
                        $x = $y.'-'.$m.'-'.$d;
                                                
                        $dataorigem = new DateTime($x);
                        $mo = $dataorigem->format('m');
                        #$ds = $dataorigem->format('w');
                        
                        $j=$k=0;
                        #enquanto a data do mês for válida
                        for($i=0; $i < 36; $i++) {
                            
                            $data = new DateTime($x);
                            $data->modify('+'.$j.' days');
                            $ds = $data->format('w'); #4

                            #/*
                            #enquanto o dia for válido
                            if ($i >= $ds && $mo == $data->format('m')) {
                            #if ($i >= $ds) {


                                echo "<td><br> i= ".$i.'
                                <br> ds= '.$ds.'
                                <br> j= '.$j.'
                                <br> d= '.$data->format('d').' 
                                <br> mo= '.$mo.'
                                <br> ma= '.$data->format('m').'
                                <br> mf= '.$data->format('m').'
                                <br> data= '.$data->format('d/m/Y')."
                                </td>";
                                echo ($ds == '6') ? '</tr><tr>' : NULL;
                                
                                $j++;

                            }
                            else {
                                
                                $a = ($mo < $data->format('m')) ? 'true' : 'false';
                                /*
                                if ($dataorigem->format('Ymd') < $data->format('Ymd')) {
                                    $j=0;
                                    $x = $data->format('Y-m-d');

                                } */
                                #$a = ($m < $data->format('m')) ? $x : 'false';
                                #$a = ($data->format('Y-m-d') < $data->format('Y-m-d')) ? $x : 'false';
                                echo "<td>KBO!<br> i= ".$i.'
                                <br> ds= '.$ds.'
                                <br> j= '.$j.'
                                <br> d= '.$data->format('d').' 
                                <br> m= '.$m.'
                                <br> mf= '.$data->format('m').'
                                <br> mo= '.$mo.'
                                <br> ma= '.$data->format('m').'
                                <br> a?= '.$a.'
                                <br> data= '.$data->format('d/m/Y')."
                                                                
                                </td>";
                                
                                

                                #if ($m < $data->format('m'))
                                #    echo 'OLAOLAOLA';

                                #echo "<td> KBÔ!!! ".$m.'<#m. m#> '.$data->format('m').' ds.. '.$ds."</td>";
                                #$j++;

                            }
                                
                            #*/

                            /*
                            if ($ds == 6 && $m < $data->format('m'))
                                echo '<tr><td>OLAOLAOLA</td></tr>';
                            #*/

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
