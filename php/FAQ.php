<?php
class FAQ {
	private $perguntaId;
	private $perguntaConteudo;
	private $respostaId;
	private $respostaConteudo;
	private $categoriaId;

	public function __construct($conn){
		$this->conn = $conn;
	}

	public function setCategoriaId($id){
		$this->categoriaId = $id;
	}

	public function buscaFAQ(){
		$sql = "SELECT perguntaId, perguntaConteudo, categoriaId, perguntas.respostaId as respostaId, respostaConteudo FROM perguntas INNER JOIN respostas ON perguntas.respostaId = respostas.respostaId AND categoriaId = '$this->categoriaId'";
		$response = $this->conn->query($sql);
		if($response->num_rows > 0){
			while($row = $response->fetch_assoc()){
				$faq[] = "<div class='card'>
          <div class='card-header' id='pergunta".$row["perguntaId"]."'>
            <h5 class='mb-0'>
              <button class='btn btn-link' data-toggle='collapse' data-target='#resposta".$row["respostaId"]."' aria-expanded='true' aria-controls='".$row["respostaId"]."'>
                ".$row["perguntaConteudo"]."
              </button>
            </h5>
          </div>

          <div id='resposta".$row["respostaId"]."' class='collapse' aria-labelledby='pergunta".$row["perguntaId"]."' data-parent='#accordion'>
            <div class='card-body'>
            ".$row["respostaConteudo"]."
            </div>
          </div>
        </div>";
			}
			return array("erro" => false, "faq" => $faq);
		}else{
			return array("erro" => true, "faq" => null);
		}
	}

	public function contribuirFAQ($categoria, $pergunta, $resposta, $nome, $email){
		$data = date('Y-m-d');
		$sql = "INSERT INTO perguntas(perguntaConteudo, categoriaId, nome, email, data) VALUES ('$pergunta', '$categoria', '$nome', '$email', '$data')";
		if($this->conn->query($sql)){
			$perguntaId = $this->conn->insert_id;
			$sql = "INSERT INTO respostas (respostaConteudo, nome, email, data) VALUES ('$resposta', '$nome', '$email', '$data')";
			if($this->query($sql)){
				$respostaId = $this->conn->insert_id;

				$sql = "UPDATE perguntas SET respostaId = '$respostaId' WHERE perguntaId = '$perguntaId'";
				if($this->conn->query($sql)){
					// Success
					return 0;
				}
			}
		}
		//Erro
		return -1;
	}

}
?>