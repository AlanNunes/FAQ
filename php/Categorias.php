<?php
class Categorias {
	private $id;
	private $nome;
	private $conn;

	public function __construct($conn){
		$this->conn = $conn;
	}

	public function getCategorias(){
		$sql = "SELECT * FROM categorias";
		$response = $this->conn->query($sql);
		if($response->num_rows > 0){
			while($row = $response->fetch_assoc()){
				$categorias[] = $row;
			}
			return array("erro" => false, "categorias" => $categorias);
		}else{
			return array("erro" => true, "categorias" => null);
		}
	}

	public function criarCategoria($nome){
		$sql = "INSERT INTO categorias (categoriaNome) VALUES ('{$nome}')";
		if($this->conn->query($sql)){
			return 0;
		}else{
			return 1;
		}
	}

	public function editCategoria($id, $nome){
		$sql = "UPDATE categorias SET categoriaNome = '{$nome}' WHERE categoriaId = {$id}";
		if($this->conn->query($sql)){
			return 1;
		}else{
			return 0;
		}
	}

	public function excluirCategoria($id){
		$sql = "SELECT perguntaId FROM perguntas WHERE categoriaId = {$id} LIMIT 1";
		$response = $this->conn->query($sql);
		if($response->num_rows > 0){
			return 0;
		}else{
			$sql = "DELETE FROM categorias WHERE categoriaId = {$id} LIMIT 1";
			if($this->conn->query($sql)){
				return 1;
			}else{
				return 0;
			}
		}
	}

}
?>