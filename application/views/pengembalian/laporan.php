<div class="text-body-emphasis">
	<h4 class="mb-0 text-center">Laporan Perpustakaan</h4>
	<h4 class="mb-3 text-center">Data Pengembalian</h4>
	<table class="align-middle border-black mb-0 table table-bordered w-100">
		<thead>
			<tr class="align-middle">
				<th>#</th>
				<th>Kode Transaksi</th>
				<th>Nama Anggota</th>
				<th>Tanggal Pengembalian</th>
				<th>Judul Buku</th>
				<th>Denda</th>
				<th>Keterangan</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 0 ?>
			<?php foreach($data_pengembalian as $pengembalian): ?>
				<tr>
					<td><?= ++$i ?></td>
					<td><?= $pengembalian->kode_transaksi ?></td>
					<td><?= $pengembalian->nama_lengkap ?></td>
					<td><?= nice_date($pengembalian->tanggal_pengembalian, 'd-m-Y') ?></td>
					<td><?= $pengembalian->judul ?></td>
					<td>Rp<?= number_format($pengembalian->denda, 2, ',', '.') ?></td>
					<td><?= $pengembalian->keterangan ?></td>
					<td><?= $pengembalian->status_pengembalian ?></td>
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