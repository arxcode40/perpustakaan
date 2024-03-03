<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {
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

		$this->load->model('buku_model');
	}
	
	public function index()
	{
		$jenis_koleksi = array('Novel', 'Cergam', 'Komik', 'Ensiklopedi', 'Nomik', 'Antologi', 'Dongeng', 'Biografi', 'Catatan Harian', 'Novelet', 'Fotografi', 'Karya Ilmiah', 'Tafsir', 'Kamus', 'Panduan', 'Atlas', 'Buku Ilmiah', 'Teks', 'Majalah', 'Lainnya');

		$this->load->view('templates/begin', array('title' => 'Data Buku'));
		$this->load->view('templates/navbar', array('active' => 'buku'));
		$this->load->view('buku/index', array('data_buku' => $this->buku_model->get(), 'jenis_koleksi' => $jenis_koleksi));
		$this->load->view('templates/footer');
		$this->load->view('templates/end');
	}

	public function detail($code)
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($this->buku_model->get($code)));
	}

	public function tambah()
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$this->form_validation->set_rules(array(
			array(
				'field' => 'judul',
				'label' => 'Judul',
				'rules' => array('max_length[32]', 'required', 'trim')
			),
			array(
				'field' => 'jenis_koleksi',
				'label' => 'Jenis koleksi',
				'rules' => array('max_length[16]', 'required', 'trim')
			),
			array(
				'field' => 'pengarang',
				'label' => 'Pengarang',
				'rules' => array('max_length[32]', 'required', 'trim')
			),
			array(
				'field' => 'penerbit',
				'label' => 'Penerbit',
				'rules' => array('max_length[32]', 'required', 'trim')
			),
			array(
				'field' => 'tahun_terbit',
				'label' => 'Tahun terbit',
				'rules' => array('greater_than_equal_to[1970]', 'integer', 'max_length[4]', 'required', 'trim')
			),
			array(
				'field' => 'cetakan',
				'label' => 'Cetakan',
				'rules' => array('max_length[16]', 'trim')
			),
			array(
				'field' => 'edisi',
				'label' => 'Edisi',
				'rules' => array('max_length[16]', 'trim')
			),
			array(
				'field' => 'status_buku',
				'label' => 'Status buku',
				'rules' => array('in_list[Tersedia,Dipinjam,Tidak Tersedia]', 'required', 'trim')
			)
		));

		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-x-circle-fill',
				'status' => 'danger',
				'text' => 'Data buku gagal ditambahkan'
			));
		}
		else
		{
			$this->buku_model->insert();
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Data buku berhasil ditambahkan'
			));
		}

		redirect('buku');
	}

	public function ubah()
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$this->form_validation->set_rules(array(
			array(
				'field' => 'kode_buku',
				'label' => 'Kode buku',
				'rules' => array('alpha_numeric', 'max_length[5]', 'required', 'trim')
			),
			array(
				'field' => 'judul',
				'label' => 'Judul',
				'rules' => array('max_length[32]', 'required', 'trim')
			),
			array(
				'field' => 'jenis_koleksi',
				'label' => 'Jenis koleksi',
				'rules' => array('max_length[16]', 'required', 'trim')
			),
			array(
				'field' => 'pengarang',
				'label' => 'Pengarang',
				'rules' => array('max_length[32]', 'required', 'trim')
			),
			array(
				'field' => 'penerbit',
				'label' => 'Penerbit',
				'rules' => array('max_length[32]', 'required', 'trim')
			),
			array(
				'field' => 'tahun_terbit',
				'label' => 'Tahun terbit',
				'rules' => array('greater_than_equal_to[1970]', 'integer', 'max_length[4]', 'required', 'trim')
			),
			array(
				'field' => 'cetakan',
				'label' => 'Cetakan',
				'rules' => array('max_length[16]', 'trim')
			),
			array(
				'field' => 'edisi',
				'label' => 'Edisi',
				'rules' => array('max_length[16]', 'trim')
			),
			array(
				'field' => 'status_buku',
				'label' => 'Status buku',
				'rules' => array('in_list[Tersedia,Dipinjam,Tidak Tersedia]', 'required', 'trim')
			)
		));

		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-x-circle-fill',
				'status' => 'danger',
				'text' => 'Data buku gagal diperbarui'
			));
		}
		else
		{
			$this->buku_model->update();
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Data buku berhasil diperbarui'
			));
		}

		redirect('buku');
	}

	public function hapus($code)
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$this->buku_model->delete($code);
		$this->session->set_flashdata('alert', array(
			'icon' => 'bi-check-circle-fill',
			'status' => 'success',
			'text' => 'Data buku berhasil dihapus'
		));
		
		redirect('buku');
	}

	public function laporan()
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}
		
		$this->load->view('templates/begin', array('theme' => 'light', 'title' => 'Laporan Data Buku'));
		$this->load->view('buku/laporan', array('data_buku' => $this->buku_model->get()));
		$this->load->view('templates/end');
	}
}
