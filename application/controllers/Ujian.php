<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('mapel_model');
		$this->load->model('guru_model');
		$this->load->model('siswa_model');
		$this->load->model('ujian_model');
		$this->load->model('jawaban_model');
		$this->load->model('soal_model');
		$this->load->library('form_validation');
		$this->load->model('auth_model');
		if(!$this->auth_model->current_user()){
			redirect('login');
		}
	}

	public function index()
	{
		$ujian = $this->ujian_model->get_all();
		
		$user_login = $this->session->userdata('uuid'); 
		$peserta = []; 
		// foreach ($ujian as $u) {
		// 	$pengerjaan = false;
		// 	$pengumpulan = false;
		// 	$peserta[$u->uuid] = $this->siswa_model->get_by_ujian($u->uuid);
			
		// 	foreach ($peserta as $p){
		// 		foreach($p as $q){
		// 			if ($q->ujian_uuid == $u->uuid && $q->siswa_uuid == $user_login) {
		// 				$pengerjaan = true;
		// 				break;
		// 			} 
		// 			if ($this->ujian_model->get_pengumpulan_siswa($q->ujian_uuid, $user_login) != NULL) {
		// 				$pengumpulan = true;
		// 				break;
						
		// 			}
		// 		}
		// 	}
		// 	$u->pengumpulan = $pengumpulan;
		// 	$u->pengerjaan = $pengerjaan;
		// }

		foreach ($ujian as $u) {
			$pengerjaan = false;
			$pengumpulan = false;
		
			$peserta[$u->uuid] = $this->siswa_model->get_by_ujian($u->uuid);
		
			foreach ($peserta[$u->uuid] as $q) {
				if ($q->ujian_uuid == $u->uuid && $q->siswa_uuid == $user_login) {
					$pengerjaan = true;
				}
		
				if ($this->ujian_model->get_pengumpulan_siswa($q->ujian_uuid, $user_login) !== NULL) {
					$pengumpulan = true;
				}
			}
		
			$u->pengumpulan = $pengumpulan;
			$u->pengerjaan = $pengerjaan;
		}
		
		
		$data = array(
			'ujian' => $ujian,
			'user' => $user_login,
			'peserta' => $peserta,
			'active_nav' => 'ujian'
		);
		// echo"<pre>";
		// print_r($ujian);
		// echo"</pre>";
		
        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('ujian/ujian', $data);
		$this->load->view('partials/footer');
	}

	public function tambah()
	{
		$rules_ujian = $this->ujian_model->rules();
		$rules_mapel = $this->mapel_model->rules();
		$rules = array_merge($rules_ujian, $rules_mapel);
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) {
			$insert = $this->ujian_model->insert();
			if ($insert) {
				$this->session->set_flashdata('success_msg', 'Data ujian berhasil disimpan');
				
				$action = $this->input->post('action');
				if ($action == 'simpan') {
					redirect('ujian');
				} elseif ($action == 'simpan_detail') {
					redirect('ujian/tambah_soal/'.$insert);	
				} 
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal menyimpan data ujian');
				redirect('ujian/tambah');	
			}
		
		}

		$guru_uuid = $this->session->userdata('uuid');
		$guru = $this->guru_model->get_by_uuid($guru_uuid);
		$mapel_list = json_decode($guru->mapel_uuid);
		$mapel = $this->mapel_model->get_many_mapel_by_uuid($mapel_list);
		
		$data = array(
			'mapel' => $mapel,
			'active_nav' => 'ujian'
		);

        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('ujian/ujian-tambah', $data);
		$this->load->view('partials/footer');
	}

	public function tambah_soal($ujian_uuid)
	{
		$rules = [
			[
				'field' => 'soal',
				'label' => 'Soal',
				'rules' => 'required'
			]
		];
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$insert = $this->soal_model->insert();
			if ($insert) {
				$this->session->set_flashdata('success_msg', 'Data Soal berhasil di simpan');
			}else {
				$this->session->set_flashdata('error_msg', 'Data Soal gagal di simpan');
			}
			redirect('ujian/tambah_soal/'.$ujian_uuid);
		}
		
		$data = array(
			'ujian' => $this->ujian_model->get_by_uuid($ujian_uuid),
			'soal' => $this->soal_model->get_by_ujian_uuid($ujian_uuid),
			'active_nav' => 'ujian'
		);

		// echo"<pre>";
		// print_r($data);
		// echo"</pre>";
		
        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('ujian/ujian-soal', $data);
		$this->load->view('partials/footer');
	}

	public function tambah_siswa($ujian_uuid)
	{
		$rules = [
			[
				'field' => 'siswa',
				'label' => 'siswa',
				'rules' => 'required'
			]
		];
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$insert = $this->siswa_model->insert_on_ujian();
			if ($insert) {
				$this->session->set_flashdata('success_msg', 'Data siswa berhasil di simpan');
			}else {
				$this->session->set_flashdata('error_msg', 'Data siswa gagal di simpan');
			}
			redirect('ujian/tambah_siswa/'.$ujian_uuid);
		}

		$ujian = $this->ujian_model->get_by_uuid($ujian_uuid);
		$peserta = $this->siswa_model->get_by_ujian($ujian_uuid);
		foreach($peserta as $p){
			$pengumpulan = $this->ujian_model->get_pengumpulan_siswa($ujian_uuid, $p->siswa_uuid);
			$p->pengumpulan = $pengumpulan ? $pengumpulan->modified_at : null;
		}
		// echo"<pre>";
		// print_r($peserta);
		// echo"</pre>";
		
		$data = array(
			'ujian' => $ujian,
			'peserta' => $peserta,
			'siswa' => $this->siswa_model->get_all(),
			'active_nav' => 'ujian'
		);

		
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
        $this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('ujian/ujian-siswa', $data);
		$this->load->view('partials/footer');
	}
	
	public function tambah_nilai($ujian_uuid, $siswa_uuid)
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $insert = $this->jawaban_model->insert_nilai($ujian_uuid, $siswa_uuid);
            if ($insert) {
				$this->session->set_flashdata('success_msg', 'Nilai berhasil disimpan');
            } else {
				$this->session->set_flashdata('error_msg', 'Nilai gagal disimpan');
            }
            redirect('ujian/tambah_siswa/'.$ujian_uuid	);
        }
		
		$ujian = $this->ujian_model->get_by_uuid($ujian_uuid);
		$guru = $this->guru_model->get_by_uuid($ujian->created_by);
		$mapel = $this->mapel_model->get_by_uuid($ujian->mapel_uuid);
		$soal = $this->soal_model->get_by_ujian_uuid($ujian_uuid);
		$siswa = $this->siswa_model->get_by_uuid($siswa_uuid);
		//ambil jawaban tiap soal
		$jawaban =[];
		foreach ($soal as $d) {
			$jawaban[$d->uuid] = $this->jawaban_model->get_by_soal_uuid($d->uuid, $siswa_uuid);
		}
		if($jawaban != NULL){
			//ambil nilai total 
			$total_nilai = 0;
			$jumlah_soal = count($soal); // Menghitung jumlah soal
	
			foreach ($jawaban as $uuid => $data) {
				if (!empty($data[0]->nilai)) {
					$total_nilai += $data[0]->nilai;
				}
			}
			$rata_rata = ($jumlah_soal > 0) ? ($total_nilai / $jumlah_soal) : 0;
			$nilai_ujian = number_format($rata_rata, 2);
		}
		
		$data = array(
			'mapel' => $mapel->nama,
			'siswa' => $siswa,
			'guru' => $guru->nama,
			'ujian' => $ujian,
			'soal' => $soal,
			'nilai' => $nilai_ujian,
			'jawaban' => $jawaban,
			'active_nav' => 'ujian'
		);

		// echo"<pre>";
		// print_r($data);
		// echo"</pre>";
		
		$this->load->view('partials/header');
		$this->load->view('partials/sidebar', $data);
        $this->load->view('partials/topbar');
        $this->load->view('ujian/ujian-nilai', $data);
		$this->load->view('partials/footer');
	}

	public function pengerjaan($ujian_uuid)
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $insert = $this->jawaban_model->insert($ujian_uuid);
            if ($insert) {
                $this->session->set_flashdata('success_msg', 'Ujian berhasil disimpan');
            } else {
                $this->session->set_flashdata('error_msg', 'Ujian gagal disimpan');
            }
            redirect('ujian');
        }
	
		$data = array(
			'ujian' => $this->ujian_model->get_by_uuid($ujian_uuid),
			'soal' => $this->soal_model->get_by_ujian_uuid($ujian_uuid)
		);

		// echo"<pre>";
		// print_r($data);
		// echo"</pre>";
		
        $this->load->view('ujian/ujian-pengerjaan', $data);
	}

	public function hapus_siswa($relasi_uuid){
		{
			$result = $this->siswa_model->delete_siswa_ujian_and_ujian_jawaban_by_uuid($relasi_uuid);
			if ($result) {
				$this->session->set_flashdata('success_msg', 'Data siswa ujian berhasil dihapus');
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal menghapus data siswa ujian');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function hapus_soal($soal_uuid){
		{
			$result = $this->soal_model->delete_by_uuid($soal_uuid);
			if ($result) {
				$this->session->set_flashdata('success_msg', 'Data soal ujian berhasil dihapus');
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal menghapus data soal ujian');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function edit_soal($soal_uuid){
		
		$ujian_uuid = $this->input->post('ujian_uuid');
		$rules = [
			[
				'field' => 'soal',
				'label' => 'Soal',
				'rules' => 'required'
			]
		];
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$update = $this->soal_model->update($soal_uuid);
			if ($update) {
				$this->session->set_flashdata('success_msg', 'Data soal berhasil di Update');
				redirect('ujian/tambah_soal/'.$ujian_uuid);
			}else {
				$this->session->set_flashdata('error_msg', 'Data soal gagal di Update');
				redirect('ujian/tambah_soal/'.$ujian_uuid);
			}
		}
	}

	public function hapus($uuid)
	{
		$result = $this->ujian_model->delete_by_uuid($uuid);
		if ($result) {
			$this->session->set_flashdata('success_msg', 'Data ujian berhasil dihapus');
		} else {
			$this->session->set_flashdata('error_msg', 'Gagal menghapus data ujian');
		}
		redirect('ujian');
	}
}