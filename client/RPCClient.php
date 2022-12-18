<?php
error_reporting(1); //error ditampilakan

class RPCClient
{	private $url;

	//function pertama kali di-load saat classdipanggil
	public function __construct($url)
	{	$this->url = $url;
		unset($url);
	}

	//function untuk menghapus selain huruf dan angka
	function filter($data)
	{	$data = preg_replace('/[^a-zA-Z0-9]/', '', $data);
		return $data;
		unset($data);
	}

	public function tampil_semua_data()
	{	$context = stream_context_create(array('http' => array(
					'method' => "GET",
					'header' => "Content-Type:text/xml;charset=UTF-8"
					)));
		$response = file_get_contents($this->url, false, $context);
		$data = xmlrpc_decode($response);
		return $data;
		unset($context,$response,$data);
	}

	public function tampil_data($id_barang)
	{	$id_barang = $this->filter($id_barang);
		$context = stream_context_create(array('http' => array(
					'method' => "GET",
					'header' => "Content-Type:text/xml;charset=UTF-8"
					)));
		$response = file_get_contents($this->url."?id_barang=".$id_barang."&aksi=tampil", false, $context);
		$data = xmlrpc_decode($response);
		return $data;
		// hapus variable dari memory
		unset($id_barang,$context,$response,$data);
	}
}

// url server
$url = 'http://192.168.56.136/rpc-xml-toko/server/server.php';

// buat objek baru dari class Client
$abc = new RPCClient($url);
?>