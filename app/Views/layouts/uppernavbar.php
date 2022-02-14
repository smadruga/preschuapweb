<?php $session = \Config\Services::session(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('admin') ?>"><?= HUAP_APPNAME ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <form class="d-inline-flex">
                <input class="form-control me-sm-2" type="text" placeholder="Nome, prontuário...">
                <button class="btn btn-info my-2 my-sm-0" style="width: 150px" type="submit"><i class="fa-solid fa-search"></i> Buscar</button>
            </form>
            <div style="padding: 0px 10px 0px 10px;" ></div>
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home
                        <span class="visually-hidden">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Configurações</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= base_url('admin/find_user') ?>"><i class="fas fa-user"></i> Gerenciar Usuário</a>
                        <!--<div class="dropdown-divider"></div>-->
                    </div>
                </li>
            </ul>
            <div style="padding: 0px 10px 0px 10px;">
                <span class="text-warning fs-6">
                    <i class="fa-solid fa-circle-user"></i> <?= $_SESSION['Sessao']['Nome'] ?><br>
                    Sessão: <b><div id="defaultCountdown"></div></b> <i class="fa-solid fa-hourglass"></i> 
                    </span>
            </div>
            <a class="btn btn-danger my-2 my-sm-0" href="<?= base_url('home/logout') ?>"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</a>
        </div>
    </div>
</nav>
