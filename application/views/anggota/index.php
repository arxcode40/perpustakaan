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
			<i class="bi bi-person-fill"></i> Data Anggota
		</h1>

		<nav class="mb-0">
			<ul class="breadcrumb">
				<li class="breadcrumb-item">
					<a class="link-body-emphasis text-decoration-none" href="<?= base_url() ?>">
						<i class="bi bi-house-door-fill"></i> Beranda
					</a>
				</li>
				<li class="active breadcrumb-item">
					<i class="bi bi-person-fill"></i> Data Anggota
				</li>
			</ul>
		</nav>
	</header>

	<!-- Data Table -->
	<div class="card">
		<div class="align-items-center card-header d-flex">
			<h5 class="mb-0">
				<i class="bi bi-table me-2"></i> Tabel Anggota
			</h5>
			<button class="btn btn-primary btn-sm ms-auto" data-bs-target="#insertModal" data-bs-toggle="modal" type="button">
				<i class="bi bi-plus-lg"></i>
				<span class="d-none d-sm-inline-block">Tambah Data</span>
			</button>
			<a class="btn btn-warning btn-sm ms-2" href="<?= base_url('anggota/laporan') ?>" target="_blank">
				<i class="bi bi-printer-fill"></i>
				<span class="d-none d-sm-inline-block">Cetak Laporan</span>
			</a>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="align-middle mb-0 table table-bordered table-hover table-striped w-100" id="dataTable">
					<thead>
						<tr class="align-middle">
							<th>#</th>
							<th>Kode Anggota</th>
							<th>Nama Lengkap</th>
							<th>Jenis Kelamin</th>
							<th>Tempat, Tanggal Lahir</th>
							<th>Hak Akses</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 0 ?>
						<?php $jenis = array('Administrator' => 'primary', 'Anggota' => 'secondary') ?>
						<?php $status = array('Terverifikasi' => 'success', 'Terdaftar' => 'danger') ?>
						<?php foreach($data_anggota as $anggota): ?>
							<tr class="table-<?= $status[$anggota->status_anggota] ?>">
								<td><?= ++$i ?></td>
								<td><?= $anggota->kode_anggota ?></td>
								<td><?= $anggota->nama_lengkap ?></td>
								<td><?= $anggota->jenis_kelamin ?></td>
								<td><?= $anggota->tempat_lahir ?>, <?= nice_date($anggota->tanggal_lahir, 'd-m-Y') ?></td>
								<td>
									<span class="bg-<?= $jenis[$anggota->jenis_anggota] ?> badge"><?= $anggota->jenis_anggota ?></span>
								</td>
								<td>
									<span class="bg-<?= $status[$anggota->status_anggota] ?> badge"><?= $anggota->status_anggota ?></span>
								</td>
								<td class="text-nowrap">
									<button class="btn btn-primary btn-sm" data-bs-target="#detailModal" data-bs-toggle="modal" onclick="detailAnggota('<?= $anggota->kode_anggota ?>')" type="button">
										<i class="bi bi-eye"></i> Lihat Detail
									</button>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Insert Modal -->
<div class="fade modal" id="insertModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<form action="<?= base_url('anggota/tambah') ?>" class="modal-content" method="post">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Anggota</h5>
				<button class="btn-close" data-bs-dismiss="modal" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="g-3 row">
					<div class="col-6">
						<label class="form-label" for="insertUser">
							Nama pengguna<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input autocapitalize="off" class="form-control" id="insertUser" maxlength="16" name="nama_pengguna" oninput="filterUsername()" placeholder="Masukkan nama pengguna" required type="text">
					</div>

					<div class="col-6">
						<label class="form-label" for="insertPass">
							Kata sandi<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<div class="input-group">
							<input class="form-control" id="insertPass" maxlength="16" name="kata_sandi" placeholder="Masukkan kata sandi" required type="password">
							<button class="btn btn-secondary" onclick="showPassword()" tabindex="-1" type="button">
								<i class="bi bi-eye-slash pe-none"></i>
							</button>
						</div>
					</div>

					<div class="col-12">
						<label class="d-block form-label" for="insertPrivileges">
							Hak akses<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<div class="form-check form-check-inline">
							<input checked class="form-check-input" id="insertPrivilegesAdmin" name="hak_akses" required type="radio" value="admin">
							<label class="form-check-label" for="insertPrivilegesAdmin">Administrator</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" id="insertPrivilegesUser" name="hak_akses" required type="radio" value="user">
							<label class="form-check-label" for="insertPrivilegesUser">Anggota</label>
						</div>
					</div>

					<div class="col-12">
						<label class="form-label" for="insertName">
							Nama lengkap<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" id="insertName" maxlength="32" name="nama_lengkap" placeholder="Masukkan nama lengkap" required type="text">
					</div>

					<div class="col-12">
						<label class="d-block form-label" for="insertGender">
							Jenis kelamin<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<div class="form-check form-check-inline">
							<input checked class="form-check-input" id="insertGenderMale" name="jenis_kelamin" required type="radio" value="Laki-laki">
							<label class="form-check-label" for="insertGenderMale">Laki-laki</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" id="insertGenderFemale" name="jenis_kelamin" required type="radio" value="Perempuan">
							<label class="form-check-label" for="insertGenderFemale">Perempuan</label>
						</div>
					</div>

					<div class="col-6">
						<label class="form-label" for="insertPlace">
							Tempat lahir<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" id="insertPlace" maxlength="16" name="tempat_lahir" placeholder="Masukkan tempat lahir" required type="text">
					</div>

					<div class="col-6">
						<label class="form-label" for="insertDate">
							Tanggal lahir<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" id="insertDate" min="<?= date('Y-m-d', 0) ?>" name="tanggal_lahir" required type="date" value="<?= date('Y-m-d') ?>">
					</div>

					<div class="col-12">
						<label class="form-label" for="insertAddress">Alamat</label>
						<textarea class="form-control" id="insertAddress" maxlength="255" name="alamat" placeholder="Masukkan alamat"></textarea>
					</div>

					<div class="col-12">
						<label class="form-label" for="insertPhone">Nomor telepon</label>
						<input class="form-control" id="insertPhone" maxlength="13" name="nomor_telepon" placeholder="Masukkan nomor telepon" type="tel">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-bs-dismiss="modal" type="reset">
					<i class="bi bi-x-lg"></i> Batal
				</button>
				<button class="btn btn-primary" type="submit">
					<i class="bi bi-plus-lg"></i> Tambah
				</button>
			</div>
		</form>
	</div>
</div>

<!-- Detail Modal -->
<div class="fade modal" id="detailModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<form action="<?= base_url('anggota/ubah') ?>" class="modal-content" method="post">
			<div class="modal-header">
				<h5 class="modal-title">Detail Anggota</h5>
				<button class="btn-close" data-bs-dismiss="modal" type="button"></button>
			</div>
			<div class="modal-body">
				<input id="detailId" maxlength="5" name="kode_anggota" type="hidden">
				<div class="g-3 row">
					<div class="col-6">
						<label class="form-label">Kode anggota</label>
						<input class="form-control" disabled id="detailCode" type="text">
					</div>

					<div class="col-6">
						<label class="form-label">Jumlah pinjam</label>
						<input class="form-control" disabled id="detailAmount" type="number">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailUser">
							Nama pengguna<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input autocapitalize="off" class="form-control" id="detailUser" maxlength="16" name="nama_pengguna" oninput="filterUsername()" placeholder="Masukkan nama pengguna" required type="text">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailPass">
							Kata sandi<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<div class="input-group">
							<input class="form-control" id="detailPass" maxlength="16" name="kata_sandi" placeholder="Masukkan kata sandi" required type="password">
							<button class="btn btn-secondary" onclick="showPassword()" tabindex="-1" type="button">
								<i class="bi bi-eye-slash pe-none"></i>
							</button>
						</div>
					</div>

					<div class="col-12">
						<label class="d-block form-label" for="detailPrivileges">
							Hak akses<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<div class="form-check form-check-inline">
							<input class="form-check-input" id="detailPrivilegesAdmin" name="hak_akses" required type="radio" value="admin">
							<label class="form-check-label" for="detailPrivilegesAdmin">Administrator</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" id="detailPrivilegesUser" name="hak_akses" required type="radio" value="user">
							<label class="form-check-label" for="detailPrivilegesUser">Anggota</label>
						</div>
					</div>

					<div class="col-12">
						<label class="form-label" for="detailName">
							Nama lengkap<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" id="detailName" maxlength="32" name="nama_lengkap" placeholder="Masukkan nama lengkap" required type="text">
					</div>

					<div class="col-12">
						<label class="d-block form-label" for="detailGender">
							Jenis kelamin<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<div class="form-check form-check-inline">
							<input class="form-check-input" id="detailGenderMale" name="jenis_kelamin" required type="radio" value="Laki-laki">
							<label class="form-check-label" for="detailGenderMale">Laki-laki</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" id="detailGenderFemale" name="jenis_kelamin" required type="radio" value="Perempuan">
							<label class="form-check-label" for="detailGenderFemale">Perempuan</label>
						</div>
					</div>

					<div class="col-6">
						<label class="form-label" for="detailPlace">
							Tempat lahir<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" id="detailPlace" maxlength="16" name="tempat_lahir" placeholder="Masukkan tempat lahir" required type="text">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailDate">
							Tanggal lahir<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" id="detailDate" min="<?= date('Y-m-d', 0) ?>" name="tanggal_lahir" required type="date">
					</div>

					<div class="col-12">
						<label class="form-label" for="detailAddress">Alamat</label>
						<textarea class="form-control" id="detailAddress" maxlength="255" name="alamat" placeholder="Masukkan alamat"></textarea>
					</div>

					<div class="col-6">
						<label class="form-label" for="detailPhone">No. Telp</label>
						<input class="form-control" id="detailPhone" maxlength="13" name="nomor_telepon" placeholder="Masukkan nomor telepon" type="tel">
					</div>

					<div class="col-6">
						<label class="form-label">Status anggota</label>
						<input class="form-control" disabled id="detailStatus" type="text">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-danger" id="deleteAnggota" href="">
					<i class="bi bi-trash-fill"></i> Hapus
				</a>
				<button class="btn btn-secondary" data-bs-dismiss="modal" type="reset">
					<i class="bi bi-x-lg"></i> Batal
				</button>
				<button class="btn btn-primary" type="submit">
					<i class="bi bi-floppy-fill"></i> Simpan
				</button>
				<a class="btn btn-success" id="verifyAnggota" href="">
					<i class="bi bi-check2-circle"></i> Verifikasi
				</a>
			</div>
		</form>
	</div>
</div>