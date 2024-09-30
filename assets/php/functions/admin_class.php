<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   		include 'db_connect.php';
    
    	$this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);		
		$qry = $this->db->query("SELECT * FROM TUsuarios where Correo = '".$Correo."' and Contraseña = '".md5($Contraseña)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function login2(){
		
		extract($_POST);		
		$qry = $this->db->query("SELECT * FROM complainants where email = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:/../FIBERTIM CAJA/login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " Nombre = '$Nombre' ";
		$data .= ", Correo = '$Correo' ";
		if(!empty($Contraseña))
		$data .= ", Contraseña = '".md5($Contraseña)."' ";
		$data .= ", TipoUsuario = '$TipoUsuario' ";
		#if($type == 1)
		#	$establishment_id = 0;
		#$data .= ", establishment_id = '$establishment_id' ";
		$chk = $this->db->query("Select * from TUsuarios where Correo = '$Correo' and IdUsuario !='$IdUsuario' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if(empty($IdUsuario)){
			$save = $this->db->query("INSERT INTO TUsuarios set ".$data);
		}else{
			$save = $this->db->query("UPDATE TUsuarios set ".$data." where IdUsuario = ".$IdUsuario);
		}
		if($save){
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM TUsuarios where IdUsuario = ".$IdUsuario);
		if($delete)
			return 1;
	}
	
	function save_cliente(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('IdCliente')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					if (!empty($v)){
						if ($k=='Nombre' && preg_match('/#[0-9]#/',$v)){
							$data = "noalfabetico";
							break;
						}
						if($k=='Telefono' && !is_numeric($v)){
							$data = "nonumerico";
							break;
						}
						$data .= ", $k='$v' ";
					}
					else if($k=='Email'){
						$data .= ", $k='$v' ";
					}
					else {
						$data = "";
						break;
					}
				}
			}
		}
		if(empty($data)){
			return 3;
			exit;
		}
		if($data=='nonumerico'){
			return 4;
			exit;
		}
		if($data=='noalfabetico'){
			return 5;
			exit;
		}
		$check = $this->db->query("SELECT * FROM TClientes where NroDocumento ='$NroDocumento' ".(!empty($IdCliente) ? " and IdCliente != {$IdCliente} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($IdCliente)){
			$save = $this->db->query("INSERT INTO TClientes set $data");
		}else{
			$save = $this->db->query("UPDATE TClientes set $data where IdCliente = $IdCliente");
		}
		if($save)
			return 1;
	}
	function delete_cliente(){
		extract($_POST);
		$delete1 = $this->db->query("DELETE FROM TPagos where IdCliente = ".$IdCliente);
		$delete2 = $this->db->query("DELETE FROM TClientes where IdCliente = ".$IdCliente);
		if($delete2){
			return 1;
		}
	}
	
	function save_payment(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('IdPago')) && !is_numeric($k)){
				if($k == 'MontoPagado'){
					$v = str_replace(',', '', $v);
				}
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(empty($IdPago)){
			$save = $this->db->query("INSERT INTO TPagos set $data");
			#if($save)
			#	$IdPago= $this->db->insert_id;
		}else{
			$save = $this->db->query("UPDATE TPagos set $data where IdPago = $IdPago");
		}
		if($save)
			return 1;
		#if($save)
		#	return json_encode(array('ef_id'=>$ef_id, 'pid'=>$IdPago,'status'=>1));
	}
	function delete_payment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM TPagos where IdPago = ".$IdPago);
		if($delete){
			return 1;
		}
	}
}