<?php $session = \Config\Services::session(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary pt-1 pb-1">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('admin') ?>"><?= HUAP_APPNAME ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <form class="d-inline-flex" method="post" action="<?= base_url('paciente/get_paciente') ?>">
                <input class="form-control me-sm-2" type="text" name="Pesquisar" placeholder="Nome, prontuário, nascimento...">
                <button class="btn btn-info my-2 my-sm-0" style="width: 150px" type="submit"><i class="fa-solid fa-search"></i> Buscar</button>
            </form>
            <div class="ps-2 pe-2"></div>
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('paciente/find_paciente') ?>">Prescrição
                        <span class="visually-hidden"></span>
                    </a>
                </li>
                <?php if (isset($_SESSION['Sessao']['Perfil'][1]) || isset($_SESSION['Sessao']['Perfil'][2]) ) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Configurações</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= base_url('admin/find_user') ?>"><i class="fas fa-user"></i> Gerenciar Usuário</a>
                        <!--<div class="dropdown-divider"></div>-->
                    </div>
                </li>
                <?php } ?>
            </ul>
            <div class="ms-3 me-3 text-warning fs-6 text-center">
                <span><i class="fa-solid fa-circle-user"></i> <?= $_SESSION['Sessao']['Nome'] ?><br></span>
                <span id="clock"></span>
            </div>
            <a class="btn btn-danger my-2 my-sm-0" href="<?= base_url('home/logout') ?>"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</a>
        </div>
    </div>
</nav>

<input type="hidden" name="timeout" value="<?= env('huap.session.expires') ?>" />
