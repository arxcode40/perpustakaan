<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_model extends CI_Model {
	public function get($code = NULL)
	{
		if( ! $code)
		{
			return $this->db->order_by('kode_buku')->get('tbl_buku')->result();
		}
		
		return $this->db->get_where('tbl_buku', array('kode_buku' => $code))->row();
	}

	public function insert()
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$buku = $this->db->select('kode_buku')->order_by('kode_buku', 'DESC')->get('tbl_buku')->row();
		$id_buku = intval(substr($buku->kode_buku, 1));
		$kode_buku = sprintf('B%s%d', str_repeat(0, 4 - strlen($id_buku)), ++$id_buku);

		$data = array(
			'kode_buku' => $kode_buku,
			'judul' => $this->input->post('judul', true),
			'jenis_koleksi' => $this->input->post('jenis_koleksi', true),
			'pengarang' => $this->input->post('pengarang', true),
			'penerbit' => $this->input->post('penerbit', true),
			'tahun_terbit' => $this->input->post('tahun_terbit', true),
			'cetakan' => $this->input->post('cetakan', true),
			'edisi' => $this->input->post('edisi', true),
			'status_buku' => $this->input->post('status_buku', true)
		);

		$this->db->trans_start();
		$this->db->insert('tbl_buku', $data);
		$this->db->trans_complete();
	}

	public function update()
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$data = array(
			'judul' => $this->input->post('judul', true),
			'jenis_koleksi' => $this->input->post('jenis_koleksi', true),
			'pengarang' => $this->input->post('pengarang', true),
			'penerbit' => $this->input->post('penerbit', true),
			'tahun_terbit' => $this->input->post('tahun_terbit', true),
			'cetakan' => $this->input->post('cetakan', true),
			'edisi' => $this->input->post('edisi', true),
			'status_buku' => $this->input->post('status_buku', true)
		);

		$this->db->trans_start();
		$this->db->update('tbl_buku', $data, array('kode_buku' => $this->input->post('kode_buku', true)));
		$this->db->trans_complete();
	}

	public function delete($code)
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}
		
		$this->db->trans_start();
		$this->db->delete('tbl_buku', array('kode_buku' => $code));
		$this->db->trans_complete();
	}
}
