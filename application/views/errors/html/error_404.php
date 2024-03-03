<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!doctype html>
<html data-bs-theme="dark" lang="id">
<head>
	<meta charset="utf-8">
	<meta content="initial-scale=1.0, width=device-width" name="viewport">
	<meta content="ie=edge" http-equiv="X-UA-Compatible">
	<base href="http://localhost/perpustakaan/">
	<link href="assets/img/logo.svg'" rel="apple-touch-icon">
	<link href="assets/img/logo.svg" rel="icon shortcut">
	<title><?= $heading ?></title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="align-items-center container-fluid d-flex flex-column justify-content-center min-vh-100">
	<div class="display-1 mb-3"><?= $heading ?></div>
	<h3 class="mb-3"><?= $message ?></h3>
	<a class="btn btn-primary" href="">
		Back Home <i class="bi bi-arrow-right"></i>
	</a>
</body>
</html>