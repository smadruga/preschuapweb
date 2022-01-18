<?= $this->extend('layouts/main'); $this->section('title') ?>
Entrar <?= $this->endSection() ?>
<?= $this->section('content') ?>

<main class="form-signin">
    <form method="post" action="/home/login">
        <?= csrf_field() ?>

        <div class="form-floating alert alert-danger text-start" role="alert">
            <?= session()->getFlashdata('error') ?>
            <?= service('validation')->listErrors() ?>
        </div>

		<img class="mb-4" src="<?= base_url() ?>/assets/img/caduceus/caduceus-128.png" alt="">
		<h1 class="h3 mb-3 fw-normal"><?= HUAP_APPNAME ?></h1>

		<div class="form-floating">
			<input type="text" name="Usuario" class="form-control" id="floatingInput" placeholder="nome.sobrenome@ebserh.gov.br" value="<?= set_value('Usuario') ?>">
			<label for="floatingInput">Login EBSERH</label>
		</div>
		<div class="form-floating">
			<input type="password" name="Senha" class="form-control" id="floatingPassword" placeholder="Password" value="<?= set_value('Password') ?>">
			<label for="floatingPassword">Senha</label>
		</div>

		<div class="checkbox mb-3">
			<!--<label>
				<input type="checkbox" value="remember-me"> Remember me
			</label>-->
		</div>
		<button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
		<p class="mt-5 mb-3 text-muted">&copy; 2020 - <?= date('Y') ?></p>
	</form>
</main>

<?= $this->endSection() ?>

http://prescteste.com/admin
http://prescteste.com/home/login
