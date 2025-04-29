<?php 
date_default_timezone_set('Asia/Jakarta');
use Ramsey\Uuid\Uuid;

class ujian_model extends CI_Model {

    public function rules()
	{
		return[
			[
				'field' => 'namaUjian',
				'label' => 'Nama Ujian',
				'rules' => 'required'
			],
			[
				'field' => 'tgl_mulai',
				'label' => 'Tanggal Mulai',
				'rules' => 'required'
			],
			[
				'field' => 'tgl_selesai',
				'label' => 'Tanggal Selesai',
				'rules' => 'required'
			]
		];
	}

	public function get_all()
	{
		$this->db->select("u.*,m.nama AS mapel_nama, DATE_FORMAT(u.tgl_mulai, '%d-%m-%Y %H:%m') as tgl_mulai_formatted, DATE_FORMAT(u.tgl_selesai, '%d-%m-%Y %H:%m') as tgl_selesai_formatted, g.nama AS guru_nama", FALSE);
		$this->db->from('ujian u');
		$this->db->join('guru g', 'g.uuid = u.created_by', 'left');
		$this->db->join('mapel m', 'm.uuid = u.mapel_uuid', 'left');
		$this->db->where('u.deleted_at', NULL, FALSE);
		$this->db->order_by('u.modified_at', 'DESC');
		
		return $this->db->get()->result();
	}
	
    public function insert()
	{
		$uuid = Uuid::uuid4()->toString();
        $mapel_uuid = $this->input->post('namaMapel');
		$namaUjian = $this->input->post('namaUjian');
		$tgl_mulai = $this->input->post('tgl_mulai');
		$tgl_selesai = $this->input->post('tgl_selesai');
		$user = $this->session->userdata('uuid');

		$data = array(
			'uuid' => $uuid,
			'mapel_uuid' => $mapel_uuid,
			'nama' => $namaUjian,
			'tgl_mulai' => $tgl_mulai,
			'tgl_selesai' => $tgl_selesai,
			'created_by' => $user
		);

		$this->db->insert('ujian', $data);
		if ($this->db->affected_rows() > 0) {
			// return true;
			return $data['uuid'];
		} else {
			return false;
		}
	}

	public function delete_by_uuid($uuid)
	{
		$data = array(
			'deleted_at' => date("Y-m-d H:i:s")
		);
		$this->db->update('ujian', $data, array('uuid' => $uuid));
		return($this->db->affected_rows() > 0) ? true :false;
	}

	public function get_by_uuid($uuid)
	{
		$data = $this->db->get_where('ujian', array('uuid' => $uuid))->row();
		
		return $data;
	}

	public function get_jawaban_siswa_by_ujian_siswa_uuid($ujian_uuid , $siswa_uuid)
	{
		$this->db->select(
			'uj.*, uo.*, u.*'
		);
		$this->db->from('ujian u');
		$this->db->join('ujian_soal uo', 'uo.ujian_uuid = u.uuid', 'left');
		$this->db->join('ujian_jawaban uj', 'uj.soal_uuid = uo.uuid', 'left');
		$this->db->where('u.uuid', $ujian_uuid);
		$this->db->where('uj.created_by', $siswa_uuid);
		$this->db->where('uj.deleted_at', NULL, FALSE);
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->order_by('uj.created_by', 'DESC');
		
		return $this->db->get()->result();
	}

	public function get_pengumpulan_siswa($ujian_uuid , $siswa_uuid)
	{
			$this->db->select(
				"modified_at"
			);
			$this->db->from('ujian_jawaban');
			$this->db->where('ujian_uuid', $ujian_uuid);
			$this->db->where('created_by', $siswa_uuid);
			$this->db->where('deleted_at', NULL, FALSE);
			$this->db->group_by('ujian_uuid');
			
			// return $this->db->get()->result();
			return $this->db->get()->row(); 

	}

}
?>