<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminpanel extends CI_Controller {

	public function index(){
		$this->load->view('admin/login');
	}

	public function dashboard(){
		if(empty($this->session->userdata('userName'))){
			redirect('adminpanel');
		}
		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/menu');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/layout/footer');
	}

	public function login() {
		$this->load->model('Madmin');
		$u = $this->input->post('username');
		$p = md5($this->input->post('password'));
		
		// Ambil data pengguna dari database
		$user = $this->Madmin->cek_login($u, $p)->row();
	
		if ($user) { 
			$data_session = array(
				'idAdmin' => $user->idAdmin, 
				'userName' => $user->userName,
				'status' => 'login'
			);
			$this->session->set_userdata($data_session);
			redirect('adminpanel/dashboard');
		} else {
			redirect('adminpanel');
		}
	}
	
	

	public function logout(){
		$this->session->sess_destroy();
		redirect('adminpanel');
	}

	public function admin(){
		if(empty($this->session->userdata('userName'))){
			redirect('adminpanel');
		}

		$this->load->model('Madmin');
		$data['admin']=$this->Madmin->get_all_data('tbl_admin')->result();
		
		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/menu');
		$this->load->view('admin/admin', $data);
		$this->load->view('admin/layout/footer');
	}

	public function delete($id){
		if(empty($this->session->userdata('userName'))){
			redirect('adminpanel');
		}
		$this->load->model('Madmin');
		$this->Madmin->delete('tbl_admin', 'idAdmin', $id);
		redirect('adminpanel/admin');
	}

	public function get_by_id($id){
		if(empty($this->session->userdata('userName'))){
			redirect('adminpanel');
		}
		$this->load->model('Madmin');
		$dataWhere = array('idAdmin'=>$id);
		$data['admin'] = $this->Madmin->get_by_id('tbl_admin', $dataWhere)->row_object();
		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/menu');
		$this->load->view('admin/kategori/formEdit', $data);
		$this->load->view('admin/layout/footer');
	}


}
