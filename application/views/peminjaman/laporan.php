<div class="text-body-emphasis">
	<h4 class="mb-0 text-center">Laporan Perpustakaan</h4>
	<h4 class="mb-3 text-center">Data Peminjaman</h4>
	<table class="align-middle border-black mb-0 table table-bordered w-100">
		<thead>
			<tr class="align-middle">
				<th>#</th>
				<th>Kode Transaksi</th>
				<th>Nama Anggota</th>
				<th>Tanggal Pinjam</th>
				<th>Tanggal Kembali</th>
				<th>Judul Buku</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 0 ?>
			<?php foreach($data_peminjaman as $peminjaman): ?>
				<tr>
					<td><?= ++$i ?></td>
					<td><?= $peminjaman->kode_transaksi ?></td>
					<td><?= $peminjaman->nama_lengkap ?></td>
					<td><?= nice_date($peminjaman->tanggal_pinjam, 'd-m-Y') ?></td>
					<td><?= nice_date($peminjaman->tanggal_kembali, 'd-m-Y') ?></td>
					<td><?= $peminjaman->judul ?></td>
					<td><?= $peminjaman->status_peminjaman ?></td>
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