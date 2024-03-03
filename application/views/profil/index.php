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
			<i class="bi bi-person-circle"></i> Profil Saya
		</h1>

		<nav class="mb-0">
			<ul class="breadcrumb">
				<li class="breadcrumb-item">
					<a class="link-body-emphasis text-decoration-none" href="<?= base_url() ?>">
						<i class="bi bi-house-door-fill"></i> Beranda
					</a>
				</li>
				<li class="active breadcrumb-item">
					<i class="bi bi-person-circle"></i> Profil Saya
				</li>
			</ul>
		</nav>
	</header>

	<div class="g-3 row">
		<!-- Profil Pengguna -->
		<div class="col-md-6 col-lg-4">
			<form action="<?= base_url('profil/pengguna') ?>" class="card" method="post">
				<h5 class="card-header">Profil Pengguna</h5>
				<div class="card-body">
					<input name="kode_pengguna" type="hidden" value="<?= $profil->kode_pengguna ?>">
					<div class="g-3 row">
						<div class="col-6">
							<label class="form-label">Kode pengguna</label>
							<input class="form-control" disabled type="text" value="<?= $profil->kode_pengguna ?>">
						</div>

						<div class="col-6">
							<label class="form-label">Hak akses</label>
							<input class="form-control" disabled type="text" value="<?= $profil->status_pengguna ?>">
						</div>

						<div class="col-6">
							<label class="form-label" for="formUser">
								Nama pengguna<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<input autocapitalize="off" class="form-control" id="formUser" maxlength="16" name="nama_pengguna" oninput="filterUsername()" placeholder="Masukkan nama pengguna" required type="text" value="<?= $profil->nama_pengguna ?>">
						</div>

						<div class="col-6">
							<label class="form-label" for="formPass">
								Kata sandi<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<div class="input-group">
								<input class="form-control" id="formPass" maxlength="16" name="kata_sandi" placeholder="Masukkan kata sandi" required type="password" value="<?= $profil->kata_sandi ?>">
								<button class="btn btn-secondary" onclick="showPassword()" tabindex="-1" type="button">
									<i class="bi bi-eye-slash pe-none"></i>
								</button>
							</div>
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

		<!-- Profil Anggota -->
		<div class="col-md-6 col-lg-8">
			<form action="<?= base_url('profil/anggota') ?>" class="card" method="post">
				<h5 class="card-header">Detail Anggota</h5>
				<div class="card-body">
					<input name="kode_anggota" type="hidden" value="<?= $profil->kode_anggota ?>">
					<div class="g-3 row">
						<div class="col-6">
							<label class="form-label">Kode anggota</label>
							<input class="form-control" disabled type="text" value="<?= $profil->kode_anggota ?>">
						</div>

						<div class="col-6">
							<label class="form-label">Jumlah pinjam</label>
							<input class="form-control" disabled type="text" value="<?= $profil->jumlah_pinjam ?>">
						</div>

						<div class="col-lg-6">
							<label class="form-label" for="formName">
								Nama lengkap<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<input class="form-control" id="formName" maxlength="32" name="nama_lengkap" placeholder="Masukkan nama lengkap" required type="text" value="<?= $profil->nama_lengkap ?>">
						</div>

						<div class="col-lg-6">
							<label class="d-block mb-lg-3 form-label" for="formGender">
								Jenis kelamin<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<div class="form-check form-check-inline">
								<input <?= $profil->jenis_kelamin === 'Laki-laki' ? 'checked' : '' ?> class="form-check-input" id="formGenderMale" name="jenis_kelamin" required type="radio" value="Laki-laki">
								<label class="form-check-label" for="formGenderMale">Laki-laki</label>
							</div>
							<div class="form-check form-check-inline">
								<input <?= $profil->jenis_kelamin === 'Perempuan' ? 'checked' : '' ?> class="form-check-input" id="formGenderFemale" name="jenis_kelamin" required type="radio" value="Perempuan">
								<label class="form-check-label" for="formGenderFemale">Perempuan</label>
							</div>
						</div>

						<div class="col-6">
							<label class="form-label" for="formPlace">
								Tempat lahir<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<input class="form-control" id="formPlace" maxlength="16" name="tempat_lahir" placeholder="Masukkan tempat lahir" required type="text" value="<?= $profil->tempat_lahir ?>">
						</div>

						<div class="col-6">
							<label class="form-label" for="formDate">
								Tanggal lahir<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<input class="form-control" id="formDate" min="<?= date('Y-m-d', 0) ?>" name="tanggal_lahir" placeholder="Masukkan tanggal lahir" required type="date" value="<?= $profil->tanggal_lahir ?>">
						</div>

						<div class="col-6">
							<label class="form-label" for="formPhone">Nomor telepon</label>
							<input class="form-control" id="formPhone" maxlength="13" name="nomor_telepon" placeholder="Masukkan nomor telepon" type="tel" value="<?= $profil->nomor_telepon ?>">
						</div>

						<div class="col-6">
							<label class="form-label">Status anggota</label>
							<input class="form-control" disabled type="text" value="<?= $profil->status_anggota ?>">
						</div>

						<div class="col-12">
							<label class="form-label" for="formAddress">Alamat</label>
							<textarea class="form-control" id="formAddress" maxlength="255" name="alamat" placeholder="Masukkan alamat"><?= $profil->alamat ?></textarea>
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