<?= $this->extend('layouts/main_content') ?>
<?= $this->section('subcontent') ?>

<main class="container">
<div class="container">
    <div class="d-flex justify-content-between my-3">
        <a href="<?= site_url("calendar/index/{$prevMonth['year']}/{$prevMonth['month']}") ?>" class="btn btn-primary">
            <i class="fas fa-chevron-left"></i> Mês Anterior
        </a>
        <h3><?= DateTime::createFromFormat('!m', $month)->format('F') ?>, <?= $year ?></h3>
        <a href="<?= site_url("calendar/index/{$nextMonth['year']}/{$nextMonth['month']}") ?>" class="btn btn-primary">
            Próximo Mês <i class="fas fa-chevron-right"></i>
        </a>
    </div>

    <div class="calendar">
        <div class="calendar-header">Dom</div>
        <div class="calendar-header">Seg</div>
        <div class="calendar-header">Ter</div>
        <div class="calendar-header">Qua</div>
        <div class="calendar-header">Qui</div>
        <div class="calendar-header">Sex</div>
        <div class="calendar-header">Sáb</div>

        <?php
        for ($i = 0; $i < $dayOfWeek; $i++): ?>
            <div class="calendar-day hidden"></div>
        <?php endfor; ?>

        <?php
        for ($day = 1; $day <= $daysInMonth; $day++): ?>
            <div class="calendar-day"><?= $day ?></div>
        <?php endfor; ?>
    </div>
</div>
</main>

<?= $this->endSection() ?>
