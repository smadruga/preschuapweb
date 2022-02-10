<?= $this->extend('layouts/main_admin') ?>
<?= $this->section('content') ?>

<main class="container">

    <?= $this->include('layouts/div_flashdata') ?>

    <div class="container">
        <div class="row">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-primary rounded" style="width: 280px;">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5"><?= $data->Nome ?></span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link" aria-current="page">
                            <i class="fa-solid fa-chalkboard-user"></i> Perfil
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <i class="fa-solid fa-user-slash"></i> Desativar
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col border rounded ms-2 p-4">

                <table class="table table-user-information">
                    <tbody>

                        <tr>
                            <td width="30%"><i class="fa-solid fa-hospital-user"></i> Nome do Usuário:</td>
                            <td><b><?= $data->Nome ?></b></td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-address-card"></i> CPF:</td>
                            <td><?= $func->mascara_cpf($data->Cpf) ?></td>
                        </tr>
                        <tr class="bg-white">
                            <td><i class="fa-solid fa-desktop"></i> Login EBSERH:</td>
                            <td><?= $data->Usuario ?></td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-at"></i> E-mail:</td>
                            <td><?= $data->EmailSecundario ?></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                            <?php
                            if($data->Inativo == 1) {
                                $bg     = 'warning';
                                $msg    = 'Usuário Inativo';
                                $fa     = 'user-slash';
                            }
                            else {
                                $bg     = 'success';
                                $msg    = 'Usuário Ativo';
                                $fa     = 'user-check';
                            }
                            ?>
                            <h4><span class="badge bg-<?= $bg ?>"><i class="fa-solid fa-<?= $fa ?>"></i> <?= $msg ?></span></h4>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>
