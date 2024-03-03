<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian extends CI_Controller {
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

		$this->load->model('pengembalian_model');
	}
	
	public function index()
	{
		$this->load->view('templates/begin', array('title' => 'Data Pengembalian'));
		$this->load->view('templates/navbar', array('active' => 'pengembalian'));
		if($this->session->userdata('auth')->hak_akses === 'admin')
		{
			$this->load->view('pengembalian/index', array(
				'data_peminjaman' => $this->db->join('tbl_anggota', 'tbl_anggota.kode_anggota = tbl_peminjaman.kode_anggota', 'inner')->join('tbl_buku', 'tbl_buku.kode_buku = tbl_peminjaman.kode_buku', 'inner')->get_where('tbl_peminjaman', array('status_peminjaman' => 'Terverifikasi', 'status_transaksi' => 'Dipinjam'))->result_object(),
				'data_pengembalian' => $this->pengembalian_model->get()
			));
		}
		else
		{
			$this->load->view('pengembalian/index', array(
				'data_peminjaman' => $this->db->join('tbl_anggota', 'tbl_anggota.kode_anggota = tbl_peminjaman.kode_anggota', 'inner')->join('tbl_buku', 'tbl_buku.kode_buku = tbl_peminjaman.kode_buku', 'inner')->get_where('tbl_peminjaman', array('tbl_peminjaman.kode_anggota' => $this->session->userdata('auth')->kode_anggota, 'status_peminjaman' => 'Terverifikasi', 'status_transaksi' => 'Dipinjam'))->result_object(),
				'data_pengembalian' => $this->pengembalian_model->get()
			));
		}
		$this->load->view('templates/footer');
		$this->load->view('templates/end');
	}

	public function detail($code)
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($this->pengembalian_model->get($code)));
	}

	public function tambah()
	{
		$this->form_validation->set_rules(array(
			array(
				'field' => 'kode_transaksi',
				'label' => 'Kode transaksi',
				'rules' => array('alpha_numeric', 'max_length[5]', 'required', 'trim')
			),
			array(
				'field' => 'tanggal_pengembalian',
				'label' => 'Tanggal pengembalian',
				'rules' => array('alpha_dash', 'required', 'trim')
			),
			array(
				'field' => 'keterangan',
				'label' => 'Keterangan',
				'rules' => array('in_list[Baik,Rusak,Hilang]', 'required', 'trim')
			)
		));

		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-x-circle-fill',
				'status' => 'danger',
				'text' => 'Data pengembalian gagal ditambahkan'
			));
		}
		else
		{
			$this->pengembalian_model->insert();
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Data pengembalian berhasil ditambahkan'
			));
		}

		redirect('pengembalian');
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
				'field' => 'tanggal_pengembalian',
				'label' => 'Tanggal pengembalian',
				'rules' => array('alpha_dash', 'required', 'trim')
			),
			array(
				'field' => 'keterangan',
				'label' => 'Keterangan',
				'rules' => array('in_list[Baik,Rusak,Hilang]', 'required', 'trim')
			)
		));

		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-x-circle-fill',
				'status' => 'danger',
				'text' => 'Data pengembalian gagal diperbarui'
			));
		}
		else
		{
			$this->pengembalian_model->update();
			$this->session->set_flashdata('alert', array(
				'icon' => 'bi-check-circle-fill',
				'status' => 'success',
				'text' => 'Data pengembalian berhasil diperbarui'
			));
		}

		redirect('pengembalian');
	}

	public function hapus($code)
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}
		
		$this->pengembalian_model->delete($code);
		$this->session->set_flashdata('alert', array(
			'icon' => 'bi-check-circle-fill',
			'status' => 'success',
			'text' => 'Data pengembalian berhasil dihapus'
		));
		
		redirect('pengembalian');
	}

	public function verifikasi($code)
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$this->pengembalian_model->verify($code);
		$this->session->set_flashdata('alert', array(
			'icon' => 'bi-check-circle-fill',
			'status' => 'success',
			'text' => 'Data pengembalian berhasil diverifikasi'
		));
		
		redirect('pengembalian');
	}

	public function laporan()
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			show_404();
			return;
		}

		$this->load->view('templates/begin', array('theme' => 'light', 'title' => 'Laporan Data Pengembalian'));
		$this->load->view('pengembalian/laporan', array('data_pengembalian' => $this->pengembalian_model->get()));
		$this->load->view('templates/end');
	}
}
