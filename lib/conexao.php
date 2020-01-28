<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

class Conexao {

	public function Banco_de_Dados() {
	  $conn=new PDO("mysql:host=127.0.0.1;dbname=montarsite", "root", "");	
	  return $conn;
	} 
}
?>
