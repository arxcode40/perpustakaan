<div class="container py-3">
	<!-- Alert -->
	<?php if($this->session->flashdata('alert')): ?>
		<div class="alert alert-<?= $this->session->flashdata('alert')['status'] ?> alert-dismissible fade show">
			<i class="bi <?= $this->session->flashdata('alert')['icon'] ?>"></i>
			<span class="ms-2"><?= $this->session->flashdata('alert')['text'] ?></span>
			<button class="btn-close" data-bs-dismiss="alert" type="button"></button>
		</div>
	<?php endif; ?>

	<!-- Header -->
	<header class="mb-3">
		<h1 class="mb-0">
			<i class="bi bi-speedometer"></i> Dashboard
		</h1>

		<nav class="mb-0">
			<ul class="breadcrumb">
				<li class="breadcrumb-item">
					<a class="link-body-emphasis text-decoration-none" href="<?= base_url() ?>">
						<i class="bi bi-house-door-fill"></i> Beranda
					</a>
				</li>
				<li class="active breadcrumb-item">
					<i class="bi bi-speedometer"></i> Dashboard
				</li>
			</ul>
		</nav>
	</header>

	<!-- Monitor -->
	<div class="g-3 row">
		<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
			<div class="col-sm-6 col-md-4 col-lg-3">
				<div class="card">
					<div class="card-body">
						<div class="g-3 row">
							<div class="col">
								<h3 class="card-title"><?= $total_anggota ?></h3>
								<p class="card-text">Anggota</p>
							</div>
							<div class="col">
								<svg xmlns="http://www.w3.org/2000/svg" width="48" fill="currentColor" class="bi bi-person-fill d-block ms-auto" viewBox="0 0 16 16">
								  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
								</svg>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<a class="icon-link icon-link-hover" href="<?= base_url('anggota') ?>">
							Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
						</a>
					</div>
				</div>
			</div>
		<?php endif ?>

		<div class="col-sm-6 col-md-4 col-lg-3">
			<div class="card">
				<div class="card-body">
					<div class="g-3 row">
						<div class="col">
							<h3 class="card-title"><?= $total_buku ?></h3>
							<p class="card-text">Buku</p>
						</div>
						<div class="col">
							<svg xmlns="http://www.w3.org/2000/svg" width="48" fill="currentColor" class="bi bi-journal-richtext d-block ms-auto" viewBox="0 0 16 16">
								<path d="M7.5 3.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0m-.861 1.542 1.33.886 1.854-1.855a.25.25 0 0 1 .289-.047L11 4.75V7a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 7v-.5s1.54-1.274 1.639-1.208M5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
								<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/><path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
							</svg>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<a class="icon-link icon-link-hover" href="<?= base_url('buku') ?>">
						Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
					</a>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-md-4 col-lg-3">
			<div class="card">
				<div class="card-body">
					<div class="g-3 row">
						<div class="col">
							<h3 class="card-title"><?= $total_peminjaman ?></h3>
							<p class="card-text">Peminjaman</p>
						</div>
						<div class="col">
							<svg xmlns="http://www.w3.org/2000/svg" width="48" fill="currentColor" class="bi bi-journal-arrow-up d-block ms-auto" viewBox="0 0 16 16">
								<path fill-rule="evenodd" d="M8 11a.5.5 0 0 0 .5-.5V6.707l1.146 1.147a.5.5 0 0 0 .708-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L7.5 6.707V10.5a.5.5 0 0 0 .5.5"/>
								<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
								<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
							</svg>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<a class="icon-link icon-link-hover" href="<?= base_url('peminjaman') ?>">
						Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
					</a>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-md-4 col-lg-3">
			<div class="card">
				<div class="card-body">
					<div class="g-3 row">
						<div class="col">
							<h3 class="card-title"><?= $total_pengembalian ?></h3>
							<p class="card-text">Pengembalian</p>
						</div>
						<div class="col">
							<svg xmlns="http://www.w3.org/2000/svg" width="48" fill="currentColor" class="bi bi-journal-arrow-down d-block ms-auto" viewBox="0 0 16 16">
								<path fill-rule="evenodd" d="M8 5a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5A.5.5 0 0 1 8 5"/>
								<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
								<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
							</svg>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<a class="icon-link icon-link-hover" href="<?= base_url('pengembalian') ?>">
						Lihat Selengkapnya <i class="bi bi-arrow-right"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>