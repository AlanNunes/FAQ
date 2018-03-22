<?php
require_once('DataBase.php');
require_once('Messages.php');
require_once('Categorias.php');
require_once('FAQ.php');
require_once('Perguntas.php');

if(isset($_POST["process"]) && !empty($_POST["process"])) {

	switch ($_POST["process"]) {
		// case 'sendMessage':
		// 	sendMessage();
		// 	break;

		// case 'saveHelp':
		// 	saveHelp();
		// 	break;
		
		case 'mostrarCategorias':
			mostrarCategorias();
			break;

		case 'buscaFAQ':
			buscaFAQ();
			break;

		case 'registrarPergunta':
			registrarPergunta();
			break;

		case 'listPerguntas':
			listPerguntas();
			break;

		case 'contribuirFAQ':
			contribuirFAQ();
			break;

		default:
			echo "ERROR 404 - Process Not Found";
			break;
	}
}

// function sendMessage(){
// 	$db = new DataBase();
// 	$conn = $db->getConnection();

// 	$message = new Messages($conn);
// 	$txt = safe_data($_POST["message"]);
// 	// We need the original text to use it after
// 	$message->setText($txt);

// 	$txt = $message->removeSpecialCharacters($txt);
// 	$words = array();
// 	$words = $message->explodeString($txt);
// 	$responseAnswer = $message->findAnswer($words);
// 	echo $responseAnswer;
// }

function contribuirFAQ(){
	if(!empty($_POST["categoria"]) && isset($_POST["categoria"]) && !empty($_POST["pergunta"]) && isset($_POST["pergunta"]) && !empty($_POST["resposta"]) && isset($_POST["resposta"])){
		$categoria = safe_data($_POST["categoria"]);
		$pergunta = safe_data($_POST["pergunta"]);
		$resposta = safe_data($_POST["resposta"]);
		$nome = safe_data($_SESSION["nome"]);
		$email = safe_data($_SESSION["email"]);

		$db = new DataBase();
		$conn = $db->getConnection();

		$faq = new FAQ($conn);
		$response = $faq->contribuirFAQ($categoria, $pergunta, $resposta, $nome, $email);
		if($response == -1){
			// Erro Interno
			echo -2;
		}else{
			// Success
			echo 1;
		}
	}else{
		// Erro, não preencheu os dados
		echo -1;
	}
}

function listPerguntas(){
	$db = new DataBase();
	$conn = $db->getConnection();

	$pergunta = new Perguntas($conn);
	$response = $pergunta->listPerguntasSemRespostas();

	while($row = $response->fetch_assoc()){
		echo "<p><div class='card text-center'>
				  <div class='card-header'>
				    ".$row["nome"]."/".$row["email"]."
				  </div>
				  <div class='card-body'>
				    <h5 class='card-title'>Pergunta:</h5>
				    <p class='card-text'>".$row["perguntaConteudo"]."</p>
				    <a href='#' class='btn btn-primary'>Adicionar Resposta</a>
				  </div>
				  <div class='card-footer text-muted'>
				    ".date('d/m/Y', strtotime(str_replace('-','/', $row["data"])))."
				  </div>
				</div></p>";
	}
}

function registrarPergunta(){
	$nome = safe_data($_POST["nome"]);
	$email = safe_data($_POST["email"]);
	$conteudo = safe_data($_POST["conteudo"]);
	$erro = $erroNome = $erroEmail = $erroConteudo = false;
	if(empty($nome) OR !isset($nome)){
		$erro = true;
		$erroNome = true;
	}
	if(empty($email) OR !isset($email) OR !filter_var($email, FILTER_VALIDATE_EMAIL)){
		$erro = true;
		$erroEmail = true;
	}
	if(empty($conteudo) OR !isset($conteudo)){
		$erro = true;
		$erroConteudo = true;
	}

	if($erro){
		$response = array("erro" => true, "erroNome" => $erroNome, "erroEmail" => $erroEmail, "erroConteudo" => $erroConteudo);
		echo json_encode($response);
	}else{
		$db = new DataBase();
		$conn = $db->getConnection();

		$pergunta = new Perguntas($conn);
		if($pergunta->registrarPergunta($nome, $email, $conteudo)){
			// Process completed without any erro
			$response = array("erro" => false);
			echo json_encode($response);
		}else{
			// Something cause an erro
			$response = array("erro" => true);
			echo json_encode($response);
		}
	}
	
}

function buscaFAQ(){
	$categoriaId = $_POST["categoriaId"];
	$db = new DataBase();
	$conn = $db->getConnection();

	$faq = new FAQ($conn);
	$faq->setCategoriaId($categoriaId);
	$response = $faq->buscaFAQ();

	if($response["erro"]){
		echo "Nenhum FAQ foi encontrado.";
	}else{
		$faq = $response["faq"];
		$size = sizeof($faq);
		for($i = 0; $i < $size; $i++){
			echo $faq[$i];
		}
	}
}

function mostrarCategorias(){
	$db = new DataBase();
	$conn = $db->getConnection();

	$categoria = new Categorias($conn);
	$response = $categoria->getCategorias();
	if( $response["erro"] ){
		echo "Nenhuma categoria registrada.";
	}else{
		$categorias = $response["categorias"];
		foreach($categorias as $categoria){
			echo "<option value='".$categoria["categoriaId"]."'>". $categoria["categoriaNome"] ."</option>";
		}
	}
}

function safe_data($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>