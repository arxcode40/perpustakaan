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
			<i class="bi bi-journal-arrow-down"></i> Data Pengembalian
		</h1>

		<nav class="mb-0">
			<ul class="breadcrumb">
				<li class="breadcrumb-item">
					<a class="link-body-emphasis text-decoration-none" href="<?= base_url() ?>">
						<i class="bi bi-house-door-fill"></i> Beranda
					</a>
				</li>
				<li class="active breadcrumb-item">
					<i class="bi bi-journal-arrow-down"></i> Data Pengembalian
				</li>
			</ul>
		</nav>
	</header>

	<!-- Data Table -->
	<div class="card">
		<div class="align-items-center card-header d-flex">
			<h5 class="mb-0">
				<i class="bi bi-table me-2"></i> Tabel Pengembalian
			</h5>
			<?php if($this->session->userdata('auth')->status_anggota === 'Terverifikasi'): ?>
				<button class="btn btn-primary btn-sm ms-auto" data-bs-target="#insertModal" data-bs-toggle="modal" type="button">
					<i class="bi bi-plus-lg"></i>
					<span class="d-none d-sm-inline-block">Tambah Data</span>
				</button>
			<?php endif ?>
			<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
				<a class="btn btn-warning btn-sm ms-2" href="<?= base_url('pengembalian/laporan') ?>" target="_blank">
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
							<th>Tanggal Pengembalian</th>
							<th>Judul Buku</th>
							<th>Denda</th>
							<th>Keterangan</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 0 ?>
						<?php $status = array('Terverifikasi' => 'success', 'Tertunda' => 'danger') ?>
						<?php foreach($data_pengembalian as $pengembalian): ?>
							<tr class="table-<?= $status[$pengembalian->status_pengembalian] ?>">
								<td><?= ++$i ?></td>
								<td><?= $pengembalian->kode_transaksi ?></td>
								<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
									<td><?= $pengembalian->nama_lengkap ?></td>
								<?php endif ?>
								<td><?= nice_date($pengembalian->tanggal_pengembalian, 'd-m-Y') ?></td>
								<td><?= $pengembalian->judul ?></td>
								<td>Rp<?= number_format($pengembalian->denda, 2, ',', '.') ?></td>
								<td><?= $pengembalian->keterangan ?></td>
								<td>
									<span class="bg-<?= $status[$pengembalian->status_pengembalian] ?> badge"><?= $pengembalian->status_pengembalian ?></span>
								</td>
								<td class="text-nowrap">
									<button class="btn btn-primary btn-sm" data-bs-target="#detailModal" data-bs-toggle="modal" onclick="detailPengembalian('<?= $pengembalian->kode_transaksi ?>')" type="button">
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
		<form action="<?= base_url('pengembalian/tambah') ?>" class="modal-content" method="post">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Pengembalian</h5>
				<button class="btn-close" data-bs-dismiss="modal" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="g-3 row">
					<div class="col-12">
						<label class="form-label" for="insertCode">
							Kode transaksi<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<select class="form-select" id="insertCode" name="kode_transaksi" required>
							<?php foreach($data_peminjaman as $peminjaman): ?>
								<option value="<?= $peminjaman->kode_transaksi ?>"><?= $peminjaman->kode_transaksi ?> &minus; <?= $peminjaman->nama_lengkap ?> &minus;<?= $peminjaman->judul ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="col-6">
						<label class="form-label" for="insertTransaction">
							Tanggal pengembalian<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" id="insertTransaction" min="<?= date('Y-m-d', 0) ?>" name="tanggal_pengembalian" required type="date" value="<?= date('Y-m-d') ?>">
					</div>

					<div class="col-6">
						<label class="form-label" for="insertInformation">
							Keterangan<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<select class="form-select" id="insertInformation" name="keterangan" required>
							<?php $data_keterangan = array('Baik', 'Rusak', 'Hilang') ?>
							<?php foreach($data_keterangan as $keterangan): ?>
								<option value="<?= $keterangan ?>"><?= $keterangan ?></option>
							<?php endforeach ?>
						</select>
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
		<form action="<?= base_url('pengembalian/ubah') ?>" class="modal-content" method="post">
			<div class="modal-header">
				<h5 class="modal-title">Detail Pengembalian</h5>
				<button class="btn-close" data-bs-dismiss="modal" type="button"></button>
			</div>
			<div class="modal-body">
				<input id="detailId" maxlength="5" name="kode_transaksi" type="hidden">
				<div class="g-3 row">
					<div class="col-12">
						<label class="form-label" for="detailCode">Kode transaksi</label>
						<input class="form-control" disabled id="detailCode" type="text">
					</div>

					<div class="col-sm-6">
						<label class="form-label" for="detailTransaction">
							Tanggal pengembalian<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" id="detailTransaction" min="<?= date('Y-m-d', 0) ?>" name="tanggal_pengembalian" required type="date">
					</div>

					<div class="col-sm-6">
						<label class="form-label" for="detailInformation">
							Keterangan<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<select class="form-select" id="detailInformation" name="keterangan" required>
							<?php $data_keterangan = array('Baik', 'Rusak', 'Hilang') ?>
							<?php foreach($data_keterangan as $keterangan): ?>
								<option value="<?= $keterangan ?>"><?= $keterangan ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="col-6">
						<label class="form-label" for="detailPenalty">Denda</label>
						<input class="form-control" disabled id="detailPenalty" type="text">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailStatus">Status</label>
						<input class="form-control" disabled id="detailStatus" type="text">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
					<a class="btn btn-danger" id="deletePengembalian" href="">
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