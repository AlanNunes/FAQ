<?php
class Perguntas {
	private $id;
	private $conteudo;
	private $respostaId;
	private $nome;
	private $email;
	private $conn;

	public function __construct($conn){
		$this->conn = $conn;
	}

	public function setConteudo($conteudo){
		$this->conteudo = $conteudo;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function registrarPergunta($nome, $email, $conteudo){
		$sql = "INSERT INTO perguntas (perguntaConteudo, nome, email) VALUES ('$conteudo', '$nome', '$email')";
		if($this->conn->query($sql)){
			return true;
		}else{
			return false;
		}
	}

}
?>