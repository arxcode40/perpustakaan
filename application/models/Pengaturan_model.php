<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_model extends CI_Model {
	public function get()
	{
		return $this->db->get('tbl_pengaturan')->row();
	}

	public function update()
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}
		
		$data = array(
			'nama_aplikasi' => $this->input->post('nama_aplikasi', true),
			'alamat' => $this->input->post('alamat', true),
			'nomor_telepon' => $this->input->post('nomor_telepon', true),
			'email' => $this->input->post('email', true),
			'denda_telat' => $this->input->post('denda_telat', true),
			'denda_rusak' => $this->input->post('denda_rusak', true),
			'denda_hilang' => $this->input->post('denda_hilang', true),
		);

		$this->db->update('tbl_pengaturan', $data, array('id_pengaturan' => 1));
	}
}
