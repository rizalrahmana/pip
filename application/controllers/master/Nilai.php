<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nilai extends User_auth
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('master/M_nilai', 'M_nilai');
		$this->load->helper('tanggal_indo');
	}

	public function index()
	{
		$this->load->view('master/nilai');
	}

	public function ajaxTable()
	{
		$list = $this->M_nilai->tampil();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no; //0
			$row[] = $key->nama; //1 
			$row[] = $key->kriteria; //2
			$row[] = $key->bobot; //3
			$row[] = $key->id; //4

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->M_nilai->count_all(),
			"recordsFiltered" => $this->M_nilai->count_filtered(),
			"data" => $data
		);

		echo json_encode($output);
	}

	public function kalkulasi()
	{
		$data = $this->db->query(
			'SELECT
			mp.id as id_siswa,
			ks.id,
			mp.nama,
			dk.detail,
			dk.bobot AS bobot_dk,
			k.kd_kriteria,
			k.bobot AS bobot_kriteria,
			k.sifat
			FROM kriteria_siswa ks
			LEFT JOIN kriteria k 			ON  ks.id_kriteria 			=  k.id
			LEFT JOIN detail_kriteria dk 	ON  ks.id_detail_kriteria 	=  dk.id
			LEFT JOIN master_pesdik mp 	ON  ks.id_pesdik 				=  mp.id'
		)->result_array();

		$rating_kecocokan = array();
		foreach ($data as $key => $value) {
			$row = array();
			if ($key > 0) {
				if ($value['id_siswa'] == $data[$key - 1]['id_siswa']) {
					$rating_kecocokan[$value['id_siswa']]['kode_kriteria'][] = $value['kd_kriteria'];
					$rating_kecocokan[$value['id_siswa']]['sifat_kriteria'][] = $value['sifat'];
					$rating_kecocokan[$value['id_siswa']]['bobot_detail'][] = $value['bobot_dk'];
					$rating_kecocokan[$value['id_siswa']]['bobot_k'][] = $value['bobot_kriteria'];
				} else {
					$row['nama_siswa'] = $value['nama'];
					$row['kode_kriteria'] = array($value['kd_kriteria']);
					$row['sifat_kriteria'] = array($value['sifat']);
					$row['bobot_detail'] = array($value['bobot_dk']);
					$row['bobot_k'] = array($value['bobot_kriteria']);
					$row['id_siswa'] = $value['id_siswa'];
					$rating_kecocokan[$value['id_siswa']] = $row;
				}
			} else {
				$row['nama_siswa'] = $value['nama'];
				$row['kode_kriteria'] = array($value['kd_kriteria']);
				$row['sifat_kriteria'] = array($value['sifat']);
				$row['bobot_detail'] = array($value['bobot_dk']);
				$row['bobot_k'] = array($value['bobot_kriteria']);
				$row['id_siswa'] = $value['id_siswa'];
				$rating_kecocokan[$value['id_siswa']] = $row;
			}
		}
		$rating_kecocokan1 = array();
		foreach ($rating_kecocokan as $key => $value) {
			$rating_kecocokan1[] = $value;
		}

		//normalisasi Detail Kriteria
		$minmax = array();

		foreach ($rating_kecocokan1 as $key => $value) {

			foreach ($value['sifat_kriteria'] as $k => $sa) {

				if ($sa == "C") {
					if ($key == 0) {
						$minmax[$rating_kecocokan1[$key]['kode_kriteria'][$k]] = $rating_kecocokan1[$key]['bobot_detail'][$k];
					} else {
						if ($rating_kecocokan1[$key]['bobot_detail'][$k] < $minmax[$rating_kecocokan1[$key]['kode_kriteria'][$k]]) {
							$minmax[$rating_kecocokan1[$key]['kode_kriteria'][$k]] = $rating_kecocokan1[$key]['bobot_detail'][$k];
						}
					}
				} else {
					if ($key == 0) {
						$minmax[$rating_kecocokan1[$key]['kode_kriteria'][$k]] = $rating_kecocokan1[$key]['bobot_detail'][$k];
					} else {
						if ($rating_kecocokan1[$key]['bobot_detail'][$k] > $minmax[$rating_kecocokan1[$key]['kode_kriteria'][$k]]) {
							$minmax[$rating_kecocokan1[$key]['kode_kriteria'][$k]] = $rating_kecocokan1[$key]['bobot_detail'][$k];
						}
					}
				}
			}
		}

		foreach ($rating_kecocokan1 as $key => $value) {
			foreach ($value['sifat_kriteria'] as $k => $v) {
				if ($v == "C") {
					$rating_kecocokan1[$key]['bobot_detail'][$k] = $minmax[$rating_kecocokan1[$key]['kode_kriteria'][$k]] / $rating_kecocokan1[$key]['bobot_detail'][$k];
				} else {
					$rating_kecocokan1[$key]['bobot_detail'][$k] = $rating_kecocokan1[$key]['bobot_detail'][$k] / $minmax[$rating_kecocokan1[$key]['kode_kriteria'][$k]];
				}
			}
		}

		$ranking = array();
		foreach ($rating_kecocokan1 as $key => $value) {
			$total = 0;
			foreach ($value['sifat_kriteria'] as $k => $v) {
				$total += $rating_kecocokan1[$key]['bobot_detail'][$k] * $rating_kecocokan1[$key]['bobot_k'][$k];
			}
			$row['nama_pesdik'] = $value['nama_siswa'];
			$row['nilai'] = $total;
			$ranking[$total . "-" . $value['id_siswa']] = $row;
		}
		// asort($ranking);
		usort($ranking, function ($a, $b) {
			if ($a['nilai'] == $b['nilai']) return 0;
			return $a['nilai'] < $b['nilai'] ? 1 : -1;
		});
		echo json_encode($ranking);
	}

	public function ajax_save()
	{

		$data_input = $this->input->post('detail_kriteria');
		foreach ($data_input as $key => $value) {
			$data = array(
				'id_pesdik' => $this->input->post('pesdik'),
				'id_detail_kriteria' => $value,
				'id_kriteria' => $key
			);
			$this->db->insert('kriteria_siswa', $data);
		}
		echo json_encode("true");
		// $insert = array(
		// 	'id_pesdik' => $this->input->post('pesdik'),
		// 	'id_kriteria' => $this->input->post('detail'),
		// 	'id_detail_kriteria' => $this->input->post('bobot_detail')
		// );

		// $this->M_nilai->save($insert);
	}

	public function ajax_delete()
	{
		$this->M_nilai->ajax_delete($this->input->post('id'));
	}

	public function select2_pesdik()
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
			$where .= "where id like '%{$term}%' OR nama like '%{$term}%'";
		} else if ($id) {
			$where .= "where id = '$id'";
		}

		$SQL = "
            SELECT count(*) as total
            FROM master_pesdik
            {$where}
        ";

		$query = $this->db->query($SQL);
		$return['total'] = $query->row()->total;

		if ($return['total'] > 0) {

			$sql = "SELECT
                *
            FROM master_pesdik
            {$where}
            ORDER BY id ASC
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
