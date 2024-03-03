<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autentikasi extends CI_Controller {
	public function masuk()
	{
		$this->form_validation->set_rules(array(
			array(
				'field' => 'nama_pengguna',
				'label' => 'Nama pengguna',
				'rules' => array('alpha_numeric', 'max_length[16]', 'regex_match[/[a-z0-9]+/]', 'required', 'trim')
			),
			array(
				'field' => 'kata_sandi',
				'label' => 'Kata sandi',
				'rules' => array('alpha_numeric', 'max_length[16]', 'required', 'trim')
			)
		));

		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/begin', array('title' => 'Masuk'));
			$this->load->view('autentikasi/masuk');
			$this->load->view('templates/end');
		}
		else
		{
			$auth = $this->db->join('tbl_anggota', 'tbl_anggota.kode_pengguna = tbl_pengguna.kode_pengguna', 'inner')->get_where('tbl_pengguna', array(
				'nama_pengguna' => $this->input->post('nama_pengguna', true),
				'kata_sandi' => $this->input->post('kata_sandi', true)
			));

			if( ! $auth->num_rows())
			{
				$this->session->set_flashdata('alert', array(
					'icon' => 'bi-x-circle-fill',
					'status' => 'danger',
					'text' => 'Nama pengguna atau kata sandi salah'
				));

				redirect('autentikasi/masuk');
			}

			$this->session->set_userdata('auth', $auth->row());
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Berhasil masuk sebagai ' . $auth->row()->jenis_anggota
			));

			redirect('');
		}
	}

	public function daftar()
	{
		$this->form_validation->set_rules(array(
			array(
				'field' => 'nama_pengguna',
				'label' => 'Nama pengguna',
				'rules' => array('alpha_numeric', 'is_unique[tbl_pengguna.nama_pengguna]', 'max_length[16]', 'required', 'trim')
			),
			array(
				'field' => 'kata_sandi',
				'label' => 'Kata sandi',
				'rules' => array('alpha_numeric', 'max_length[16]', 'required', 'trim')
			),
			array(
				'field' => 'nama_lengkap',
				'label' => 'Nama lengkap',
				'rules' => array('max_length[32]', 'required', 'trim')
			),
			array(
				'field' => 'jenis_kelamin',
				'label' => 'Jenis kelamin',
				'rules' => array('in_list[Laki-laki,Perempuan]', 'required', 'trim')
			),
			array(
				'field' => 'tempat_lahir',
				'label' => 'Tempat lahir',
				'rules' => array('max_length[16]', 'required', 'trim')
			),
			array(
				'field' => 'tanggal_lahir',
				'label' => 'Tanggal lahir',
				'rules' => array('alpha_dash', 'required', 'trim')
			)
		));

		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/begin', array('title' => 'Daftar'));
			$this->load->view('autentikasi/daftar');
			$this->load->view('templates/end');
		}
		else
		{
			$this->anggota_model->insert('Terdaftar');
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Akun berhasil didaftarkan'
			));

			redirect('autentikasi/masuk');
		}
	}

	public function keluar()
	{
		$jenis_anggota = $this->session->userdata('auth')->jenis_anggota;

		$this->session->unset_userdata('auth');
		$this->session->set_flashdata('alert', array(
			'icon' => 'bi-check-circle-fill',
			'status' => 'success',
			'text' => 'Berhasil keluar dari ' . $jenis_anggota
		));

		redirect('autentikasi/masuk');
	}
}
