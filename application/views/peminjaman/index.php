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
			<i class="bi bi-journal-arrow-up"></i> Data Peminjaman
		</h1>

		<nav class="mb-0">
			<ul class="breadcrumb">
				<li class="breadcrumb-item">
					<a class="link-body-emphasis text-decoration-none" href="<?= base_url() ?>">
						<i class="bi bi-house-door-fill"></i> Beranda
					</a>
				</li>
				<li class="active breadcrumb-item">
					<i class="bi bi-journal-arrow-up"></i> Data Peminjaman
				</li>
			</ul>
		</nav>
	</header>

	<!-- Data Table -->
	<div class="card">
		<div class="align-items-center card-header d-flex">
			<h5 class="mb-0">
				<i class="bi bi-table me-2"></i> Tabel Peminjaman
			</h5>
			<?php if($this->session->userdata('auth')->status_anggota === 'Terverifikasi'): ?>
				<button class="btn btn-primary btn-sm ms-auto" data-bs-target="#insertModal" data-bs-toggle="modal" type="button">
					<i class="bi bi-plus-lg"></i>
					<span class="d-none d-sm-inline-block">Tambah Data</span>
				</button>
			<?php endif ?>
			<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
				<a class="btn btn-warning btn-sm ms-2" href="<?= base_url('peminjaman/laporan') ?>" target="_blank">
					<i class="bi bi-printer-fill"></i>
					<span class="d-none d-sm-inline-block">Cetak Laporan</span>
				</a>
			<?php endif ?>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="align-middle mb-0 table table-bordered table-hover table-striped w-100" id="dataTable">
					<thead>
						<tr class="align-middle">
							<th>#</th>
							<th>Kode Transaksi</th>
							<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
								<th>Nama Anggota</th>
							<?php endif ?>
							<th>Tanggal Pinjam</th>
							<th>Tanggal Kembali</th>
							<th>Judul Buku</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 0 ?>
						<?php $status = array('Terverifikasi' => 'success', 'Tertunda' => 'danger') ?>
						<?php foreach($data_peminjaman as $peminjaman): ?>
							<tr class="table-<?= $status[$peminjaman->status_peminjaman] ?>">
								<td><?= ++$i ?></td>
								<td><?= $peminjaman->kode_transaksi ?></td>
								<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
									<td><?= $peminjaman->nama_lengkap ?></td>
								<?php endif ?>
								<td><?= nice_date($peminjaman->tanggal_pinjam, 'd-m-Y') ?></td>
								<td><?= nice_date($peminjaman->tanggal_kembali, 'd-m-Y') ?></td>
								<td><?= $peminjaman->judul ?></td>
								<td>
									<span class="bg-<?= $status[$peminjaman->status_peminjaman] ?> badge"><?= $peminjaman->status_peminjaman ?></span>
								</td>
								<td class="text-nowrap">
									<button class="btn btn-primary btn-sm" data-bs-target="#detailModal" data-bs-toggle="modal" onclick="detailPeminjaman('<?= $peminjaman->kode_transaksi ?>')" type="button">
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
		<form action="<?= base_url('peminjaman/tambah') ?>" class="modal-content" method="post">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Peminjaman</h5>
				<button class="btn-close" data-bs-dismiss="modal" type="button"></button>
			</div>
			<div class="modal-body">
				<?php if($this->session->userdata('auth')->hak_akses !== 'admin'): ?>
					<input maxlength="5" name="kode_anggota" type="hidden" value="<?= $this->session->userdata('auth')->kode_anggota ?>">
				<?php endif ?>
				<div class="g-3 row">
					<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
						<div class="col-6">
							<label class="form-label" for="insertMember">
								Nama anggota<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<select class="form-select" id="insertMember" name="kode_anggota" required>
								<?php foreach($data_anggota as $anggota): ?>
									<option value="<?= $anggota->kode_anggota ?>"><?= $anggota->kode_anggota ?> &minus; <?= $anggota->nama_lengkap ?></option>
								<?php endforeach ?>
							</select>
						</div>
					<?php endif ?>

					<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
						<div class="col-6">
					<?php else: ?>
						<div class="col-12">
					<?php endif ?>
						<label class="form-label" for="insertBook">
							Judul buku<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<select class="form-select" id="insertBook" name="kode_buku" required>
							<?php foreach($data_buku as $buku): ?>
								<option value="<?= $buku->kode_buku ?>"><?= $buku->kode_buku ?> &minus; <?= $buku->judul ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="col-6">
						<label class="form-label" for="insertLoan">
							Tanggal pinjam<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" id="insertLoan" min="<?= date('Y-m-d', 0) ?>" name="tanggal_pinjam" required type="date" value="<?= date('Y-m-d') ?>">
					</div>

					<div class="col-6">
						<label class="form-label" for="insertReturn">
							Tanggal kembali<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" id="insertReturn" min="<?= date('Y-m-d', 0) ?>" name="tanggal_kembali" required type="date" value="<?= date('Y-m-d') ?>">
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
		<form action="<?= base_url('peminjaman/ubah') ?>" class="modal-content" method="post">
			<div class="modal-header">
				<h5 class="modal-title">Detail Peminjaman</h5>
				<button class="btn-close" data-bs-dismiss="modal" type="button"></button>
			</div>
			<div class="modal-body">
				<input id="detailId" maxlength="5" name="kode_transaksi" type="hidden">
				<?php if($this->session->userdata('auth')->hak_akses !== 'admin'): ?>
					<input maxlength="5" name="kode_anggota" type="hidden" value="<?= $this->session->userdata('auth')->kode_anggota ?>">
				<?php endif ?>
				<div class="g-3 row">
					<div class="col-6">
						<label class="form-label">Kode transaksi</label>
						<input class="form-control" disabled id="detailCode" type="text">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailStatus">Status</label>
						<input class="form-control" disabled id="detailStatus" type="text">
					</div>

					<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
						<div class="col-6">
							<label class="form-label" for="detailMember">
								Nama anggota<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<select class="form-select" id="detailMember" name="kode_anggota" required>
								<?php foreach($data_anggota as $anggota): ?>
									<option value="<?= $anggota->kode_anggota ?>"><?= $anggota->kode_anggota ?> &minus; <?= $anggota->nama_lengkap ?></option>
								<?php endforeach ?>
							</select>
						</div>
					<?php endif ?>

					<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
						<div class="col-6">
					<?php else: ?>
						<div class="col-12">
					<?php endif ?>
						<label class="form-label" for="detailBook">
							Judul buku<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<select class="form-select" id="detailBook" name="kode_buku" required>
							<option></option>
							<?php foreach($data_buku as $buku): ?>
								<option value="<?= $buku->kode_buku ?>"><?= $buku->kode_buku ?> &minus; <?= $buku->judul ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="col-6">
						<label class="form-label" for="detailLoan">
							Tanggal pinjam<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" id="detailLoan" min="<?= date('Y-m-d', 0) ?>" name="tanggal_pinjam" required type="date">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailReturn">
							Tanggal kembali<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" id="detailReturn" min="<?= date('Y-m-d', 0) ?>" name="tanggal_kembali" required type="date">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
					<a class="btn btn-danger" id="deletePeminjaman" href="">
						<i class="bi bi-trash-fill"></i> Hapus
					</a>
				<?php endif ?>
				<button class="btn btn-secondary" data-bs-dismiss="modal" type="reset">
					<i class="bi bi-x-lg"></i> Batal
				</button>
				<?php if($this->session->userdata('auth')->status_anggota === 'Terverifikasi'): ?>
					<button class="btn btn-primary" type="submit">
						<i class="bi bi-floppy-fill"></i> Simpan
					</button>
				<?php endif ?>
				<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
					<a class="btn btn-success" id="verifyTransaksi" href="">
						<i class="bi bi-check2-circle"></i> Verifikasi
					</a>
				<?php endif ?>
			</div>
		</form>
	</div>
</div>