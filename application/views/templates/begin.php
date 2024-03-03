<!doctype html>
<html data-bs-theme="<?= $theme ?? 'dark' ?>" lang="id">
<head>
	<meta charset="utf-8">
	<meta content="initial-scale=1.0, width=device-width" name="viewport">
	<meta content="ie=edge" http-equiv="X-UA-Compatible">
	<link href="<?= base_url('assets/img/logo.svg') ?>" rel="apple-touch-icon">
	<link href="<?= base_url('assets/img/logo.svg') ?>" rel="icon shortcut">
	<title><?= $title ?? '' ?> | <?= $this->pengaturan_model->get()->nama_aplikasi ?></title>

	<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.13.11/css/dataTables.bootstrap5.min.css" rel="stylesheet">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.13.11/js/dataTables.bootstrap5.min.js"></script> -->
	<link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap-icons.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/dataTables.bootstrap5.min.css') ?>" rel="stylesheet">

	<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/dataTables.bootstrap5.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/index.js') ?>"></script>
</head>
<body class="d-flex flex-column min-vh-100">