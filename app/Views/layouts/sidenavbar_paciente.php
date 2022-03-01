<a href="<?= base_url('prescricao/show_paciente/'.$_SESSION['Paciente']['nome']) ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <span class="fs-5"><?= $_SESSION['Paciente']['nome'] ?></span>
</a>
<span class="fs-6">Prontuário: <?= $_SESSION['Paciente']['prontuario'] ?></span>
<hr>
<ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
        <a href="<?= base_url('prescricao/list_prescricao/'.$_SESSION['Paciente']['codigo']) ?>" class="nav-link" aria-current="page">
            <i class="fa-solid fa-chalkboard-user"></i> Perfil
        </a>
    </li>
    <li>

    </li>
</ul>
