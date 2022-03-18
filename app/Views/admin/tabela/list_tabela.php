<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>

<main class="container">
    <div class="text-center">
        <a class="btn btn-warning" href="<?= base_url('paciente/find_paciente') ?>"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
        <br /><br />
    </div>

    <?= $pager->makeLinks($page, $perpage, $count, 'bootstrap') ?>

    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col" colspan="4" class="bg-light text-center">Tabela: <?= $tabela ?></th>
            </tr>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Descrição</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($lista->getResultArray() as $v) {
                $v['Inativo'] = (!$v['Inativo']) ? 'ATIVO' : 'INATIVO';
                echo '
                <tr>
                    <th>'.$v['idTabPreschuap_'.$tabela].'</th>
                    <td>'.$v[$tabela].'</td>
                    <td>'.$v['Inativo'].'</th>
                    <td></th>
                </tr>
                ';
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="bg-light text-center">Total: <?= $lista->getNumRows().' de '. $count ?> resultado(s).</th>
            </tr>
        </tfoot>
    </table>

    <?= $pager->makeLinks($page, $perpage, $count, 'bootstrap') ?>

    <div class="text-center">
        <a class="btn btn-warning" href="<?= base_url('paciente/find_paciente') ?>"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
        <br /><br />
    </div>
</main>

<?= $this->endSection() ?>
