<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title><?= $this->renderSection("title") ?> · QUIZY</title>

	<link rel="stylesheet" href="/lib/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="/lib/DataTables/datatables.min.css">
	<link rel="stylesheet" href="/lib/sb-admin/css/sb-admin.min.css">
	<link rel="stylesheet" href="/css/admin.css">
	<script src="/lib/jquery/jquery-3.4.1.min.js"></script>
</head>

<body id="page-top">
	<?= $this->include('admin/templates/header') ?>

	<div id="wrapper">
		<!-- Sidebar -->
		<?= $this->include('admin/templates/sidebar') ?>

		<div id="content-wrapper">
			<div class="container-fluid">
				<?= $this->renderSection("content") ?>
			</div>

			<!-- Sticky Footer -->
			<?= $this->include('admin/templates/footer') ?>
		</div>
	</div>

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Bootstrap core JavaScript-->
	<script src="/lib/popper/popper.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>

	<!-- Core plugin JavaScript-->
	<!-- <script src="vendor/jquery-easing/jquery.easing.min.js"></script> -->

	<!-- Page level plugin JavaScript-->
	<script src="/lib/Chart/Chart.min.js"></script>
	<script src="/lib/DataTables/datatables.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="/lib/sb-admin/js/sb-admin.min.js"></script>
	<script src="/js/admin.js"></script>
</body>

</html>
