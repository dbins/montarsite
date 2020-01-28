<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once 'conexao.php';  

class Usuarios {
	
	public function __construct(){
		$this->banco = new Conexao();
		$this->conexao = $this->banco->Banco_de_Dados();
	}
	
	public function Listar() {
		$resultado = $this->conexao->query("SELECT usu_cod, usu_nome, usu_data_cad, usu_data_atu from usuarios ORDER BY usu_cod DESC")->fetchAll();	
		return $resultado;
	}
	
	public function RetornarUsuario($id) {
		$consulta = $this->conexao->prepare("SELECT usu_cod, usu_nome, usu_data_cad from usuarios where usu_cod = :id");	
		$consulta->bindParam(':id', $id);
		$consulta->execute();
		return $consulta->fetchAll();
	}
	
	public function Inserir($nome){
		$retorno = false;
		$consulta = $this->conexao->prepare('INSERT INTO usuarios (usu_nome, usu_data_cad) VALUES (:nome, CURRENT_TIMESTAMP)');
		$consulta->execute(array(':nome' => $nome));
		if ($consulta->rowCount() >0){
			$retorno = true;
		}
		return $retorno;
	}
	
	public function Atualizar($nome, $id){
		$retorno = false;
		$consulta = $this->conexao->prepare("UPDATE usuarios SET usu_nome = :nome, usu_data_atu = CURRENT_TIMESTAMP WHERE usu_cod = :id");	
		$consulta->bindParam(':nome', $nome);
		$consulta->bindParam(':id', $id);
		$consulta->execute();
		if ($consulta->rowCount() >0){
			$retorno = true;
		}
		return $retorno;
	}
	
	public function CadastroExistente($nome, $id){
		$retorno = false;
		$consulta = $this->conexao->prepare("SELECT usu_cod from usuarios where usu_nome = :nome and usu_cod <> :id");	
		$consulta->bindParam(':nome', $nome);
		$consulta->bindParam(':id', $id);
		$consulta->execute();
		if ($consulta->rowCount()>0){
			$retorno = true;
		}
		return $retorno;
		
	}

	public function Excluir($id){
		$retorno = false;
		$consulta = $this->conexao->prepare("DELETE from usuarios WHERE usu_cod = :id");
		$consulta->bindParam(':id', $id); 
		$consulta->execute();
		if ($consulta->rowCount()>0){
			$retorno = true;
		}
		return $retorno;
	}
	
	public function ValidarNome($nome){
		$retorno = true;
		$conteudo = $pieces = explode(" ", $nome);
		
		if (count($conteudo) < 2){
			$retorno = false;
		} else {
			$nome_valido = false;
			foreach ($conteudo as $item) {
				$nome_valido = preg_match("/^[a-záàâãéèêíïóôõöúçñ]+$/i", $item);
				if (!$nome_valido) {
					break;   
				}
			}
			if (!$nome_valido){
				$retorno = false;
			}
		}	
		return $retorno;
}	}
?>
