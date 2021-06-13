<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
	<a class="navbar-brand mr-1" href="/admin">QUIZY</a>

	<button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
		<i class="fas fa-bars"></i>
	</button>

	<a href="/" class="btn btn-secondary ml-2"><?= lang('admin/Templates.goBack') ?></a>

	<!-- Navbar language -->
	<form action="/language" method="get" id="language-form"
			class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
		<div class="input-group">
			<div class="input-group-prepend">
				<label class="input-group-text" for="language"><?= lang('General.language') ?></label>
			</div>
			<select class="custom-select" id="language" name="language">
				<?php foreach(config('Quizy')->locales as $lang => $language): ?>
					<option <?= session('language')==$lang ? 'selected':'' ?> value="<?= $lang ?>"><?= $language ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</form>

	<!-- Navbar -->
	<ul class="navbar-nav ml-auto ml-md-0">
		<li class="nav-item dropdown no-arrow">
			<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-user-circle fa-fw"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
				<a class="dropdown-item" href="/logout"><?= lang('Home.logout') ?></a>
			</div>
		</li>
	</ul>
</nav>

<script>
	$("#language").change(function() {
		$("#language-form").submit();
	});
</script>