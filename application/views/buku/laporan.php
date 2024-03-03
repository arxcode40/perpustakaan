<div class="text-body-emphasis">
	<h4 class="mb-0 text-center">Laporan Perpustakaan</h4>
	<h4 class="mb-3 text-center">Data Buku</h4>
	<table class="align-middle border-black mb-0 table table-bordered w-100">
		<thead>
			<tr class="align-middle">
				<th>#</th>
				<th>Kode Buku</th>
				<th>Judul</th>
				<th>Jenis</th>
				<th>Pengarang</th>
				<th>Penerbit</th>
				<th>Tahun Terbit</th>
				<th>Cetakan</th>
				<th>Edisi</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 0 ?>
			<?php foreach($data_buku as $buku): ?>
				<tr>
					<td><?= ++$i ?></td>
					<td><?= $buku->kode_buku ?></td>
					<td><?= $buku->judul ?></td>
					<td><?= $buku->jenis_koleksi ?></td>
					<td><?= $buku->pengarang ?></td>
					<td><?= $buku->penerbit ?></td>
					<td><?= $buku->tahun_terbit ?></td>
					<td><?= $buku->cetakan ?></td>
					<td><?= $buku->edisi ?></td>
					<td><?= $buku->status_buku ?></td>
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