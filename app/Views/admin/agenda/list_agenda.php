<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>

<main class="container">
    <div class="text-center">
        <a class="btn btn-warning" href="<?= base_url('paciente/find_paciente') ?>"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
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
            $date = date('Y-m-d H:i:s', strtotime($dtinicio . ' + 0 minute'));
        ?>

        <tbody>
            <?php
                for($i=0; $date<$dtfim; $i+=10) {
                #for($i=0; $i<=100; $i+=10) {
                    $date = date('Y-m-d H:i:s', strtotime($dtinicio . ' + ' . $i . ' minute'));
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
