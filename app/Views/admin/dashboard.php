<?= $this->extend("admin/templates/base") ?>


<?= $this->section('title') ?>
	<?= lang('General.dashboard') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="/admin"><?= lang('General.dashboard') ?></a>
	</li>
	<li class="breadcrumb-item active"></li>
</ol>

<div class="row mb-2">
	<div class="col-xl-3 col-sm-6 mb-1">
		<div class="card text-white bg-primary o-hidden h-100">
			<div class="card-body">
				<h5 class="mb-0"><?= esc($statistics['users']) ?> <?= lang('General.user') ?></h5>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-sm-6 mb-1">
		<div class="card text-white bg-success o-hidden h-100">
			<div class="card-body">
				<h5 class="mb-0"><?= esc($statistics['teams']) ?> <?= lang('General.team') ?></h5>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-sm-6 mb-1">
		<div class="card text-white bg-warning o-hidden h-100">
			<div class="card-body">
				<h5 class="mb-0"><?= esc($statistics['submissions']) ?> <?= lang('General.submission') ?></h5>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-sm-6 mb-1">
		<div class="card text-white bg-danger o-hidden h-100">
			<div class="card-body">
				<h5 class="mb-0"><?= esc($statistics['solves']) ?> <?= lang('General.solve') ?></h5>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>