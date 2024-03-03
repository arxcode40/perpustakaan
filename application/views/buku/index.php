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
			<i class="bi bi-journal-richtext"></i> Data Buku
		</h1>

		<nav class="mb-0">
			<ul class="breadcrumb">
				<li class="breadcrumb-item">
					<a class="link-body-emphasis text-decoration-none" href="<?= base_url() ?>">
						<i class="bi bi-house-door-fill"></i> Beranda
					</a>
				</li>
				<li class="active breadcrumb-item">
					<i class="bi bi-journal-richtext"></i> Data Buku
				</li>
			</ul>
		</nav>
	</header>

	<!-- Data Table -->
	<div class="card">
		<div class="align-items-center card-header d-flex">
			<h5 class="mb-0">
				<i class="bi bi-table me-2"></i> Tabel Buku
			</h5>
			<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
				<button class="btn btn-primary btn-sm ms-auto" data-bs-target="#insertModal" data-bs-toggle="modal" type="button">
					<i class="bi bi-plus-lg"></i>
					<span class="d-none d-sm-inline-block">Tambah Data</span>
				</button>
				<a class="btn btn-warning btn-sm ms-2" href="<?= base_url('buku/laporan') ?>" target="_blank">
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
							<th>Kode Buku</th>
							<th>Judul</th>
							<th>Jenis</th>
							<th>Pengarang</th>
							<th>Penerbit</th>
							<th>Tahun Terbit</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 0 ?>
						<?php $status = array('Tersedia' => 'success', 'Dipinjam' => 'warning', 'Tidak Tersedia' => 'danger') ?>
						<?php foreach($data_buku as $buku): ?>
							<tr class="table-<?= $status[$buku->status_buku] ?>">
								<td><?= ++$i ?></td>
								<td><?= $buku->kode_buku ?></td>
								<td><?= $buku->judul ?></td>
								<td><?= $buku->jenis_koleksi ?></td>
								<td><?= $buku->pengarang ?></td>
								<td><?= $buku->penerbit ?></td>
								<td><?= $buku->tahun_terbit ?></td>
								<td>
									<span class="bg-<?= $status[$buku->status_buku] ?> badge"><?= $buku->status_buku ?></span>
								</td>
								<td class="text-nowrap">
									<button class="btn btn-primary btn-sm" data-bs-target="#detailModal" data-bs-toggle="modal" onclick="detailBuku('<?= $buku->kode_buku ?>')" type="button">
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

<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
<!-- Insert Modal -->
	<div class="fade modal" id="insertModal" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<form action="<?= base_url('buku/tambah') ?>" class="modal-content" method="post">
				<div class="modal-header">
					<h5 class="modal-title">Tambah Buku</h5>
					<button class="btn-close" data-bs-dismiss="modal" type="button"></button>
				</div>
				<div class="modal-body">
					<div class="g-3 row">
						<div class="col-6">
							<label class="form-label" for="insertTitle">
								Judul<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<input class="form-control" id="insertTitle" maxlength="32" name="judul" placeholder="Masukkan judul" required type="text">
						</div>

						<div class="col-6">
							<label class="form-label" for="insertType">
								Jenis koleksi<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<select class="form-select" id="insertType" name="jenis_koleksi" required>
								<?php foreach($jenis_koleksi as $koleksi): ?>
									<option value="<?= $koleksi ?>"><?= $koleksi ?></option>
								<?php endforeach ?>
							</select>
						</div>

						<div class="col-6">
							<label class="form-label" for="insertAuthor">
								Pengarang<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<input class="form-control" id="insertAuthor" maxlength="32" name="pengarang" placeholder="Masukkan pengarang" required type="text">
						</div>

						<div class="col-6">
							<label class="form-label" for="insertPublisher">
								Penerbit<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<input class="form-control" id="insertPublisher" maxlength="32" name="penerbit" placeholder="Masukkan penerbit" required type="text">
						</div>

						<div class="col-6">
							<label class="form-label" for="insertPrint">Cetakan</label>
							<input class="form-control" id="insertPrint" maxlength="16" name="cetakan" placeholder="Masukkan cetakan" type="text">
						</div>

						<div class="col-6">
							<label class="form-label" for="insertEdition">Edisi</label>
							<input class="form-control" id="insertEdition" maxlength="16" name="edisi" placeholder="Masukkan edisi" type="text">
						</div>

						<div class="col-6">
							<label class="form-label" for="insertYear">
								Tahun terbit<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<input class="form-control" id="insertYear" min="<?= date('Y', 0) ?>" name="tahun_terbit" placeholder="Masukkan tahun terbit" required type="number" value="<?= date('Y') ?>">
						</div>

						<div class="col-6">
							<label class="form-label" for="insertStatus">
								Status<b class="fs-5 text-danger">&#x002a;</b>
							</label>
							<select class="form-select" id="insertStatus" name="status_buku" required>
								<?php $status_buku = array('Tersedia', 'Dipinjam', 'Tidak Tersedia') ?>
								<?php foreach($status_buku as $status): ?>
									<option value="<?= $status ?>"><?= $status ?></option>
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
<?php endif ?>

<!-- Detail Modal -->
<?php $authorization = $this->session->userdata('auth')->hak_akses !== 'admin' ? 'disabled' : '' ?>
<div class="fade modal" id="detailModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<form action="<?= base_url('buku/ubah') ?>" class="modal-content" method="post">
			<div class="modal-header">
				<h5 class="modal-title">Detail Buku</h5>
				<button class="btn-close" data-bs-dismiss="modal" type="button"></button>
			</div>
			<div class="modal-body">
				<input id="detailId" maxlength="5" name="kode_buku" type="hidden">
				<div class="g-3 row">
					<div class="col-12">
						<label class="form-label">Kode buku</label>
						<input class="form-control" disabled id="detailCode" type="text">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailTitle">
							Judul<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" <?= $authorization ?> id="detailTitle" maxlength="32" name="judul" placeholder="Masukkan judul" required type="text">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailType">
							Jenis koleksi<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<select class="form-select" <?= $authorization ?> id="detailType" name="jenis_koleksi" required>
							<?php foreach($jenis_koleksi as $koleksi): ?>
								<option value="<?= $koleksi ?>"><?= $koleksi ?></option>
							<?php endforeach ?>
						</select>
					</div>

					<div class="col-6">
						<label class="form-label" for="detailAuthor">
							Pengarang<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" <?= $authorization ?> id="detailAuthor" maxlength="32" name="pengarang" placeholder="Masukkan pengarang" required type="text">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailPublisher">
							Penerbit<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" <?= $authorization ?> id="detailPublisher" maxlength="32" name="penerbit" placeholder="Masukkan penerbit" required type="text">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailPrint">Cetakan</label>
						<input class="form-control" <?= $authorization ?> id="detailPrint" maxlength="16" name="cetakan" placeholder="Masukkan cetakan" type="text">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailEdition">Edisi</label>
						<input class="form-control" <?= $authorization ?> id="detailEdition" maxlength="16" name="edisi" placeholder="Masukkan edisi" type="text">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailYear">
							Tahun terbit<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<input class="form-control" <?= $authorization ?> id="detailYear" min="<?= date('Y', 0) ?>" name="tahun_terbit" placeholder="Masukkan tahun terbit" required type="number">
					</div>

					<div class="col-6">
						<label class="form-label" for="detailStatus">
							Status<b class="fs-5 text-danger">&#x002a;</b>
						</label>
						<select class="form-select" <?= $authorization ?> id="detailStatus" name="status_buku" required>
							<?php $status_buku = array('Tersedia', 'Dipinjam', 'Tidak Tersedia') ?>
							<?php foreach($status_buku as $status): ?>
								<option value="<?= $status ?>"><?= $status ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
					<a class="btn btn-danger" id="deleteBuku" href="">
						<i class="bi bi-trash-fill"></i> Hapus
					</a>
				<?php endif ?>
				<button class="btn btn-secondary" data-bs-dismiss="modal" type="reset">
					<i class="bi bi-x-lg"></i> Batal
				</button>
				<?php if($this->session->userdata('auth')->hak_akses === 'admin'): ?>
					<button class="btn btn-primary" type="submit">
						<i class="bi bi-floppy-fill"></i> Simpan
					</button>
				<?php endif ?>
			</div>
		</form>
	</div>
</div>