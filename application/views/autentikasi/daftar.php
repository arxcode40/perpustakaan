<div class="container d-grid min-vh-100 py-3">
	<form action="" class="card m-auto" method="post">
		<h5 class="card-header">
			<i class="bi bi-person-plus-fill"></i> Daftar
		</h5>
		<div class="card-body">
			<input name="hak_akses" type="hidden" value="user">
			<!-- Alert -->
			<?php if($this->session->flashdata('alert')): ?>
				<div class="alert alert-<?= $this->session->flashdata('alert')['status'] ?> alert-dismissible fade show">
					<i class="bi <?= $this->session->flashdata('alert')['icon'] ?>"></i>
					<span class="ms-2"><?= $this->session->flashdata('alert')['text'] ?></span>
					<button class="btn-close" data-bs-dismiss="alert" type="button"></button>
				</div>
			<?php endif; ?>

			<!-- Registration Form -->
			<div class="g-3 row">
				<div class="col-6">
					<label class="form-label" for="formUser">
						Nama pengguna<b class="fs-5 text-danger">&#x002a;</b>
					</label>
					<input autocapitalize="off" autofocus class="form-control" id="formUser" maxlength="16" name="nama_pengguna" oninput="filterUsername()" placeholder="Masukkan nama pengguna" required type="text" value="<?= set_value('nama_pengguna') ?>">
					<div class="text-danger">
						<?= form_error('nama_pengguna', '<small>', '</small>') ?>
					</div>
				</div>

				<div class="col-6">
					<label class="form-label" for="formPass">
						Kata sandi<b class="fs-5 text-danger">&#x002a;</b>
					</label>
					<div class="input-group">
						<input class="form-control" id="formPass" maxlength="16" name="kata_sandi" placeholder="Masukkan kata sandi" required type="password" value="<?= set_value('kata_sandi') ?>">
						<button class="btn btn-secondary" onclick="showPassword()" tabindex="-1" type="button">
							<i class="bi bi-eye-slash pe-none"></i>
						</button>
					</div>
					<div class="text-danger">
						<?= form_error('kata_sandi', '<small>', '</small>') ?>
					</div>
				</div>

				<div class="col-6">
					<label class="form-label" for="formName">
						Nama lengkap<b class="fs-5 text-danger">&#x002a;</b>
					</label>
					<input class="form-control" id="formName" maxlength="32" name="nama_lengkap" placeholder="Masukkan nama lengkap" required type="text" value="<?= set_value('nama_lengkap') ?>">
					<div class="text-danger">
						<?= form_error('nama_lengkap', '<small>', '</small>') ?>
					</div>
				</div>

				<div class="col-6">
					<label class="d-block mb-lg-3 form-label" for="formGender">
						Jenis kelamin<b class="fs-5 text-danger">&#x002a;</b>
					</label>
					<div class="form-check form-check-inline">
						<input <?= set_radio('jenis_kelamin', 'Laki-laki', TRUE) ?> class="form-check-input" id="formGenderMale" name="jenis_kelamin" required type="radio" value="Laki-laki">
						<label class="form-check-label" for="formGenderMale">Laki-laki</label>
					</div>
					<div class="form-check form-check-inline">
						<input <?= set_radio('jenis_kelamin', 'Perempuan') ?> class="form-check-input" id="formGenderFemale" name="jenis_kelamin" required type="radio" value="Perempuan">
						<label class="form-check-label" for="formGenderFemale">Perempuan</label>
					</div>
					<div class="text-danger">
						<?= form_error('jenis_kelamin', '<small>', '</small>') ?>
					</div>
				</div>

				<div class="col-6">
					<label class="form-label" for="formPlace">
						Tempat lahir<b class="fs-5 text-danger">&#x002a;</b>
					</label>
					<input class="form-control" id="formPlace" maxlength="16" name="tempat_lahir" placeholder="Masukkan tempat lahir" required type="text" value="<?= set_value('tempat_lahir') ?>">
					<div class="text-danger">
						<?= form_error('tempat_lahir', '<small>', '</small>') ?>
					</div>
				</div>

				<div class="col-6">
					<label class="form-label" for="formDate">
						Tanggal lahir<b class="fs-5 text-danger">&#x002a;</b>
					</label>
					<input class="form-control" id="formDate" name="tanggal_lahir" required type="date"  value="<?= set_value('tanggal_lahir') ?>">
					<div class="text-danger">
						<?= form_error('tanggal_lahir', '<small>', '</small>') ?>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button class="btn btn-primary" type="submit">
				<i class="bi bi-person-plus-fill"></i> Daftar
			</button>
			<a class="btn btn-outline-primary" href="<?= base_url('autentikasi/masuk') ?>">
				<i class="bi bi-box-arrow-in-right"></i> Masuk
			</a>
		</div>
	</form>
</div>