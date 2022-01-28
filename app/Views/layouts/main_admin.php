<!DOCTYPE html>
<html>
    <head>
        <title><?= HUAP_APPNAME ?></title>
        <meta charset="UTF-8">
        <meta name="description" content="PRESCHUAP WEB - Prescrição médica eletrônica de média e alta complexidade.">
        <meta name="author" content="Rodrigo Campos - rodrigopc@id.uff.br" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="theme-color" content="#7952b3">

        <!-- Styles and scripts -->
        <link href="<?= base_url('/assets/css/simple-datatables@latest-style.css') ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/css/bootswatch-flatly-bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('/assets/fontawesome-free-6.0.0-beta3-web/css/all.min.css') ?>" rel="stylesheet">

        <!-- Favicons -->
        <link href="<?= base_url('/favicon.ico') ?>" rel="shortcut icon" type="image/png"/>
        <link href="<?= base_url('/assets/img/caduceus/caduceus-128.png') ?>" sizes="180x180" rel="apple-touch-icon">
        <link href="<?= base_url('/assets/img/caduceus/caduceus-32.png') ?>" sizes="32x32" type="image/png" rel="icon">
        <link href="<?= base_url('/assets/img/caduceus/caduceus-16.png') ?>" sizes="16x16" type="image/png" rel="icon">
        <link href="<?= base_url('/favicon.ico') ?>" rel="icon">


    </head>
    <body>

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
                                <a class="dropdown-item" href="<?= base_url('admin/pesquisar') ?>"><i class="fas fa-upload"></i> Importar Usuário AD/EBSERH</a>
                                <a class="dropdown-item" href="<?= base_url('admin/gerenciar') ?>"><i class="fas fa-user"></i> Gerenciar Usuário</a>
                                <!--<div class="dropdown-divider"></div>-->
                            </div>
                        </li>
                    </ul>
                    <div style="padding: 0px 10px 0px 10px;">
                        <span class="text-warning"><i class="fa-solid fa-circle-user"></i> <?= $session->Usuario ?></span>
                    </div>
                    <a class="btn btn-danger my-2 my-sm-0" href="<?= base_url('home/logout') ?>"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</a>
                </div>
            </div>
        </nav>

        <?= $this->renderSection('content') ?>

        <script src="<?= base_url('/assets/bootstrap/dist/js/bootstrap.bundle.min.js') ?>" crossorigin="anonymous"></script>
        <script src="<?= base_url('/assets/js/jquery-3.6.0.min.js') ?>" crossorigin="anonymous"></script>

    </body>
</html>
