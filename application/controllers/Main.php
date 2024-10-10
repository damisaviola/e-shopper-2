<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('Madmin');
		$this->load->library('cart');
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
	
		$params = array(
			'server_key' => 'SB-Mid-server-KClKjF4WF2RVmJsTr891CQcn',
			'production' => false
		);
		$this->load->library('Midtrans');
		$this->midtrans->config($params);
	
		$this->load->helper('url');
	}
	

	public function index()
	{
		$idKonsumen = $this->session->userdata('idKonsumen');
		$dataWhere = array('idKonsumen' => $idKonsumen);
		$this->db->where('idKonsumen', $idKonsumen);
		$data['member'] = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();
		$data['produk']=$this->Madmin->get_produk()->result();
		$data['kategori']=$this->Madmin->get_all_data('tbl_kategori')->result();
		$data['reviews'] = $this->Madmin->get_reviews();
		$this->load->view('home/layout/header',$data);
		$this->load->view('home/layanan');
		$this->load->view('home/home');
		$this->load->view('home/layout/footer');
	}



public function get_by_id($idDetailOrder){
	$idKonsumen = $this->session->userdata('idKonsumen');
		$dataWhere = array('idKonsumen' => $idKonsumen);
		$this->db->where('idKonsumen', $idKonsumen);
		$data['member'] = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();
		$data['produk']=$this->Madmin->get_produk()->result();
		$data['kategori']=$this->Madmin->get_all_data('tbl_kategori')->result();
		$data['reviews'] = $this->Madmin->get_reviews();
	$data['detailOrder'] = $this->Madmin->get_by_id1($idDetailOrder);
	$this->load->view('home/layout/header', $data);
    $this->load->view('home/layanan');
    $this->load->view('home/resi', $data);
    $this->load->view('home/layout/footer');
}



public function save() {
	$iddetailorder = $this->input->post('id');
	$nomor_resi = $this->input->post('resi');
	
	if (!empty($nomor_resi)) {
		$this->Madmin->updateNullNomorResi($iddetailorder, $nomor_resi);
	}
	
	
	redirect('main/history');
}

	public function history() {
		if (empty($this->session->userdata('idKonsumen'))) {
			echo "<script>alert('Anda harus login dulu untuk melihat history belanja');history.back()</script>";
			exit();
		}
	
		$idKonsumen = $this->session->userdata('idKonsumen');
		$dataWhere = array('idKonsumen' => $idKonsumen);
	
		$this->db->where('idKonsumen', $idKonsumen);
		$data['member'] = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();
		$data['order'] = $this->Madmin->get_order_with_product($idKonsumen);
	
		$this->load->view('home/layout/header', $data);
		$this->load->view('home/layanan');
		$this->load->view('home/history', $data);
		$this->load->view('home/layout/footer');
	}



	public function history_jual($idDetailOrder) {
		$idKonsumen = $this->session->userdata('idKonsumen');
		
		if (!$idKonsumen) {
			redirect('login');
		}
		
		$toko = $this->Madmin->get_toko_by_konsumen($idKonsumen);
		
		if (!$toko) {
			show_error('Toko tidak ditemukan untuk konsumen ini');
		}
		
		$data['member'] = $this->Madmin->get_by_id('tbl_member', array('idKonsumen' => $idKonsumen))->row();
		$data['order'] = $this->Madmin->get_order_with_product($idKonsumen);
		
		$idToko = $toko->idToko;
		$data['orders'] = $this->Madmin->getSoldItemsByStore($idToko);

		$dataWhere = array('idDetailOrder' => $idDetailOrder); 
		
		$data['DetailOrder'] = $this->Madmin->get_by_id('tbl_detail_order', $dataWhere)->row_object();
		$data['kategori']=$this->Madmin->get_all_data('tbl_kategori')->result();
	
		$this->load->view('home/layout/header', $data);
		$this->load->view('home/layanan');
		$this->load->view('home/h_jual', $data);
		$this->load->view('home/layout/footer');
	}
	
	

	public function input_nomor_resi() {
		$idDetailOrder = $this->input->post('idDetailOrder');
		$nomorResi = $this->input->post('nomor_resi');
	
		if (!$idDetailOrder || !$nomorResi) {
			
			echo "Error";
		}
	
		// Panggil model untuk menyimpan nomor resi
		$success = $this->Madmin->updateResiNumber($idDetailOrder, $nomorResi);
	
		if ($success) {
			// Redirect atau tampilkan pesan sukses
			echo "berhasil";
		} else {
			// Handle jika gagal menyimpan nomor resi
			echo "gagal";
		}
	}
	
	

	public function detail_produk($idProduk) {
        $idKonsumen = $this->session->userdata('idKonsumen');
        $dataWhere = array('idKonsumen' => $idKonsumen);
        $this->db->where('idKonsumen', $idKonsumen);
        $data['member'] = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();    

        // Ambil detail produk
        $dataWhere = array('idProduk' => $idProduk);
        $data['product'] = $this->Madmin->get_product_by_id($idProduk);
        $data['produk1'] = $this->Madmin->get_produk()->result(); // Ambil semua produk
        $data['produk'] = $this->Madmin->get_by_id('tbl_produk', $dataWhere)->row_object();
        $data['kategori'] = $this->Madmin->get_all_data('tbl_kategori')->result();
        $data['reviews'] = $this->Madmin->get_reviews_by_product($idProduk);

        // Ambil rekomendasi produk berdasarkan idProduk dari fungsi recommend di produk.php
        $data['recommendedProducts'] = $this->Madmin->recommend($idProduk);

        // Load view
        $this->load->view('home/layout/header', $data);
        $this->load->view('home/detail_produk', $data);
        $this->load->view('home/layout/footer');
    }


	public function submit_review() {
		
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('rating', 'Rating', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]');
		$this->form_validation->set_rules('message', 'Review', 'required');
		
	
		if ($this->form_validation->run() === FALSE) {
			
			echo "ok";
		} else {
			
			$data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'rating' => $this->input->post('rating'),
				'message' => $this->input->post('message'),
				'idProduk' => $this->input->post('product_id')
			);
	
			
			if ($this->Madmin->add_review($data)) {
				$this->session->set_flashdata('success', 'Your review has been submitted.');
			} else {
				$this->session->set_flashdata('error', 'Failed to submit review. Please try again.');
			}
	
			
			redirect('main/detail_produk/'.$this->input->post('product_id'));
		}
	}
	

	public function register()
	{
		$this->load->view('home/layout/header');
		$this->load->view('home/register');
		$this->load->view('home/layout/footer');
	}

	public function save_reg(){
		$nama = $this->input->post('nama');
		$email = $this->input->post('email');
		$telpon = $this->input->post('telpon');
		$idKota = $this->input->post('city');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$alamat = $this->input->post('alamat');

		$dataInput=array('username'=>$username,'password'=>$password, 'idKota'=>$idKota,'namaKonsumen'=>$nama,'alamat'=>$alamat,'email'=>$email,'tlpn'=>$telpon,'statusAktif'=>'Y');
		$this->Madmin->insert('tbl_member', $dataInput);
		redirect('main/login');
	}

	public function login(){
		$data['kategori']=$this->Madmin->get_all_data('tbl_kategori')->result();
		$this->load->view('home/layout/header', $data);
		$this->load->view('home/login');
		$this->load->view('home/layout/footer');	
	}

	public function login_member(){
		$this->load->model('Madmin');
		$u = $this->input->post('username');
		$p = $this->input->post('password');
	
		$cek = $this->Madmin->cek_login_member($u, $p)->num_rows();
		$result = $this->Madmin->cek_login_member($u, $p)->row();
	
		if($cek == 1 && $result){ 
			$data_session = array(
				'idKonsumen' => $result->idKonsumen,
				'idKotaTujuan' => $result->idKota,
				'Member' => $u,
				'status' => 'login'
			);
			$this->session->set_userdata($data_session);
			redirect('main/dashboard');
		} else {
			redirect('main/login');
		}
	}
	

	public function dashboard(){
		$idKonsumen = $this->session->userdata('idKonsumen');
		$dataWhere = array('idKonsumen' => $idKonsumen);
		$this->db->where('idKonsumen', $idKonsumen);
		$data['member'] = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();
		$this->load->view('home/layout/header',$data);
		$this->load->view('home/dashboard');
		$this->load->view('home/layout/footer');
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('main/login');
	}

	public function add_cart($idProduk) {


		if(empty($this->session->userdata('idKonsumen'))) {
			echo "<script>alert('Anda harus login dulu untuk add cart');history.back()</script>";
			exit();
		}
		
		$dataWhere = array('idProduk' => $idProduk);
		$produk = $this->Madmin->get_by_id('tbl_produk', $dataWhere)->row_object();
		$kota = $this->Madmin->get_kota_penjual($produk->idToko)->row_object();
	
		$this->session->set_userdata('idKotaAsal', $kota->idKota);
		$this->session->set_userdata('idTokoPenjual', $produk->idToko);
	
		$data = array(
			'id' => $produk->idProduk,
			'qty' => 1,
			'price' => $produk->harga,
			'name' => $produk->namaProduk,
			'image' => $produk->foto
		);
	
		$this->cart->insert($data);
		redirect("main/cart");
	}

	

	public function proses_transaksi() {
	
		$dataWhere = array('idKonsumen' => $this->session->userdata('idKonsumen'));
		$member = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();
	
		
		$kota_asal = $this->session->userdata('idKotaAsal');
		$kota_tujuan = $this->session->userdata('idKotaTujuan');
	
		
		$this->load->helper('toko');
		$ongkir = getOngkir($kota_asal, $kota_tujuan, '1000', 'jne');
		$ongkir_value = $ongkir['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'];
	
		
		$dataInput = array(
			'idKonsumen' => $member->idKonsumen,
			'idToko' => $this->session->userdata('idTokoPenjual'),
			'tglOrder' => date("Y-m-d"),
			'statusOrder' => "Dikemas",
			'kurir' => "JNE Oke",
			'ongkir' => $ongkir_value,
		);
		$this->Madmin->insert('tbl_order', $dataInput);
		$insert_id = $this->db->insert_id();
	
		
		$cartItems = $this->cart->contents();
    foreach ($cartItems as $item) {
        $dataInput2 = array(
            'idOrder' => $insert_id,  // Gunakan ID pesanan yang baru saja dimasukkan
            'idProduk' => $item['id'],
            'jumlah' => $item['qty'],
            'harga' => $item['price'] * $item['qty'],  // Hitung harga total untuk item ini
        );
        
        $this->Madmin->insert('tbl_detail_order', $dataInput2);
    }

    
  


		$transaction_details = array(
			'order_id' => $insert_id,
			'gross_amount' => $ongkir_value + $this->cart->total(), 
		);
	
		$item_details = [];
		foreach ($this->cart->contents() as $item) {
			$item_details[] = array(
				'id' => $item["id"],
				'price' => $item["price"],
				'quantity' => $item["qty"],
				'name' => $item["name"]
			);
		}
	
		$item_details[] = array(
			'id' => 'ONGKIR',
			'price' => $ongkir_value,
			'quantity' => 1,
			'name' => "Ongkos Kirim JNE Oke"
		);
	
		$billing_address = array(
			'first_name'    => $member->namaKonsumen,
			'address'       => $member->alamat,
			'city'          => $member->alamat,
			'phone'         => $member->tlpn,
			'country_code'  => 'IDN'
		);
	
		$shipping_address = array(
			'first_name'    => $member->namaKonsumen,
			'address'       => $member->alamat,
			'city'          => $member->alamat,
			'phone'         => $member->tlpn,
			'country_code'  => 'IDN'
		);
	
		$customer_details = array(
			'first_name'    => $member->namaKonsumen,
			'email'         => $member->email,
			'phone'         => $member->tlpn,
			'billing_address'  => $billing_address,
			'shipping_address' => $shipping_address
		);
	
		$credit_card = array('secure' => true);
	
		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'hour',
			'duration'  => 2
		);
	
		$transaction_data = array(
			'transaction_details'=> $transaction_details,
			'item_details'       => $item_details,
			'customer_details'   => $customer_details,
			'credit_card'        => $credit_card,
			'expiry'             => $custom_expiry
		);
	
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		echo $snapToken;
	}
	
	

	public function finish() {
		
		$result_data = $this->input->post('result_data'); 
	
		
		if (!empty($result_data)) {
			
			$result = json_decode($result_data);
	
			if (!$result) {
				
				echo 'Error decoding result data';
				exit;
			}
	
			// Cek apakah transaction_status ada dan tidak kosong
			if (isset($result->transaction_status) && !empty($result->transaction_status)) {
				// Cek jika transaction_status adalah "settlement"
				if ($result->transaction_status == "settlement") {
					// Update statusOrder menjadi 'Dikemas'
					$id = $result->order_id; // Sesuaikan dengan nama field yang digunakan
					$dataUpdate = array('statusOrder' => 'Dikemas');
					$this->Madmin->update('tbl_order', $dataUpdate, 'idOrder', $id); // Sesuaikan dengan model dan field yang digunakan
	
					// Redirect ke halaman utama atau halaman berhasil
					redirect('/');
				} else {
					// Handle jika transaksi tidak berhasil
					echo 'Transaction status is not settlement';
				}
			} else {
				// Handle jika transaction_status tidak ada atau kosong
				echo 'Transaction status is not provided or empty';
			}
		} else {
			// Handle jika data result_data kosong atau tidak terdefinisi
			echo 'No result data received';
		}
	}
	
	
	

	public function cart() {
		if(empty($this->session->userdata('idKonsumen'))) {
			echo "<script>alert('Anda harus login dulu untuk add cart');history.back()</script>";
			exit();
		}
	
		$data['kota_asal'] = $this->session->userdata('idKotaAsal');
		$data['kota_tujuan'] = $this->session->userdata('idKotaTujuan');
	
		$data['cartItems'] = $this->cart->contents();
		$data['kategori'] = $this->Madmin->get_all_data('tbl_kategori')->result();
		$data['total'] = $this->cart->total();
	
		$this->load->view('home/layout/header', $data);
		$this->load->view('home/cart', $data);
		$this->load->view('home/layout/footer');  
	}
	

	public function delete_cart () {
		$remove = $this->cart->remove($rowId);
		redirect("main/cart");
	}

	public function getProvince() {
		$curl = curl_init();
	
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: 6b5ae6f345b32a50c26c87b48e6a799e"
			),
		));
	
		$response = curl_exec($curl);
		$err = curl_error($curl);
	
		curl_close($curl);
	
		$data = json_decode($response, true);
	
		echo "<option value=''>Pilih Provinsi</option>";
	
		for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
			echo "<option value='" . $data['rajaongkir']['results'][$i]['province_id'] . "'>" . $data['rajaongkir']['results'][$i]['province']. "</option>";
		}
	}

	public function getCity($province) {
		$curl = curl_init();
	
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://api.rajaongkir.com/starter/city?province=" . $province,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: 6b5ae6f345b32a50c26c87b48e6a799e"
			),
		));
	
		$response = curl_exec($curl);
		$err = curl_error($curl);
	
		curl_close($curl);
	
		$data = json_decode($response, true);
	
		echo "<option value=''>Pilih Kota</option>";
	
		foreach ($data['rajaongkir']['results'] as $city) {
			echo "<option value='" . $city['city_id'] . "'>" . $city['city_name'] . "</option>";
		}
	}

	public function produk_by_kategori($idKategori) {
		$idKonsumen = $this->session->userdata('idKonsumen');
		$dataWhere = array('idKonsumen' => $idKonsumen);
		$this->db->where('idKonsumen', $idKonsumen);
		$data['member'] = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row();
		$data['produk']=$this->Madmin->get_produk()->result();
		$data['kategori']=$this->Madmin->get_all_data('tbl_kategori')->result();
		$data['reviews'] = $this->Madmin->get_reviews();
		$data['produk']=$this->Madmin->get_produk()->result();
		$data['kategori'] = $this->Madmin->get_all_data('tbl_kategori')->result();
		$data['produk_l'] = $this->Madmin->get_produk_by_kategori($idKategori)->result();
		$data['selected_kategori'] = $this->Madmin->get_by_id('tbl_kategori', array('idkat' => $idKategori))->row_object();
		$this->load->view('home/layout/header', $data);
		$this->load->view('home/layanan');
		$this->load->view('home/filter', $data);
		$this->load->view('home/layout/footer');
	}
	
	
	
	

}
