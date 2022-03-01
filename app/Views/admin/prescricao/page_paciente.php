<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>

<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-primary rounded" style="width: 280px;">
    <?= $this->include('layouts/sidenavbar_paciente') ?>
</div>

<div class="col border rounded ms-2 p-4">

    <table class="table table-user-information">
        <tbody>

            <tr>
                <td width="30%"><i class="fa-solid fa-id-card-clip"></i> Nome do Paciente:</td>
                <td><b><?= $_SESSION['Paciente']['nome'] ?></b></td>
            </tr>
            <tr>
                <td width="30%"><i class="fa-solid fa-address-card"></i> Prontuário:</td>
                <td><b><?= $_SESSION['Paciente']['prontuario'] ?></b></td>
            </tr>
            <tr>
                <td width="30%"><i class="fa-solid fa-id-badge"></i> Nome da Mãe:</td>
                <td><b><?= $_SESSION['Paciente']['nome_mae'] ?></b></td>
            </tr>
            <tr>
                <td width="30%"><i class="fa-solid fa-cake-candles"></i> Data de Nascimento:</td>
                <td><b><?= $func->mascara_data($_SESSION['Paciente']['dt_nascimento'], 'barras', TRUE, FALSE, TRUE) ?></b></td>
            </tr>
            <?php
                if($_SESSION['Paciente']['sexo'] == 'M')
                    $fa = 'mars';
                elseif($_SESSION['Paciente']['sexo'] == 'F')
                    $fa = 'venus';
                else
                    $fa = 'neuter';
            ?>
            <tr>
                <td width="30%"><i class="fa-solid fa-<?= $fa ?>"></i> Sexo:</td>
                <td><b><?= $func->get_sexo($_SESSION['Paciente']['sexo']) ?></b></td>
            </tr>
            <tr>
                <td width="30%"><i class="fa-solid fa-id-card"></i> CPF:</td>
                <td><b><?= $func->mascara_cpf($_SESSION['Paciente']['cpf']) ?></b></td>
            </tr>
            <tr>
                <td width="30%"><i class="fa-solid fa-hospital-user"></i> CNS:</td>
                <td><b><?= $_SESSION['Paciente']['nro_cartao_saude'] ?></b></td>
            </tr>
            <tr>
                <td width="30%"><i class="fa-solid fa-phone"></i> Telefone:</td>
                <td><b><?=
                    $_SESSION['Paciente']['ddd_fone_residencial'].' '.
                    $_SESSION['Paciente']['fone_residencial'].' '.
                    $_SESSION['Paciente']['ddd_fone_recado'].' '.
                    $_SESSION['Paciente']['fone_recado']
                ?></b></td>
            </tr>
            <tr>
                <td width="30%"><i class="fa-solid fa-at"></i> E-mail:</td>
                <td><b><?= $_SESSION['Paciente']['email'] ?></b></td>
            </tr>
        </tbody>
    </table>

</div>

<?= $this->endSection() ?>
