<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	public function count($name)
	{
		if($this->session->userdata('auth')->hak_akses !== 'admin')
		{
			if(in_array($name, array('peminjaman', 'pengembalian')))
			{
				return $this->db->get_where("tbl_$name", array('kode_anggota' => $this->session->userdata('auth')->kode_anggota))->num_rows();
			}

			return $this->db->count_all("tbl_$name");
		}

		return $this->db->count_all("tbl_$name");
	}
}
