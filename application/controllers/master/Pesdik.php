<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesdik extends User_auth
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('master/M_pesdik', 'M_pesdik');
		$this->load->helper('tanggal_indo');
	}

	public function index()
	{
		$this->load->view('master/pesdik');
	}

	public function ajaxTable()
	{
		$list = $this->M_pesdik->tampil();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no; //0
			$row[] = $key->nisn; //1 
			$row[] = $key->rombongan; //2
			$row[] = $key->nama; //3
			$row[] = $key->jenis_kelamin; //4
			$row[] = $key->id; //5

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->M_pesdik->count_all(),
			"recordsFiltered" => $this->M_pesdik->count_filtered(),
			"data" => $data
		);

		echo json_encode($output);
	}

	public function ajax_save()
	{
		$insert = array(
			'nama' => $this->input->post('nama'),
			'nisn' => $this->input->post('nisn'),
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'tanggal_lahir' => dateSlashIndoToMysql($this->input->post('tanggal_lahir')),
			'nama_ibu' => $this->input->post('nama_ibu'),
			'tingkat' => $this->input->post('tingkat'),
			'rombongan' => $this->input->post('rombongan'),
		);

		$this->M_pesdik->save($insert);
	}

	public function ajax_edit($id)
	{
		$this->M_pesdik->edit($id);
	}

	public function ajax_delete()
	{
		$this->M_pesdik->ajax_delete($this->input->post('id'));
	}

	public function ajax_update($id)
	{
		$insert = array(
			'nama' => $this->input->post('nama'),
			'nisn' => $this->input->post('nisn'),
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'tanggal_lahir' => dateSlashIndoToMysql($this->input->post('tanggal_lahir')),
			'nama_ibu' => $this->input->post('nama_ibu'),
			'tingkat' => $this->input->post('tingkat'),
			'rombongan' => $this->input->post('rombongan')
		);
		$this->M_pesdik->update($id, $insert);
	}

	public function detail_kriteria($id)
	{
		$data = $this->db->get_where('detail_kriteria', array('id_kriteria' => $id))->result();
		echo json_encode($data);
	}

	public function ajax_get($id)
	{
		$siswa = $this->db->get_where('master_pesdik', array('id' => $id))->row();
		$kriteria = $this->db->get('kriteria')->result();
		$data = array('siswa' => $siswa, 'kriteria' => $kriteria);
		echo json_encode($data);
	}

	public function ajax_save_kriteria($id)
	{
		$data_input = $this->input->post('detail_kriteria');
		foreach ($data_input as $key => $value) {
			$data = array(
				'id_pesdik' => $id,
				'id_detail_kriteria' => $value,
				'id_kriteria' => $key
			);
			$this->db->insert('kriteria_siswa', $data);
		}
		echo json_encode("true");
	}
}
