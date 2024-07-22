<?php

class Madmin extends CI_Model{
	
	public function cek_login($u, $p) {
		return $this->db->get_where('tbl_admin', array('userName' => $u, 'password' => $p));
	}
	

	public function get_order_by_id($idOrder) {
		$this->db->select('tbl_order.*, tbl_order_detail.idProduk, tbl_order_detail.quantity, (tbl_order.ongkir + tbl_order.total_harga) as total_price');
		$this->db->from('tbl_order');
		$this->db->join('tbl_order_detail', 'tbl_order_detail.order_id = tbl_order.idOrder');
		$this->db->where('tbl_order.idOrder', $idOrder);
		$query = $this->db->get();
		return $query->row_array();
	}
	

	public function get_all_data($tabel){
		$q=$this->db->get($tabel);
		return $q;
	}

	public function insert($tabel, $data){
		$this->db->insert($tabel, $data);
	}

	public function get_by_id($tabel, $id){
		return $this->db->get_where($tabel, $id);
	}

	public function update($tabel, $data, $pk, $id){
		$this->db->where($pk, $id);
		$this->db->update($tabel, $data);
	}

	public function delete($tabel, $id, $val){
		$this->db->delete($tabel, array($id => $val)); 
	}

	public function cek_login_member($u, $p){
		$q = $this->db->get_where('tbl_member', array('username'=>$u, 'password'=>$p, 'statusAktif'=>'Y'));
		return $q;
	}

	public function get_produk(){
		$this->db->select('*');
		$this->db->from('tbl_produk');
		$this->db->join('tbl_toko', 'tbl_toko.idToko = tbl_produk.idToko');
		$this->db->join('tbl_member', 'tbl_member.idKonsumen = tbl_toko.idKonsumen');
		$q = $this->db->get();
		return $q;
	}

	public function get_kota_penjual($idToko){
		$this->db->select('*');
		$this->db->from('tbl_toko');
		$this->db->join('tbl_member', 'tbl_member.idKonsumen = tbl_toko.idKonsumen');
		$this->db->where('tbl_toko.idToko', $idToko);
		$q = $this->db->get();
		return $q;
	}
	
	public function get_produk_by_kategori($idKategori) {
		$this->db->select('*');
		$this->db->from('tbl_produk');
		$this->db->join('tbl_toko', 'tbl_toko.idToko = tbl_produk.idToko');
		$this->db->join('tbl_member', 'tbl_member.idKonsumen = tbl_toko.idKonsumen');
		$this->db->where('tbl_produk.idKat', $idKategori); 
		$q = $this->db->get();
		return $q;
	}

	public function add_review($data) {
        return $this->db->insert('reviews', $data);
    }

	public function get_reviews() {
        $query = $this->db->get('reviews');
        return $query->result_array();
    }
	
	public function get_product_by_id($idProduk) {
        $query = $this->db->get_where('tbl_produk', array('idProduk' => $idProduk));
        return $query->row_array();
    }

	public function get_reviews_by_product($idProduk)
{
    $this->db->where('idProduk', $idProduk);
    $query = $this->db->get('reviews');
    return $query->result_array();
}
	
public function view_order_history() {
    
    $idKonsumen = $this->session->userdata('idKonsumen');

    
    $data['order_history'] = $this->Madmin->get_order_history_by_customer($idKonsumen);

   
    $this->load->view('home/layout/header');
    $this->load->view('home/order_history', $data); 
    $this->load->view('home/layout/footer');
}

// application/models/Madmin.php
 
public function get_order_with_product($idKonsumen) {
	$this->db->select('tbl_detail_order.*, tbl_produk.namaProduk, tbl_produk.harga as hargaProduk, tbl_order.idKonsumen');
	$this->db->from('tbl_detail_order');
	$this->db->join('tbl_produk', 'tbl_detail_order.idProduk = tbl_produk.idProduk');
	$this->db->join('tbl_order', 'tbl_detail_order.idOrder = tbl_order.idOrder'); // Join dengan tbl_order
	$this->db->where('tbl_order.idKonsumen', $idKonsumen); // Filter berdasarkan idKonsumen dari tbl_order
	$query = $this->db->get();
	return $query->result();
}

public function get_sold_items($user_id) {
	$this->db->select('tbl_order.idOrder, tbl_order.tglOrder, tbl_order.statusOrder, tbl_produk.namaProduk, tbl_detail_order.jumlah, tbl_detail_order.harga');
	$this->db->from('tbl_order');
	$this->db->join('tbl_detail_order', 'tbl_order.idOrder = tbl_detail_order.idOrder');
	$this->db->join('tbl_produk', 'tbl_detail_order.idProduk = tbl_produk.idProduk');
	$this->db->where('tbl_order.idKonsumen', $user_id);
	$this->db->where('tbl_order.statusOrder', 'Selesai');
	$query = $this->db->get();
	return $query->result_array();
}

public function get_toko_by_konsumen($idKonsumen) {
	$this->db->select('idToko');
	$this->db->from('tbl_toko');
	$this->db->where('idKonsumen', $idKonsumen);
	$query = $this->db->get();
	return $query->row();
}

public function get_order_with_product_by_toko($idToko) {
	$this->db->select('tbl_order.idOrder, tbl_order.tglOrder, tbl_order.statusOrder, tbl_produk.namaProduk, tbl_detail_order.jumlah, tbl_detail_order.harga');
	$this->db->from('tbl_order');
	$this->db->join('tbl_detail_order', 'tbl_order.idOrder = tbl_detail_order.idOrder');
	$this->db->join('tbl_produk', 'tbl_detail_order.idProduk = tbl_produk.idProduk');
	$this->db->where('tbl_order.idToko', $idToko);
	$this->db->where('tbl_order.statusOrder', 'Selesai');
	$query = $this->db->get();
	return $query->result_array();
}

public function get_sold_items_history() {
	$this->db->select('*');
	$this->db->from('tbl_detail_order');
	$this->db->join('tbl_produk', 'tbl_produk.idProduk = tbl_detail_order.idProduk');
	$this->db->join('tbl_order', 'tbl_order.idOrder = tbl_detail_order.idOrder');
	$this->db->order_by('tbl_order.tglOrder', 'desc');
	$query = $this->db->get();
	return $query->result_array();
}

public function getSoldItemsByStore($idToko) {
    $this->db->select('p.namaProduk, do.idDetailOrder, do.jumlah, do.harga, o.idOrder, o.tglOrder, o.statusOrder, do.nomor_resi');
    $this->db->from('tbl_detail_order do');
    $this->db->join('tbl_produk p', 'p.idProduk = do.idProduk', 'left');
    $this->db->join('tbl_order o', 'o.idOrder = do.idOrder', 'left');
    $this->db->where('p.idToko', $idToko); // Filter berdasarkan ID toko
    $this->db->where('o.statusOrder', 'Dikemas'); // Filter hanya status order yang sudah dikemas
    $this->db->order_by('o.tglOrder', 'DESC');
    $query = $this->db->get();

    return $query->result_array();
}




public function updateResiNumber($idDetailOrder, $nomorResi) {
    $data = array(
        'nomor_resi' => $nomorResi
    );
    $this->db->where('idDetailOrder', $idDetailOrder);
    $this->db->update('tbl_detail_order', $data);
    return $this->db->affected_rows() > 0;
}

public function tambahDataResi($idDetailOrder, $nomorResi) {
	// Data yang akan diinsert atau diupdate
	$data = array(
		'nomor_resi' => $nomorResi
	);

	// Cek apakah data dengan idDetailOrder tersebut sudah ada
	$this->db->where('idDetailOrder', $idDetailOrder);
	$query = $this->db->get('tbl_detail_order');

	if ($query->num_rows() > 0) {
		// Jika sudah ada, lakukan update
		$this->db->where('idDetailOrder', $idDetailOrder);
		$this->db->update('tbl_detail_order', $data);
	} else {
		// Jika belum ada, lakukan insert
		$data['idDetailOrder'] = $idDetailOrder; // Pastikan idDetailOrder dimasukkan juga jika baru di-insert
		$this->db->insert('tbl_detail_order', $data);
	}

	return $this->db->affected_rows() > 0;
}


 public function insertNomorResi($idDetailOrder, $nomorResi) {
        // Data yang akan diinsert hanya pada kolom nomor_resi
        $data = array(
            'nomor_resi' => $nomorResi
        );

        // Lakukan update data nomor_resi ke dalam tabel tbl_detail_order hanya untuk idDetailOrder yang diberikan
        $this->db->where('idDetailOrder', $idDetailOrder);
        $this->db->update('tbl_detail_order', $data);

        // Mengembalikan status berhasil atau tidaknya operasi update
        return $this->db->affected_rows() > 0;
    }

	public function updateNomorResi($iddetailorder, $nomor_resi) {
        $this->db->where('iddetailorder', $iddetailorder);
        $this->db->update('tbl_detail_order', ['nomor_resi' => $nomor_resi]);
    }



	public function update_nomor_resi($idDetailOrder, $nomor_resi) {
        $data = array(
            'nomor_resi' => $nomor_resi
        );

        $this->db->where('idDetailOrder', $idDetailOrder);
        return $this->db->update('tbl_detail_order', $data);
    }

	public function update_nomor_resi1($idDetailOrder, $nomor_resi) {
        $data = array(
            'nomor_resi' => $nomor_resi
        );

        $this->db->where('idDetailOrder', $idDetailOrder);
        return $this->db->update('detailorder', $data);
    }

    public function get_by_id1($idDetailOrder) {
        $this->db->where('idDetailOrder', $idDetailOrder);
        return $this->db->get('tbl_detail_order')->row();
    }

	public function updateNullNomorResi($iddetailorder, $nomor_resi) {
        // Update hanya jika nomor_resi saat ini NULL
        $this->db->where('iddetailorder', $iddetailorder);
        $this->db->where('nomor_resi IS NULL', NULL, FALSE);
        $this->db->update('tbl_detail_order', ['nomor_resi' => $nomor_resi]);
    }

}






