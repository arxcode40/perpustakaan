<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian_model extends CI_Model {
	private $pengaturan;

	public function __construct()
	{
		parent::__construct();
		
		$this->pengaturan = $this->pengaturan_model->get();
	}

	public function get($code = NULL)
	{
		if( ! $code)
		{
			return $this->db->join('tbl_anggota', 'tbl_anggota.kode_anggota = tbl_pengembalian.kode_anggota', 'inner')->join('tbl_buku', 'tbl_buku.kode_buku = tbl_pengembalian.kode_buku', 'inner')->join('tbl_pengguna', 'tbl_pengguna.kode_pengguna = tbl_pengembalian.kode_pengguna', 'inner')->order_by('kode_transaksi')->get('tbl_pengembalian')->result();
		}

		return $this->db->join('tbl_anggota', 'tbl_anggota.kode_anggota = tbl_pengembalian.kode_anggota', 'inner')->join('tbl_buku', 'tbl_buku.kode_buku = tbl_pengembalian.kode_buku', 'inner')->join('tbl_pengguna', 'tbl_pengguna.kode_pengguna = tbl_pengembalian.kode_pengguna', 'inner')->get_where('tbl_pengembalian', array('kode_transaksi' => $code))->row();
	}

	public function insert()
	{
		$transaksi = $this->db->select('kode_anggota, tanggal_kembali, kode_buku, kode_pengguna')->get_where('tbl_peminjaman', array('kode_transaksi' => $this->input->post('kode_transaksi', true)))->row();

		$selisih_hari = date_diff(date_create($transaksi->tanggal_kembali), date_create($this->input->post('tanggal_pengembalian', true)));

		switch($this->input->post('keterangan', true))
		{
			case 'Baik':
				$denda = intval($selisih_hari->format('%R%a')) * $this->pengaturan->denda_telat;
				break;

			case 'Rusak':
				$denda = $this->pengaturan->denda_rusak;
				break;

			case 'Hilang':
				$denda = $this->pengaturan->denda_hilang;
				break;
		}

		$data = array(
			'kode_transaksi' => $this->input->post('kode_transaksi', true),
			'kode_anggota' => $transaksi->kode_anggota,
			'tanggal_pengembalian' => $this->input->post('tanggal_pengembalian', true),
			'kode_buku' => $transaksi->kode_buku,
			'denda' => $denda > 0 ? $denda : 0,
			'keterangan' => $this->input->post('keterangan', true),
			'status_pengembalian' => $this->session->userdata('auth')->hak_akses === 'admin' ? 'Terverifikasi' : 'Tertunda',
			'kode_pengguna' => $transaksi->kode_pengguna
		);

		$this->db->trans_start();
		$this->db->insert('tbl_pengembalian', $data);
		$this->db->update('tbl_peminjaman', array('status_transaksi' => 'Dikembalikan'), array('kode_transaksi' => $this->input->post('kode_transaksi', true)));
		$this->db->update('tbl_buku', array('status_buku' => $this->input->post('keterangan', true) === 'Baik' ? 'Tersedia' : 'Tidak Tersedia'), array('kode_buku' => $transaksi->kode_buku));
		$this->db->trans_complete();
	}

	public function update()
	{
		$transaksi = $this->db->select('kode_anggota, tanggal_kembali, kode_buku, kode_pengguna')->get_where('tbl_peminjaman', array('kode_transaksi' => $this->input->post('kode_transaksi', true)))->row();

		$selisih_hari = date_diff(date_create($transaksi->tanggal_kembali), date_create($this->input->post('tanggal_pengembalian', true)));

		switch($this->input->post('keterangan', true))
		{
			case 'Baik':
				$denda = intval($selisih_hari->format('%R%a')) * $this->pengaturan->denda_telat;
				break;

			case 'Rusak':
				$denda = $this->pengaturan->denda_rusak;
				break;

			case 'Hilang':
				$denda = $this->pengaturan->denda_hilang;
				break;
		}

		$data = array(
			'kode_anggota' => $transaksi->kode_anggota,
			'tanggal_pengembalian' => $this->input->post('tanggal_pengembalian', true),
			'kode_buku' => $transaksi->kode_buku,
			'denda' => $denda > 0 ? $denda : 0,
			'keterangan' => $this->input->post('keterangan', true),
			'kode_pengguna' => $transaksi->kode_pengguna
		);

		$this->db->trans_start();
		$this->db->update('tbl_pengembalian', $data, array('kode_transaksi' => $this->input->post('kode_transaksi', true)));
		$this->db->update('tbl_buku', array('status_buku' => $this->input->post('keterangan', true) === 'Baik' ? 'Tersedia' : 'Tidak Tersedia'), array('kode_buku' => $transaksi->kode_buku));
		$this->db->trans_complete();
	}

	public function delete($code)
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}
		
		$transaksi = $this->db->select('kode_buku')->get_where('tbl_peminjaman', array('kode_transaksi' => $code))->row();

		$this->db->trans_start();
		$this->db->update('tbl_peminjaman', array('status_transaksi' => 'Dipinjam'), array('kode_transaksi' => $code));
		$this->db->update('tbl_buku', array('status_buku' => 'Dipinjam'), array('kode_buku' => $transaksi->kode_buku));
		$this->db->delete('tbl_pengembalian', array('kode_transaksi' => $code));
		$this->db->trans_complete();
	}

	public function verify($kode)
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$this->db->trans_start();
		$this->db->update('tbl_pengembalian', array('status_pengembalian' => 'Terverifikasi'), array('kode_transaksi' => $kode));
		$this->db->trans_complete();
	}
}
