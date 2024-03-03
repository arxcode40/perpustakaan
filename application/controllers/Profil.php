<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		if( ! $this->session->has_userdata('auth'))
		{
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-exclamation-circle-fill',
				'status' => 'warning',
				'text' => 'Silahkan masuk terlebih dahulu'
			));
			redirect('autentikasi/masuk');
		}

		$this->load->model('profil_model');
	}

	public function index()
	{
		$this->load->view('templates/begin', array('title' => 'Profil Saya'));
		$this->load->view('templates/navbar', array('active' => 'profil'));
		$this->load->view('profil/index', array('profil' => $this->session->userdata('auth')));
		$this->load->view('templates/footer');
		$this->load->view('templates/end');
	}

	public function pengguna()
	{
		$this->form_validation->set_rules(array(
			array(
				'field' => 'kode_pengguna',
				'label' => 'Kode pengguna',
				'rules' => array('alpha_numeric', 'max_length[5]', 'required', 'trim')
			),
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
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-x-circle-fill',
				'status' => 'danger',
				'text' => 'Profil pengguna gagal diperbarui'
			));
		}
		else
		{
			$this->profil_model->update_user();

			$auth = $this->db->join('tbl_anggota', 'tbl_anggota.kode_pengguna = tbl_pengguna.kode_pengguna', 'inner')->get_where('tbl_pengguna', array('tbl_pengguna.kode_pengguna' => $this->input->post('kode_pengguna', true)))->row();

			$this->session->set_userdata('auth', $auth);
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Profil pengguna berhasil diperbarui'
			));
		}

		redirect('profil');
	}

	public function anggota()
	{
		$this->form_validation->set_rules(array(
			array(
				'field' => 'kode_anggota',
				'label' => 'Kode anggota',
				'rules' => array('alpha_numeric', 'max_length[5]', 'required', 'trim')
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
			),
			array(
				'field' => 'alamat',
				'label' => 'Alamat',
				'rules' => array('max_length[255]', 'trim')
			),
			array(
				'field' => 'nomor_telepon',
				'label' => 'Nomor telepon',
				'rules' => array('max_length[13]', 'numeric', 'trim')
			)
		));

		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-x-circle-fill',
				'status' => 'danger',
				'text' => 'Profil anggota gagal diperbarui'
			));
		}
		else
		{
			$this->profil_model->update_member();

			$auth = $this->db->join('tbl_pengguna', 'tbl_pengguna.kode_pengguna = tbl_anggota.kode_pengguna', 'inner')->get_where('tbl_anggota', array('kode_anggota' => $this->input->post('kode_anggota', true)))->row();

			$this->session->set_userdata('auth', $auth);
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Profil anggota berhasil diperbarui'
			));
		}

		redirect('profil');
	}
}
