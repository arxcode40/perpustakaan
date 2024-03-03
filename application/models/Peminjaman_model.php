<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman_model extends CI_Model {
	public function get($code = NULL)
	{
		if( ! $code)
		{
			return $this->db->join('tbl_anggota', 'tbl_anggota.kode_anggota = tbl_peminjaman.kode_anggota', 'inner')->join('tbl_buku', 'tbl_buku.kode_buku = tbl_peminjaman.kode_buku', 'inner')->join('tbl_pengguna', 'tbl_pengguna.kode_pengguna = tbl_peminjaman.kode_pengguna', 'inner')->order_by('kode_transaksi')->get('tbl_peminjaman')->result();
		}

		return $this->db->join('tbl_anggota', 'tbl_anggota.kode_anggota = tbl_peminjaman.kode_anggota', 'inner')->join('tbl_buku', 'tbl_buku.kode_buku = tbl_peminjaman.kode_buku', 'inner')->join('tbl_pengguna', 'tbl_pengguna.kode_pengguna = tbl_peminjaman.kode_pengguna', 'inner')->get_where('tbl_peminjaman', array('kode_transaksi' => $code))->row();
	}

	public function insert()
	{
		$transaksi = $this->db->select('kode_transaksi')->order_by('kode_transaksi', 'DESC')->get('tbl_peminjaman')->row();
		$pengguna = $this->db->select('kode_pengguna')->get_where('tbl_anggota', array('kode_anggota' => $this->input->post('kode_anggota', true)))->row();

		$id_transaksi = intval(substr($transaksi->kode_transaksi, 1));
		$kode_transaksi = sprintf('T%s%d', str_repeat(0, 4 - strlen($id_transaksi)), ++$id_transaksi);


		$data = array(
			'kode_transaksi' => $kode_transaksi,
			'kode_anggota' => $this->input->post('kode_anggota', true),
			'tanggal_pinjam' => $this->input->post('tanggal_pinjam', true),
			'tanggal_kembali' => $this->input->post('tanggal_kembali', true),
			'kode_buku' => $this->input->post('kode_buku', true),
			'status_peminjaman' => $this->session->userdata('auth')->hak_akses === 'admin' ? 'Terverifikasi' : 'Tertunda',
			'status_transaksi' => 'Dipinjam',
			'kode_pengguna' => $pengguna->kode_pengguna
		);

		$this->db->trans_start();
		$this->db->insert('tbl_peminjaman', $data);
		$this->db->query("UPDATE tbl_anggota SET jumlah_pinjam = jumlah_pinjam + 1 WHERE kode_anggota = ?", array($this->input->post('kode_anggota', true)));
		$this->db->update('tbl_buku', array('status_buku' => 'Dipinjam'), array('kode_buku' => $this->input->post('kode_buku', true)));
		$this->db->trans_complete();
	}

	public function update()
	{
		$transaksi = $this->db->get_where('tbl_peminjaman', array('kode_transaksi' => $this->input->post('kode_transaksi', true)))->row();
		$pengguna = $this->db->select('kode_pengguna')->get_where('tbl_anggota', array('kode_anggota' => $this->input->post('kode_anggota', true)))->row();

		$data = array(
			'kode_anggota' => $this->input->post('kode_anggota', true),
			'tanggal_pinjam' => $this->input->post('tanggal_pinjam', true),
			'tanggal_kembali' => $this->input->post('tanggal_kembali', true),
			'kode_buku' => $this->input->post('kode_buku', true),
			'kode_pengguna' => $pengguna->kode_pengguna
		);

		$this->db->trans_start();
		$this->db->update('tbl_peminjaman', $data, array('kode_transaksi' => $this->input->post('kode_transaksi', true)));
		if($transaksi->status_transaksi === 'Dipinjam')
		{
			if($transaksi->kode_anggota !== $this->input->post('kode_anggota', true))
			{
				$this->db->query("UPDATE tbl_anggota SET jumlah_pinjam = jumlah_pinjam - 1 WHERE kode_anggota = ?", array($transaksi->kode_anggota));
				$this->db->query("UPDATE tbl_anggota SET jumlah_pinjam = jumlah_pinjam + 1 WHERE kode_anggota = ?", array($this->input->post('kode_anggota', true)));
			}
			if($transaksi->kode_buku !== $this->input->post('kode_buku', true))
			{
				$this->db->update('tbl_buku', array('status_buku' => 'Tersedia'), array('kode_buku' => $transaksi->kode_buku));
				$this->db->update('tbl_buku', array('status_buku' => 'Dipinjam'), array('kode_buku' => $this->input->post('kode_buku', true)));
			}
		}
		$this->db->trans_complete();
	}

	public function delete($code)
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}
		
		$transaksi = $this->db->get_where('tbl_peminjaman', array('kode_transaksi' => $code))->row();

		$this->db->trans_start();
		$this->db->query("UPDATE tbl_anggota SET jumlah_pinjam = jumlah_pinjam - 1 WHERE kode_anggota = ?", array($transaksi->kode_anggota));
		$this->db->update('tbl_buku', array('status_buku' => 'Tersedia'), array('kode_buku' => $transaksi->kode_buku));
		$this->db->delete('tbl_peminjaman', array('kode_transaksi' => $code));
		$this->db->trans_complete();
	}

	public function verify($code)
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$this->db->trans_start();
		$this->db->update('tbl_peminjaman', array('status_peminjaman' => 'Terverifikasi'), array('kode_transaksi' => $code));
		$this->db->trans_complete();
	}
}
