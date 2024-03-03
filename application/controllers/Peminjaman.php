<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman extends CI_Controller {
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

		$this->load->model('peminjaman_model');
	}
	
	public function index()
	{
		$this->load->view('templates/begin', array('title' => 'Data Peminjaman'));
		$this->load->view('templates/navbar', array('active' => 'peminjaman'));
		if($this->session->userdata('auth')->hak_akses === 'admin')
		{
			$this->load->view('peminjaman/index', array(
				'data_anggota' => $this->db->select('kode_anggota, nama_lengkap')->get_where('tbl_anggota', array('jenis_anggota' => 'Anggota', 'status_anggota' => 'Terverifikasi'))->result(),
				'data_buku' => $this->db->select('kode_buku, judul')->get_where('tbl_buku', array('status_buku' => 'Tersedia'))->result(),
				'data_peminjaman' => $this->peminjaman_model->get()
			));
		}
		else
		{
			$this->load->view('peminjaman/index', array(
				'data_buku' => $this->db->select('kode_buku, judul')->get_where('tbl_buku', array('status_buku' => 'Tersedia'))->result(),
				'data_peminjaman' => $this->peminjaman_model->get()
			));
		}
		
		$this->load->view('templates/footer');
		$this->load->view('templates/end');
	}

	public function detail($code)
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($this->peminjaman_model->get($code)));
	}

	public function tambah()
	{
		$this->form_validation->set_rules(array(
			array(
				'field' => 'kode_anggota',
				'label' => 'Nama anggota',
				'rules' => array('alpha_numeric', 'max_length[5]', 'required', 'trim')
			),
			array(
				'field' => 'tanggal_pinjam',
				'label' => 'Tanggal pinjam',
				'rules' => array('alpha_dash', 'required', 'trim')
			),
			array(
				'field' => 'tanggal_kembali',
				'label' => 'Tanggal kembali',
				'rules' => array('alpha_dash', 'required', 'trim')
			),
			array(
				'field' => 'kode_buku',
				'label' => 'Nama buku',
				'rules' => array('alpha_numeric', 'max_length[5]', 'required', 'trim')
			),
		));

		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-x-circle-fill',
				'status' => 'danger',
				'text' => 'Data peminjaman gagal ditambahkan'
			));
		}
		else
		{
			$this->peminjaman_model->insert();
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Data peminjaman berhasil ditambahkan'
			));
		}

		redirect('peminjaman');
	}

	public function ubah()
	{
		$this->form_validation->set_rules(array(
			array(
				'field' => 'kode_transaksi',
				'label' => 'Kode transaksi',
				'rules' => array('alpha_numeric', 'max_length[5]', 'required', 'trim')
			),
			array(
				'field' => 'kode_anggota',
				'label' => 'Nama anggota',
				'rules' => array('alpha_numeric', 'max_length[5]', 'required', 'trim')
			),
			array(
				'field' => 'tanggal_pinjam',
				'label' => 'Tanggal pinjam',
				'rules' => array('alpha_dash', 'required', 'trim')
			),
			array(
				'field' => 'tanggal_kembali',
				'label' => 'Tanggal kembali',
				'rules' => array('alpha_dash', 'required', 'trim')
			),
			array(
				'field' => 'kode_buku',
				'label' => 'Nama buku',
				'rules' => array('alpha_numeric', 'max_length[5]', 'required', 'trim')
			),
		));

		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-x-circle-fill',
				'status' => 'danger',
				'text' => 'Data peminjaman gagal diperbarui'
			));
		}
		else
		{
			$this->peminjaman_model->update();
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Data peminjaman berhasil diperbarui'
			));
		}

		redirect('peminjaman');
	}

	public function hapus($code)
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}
		
		$this->peminjaman_model->delete($code);
		$this->session->set_flashdata('alert', array(
			'icon' => 'bi-check-circle-fill',
			'status' => 'success',
			'text' => 'Data peminjaman berhasil dihapus'
		));
		
		redirect('peminjaman');
	}

	public function verifikasi($code)
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$this->peminjaman_model->verify($code);
		$this->session->set_flashdata('alert', array(
			'icon' => 'bi-check-circle-fill',
			'status' => 'success',
			'text' => 'Data peminjaman berhasil diverifikasi'
		));
		
		redirect('peminjaman');
	}

	public function laporan()
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$this->load->view('templates/begin', array('theme' => 'light', 'title' => 'Laporan Data Peminjaman'));
		$this->load->view('peminjaman/laporan', array('data_peminjaman' => $this->peminjaman_model->get()));
		$this->load->view('templates/end');
	}
}
