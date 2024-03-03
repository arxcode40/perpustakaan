<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {
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
	}

	public function index()
	{
		$this->load->view('templates/begin', array('title' => 'Pengaturan'));
		$this->load->view('templates/navbar', array('active' => 'pengaturan'));
		$this->load->view('pengaturan/index', array('pengaturan' => $this->pengaturan_model->get()));
		$this->load->view('templates/footer');
		$this->load->view('templates/end');
	}

	public function simpan()
	{
		$this->form_validation->set_rules(array(
			array(
				'field' => 'nama_aplikasi',
				'label' => 'Nama aplikasi',
				'rules' => array('alpha_numeric_spaces', 'max_length[16]', 'required', 'trim')
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
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => array('max_length[32]', 'trim', 'valid_email')
			),
			array(
				'field' => 'denda_telat',
				'label' => 'Denda telat',
				'rules' => array('is_natural', 'required', 'trim')
			),
			array(
				'field' => 'denda_rusak',
				'label' => 'Denda rusak',
				'rules' => array('is_natural', 'required', 'trim')
			),
			array(
				'field' => 'denda_hilang',
				'label' => 'Denda hilang',
				'rules' => array('is_natural', 'required', 'trim')
			),
		));

		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-x-circle-fill',
				'status' => 'danger',
				'text' => 'Pengaturan aplikasi gagal diperbarui'
			));
		}
		else
		{
			$this->pengaturan_model->update();
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Pengaturan aplikasi berhasil diperbarui'
			));
		}

		redirect('pengaturan');
	}
}
