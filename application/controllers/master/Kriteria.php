<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kriteria extends User_auth
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('master/M_kriteria', 'M_kriteria');
		$this->load->model('master/M_kriteria_detail', 'M_kriteria_detail');
		$this->load->helper('tanggal_indo');
	}

	public function index()
	{
		$this->load->view('master/kriteria');
	}

	public function ajaxTable()
	{
		$list = $this->M_kriteria->tampil();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no; //0
			$row[] = $key->kd_kriteria; //1 
			$row[] = $key->kriteria; //2
			$row[] = $key->sifat; //3
			$row[] = $key->bobot; //4
			$row[] = $key->id; //5

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->M_kriteria->count_all(),
			"recordsFiltered" => $this->M_kriteria->count_filtered(),
			"data" => $data
		);

		echo json_encode($output);
	}

	public function ajaxTable_detail()
	{
		$list = $this->M_kriteria_detail->tampil();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no; //0
			$row[] = $key->kd_kriteria; //1 
			$row[] = $key->kriteria; //2
			$row[] = $key->detail; //3
			$row[] = $key->bobot; //4
			$row[] = $key->id; //5

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->M_kriteria_detail->count_all(),
			"recordsFiltered" => $this->M_kriteria_detail->count_filtered(),
			"data" => $data
		);

		echo json_encode($output);
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

	public function ajax_save_detail()
	{
		$insert = array(
			'id_kriteria' => $this->input->post('id_kriteria'),
			'detail' => $this->input->post('detail'),
			'bobot' => $this->input->post('bobot_detail')
		);

		$this->M_kriteria_detail->save($insert);
	}

	public function ajax_edit($id)
	{
		$this->M_kriteria->edit($id);
	}

	public function ajax_edit_detail($id)
	{
		$this->M_kriteria_detail->edit($id);
	}

	public function ajax_delete()
	{
		$this->M_kriteria->ajax_delete($this->input->post('id'));
	}

	public function ajax_delete_detail()
	{
		$this->M_kriteria_detail->ajax_delete($this->input->post('id'));
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

	public function ajax_update_detail($id)
	{
		$insert = array(
			'id_kriteria' => $this->input->post('id_kriteria'),
			'detail' => $this->input->post('detail'),
			'bobot' => $this->input->post('bobot_detail')
		);
		$this->M_kriteria_detail->update($id, $insert);
	}

	public function select2_kode_kriteria()
	{
		$return = array('total' => 0, 'rows' => array());

		$term = $this->input->get_post('query');
		$page = $this->input->get_post('page');
		$id = $this->input->get_post('id');
		$limit = $this->input->get_post('limit');

		$where = "";
		if (!$page) $page = 1;
		if (!$limit) $limit = 10;
		$start = ($page - 1) * $limit;

		if ($term) {
			// $term = mysqli_real_escape_string( $this->link, $term );
			$where .= "where id like '%{$term}%' OR kd_kriteria like '%{$term}%'";
		} else if ($id) {
			$where .= "where id = '$id'";
		}

		$SQL = "
            SELECT count(*) as total
            FROM kriteria
            {$where}
        ";

		$query = $this->db->query($SQL);
		$return['total'] = $query->row()->total;

		if ($return['total'] > 0) {

			$sql = "SELECT
                *
            FROM kriteria
            {$where}
            ORDER BY kriteria ASC
            LIMIT $start, $limit";
			$query = $this->db->query($sql);
			if ($query->num_rows()) {
				$return['rows'] = $query->result_array();
			}
		}

		header('Content-type:application/json');
		echo json_encode($return);
		exit;
	}
}
