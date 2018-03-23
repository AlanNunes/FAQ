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
		$data = date("Y-m-d");
		$sql = "INSERT INTO perguntas (perguntaConteudo, nome, email, data) VALUES ('$conteudo', '$nome', '$email', '$data')";
		if($this->conn->query($sql)){
			return true;
		}else{
			return false;
		}
	}

	public function listPerguntasSemRespostas(){
		$sql = "SELECT * FROM perguntas WHERE respostaId IS NULL OR categoriaId IS NULL ORDER BY data";
		return $this->conn->query($sql);
	}

	public function adicionaResposta($categoriaId, $perguntaId, $resposta){
		$sql = "INSERT INTO respostas (respostaConteudo) VALUES ('{$resposta}')";
		if($this->conn->query($sql)){
			$respostaId = $this->conn->insert_id;
			$sql = "UPDATE perguntas SET respostaId = {$respostaId}, categoriaId = {$categoriaId} WHERE perguntaId = {$perguntaId}";
			if($this->conn->query($sql)){
				return array("erro" => false);
			}
		}
		return array("erro" => true);
	}

}
?>