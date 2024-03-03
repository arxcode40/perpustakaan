<div class="text-body-emphasis">
	<h4 class="mb-0 text-center">Laporan Perpustakaan</h4>
	<h4 class="mb-3 text-center">Data Anggota</h4>
	<table class="align-middle border-black mb-0 table table-bordered w-100">
		<thead>
			<tr class="align-middle">
				<th>#</th>
				<th>Kode Anggota</th>
				<th>Nama Pengguna</th>
				<th>Kata Sandi</th>
				<th>Nama Lengkap</th>
				<th>Jenis Kelamin</th>
				<th>Tempat, Tanggal Lahir</th>
				<th>Hak Akses</th>
				<th>Status</th>
				<th>Jumlah Pinjam</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 0 ?>
			<?php foreach($data_anggota as $anggota): ?>
				<tr>
					<td><?= ++$i ?></td>
					<td><?= $anggota->kode_anggota ?></td>
					<td><?= $anggota->nama_pengguna ?></td>
					<td><?= $anggota->kata_sandi ?></td>
					<td><?= $anggota->nama_lengkap ?></td>
					<td><?= $anggota->jenis_kelamin ?></td>
					<td><?= $anggota->tempat_lahir ?>, <?= nice_date($anggota->tanggal_lahir, 'd M Y') ?></td>
					<td><?= $anggota->jenis_anggota ?></td>
					<td><?= $anggota->status_anggota ?></td>
					<td><?= $anggota->jumlah_pinjam ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>

<script>
	$(document).ready(function() {
	  window.print()
	})
</script>