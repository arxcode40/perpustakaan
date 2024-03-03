<nav class="bg-body-tertiary navbar navbar-expand-lg sticky-top">
	<div class="container">
		<a class="align-items-center d-flex fw-medium navbar-brand text-primary" href="<?= base_url() ?>">
			<svg viewBox="0 0 512 512" width="24" xmlns="http://www.w3.org/2000/svg">
				<path d="M256 192A96 96 0 1 0 256 0a96 96 0 1 0 0 192z" fill="#6c757d"/>
				<path d="M240 512V248c-52.1-36.4-114.1-56-177.7-56H32c-17.7 0-32 14.3-32 32V427c0 16.4 12.5 30.2 28.8 31.8l96 9.6c23.2 2.3 45.9 8.9 66.8 19.3L240 512zm32 0l48.4-24.2c20.9-10.4 43.5-17 66.8-19.3l96-9.6c16.4-1.6 28.8-15.4 28.8-31.8V224c0-17.7-14.3-32-32-32H449.7c-63.6 0-125.6 19.6-177.7 56V512z" fill="#0d6efd"/>
			</svg>
			&nbsp;<?= $this->pengaturan_model->get()->nama_aplikasi ?>
		</a>
		<button class="navbar-toggler" data-bs-target="#navbarCollapse" data-bs-toggle="collapse" type="button">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="ms-auto navbar-nav">
				<li class="nav-item">
					<a class="<?= $active === 'dashboard' ? 'active' : '' ?> nav-link" href="<?= base_url() ?>">
						<i class="bi bi-speedometer"></i> Dashboard
					</a>
				</li>
				<li class="dropdown nav-item">
					<a class="<?= in_array($active, array('anggota', 'buku', 'peminjaman', 'pengembalian')) ? 'active' : '' ?> dropdown-toggle nav-link" data-bs-toggle="dropdown" href="">
						<i class="bi bi-database-fill"></i> Data Master
					</a>
					<ul class="dropdown-menu">
						<li>
							<h6 class="dropdown-header">
								<i class="bi bi-database-fill"></i> Data Master
							</h6>
						</li>
						<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
							<li>
								<a class="<?= $active === 'anggota' ? 'active' : '' ?> dropdown-item" href="<?= base_url('anggota') ?>">
									<i class="bi bi-person-fill"></i> Data Anggota
								</a>
							</li>
						<?php endif ?>
						<li>
							<a class="<?= $active === 'buku' ? 'active' : '' ?> dropdown-item" href="<?= base_url('buku') ?>">
								<i class="bi bi-journal-richtext"></i> Data Buku
							</a>
						</li>
						<li>
							<a class="<?= $active === 'peminjaman' ? 'active' : '' ?> dropdown-item" href="<?= base_url('peminjaman') ?>">
								<i class="bi bi-journal-arrow-up"></i> Data Peminjaman
							</a>
						</li>
						<li>
							<a class="<?= $active === 'pengembalian' ? 'active' : '' ?> dropdown-item" href="<?= base_url('pengembalian') ?>">
								<i class="bi bi-journal-arrow-down"></i> Data Pengembalian
							</a>
						</li>
					</ul>
				</li>
				<li class="dropdown nav-item">
					<a class="<?= in_array($active, array('profil', 'pengaturan')) ? 'active' : '' ?> dropdown-toggle nav-link" data-bs-toggle="dropdown" href="">
						<i class="bi bi-person-circle"></i> <?= $this->session->userdata('auth')->nama_lengkap ?>
					</a>
					<ul class="dropdown-menu">
						<li>
							<h6 class="dropdown-header">
								<i class="bi bi-person-circle"></i> <?= $this->session->userdata('auth')->nama_lengkap ?>
							</h6>
						</li>
						<li>
							<a class="<?= $active === 'profil' ? 'active' : '' ?> dropdown-item" href="<?= base_url('profil') ?>">
								<i class="bi bi-person-fill"></i> Profil Saya
							</a>
						</li>
						<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
							<li>
								<a class="<?= $active === 'pengaturan' ? 'active' : '' ?> dropdown-item" href="<?= base_url('pengaturan') ?>">
									<i class="bi bi-gear-fill"></i> Pengaturan
								</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
						<?php endif ?>
						<li>
							<a class="dropdown-item" href="<?= base_url('autentikasi/keluar') ?>">
								<i class="bi bi-box-arrow-right"></i> Keluar
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>