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

}
?>