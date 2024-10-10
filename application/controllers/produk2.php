<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Madmin');
	}
public function index($idToko){
	$idKonsumen = $this->session->userdata('idKonsumen');
		$dataWhere = array('idKonsumen' => $idKonsumen);
		$this->db->where('idKonsumen', $idKonsumen);
		$data['member'] = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();
	$data['idToko']=$idToko;
	$dataWhere = array('idToko'=>$idToko);
	$data['produk'] = $this->Madmin->get_by_id('tbl_produk', $dataWhere)->result();
	$data['kategori']=$this->Madmin->get_all_data('tbl_kategori')->result();
	$this->load->view('home/layout/header', $data);
	$this->load->view('home/produk/index', $data);
	$this->load->view('home/layout/footer');
}


public function add($idToko){
	$idKonsumen = $this->session->userdata('idKonsumen');
	$dataWhere = array('idKonsumen' => $idKonsumen);
	$this->db->where('idKonsumen', $idKonsumen);
	$data['member'] = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();
	$data['idToko']=$idToko;
	$data['kategori']=$this->Madmin->get_all_data('tbl_kategori')->result();
	$this->load->view('home/layout/header', $data);
	$this->load->view('home/produk/form_tambah', $data);
	$this->load->view('home/layout/footer');
}

public function get_by_id($idProduk){
	$idKonsumen = $this->session->userdata('idKonsumen');
		$dataWhere = array('idKonsumen' => $idKonsumen);
		$this->db->where('idKonsumen', $idKonsumen);
		$data['member'] = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();
		$data['produk']=$this->Madmin->get_produk()->result();
		$data['kategori']=$this->Madmin->get_all_data('tbl_kategori')->result();
		$data['reviews'] = $this->Madmin->get_reviews();
	$data['idProduk']=$idProduk;
	$data['kategori']=$this->Madmin->get_all_data('tbl_kategori')->result();
	$dataWhere = array('idProduk'=>$data['idProduk']);
	$data['produk'] = $this->Madmin->get_by_id('tbl_produk', $dataWhere)->row_object();
	
	$this->load->view('home/layout/header', $data);
	$this->load->view('home/produk/form_edit', $data);
	$this->load->view('home/layout/footer');
}


function cosineSimilarity($vec1, $vec2) {
    $dotProduct = 0; 
    $normVec1 = 0;   
    $normVec2 = 0;    

    
    foreach ($vec1 as $key => $value) {
        if (isset($vec2[$key])) {
            $dotProduct += $value * $vec2[$key];  
        }
        $normVec1 += $value * $value;  
    }

    
    foreach ($vec2 as $value) {
        $normVec2 += $value * $value;  
    }

   
    if ($normVec1 == 0 || $normVec2 == 0) {
        return 0;
    }


    return $dotProduct / (sqrt($normVec1) * sqrt($normVec2));
}


function textToVector($text) {
   
    $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', strtolower($text));
    
   
    $terms = explode(' ', $text);
    

    return array_count_values($terms);
}


public function recommend($id) {
    // Ambil produk yang dipilih berdasarkan 'idProduk'
    $selectedProduct = $this->Madmin->getProductById($id);

    // Ambil semua produk dari database
    $allProducts = $this->Madmin->getAllProducts();

    
    $selectedVector = $this->textToVector($selectedProduct->deskripsiProduk);

  
    $similarityScores = [];

 
    foreach ($allProducts as $product) {
      
        if ($product->idProduk != $selectedProduct->idProduk) {
     
            $productVector = $this->textToVector($product->deskripsiProduk);

           
            $similarityScores[$product->idProduk] = $this->cosineSimilarity($selectedVector, $productVector);
        }
    }

   
    arsort($similarityScores);

  
    echo '<pre>';
    print_r($similarityScores);
    echo '</pre>';
}






public function save(){
	$idToko=$this->input->post('idToko');
	$idKategori = $this->input->post('kategori');
	$namaProduk = $this->input->post('namaProduk');
	$hargaProduk = $this->input->post('hargaProduk');
	$jumlahProduk = $this->input->post('jumlahProduk');
	$beratProduk = $this->input->post('beratProduk');
	$deskripsi = $this->input->post('deskripsi');
	$config['upload_path'] = './assets/foto_produk/';
	$config['allowed_types'] = 'jpg|png|jpeg';
	$this->load->library('upload', $config);
	if($this->upload->do_upload('gambar')){
		$data_file = $this->upload->data();
		$data_insert=array('idKat' => $idKategori,
							'namaProduk' => $namaProduk,
							'idToko' => $idToko,
							'harga' => $hargaProduk,
							'stok' => $jumlahProduk,
							'berat' => $beratProduk,
							'foto' =>  $data_file['file_name'],
							'deskripsiProduk' => $deskripsi);
		$this->Madmin->insert('tbl_produk', $data_insert);
		redirect('produk/index/'.$idToko);
	} else {
		redirect('produk/add/'.$idToko);
	}
}

public function edit(){
	$idProduk=$this->input->post('idProduk');
	$idToko=$this->input->post('idToko');
	$idKategori = $this->input->post('kategori');
	$namaProduk = $this->input->post('namaProduk');
	$hargaProduk = $this->input->post('hargaProduk');
	$jumlahProduk = $this->input->post('jumlahProduk');
	$beratProduk = $this->input->post('beratProduk');
	$deskripsi = $this->input->post('deskripsi');
	$config['upload_path'] = './assets/foto_produk/';
	$config['allowed_types'] = 'jpg|png|jpeg';
	$this->load->library('upload', $config);

	if($this->upload->do_upload('gambar')){
		$data_file = $this->upload->data();
		$data_update=array('idKat' => $idKategori,
							'namaProduk' => $namaProduk,
							'idToko' => $idToko,
							'harga' => $hargaProduk,
							'stok' => $jumlahProduk,
							'berat' => $beratProduk,
							'foto' =>  $data_file['file_name'],
							'deskripsiProduk' => $deskripsi);
		$this->Madmin->update('tbl_produk', $data_update,'idProduk', $idProduk);
		redirect('produk/index/'.$idToko);
	} else {
		$data_update=array('idKat' => $idKategori,
		'namaProduk' => $namaProduk,
		'idToko' => $idToko,
		'harga' => $hargaProduk,
		'stok' => $jumlahProduk,
		'berat' => $beratProduk,
		'deskripsiProduk' => $deskripsi);
		$this->Madmin->update('tbl_produk', $data_update,'idProduk', $idProduk);

		redirect('produk/index/'.$idToko);
	}
}

public function delete($id){
	$idToko = $this->uri->segment(4);
	$this->Madmin->delete('tbl_produk', 'idProduk', $id);
	redirect('produk/index/'.$idToko);
}

}
