<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item">
			<a href="/admin/challenges"><?= lang('General.challenges') ?></a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Challenge.addChallenge') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Challenge.addChallenge') ?></div>
		<div class="card-body">
			<?php if(! empty($errors)): ?>
				<?php foreach($errors as $key => $message): ?>
				<div class="alert alert-danger" role="alert">
					<?= $message ?>
				</div>
				<?php endforeach ?>
			<?php endif; ?>

			<form action="/admin/challenges" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="category_id"><?= lang('admin/Challenge.selectCategory') ?></label>
					<select name="category_id" class="form-control" id="category_id">
						<?php foreach($categories as $category): ?>
							<option value="<?= esc($category['id']) ?>"><?= esc($category['name']) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="name"><?= lang('General.name') ?></label>
					<input type="name" name="name" class="form-control" id="name" value="<?= old('name') ?>">
				</div>
				<div class="form-group">
					<label for="description"><?= lang('General.description') ?></label>
					<textarea class="form-control" name="description" id="description" rows="3"><?= old('description') ?></textarea>
				</div>
				<div class="form-group">
					<label for="point"><?= lang('General.point') ?></label>
					<input type="number" name="point" class="form-control" id="point" value="<?= old('point') ?>">
				</div>
				<div class="form-group">
					<label for="max_attempts"><?= lang('admin/Challenge.maxAttempt') ?></label>
					<input type="number" name="max_attempts" class="form-control" id="max_attempts" value="<?= old('max_attempts') ?>">
				</div>
				<div class="form-group">
					<label for="type"><?= lang('admin/Challenge.type') ?></label>
					<select name="type" class="form-control" id="type">
						<option value="static"><?= lang('admin/Challenge.static') ?></option>
						<option value="dynamic"><?= lang('admin/Challenge.dynamic') ?></option>
					</select>
				</div>
				<div class="form-group">
					<label for="is_active"><?= lang('admin/Challenge.status') ?></label>
					<select name="is_active" class="form-control" id="is_active">
						<option value="0"><?= lang('admin/Challenge.passive') ?></option>
						<option value="1"><?= lang('admin/Challenge.active') ?></option>
					</select>
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/Challenge.addChallenge') ?></button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>
