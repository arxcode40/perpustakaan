<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil_model extends CI_Model {
	public function update_user()
	{
		$data = array(
			'nama_pengguna' => $this->input->post('nama_pengguna', true),
			'kata_sandi' => $this->input->post('kata_sandi', true)
		);

		$this->db->trans_start();
		$this->db->update('tbl_pengguna', $data, array('kode_pengguna' => $this->input->post('kode_pengguna', true)));
		$this->db->trans_complete();
	}

	public function update_member()
	{
		$data = array(
			'nama_lengkap' => $this->input->post('nama_lengkap', true),
			'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
			'tempat_lahir' => $this->input->post('tempat_lahir', true),
			'tanggal_lahir' => $this->input->post('tanggal_lahir', true),
			'alamat' => $this->input->post('alamat', true),
			'nomor_telepon' => $this->input->post('nomor_telepon', true)
		);

		$this->db->trans_start();
		$this->db->update('tbl_anggota', $data, array('kode_anggota' => $this->input->post('kode_anggota', true)));
		$this->db->trans_complete();
	}
}
