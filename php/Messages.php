
 <?php
class Messages {
	private $id;
	private $text;
	private $answer;
	private $conn;

	public function __construct($db) {
		$this->conn = $db;
	}

	public function setText($txt){
		$this->text = $this->safe_data($txt);
	}

	public function explodeString($txt){
		$words = array();
		$words = explode(" ", $txt);

		// It removes all empty elements
		$words = array_filter($words, function($value) { return $value !== ''; });

		return $words;
	}

	// This function is going to verify all matchs of words in the row
	// And say if this answer is apropriate to be returned
	// The answers is only apropriated just if the match is above or equal 60 percent
	public function analizeMatches($words, $sentence){
		$size = sizeof($words);
		$matches = 0;
		for( $i = 0; $i < $size; $i++ ){
			if( stripos($sentence, $words[$i]) ){
				$matches++;
			}
		}
		$matchPorcent = (100*$matches)/$size;
		if( $matchPorcent >= 60 ){
			// Sure of the answer
			return TRUE;
		}else{
			// Not sure of the answer
			return FALSE;
		}
	}

	public function getRespostaById($id){
		$query = "SELECT respostaConteudo FROM respostas WHERE respostaId = ".$id;
		$response = $this->conn->query($query);
		$row = $response->fetch_assoc();

		return $row["respostaConteudo"];
	}

	public function findAnswer($words){
		$size = sizeof($words);

		for($i = 0; $i < $size; $i++){
			$query = "SELECT perguntaConteudo, respostaId FROM perguntas WHERE perguntaConteudo LIKE '%".$words[$i]."%'";
			$result = $this->conn->query($query);
			if($result->num_rows > 0){
				$row = $result->fetch_assoc();
				$sentence = $row["perguntaConteudo"];
				$respostaId = $row["respostaId"];
				if($this->analizeMatches($words, $sentence)){
					return $this->getRespostaById($respostaId);
				}
			}
		}
		return "Não achamos uma resposta para a sua pergunta.";
	}
	public function removeSpecialCharacters($txt){
		$txt = str_replace(',', '', $txt);
		$txt = str_replace('.', '', $txt);
		$txt = str_replace('?', '', $txt);
		$txt = str_replace('!', '', $txt);
		$txt = str_replace(':', '', $txt);
		$txt = str_replace(';', '', $txt);
		$txt = str_replace("'", '', $txt);

		return $txt;
	}

	public function safe_data($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}
?>