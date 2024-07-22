<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Toko extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Madmin');
	}

	public function index(){
		
		$idKonsumen = $this->session->userdata('idKonsumen');
		$dataWhere = array('idKonsumen' => $idKonsumen);
		$this->db->where('idKonsumen', $idKonsumen);
		$data['member'] = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();
		$dataWhere = array('idKonsumen'=>$this->session->userdata('idKonsumen'));
		$data['toko'] = $this->Madmin->get_by_id('tbl_toko', $dataWhere)->result();
		$data['kategori']=$this->Madmin->get_all_data('tbl_kategori')->result();
		$this->load->view('home/layout/header', $data);
		$this->load->view('home/toko/index', $data);
		$this->load->view('home/layout/footer');
	}

	public function add(){
		$idKonsumen = $this->session->userdata('idKonsumen');
		$dataWhere = array('idKonsumen' => $idKonsumen);
		$this->db->where('idKonsumen', $idKonsumen);
		$data['member'] = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();
		$data['produk']=$this->Madmin->get_produk()->result();
		$data['kategori']=$this->Madmin->get_all_data('tbl_kategori')->result();
		$data['reviews'] = $this->Madmin->get_reviews();
		$this->load->view('home/layout/header' ,$data);
		$this->load->view('home/toko/form_tambah');
		$this->load->view('home/layout/footer');
	}

	public function get_by_id($id){

		

		$dataWhere = array('idToko'=>$id);
		$data['toko'] = $this->Madmin->get_by_id('tbl_toko', $dataWhere)->row_object();
		$idKonsumen = $this->session->userdata('idKonsumen');
		$dataWhere = array('idKonsumen' => $idKonsumen);
		$this->db->where('idKonsumen', $idKonsumen);
		$data['member'] = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();
		$data['produk']=$this->Madmin->get_produk()->result();
		$data['kategori']=$this->Madmin->get_all_data('tbl_kategori')->result();
		$data['reviews'] = $this->Madmin->get_reviews();

		$this->load->view('home/layout/header' ,$data);
		$this->load->view('home/toko/form_edit',$data);
		$this->load->view('home/layout/footer');
	}

	public function save(){
		$id = $this->session->userdata('idKonsumen');
		$nama_toko = $this->input->post('namaToko');
		$deskripsi = $this->input->post('deskripsi');
		$config['upload_path'] = './assets/logo_toko/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$this->load->library('upload', $config);
		if($this->upload->do_upload('logo')){
			$data_file = $this->upload->data();

			$data_insert=array('idKonsumen' => $id,
			'namaToko' => $nama_toko,
			'logo' =>  $data_file['file_name'],
			'deskripsi' => $deskripsi,
			'statusAktif' => 'Y');
			
			$this->Madmin->insert('tbl_toko', $data_insert);
			redirect('toko');
		} else {
			redirect('toko/add');
		}
	}

	public function edit(){
		$id = $this->session->userdata('idKonsumen');
		$idToko = $this->input->post('idToko');
		$nama_toko = $this->input->post('namaToko');
		$deskripsi = $this->input->post('deskripsi');
		$config['upload_path'] = './assets/logo_toko/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$this->load->library('upload', $config);
		if($this->upload->do_upload('logo')){
			$data_file = $this->upload->data();
			$dataUpdate=array('idKonsumen' => $id,
								'namaToko' => $nama_toko,
								'logo' =>  $data_file['file_name'],
								'deskripsi' => $deskripsi,
							'statusAktif' => 'Y');
			$this->Madmin->update('tbl_toko', $dataUpdate,'idToko', $idToko);
			redirect('toko');
		} else {

			$dataUpdate=array('idKonsumen' => $id,
								'namaToko' => $nama_toko,
								'deskripsi' => $deskripsi,
							'statusAktif' => 'Y');
			$this->Madmin->update('tbl_toko', $dataUpdate,'idToko', $idToko);

			redirect('toko');
		}
	}

	public function delete($id){
		$this->Madmin->delete('tbl_toko', 'idToko', $id);
		redirect('toko');
	}
}
