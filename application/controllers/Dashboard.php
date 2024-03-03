<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
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

		$this->load->model('dashboard_model');
	}

	public function index()
	{
		$this->load->view('templates/begin', array('title' => 'Beranda'));
		$this->load->view('templates/navbar', array('active' => 'dashboard'));
		if($this->session->userdata('auth')->hak_akses === 'admin')
		{	
			$this->load->view('dashboard/index', array(
				'total_anggota' => $this->dashboard_model->count('anggota'),
				'total_buku' => $this->dashboard_model->count('buku'),
				'total_peminjaman' => $this->dashboard_model->count('peminjaman'),
				'total_pengembalian' => $this->dashboard_model->count('pengembalian')
			));
		}
		else
		{
			$this->load->view('dashboard/index', array(
				'total_buku' => $this->dashboard_model->count('buku'),
				'total_peminjaman' => $this->dashboard_model->count('peminjaman'),
				'total_pengembalian' => $this->dashboard_model->count('pengembalian')
			));
		}
		$this->load->view('templates/footer');
		$this->load->view('templates/end');
	}
}
