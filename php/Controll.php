<?php
session_start();
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

		case 'adicionaResposta':
			adicionaResposta();
			break;

		case 'mostrarCategoriasInTable':
			mostrarCategoriasInTable();
			break;

		case 'criarCategoria':
			criarCategoria();
			break;

		case 'editCategoria':
			editCategoria();
			break;

		case 'excluirCategoria':
			excluirCategoria();
			break;

		default:
			echo "ERROR 404 - Process Not Found";
			break;
	}
}

function excluirCategoria(){
	$erro = false;
	if(empty($_POST["id"]) OR !isset($_POST["id"])){
		$erro = true;
	}
	if($erro){
		echo json_encode(array('erro' => true));
	}else{
		$db = new DataBase();
		$conn = $db->getConnection();

		$id = safe_data($_POST["id"]);
		$categoria = new Categorias($conn);
		if($categoria->excluirCategoria($id)){
			echo json_encode(array('erro' => false));
		}else{
			echo json_encode(array('erro' => true));
		}
	}
}

function editCategoria(){
	if(empty($_POST["nome"]) OR !isset($_POST["nome"]) OR empty($_POST["id"]) OR !isset($_POST["id"])){
		echo json_encode(array('erro' => true));
	}else{
		$db = new DataBase();
		$conn = $db->getConnection();

		$nome = safe_data($_POST["nome"]);
		$id = safe_data($_POST["id"]);
		$categoria = new Categorias($conn);
		if($categoria->editCategoria($id, $nome)){
			echo json_encode(array('erro' => false));
		}else{
			echo json_encode(array('erro' => true));
		}
	}
}

function criarCategoria(){
	$erro = false;
	if(empty($_POST["nome"]) OR !isset($_POST["nome"])){
		$erro = true;
	}
	if($erro){
		echo json_encode(array("erro" => true));
	}else{
		$db = new DataBase();
		$conn = $db->getConnection();

		$nome = safe_data($_POST["nome"]);
		$categoria = new Categorias($conn);
		$categoria->criarCategoria($nome);
		echo json_encode(array("erro" => false));
	}
}

function mostrarCategoriasInTable(){
	$db = new DataBase();
	$conn = $db->getConnection();

	$categoria = new Categorias($conn);
	$response = $categoria->getCategorias();

	if(!$response["erro"]){
		foreach($response["categorias"] as $categoria){
			echo "<tr>";
			echo "<td><input type='text' class='form-control' id='nome".$categoria["categoriaId"]."' value='".$categoria["categoriaNome"]."'></td>";
			echo "<td><button class='btn btn-primary btn-block' onclick='editCategoria(this.id)'>Salvar</button></td>";
			echo "<td><button class='btn btn-secondary btn-block' onclick='excluirCategoriaModal(".$categoria["categoriaId"].")'>Excluir</button></td>";
			echo "</tr>";
		}
	}

	
}

function adicionaResposta(){
	$erro = $categoriaErro = $perguntaErro = $respostaErro = false;
	if(empty($_POST["categoria"]) OR !isset($_POST["categoria"])){
		$erro = true;
		$categoriaErro = true;
	}
	if(empty($_POST["perguntaId"]) OR !isset($_POST["perguntaId"])){
		$erro = true;
		$perguntaErro = true;
	}
	if(empty($_POST["resposta"]) OR !isset($_POST["resposta"])){
		$erro = true;
		$respostaErro = true;
	}
	if($erro){
		$response = array("erro" => true, "categoriaErro" => $categoriaErro, "perguntaErro" => $perguntaErro, "respostaErro" => $respostaErro);
		echo json_encode($response);
	}else{
		$categoria = safe_data($_POST["categoria"]);
		$perguntaId = safe_data($_POST["perguntaId"]);
		$resposta = safe_data($_POST["resposta"]);

		$db = new DataBase();
		$conn = $db->getConnection();

		$pergunta = new Perguntas($conn);
		$response = $pergunta->adicionaResposta($categoria, $perguntaId, $resposta);

		echo json_encode($response);
	}
}

function contribuirFAQ(){
	$erro = $categoriaErro = $perguntaErro = $respostaErro = false;

	if(empty($_POST["categoria"]) OR !isset($_POST["categoria"])){
		$erro = $categoriaErro = true;
	}
	if(empty($_POST["pergunta"]) OR !isset($_POST["pergunta"]) OR strlen($_POST["pergunta"]) < 10){
		$erro = $perguntaErro = true;
	}
	if(empty($_POST["resposta"]) OR !isset($_POST["resposta"]) OR strlen($_POST["resposta"]) < 10){
		$erro = $respostaErro = true;
	}

	if(!$erro){
		$categoria = safe_data($_POST["categoria"]);
		$pergunta = safe_data($_POST["pergunta"]);
		$resposta = safe_data($_POST["resposta"]);

		$db = new DataBase();
		$conn = $db->getConnection();

		$faq = new FAQ($conn);
		$response = $faq->contribuirFAQ($categoria, $pergunta, $resposta);
		if($response == -1){
			// Erro Interno
			echo json_encode(array("erro" => true, "categoriaErro" => $categoriaErro, "perguntaErro" => $perguntaErro, "respostaErro" => $respostaErro));
		}else{
			// Success
			echo json_encode(array("erro" => false, "categoriaErro" => $categoriaErro, "perguntaErro" => $perguntaErro, "respostaErro" => $respostaErro));
		}
	}else{
		// Erro, não preencheu os dados
		echo json_encode(array("erro" => true, "categoriaErro" => $categoriaErro, "perguntaErro" => $perguntaErro, "respostaErro" => $respostaErro));
	}
}

function listPerguntas(){
	$db = new DataBase();
	$conn = $db->getConnection();

	$pergunta = new Perguntas($conn);
	$response = $pergunta->listPerguntasSemRespostas();

	if($response->num_rows > 0){
		while($row = $response->fetch_assoc()){
		echo "<p><div class='card text-center'>
				  <div class='card-header'>
				    ".$row["nome"]."/".$row["email"]."
				  </div>
				  <div class='card-body'>
				    <h5 class='card-title'>Pergunta:</h5>
				    <p class='card-text'>".$row["perguntaConteudo"]."</p>
				    <input type='hidden' id='perguntaText".$row["perguntaId"]."' value='".$row["perguntaConteudo"]."'>
				    <a href='#' class='btn btn-primary' id='".$row["perguntaId"]."' onclick='showAdicionarResposta(this.id)'>Adicionar Resposta</a>
				  </div>
				  <div class='card-footer text-muted'>
				    ".date('d/m/Y', strtotime(str_replace('-','/', $row["data"])))."
				  </div>
				</div></p>";
		}
	}else{
		echo "<br/><br/><div class='alert alert-success' role='alert'>
			  <h4 class='alert-heading'>Ótimo Trabalho NEAD!</h4>
			  <p>Nenhuma pergunta sem resposta foi encontrada. Aproveite e adicione novas perguntas :)</p>
			  <hr>
			  <p class='mb-0'>Esta mensagem significa que o NEAD trabalha duro pelos alunos.</p>
			</div>";
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