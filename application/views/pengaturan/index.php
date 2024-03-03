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
			<i class="bi bi-gear-fill"></i> Pengaturan
		</h1>

		<nav class="mb-0">
			<ul class="breadcrumb">
				<li class="breadcrumb-item">
					<a class="link-body-emphasis text-decoration-none" href="<?= base_url() ?>">
						<i class="bi bi-house-door-fill"></i> Beranda
					</a>
				</li>
				<li class="active breadcrumb-item">
					<i class="bi bi-gear-fill"></i> Pengaturan
				</li>
			</ul>
		</nav>
	</header>

	<div class="g-3 row">
		<!-- Informasi Aplikasi -->
		<div class="col-md-6 col-lg-4">
			<div class="card">
				<h5 class="card-header">Informasi Aplikasi</h5>
				<div class="card-body">
					<dl class="mb-0">
						<dt>Nama aplikasi:</dt>
						<dd><?= $pengaturan->nama_aplikasi ?></dd>
						<dt>Nomor telepon:</dt>
						<dd><?= $pengaturan->nomor_telepon ?></dd>
						<dt>Email:</dt>
						<dd><?= $pengaturan->email ?></dd>
						<dt>Alamat:</dt>
						<dd><?= $pengaturan->alamat ?></dd>
						<dt>Denda telat:</dt>
						<dd>Rp<?= number_format($pengaturan->denda_telat, 2, ',', '.') ?></dd>
						<dt>Denda rusak:</dt>
						<dd>Rp<?= number_format($pengaturan->denda_rusak, 2, ',', '.') ?></dd>
						<dt>Denda hilang:</dt>
						<dd>Rp<?= number_format($pengaturan->denda_hilang, 2, ',', '.') ?></dd>
					</dl>
				</div>
			</div>
		</div>

		<!-- Detail Pengaturan -->
		<div class="col-md-6 col-lg-8">
			<form action="<?= base_url('pengaturan/simpan') ?>" class="card" method="post">
				<h5 class="card-header">Detail Pengaturan</h5>
				<div class="card-body">
					<div class="g-3 row">
						<div class="col-12">
							<label class="form-label" for="formName">
								Nama aplikasi<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<input class="form-control" id="formName" maxlength="16" name="nama_aplikasi" placeholder="Masukkan nama aplikasi" required type="text" value="<?= $pengaturan->nama_aplikasi ?>">
						</div>

						<div class="col-6">
							<label class="form-label" for="formPhone">Nomor telepon</label>
							<input class="form-control" id="formPhone" maxlength="13" name="nomor_telepon" placeholder="Masukkan nomor telepon" type="tel" value="<?= $pengaturan->nomor_telepon ?>">
						</div>

						<div class="col-6">
							<label class="form-label" for="formEmail">Email</label>
							<input class="form-control" id="formEmail" maxlength="32" name="email" placeholder="Masukkan email" type="email" value="<?= $pengaturan->email ?>">
						</div>

						<div class="col-12">
							<label class="form-label" for="formAddress">Alamat</label>
							<textarea class="form-control" id="formAddress" maxlength="255" name="alamat" placeholder="Masukkan alamat"><?= $pengaturan->alamat ?></textarea>
						</div>

						<div class="col-lg-4">
							<label class="form-label" for="formLate">
								Denda telat<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<input class="form-control" id="formLate" min="0" name="denda_telat" placeholder="Masukkan denda telat" required type="number" value="<?= $pengaturan->denda_telat ?>">
						</div>

						<div class="col-lg-4">
							<label class="form-label" for="formBroken">
								Denda rusak<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<input class="form-control" id="formBroken" min="0" name="denda_rusak" placeholder="Masukkan denda rusak" required type="number" value="<?= $pengaturan->denda_rusak ?>">
						</div>

						<div class="col-lg-4">
							<label class="form-label" for="formLost">
								Denda hilang<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<input class="form-control" id="formLost" min="0" name="denda_hilang" placeholder="Masukkan denda hilang" required type="number" value="<?= $pengaturan->denda_hilang ?>">
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-primary" type="submit">
						<i class="bi bi-floppy-fill"></i> Simpan
					</button>
					<button class="btn btn-secondary" type="reset">
						<i class="bi bi-x-lg"></i> Batal
					</button>
				</div>
			</form>
		</div>
	</div>
</div>