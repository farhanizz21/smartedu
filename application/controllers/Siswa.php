<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('siswa_model');
		$this->load->library('form_validation');
		$this->load->model('auth_model');
		if(!$this->auth_model->current_user()){
			redirect('login');
		}
	}

	public function index()
	{
		$siswa = $this->siswa_model->get_all();

		$data = array(
			'siswa' => $siswa,
			'active_nav' => 'siswa'
		);
		
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

        $this->load->view('partials/header');
		$this->load->view('partials/sidebar');
        $this->load->view('partials/topbar');
        $this->load->view('siswa/siswa', $data);
		$this->load->view('partials/footer');
	}

    public function tambah()
	{
        $rules = $this->siswa_model->rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$insert = $this->siswa_model->insert();
			if ($insert) {
				$this->session->set_flashdata('success_msg', 'Data Siswa berhasil di simpan');
				redirect('siswa');
			}else {
				$this->session->set_flashdata('error_msg', 'Data Siswa gagal di simpan');
				redirect('siswa');
			}
		}

		$data = array(
			'active_nav' => 'siswa'
		);

        $this->load->view('partials/header');
		$this->load->view('partials/sidebar');
        $this->load->view('partials/topbar');
        $this->load->view('siswa/siswa-tambah', $data);
		$this->load->view('partials/footer');;
	}

	public function edit($uuid){
		$rules = [
			[
				'field' => 'namaLengkap',
				'label' => 'Nama Lengkap',
				'rules' => 'required'
			],[
				'field' => 'nis',
				'label' => 'Nomor Induk Siswa',
				'rules' => 'required|regex_match[/^[0-9]{10}$/]|callback_nis_check'
			],[
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|regex_match[/^[a-z]/]|callback_username_check'
			],[
				'field' => 'jenisKelamin',
				'label' => 'Jenis Kelamin',
				'rules' => 'required'
			],[
				'field' => 'tanggal_lahir',
				'label' => 'Tanggal Lahir',
				'rules' => 'required'
			]
		];
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) {
			$update = $this->siswa_model->update($uuid);
			if ($update) {
				$this->session->set_flashdata('success_msg', 'Data Siswa berhasil di Update');
				redirect('siswa');
			}else {
				$this->session->set_flashdata('error_msg', 'Data Siswa gagal di Update');
				redirect('siswa');
			}
		}

		$data = array(
			'siswa' => $this->siswa_model->get_by_uuid($uuid),
			'active_nav' => 'siswa'
		);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";

		$this->load->view('partials/header');
		$this->load->view('partials/sidebar');
        $this->load->view('partials/topbar');
        $this->load->view('siswa/siswa-edit', $data);
		$this->load->view('partials/footer');
	}

	public function username_check($username, $uuid)
	{
		$uuid = $this->input->post('uuid'); // atau sesuaikan dengan cara kamu ambil ID
		$this->db->where('username', $username);
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->where('uuid !=', $uuid);
		$query = $this->db->get('siswa');

		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('username_check', 'Username sudah digunakan oleh pengguna lain.');
			return false;
		}
		
		return true;
	}

	public function nis_check($nis, $uuid)
	{
		$uuid = $this->input->post('uuid'); // atau sesuaikan dengan cara kamu ambil ID
		$this->db->where('nis', $nis);
		$this->db->where('deleted_at', NULL, FALSE);
		$this->db->where('uuid !=', $uuid);
		$query = $this->db->get('siswa');

		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('nis_check', 'NIS sudah digunakan oleh pengguna lain.');
			return false;
		}
		
		return true;
	}

	public function hapus($uuid){
		{
			$result = $this->siswa_model->delete_by_uuid($uuid);
			if ($result) {
				$this->session->set_flashdata('success_msg', 'Data siswa berhasil dihapus');
			} else {
				$this->session->set_flashdata('error_msg', 'Gagal menghapus data siswa');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
}