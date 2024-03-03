<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota extends CI_Controller {
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

		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$this->load->model('anggota_model');
	}
	
	public function index()
	{
		$this->load->view('templates/begin', array('title' => 'Data Anggota'));
		$this->load->view('templates/navbar', array('active' => 'anggota'));
		$this->load->view('anggota/index', array('data_anggota' => $this->anggota_model->get()));
		$this->load->view('templates/footer');
		$this->load->view('templates/end');
	}

	public function detail($code)
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($this->anggota_model->get($code)));
	}

	public function tambah()
	{
		$this->form_validation->set_rules(array(
			array(
				'field' => 'nama_pengguna',
				'label' => 'Nama pengguna',
				'rules' => array('alpha_numeric', 'is_unique[tbl_pengguna.nama_pengguna]', 'max_length[16]', 'regex_match[/[a-z0-9]+/]', 'required', 'trim')
			),
			array(
				'field' => 'kata_sandi',
				'label' => 'Kata sandi',
				'rules' => array('alpha_numeric', 'max_length[16]', 'required', 'trim')
			),
			array(
				'field' => 'hak_akses',
				'label' => 'Hak akses',
				'rules' => array('in_list[admin,user]', 'required', 'trim')
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
				'text' => 'Data anggota gagal ditambahkan'
			));
		}
		else
		{
			$this->anggota_model->insert('Terverifikasi');
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Data anggota berhasil ditambahkan'
			));
		}

		redirect('anggota');
	}

	public function ubah()
	{
		$this->form_validation->set_rules(array(
			array(
				'field' => 'kode_anggota',
				'label' => 'Kode anggota',
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
			),
			array(
				'field' => 'hak_akses',
				'label' => 'Hak akses',
				'rules' => array('in_list[admin,user]', 'required', 'trim')
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
				'text' => 'Data anggota gagal diperbarui'
			));
		}
		else
		{
			$this->anggota_model->update();
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Data anggota berhasil diperbarui'
			));
		}

		redirect('anggota');
	}

	public function hapus($code)
	{
		$this->anggota_model->delete($code);
		$this->session->set_flashdata('alert', array(
			'icon' => 'bi-check-circle-fill',
			'status' => 'success',
			'text' => 'Data anggota berhasil dihapus'
		));
		
		redirect('anggota');
	}

	public function verifikasi($code)
	{
		$this->anggota_model->verify($code);
		$this->session->set_flashdata('alert', array(
			'icon' => 'bi-check-circle-fill',
			'status' => 'success',
			'text' => 'Data anggota berhasil diverifikasi'
		));
		
		redirect('anggota');
	}

	public function laporan()
	{
		$this->load->view('templates/begin', array('theme' => 'light', 'title' => 'Laporan Data Anggota'));
		$this->load->view('anggota/laporan', array('data_anggota' => $this->anggota_model->get()));
		$this->load->view('templates/end');
	}
}
