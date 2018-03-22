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

function registrarPergunta(){
	$nome = safe_data($_POST["nome"]);
	$email = safe_data($_POST["email"]);
	$conteudo = safe_data($_POST["conteudo"]);

	$db = new DataBase();
	$conn = $db->getConnection();

	$pergunta = new Perguntas($conn);
	if($pergunta->registrarPergunta($nome, $email, $conteudo)){
		// Process completed without any erro
		echo true;
	}else{
		// Something cause an erro
		echo false;
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