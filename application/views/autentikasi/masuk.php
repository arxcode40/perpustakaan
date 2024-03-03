<div class="container d-grid min-vh-100 py-3">
	<form action="" class="card m-auto" method="post">
		<h5 class="card-header">
			<i class="bi bi-box-arrow-in-right"></i> Masuk
		</h5>
		<div class="card-body">
			<!-- Alert -->
			<?php if($this->session->flashdata('alert')): ?>
				<div class="alert alert-<?= $this->session->flashdata('alert')['status'] ?> alert-dismissible fade show">
					<i class="bi <?= $this->session->flashdata('alert')['icon'] ?>"></i>
					<span class="ms-2"><?= $this->session->flashdata('alert')['text'] ?></span>
					<button class="btn-close" data-bs-dismiss="alert" type="button"></button>
				</div>
			<?php endif; ?>

			<!-- Login Form -->
			<div class="g-3 row">
				<div class="col-12">
					<label class="form-label" for="formUser">
						Nama pengguna<b class="fs-5 text-danger">&#x002a;</b>
					</label>
					<input autocapitalize="off" autofocus class="form-control" id="formUser" maxlength="16" name="nama_pengguna" oninput="filterUsername()" placeholder="Masukkan nama pengguna" required type="text" value="<?= set_value('nama_pengguna') ?>">
					<div class="text-danger">
						<?= form_error('nama_pengguna', '<small>', '</small>') ?>
					</div>
				</div>

				<div class="col-12">
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
			</div>
		</div>
		<div class="card-footer">
			<button class="btn btn-primary" type="submit">
				<i class="bi bi-box-arrow-in-right"></i> Masuk
			</button>
			<a class="btn btn-outline-primary" href="<?= base_url('autentikasi/daftar') ?>">
				<i class="bi bi-person-plus-fill"></i> Daftar
			</a>
		</div>
	</form>
</div>