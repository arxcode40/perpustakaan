<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota_model extends CI_Model {
	public function get($code = NULL)
	{
		if( ! $code)
		{
			return $this->db->join('tbl_pengguna', 'tbl_pengguna.kode_pengguna = tbl_anggota.kode_pengguna', 'inner')->order_by('kode_anggota')->get('tbl_anggota')->result();
		}
		
		return $this->db->join('tbl_pengguna', 'tbl_pengguna.kode_pengguna = tbl_anggota.kode_pengguna', 'inner')->get_where('tbl_anggota', array('kode_anggota' => $code))->row();
	}

	public function insert($status)
	{
		$pengguna = $this->db->select('kode_pengguna')->order_by('kode_pengguna', 'DESC')->get('tbl_pengguna')->row();
		$anggota = $this->db->select('kode_anggota')->order_by('kode_anggota', 'DESC')->get('tbl_anggota')->row();

		$id_pengguna = intval(substr($pengguna->kode_pengguna, 1));
		$kode_pengguna = sprintf('P%s%d', str_repeat(0, 4 - strlen($id_pengguna)), ++$id_pengguna);
		$id_anggota = intval(substr($anggota->kode_anggota, 1));
		$kode_anggota = sprintf('A%s%d', str_repeat(0, 4 - strlen($id_anggota)), ++$id_anggota);

		$data_pengguna = array(
			'kode_pengguna' => $kode_pengguna,
			'nama_pengguna' => $this->input->post('nama_pengguna', true),
			'kata_sandi' => $this->input->post('kata_sandi', true),
			'hak_akses' => $this->input->post('hak_akses', true) ?? 'user',
			'status_pengguna' => $this->input->post('hak_akses', true) === 'admin' ? 'Administrator' : 'Anggota'
		);

		$data_anggota = array(
			'kode_anggota' => $kode_anggota,
			'nama_lengkap' => $this->input->post('nama_lengkap', true),
			'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
			'tempat_lahir' => $this->input->post('tempat_lahir', true),
			'tanggal_lahir' => $this->input->post('tanggal_lahir', true),
			'alamat' => $this->input->post('alamat', true) ?? '',
			'nomor_telepon' => $this->input->post('nomor_telepon', true) ?? '',
			'kode_pengguna' => $kode_pengguna,
			'jenis_anggota' => $this->input->post('hak_akses', true) === 'admin' ? 'Administrator' : 'Anggota',
			'status_anggota' => $status,
			'jumlah_pinjam' => 0
		);

		$this->db->trans_start();
		$this->db->insert('tbl_pengguna', $data_pengguna);
		$this->db->insert('tbl_anggota', $data_anggota);
		$this->db->trans_complete();
	}

	public function update()
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$pengguna = $this->db->select('kode_pengguna')->get_where('tbl_anggota', array('kode_anggota' => $this->input->post('kode_anggota', true)))->row();

		$data_pengguna = array(
			'nama_pengguna' => $this->input->post('nama_pengguna', true),
			'kata_sandi' => $this->input->post('kata_sandi', true),
			'hak_akses' => $this->input->post('hak_akses', true),
			'status_pengguna' => $this->input->post('hak_akses', true) === 'admin' ? 'Administrator' : 'Anggota'
		);

		$data_anggota = array(
			'nama_lengkap' => $this->input->post('nama_lengkap', true),
			'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
			'tempat_lahir' => $this->input->post('tempat_lahir', true),
			'tanggal_lahir' => $this->input->post('tanggal_lahir', true),
			'alamat' => $this->input->post('alamat', true),
			'nomor_telepon' => $this->input->post('nomor_telepon', true),
			'jenis_anggota' => $this->input->post('hak_akses', true) === 'admin' ? 'Administrator' : 'Anggota'
		);

		$this->db->trans_start();
		$this->db->update('tbl_pengguna', $data_pengguna, array('kode_pengguna' => $pengguna->kode_pengguna));
		$this->db->update('tbl_anggota', $data_anggota, array('kode_anggota' => $this->input->post('kode_anggota', true)));
		$this->db->trans_complete();
	}

	public function delete($code)
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$pengguna = $this->db->select('kode_pengguna')->get_where('tbl_anggota', array('kode_anggota' => $code))->row();

		$this->db->trans_start();
		$this->db->delete('tbl_anggota', array('kode_anggota' => $code));
		$this->db->delete('tbl_pengguna', array('kode_pengguna' => $pengguna->kode_pengguna));
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
		$this->db->update('tbl_anggota', array('status_anggota' => 'Terverifikasi'), array('kode_anggota' => $code));
		$this->db->trans_complete();
	}
}
