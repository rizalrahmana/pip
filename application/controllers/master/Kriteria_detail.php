<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kriteria_detail extends User_auth
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('master/M_kriteria_detail', 'M_kriteria_detail');
		$this->load->helper('tanggal_indo');
	}

	public function index()
	{
		$this->load->view('master/kriteria');
	}

	

	public function ajax_save()
	{
		$insert = array(
			'kd_kriteria' => $this->input->post('kd_kriteria'),
			'kriteria' => $this->input->post('kriteria'),
			'sifat' => $this->input->post('sifat'),
			'bobot' => $this->input->post('bobot')
		);

		$this->M_kriteria->save($insert);
	}

	public function ajax_edit($id)
	{
		$this->M_kriteria->edit($id);
	}

	public function ajax_delete()
	{
		$this->M_kriteria->ajax_delete($this->input->post('id'));
	}

	public function ajax_update($id)
	{
		$insert = array(
			'kd_kriteria' => $this->input->post('kd_kriteria'),
			'kriteria' => $this->input->post('kriteria'),
			'sifat' => $this->input->post('sifat'),
			'bobot' => $this->input->post('bobot')
		);
		$this->M_kriteria->update($id, $insert);
	}
}
