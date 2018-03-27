<?php
session_start();
if(!isset($_SESSION["id"])){
  Header("Location: login.php");
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/icons/open-iconic-master/font/css/open-iconic-bootstrap.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <title>FAQ UGB/FERP</title>
    <style>
      body {
        background: #4286f4;
      }
      .header {
        background: #1b70f9;
        width: 100%;
        height: 60px;
      }
      .header h1 {
        color: #e5e5e5;
      }
    </style>
  </head>
  <body>
  <center>
  <div class="header">
    <h1>FAQ UGB/FERP</h1>
  </div>
    <br/>
    <div class="conteudo" id="conteudo">
      <div class="row">
        <div class="col-6 col-md-4">
          <button type="button" class="btn btn-light btn-block" data-toggle="modal" data-target="#contribuirFAQ" onclick="mostrarCategorias('categorias')"><span class="oi oi-plus"></span>  Perguntas</button>
        </div>
        <div class="col-6 col-md-4">
          <button type="button" class="btn btn-light btn-block" data-toggle="modal" data-target="#categoriasFAQ" onclick="mostrarCategoriasInTable()"><span class="oi oi-plus"></span>  Categorias</button>
        </div>
        <div class="col-6 col-md-4">
          <a href="logout.php" class="btn btn-light btn-block"><span class="oi oi-account-logout"></span>  Sair</a>
        </div>
      </div>
      <div id="semResposta"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="contribuirFAQ" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Contribuir ao FAQ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="needs-validation" novalidate>
              <div id="contribuirAlert"></div>
              <div class="form-group">
                <label for="categorias">Selecione uma Categoria</label>
                <select class="form-control" id="categorias">
                </select>
                <div class="valid-feedback">
                  Categoria selecionada.
                </div>
                <div class="invalid-feedback">
                  Selecione uma categoria.
                </div>
              </div>
              <div class="form-group">
                <label for="pergunta">Informe a Pergunta</label>
                <textarea class="form-control" id="pergunta" rows="3"></textarea>
                <div class="valid-feedback">
                  Pergunta válida.
                </div>
                <div class="invalid-feedback">
                  Pergunta inválida, deve conter no mínimo 10 caracteres.
                </div>
              </div>
              <div class="form-group">
                <label for="resposta">Informe a Resposta</label>
                <textarea class="form-control" id="resposta" rows="3"></textarea>
                <div class="valid-feedback">
                  Resposta válida.
                </div>
                <div class="invalid-feedback">
                  Resposta inválida, deve conter no mínimo 10 caracteres.
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="contribuirFAQ()">Pronto !</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="contribuirSucesso" tabindex="-1" role="dialog" aria-labelledby="contribuirSucessoTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="contribuirSucessoTitle">Mensagem</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Sua contribuição foi registrada com sucesso.
            <br/>
            <p style="float: right">Equipe NEAD</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Entendido !</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="modalAdicionaResposta" tabindex="-1" role="dialog" aria-labelledby="adicionarRespostaLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="adicionarRespostaLabel">Adicionar Resposta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div id="adicionaRespostaAlert"></div>
              <div class="form-group">
                <label for="addRespostaCategorias">Selecione uma Categoria</label>
                <select class="form-control" id="addRespostaCategorias">
                </select>
              </div>
              <div class="form-group">
                <label for="adicionaPergunta">Pergunta:</label>
                <textarea class="form-control" id="adicionaPergunta" rows="3" disabled></textarea>
              </div>
              <div class="form-group">
                <label for="adicionaResposta">Responda a pergunta:</label>
                <textarea class="form-control" id="adicionaResposta" rows="3"></textarea>
              </div>
              <input type="hidden" id="idPergunta">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="registraResposta()">Pronto !</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="categoriasFAQ" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Categorias</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Nome</th>
                  <th scope="col">Criar/Editar</th>
                  <th scope="col">Excluir</th>
                </tr>
              </thead>
              <form class="needs-validation" novalidate>
              <tbody id="categoriasEditContent">
              </tbody>
              </form>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Pronto</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="excluirCategoriaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">FAQ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Tu desejas excluir esta categoria permanentemente ?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btn-excluirCategoria">Estou ciente</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="erroCategoriaEstaSendoUsada" tabindex="-1" role="dialog" aria-labelledby="erroCategoriaEstaSendoUsadaLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="erroCategoriaEstaSendoUsadaLabel">FAQ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Esta categoria não pode ser excluída pois já está em uso.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Entendi !</button>
          </div>
        </div>
      </div>
    </div>

  </center>
    <script src="js/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <script src="js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function(){
      setInterval(listPerguntas, 500);
    });

    function showAdicionarResposta(perguntaId){
      $("#modalAdicionaResposta").modal('show');
      mostrarCategorias("addRespostaCategorias");
      document.getElementById("idPergunta").value = perguntaId;
      perguntaConteudo = $("#perguntaText"+perguntaId).val();
      document.getElementById("adicionaPergunta").value = (perguntaConteudo);
    }

    function registraResposta(){
      var perguntaId = $("#idPergunta").val();
      var categoria = $("#addRespostaCategorias").val();
      var resposta = $("#adicionaResposta").val();

      var data = {
          "process": "adicionaResposta",
          "categoria": categoria,
          "perguntaId": perguntaId,
          "resposta": resposta
        };
        data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
          type: "POST",
          dataType: "json",
          url: "php/Controll.php",
          data: data,
          success: function(data) {
            console.log(data);
            if(data.erro){
              // Erro
              if(data.categoriaErro){
                $("#addRespostaCategorias").removeClass("is-valid");
                $("#addRespostaCategorias").addClass("is-invalid");
              }else{
                $("#addRespostaCategorias").removeClass("is-invalid");
                $("#addRespostaCategorias").addClass("is-valid");
              }
              if(data.perguntaErro){
                $("#adicionaPergunta").removeClass("is-valid");
                $("#adicionaPergunta").addClass("is-invalid");
              }else{
                $("#adicionaPergunta").removeClass("is-invalid");
                $("#adicionaPergunta").addClass("is-valid");
              }
              if(data.respostaErro){
                $("#adicionaResposta").removeClass("is-valid");
                $("#adicionaResposta").addClass("is-invalid");
              }else{
                $("#adicionaResposta").removeClass("is-invalid");
                $("#adicionaResposta").addClass("is-valid");
              }
            }else{
              $("#adicionaRespostaAlert").html("");
              $("#modalAdicionaResposta").modal("hide");
              $("#contribuirSucesso").modal("show");
            }
          }
        });
    }

    function contribuirFAQ(){
      var categoria = $("#categorias").val();
      var pergunta = $("#pergunta").val();
      var resposta = $("#resposta").val();

      var data = {
          "process": "contribuirFAQ",
          "categoria": categoria,
          "pergunta": pergunta,
          "resposta": resposta
        };
        data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
          type: "POST",
          dataType: "json",
          url: "php/Controll.php",
          data: data,
          success: function(data) {
            console.log(data);
            if(data.erro){
              // Erro
              if(data.categoriaErro){
                $("#categorias").removeClass("is-valid");
                $("#categorias").addClass("is-invalid");
              }else{
                $("#categorias").removeClass("is-invalid");
                $("#categorias").addClass("is-valid");
              }
              if(data.perguntaErro){
                $("#pergunta").removeClass("is-valid");
                $("#pergunta").addClass("is-invalid");
              }else{
                $("#pergunta").removeClass("is-invalid");
                $("#pergunta").addClass("is-valid");
              }
              if(data.respostaErro){
                $("#resposta").removeClass("is-valid");
                $("#resposta").addClass("is-invalid");
              }else{
                $("#resposta").removeClass("is-invalid");
                $("#resposta").addClass("is-valid");
              }
            }else{
              $("#contribuirAlert").html("");
              $("#contribuirFAQ").modal("hide");
              $("#contribuirSucesso").modal("show");
            }
          }
        });
    }

    function listPerguntas(){
      var data = {
          "process": "listPerguntas"
        };
        data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
          type: "POST",
          dataType: "html",
          url: "php/Controll.php",
          data: data,
          success: function(data) {
            $("#semResposta").html(data);
          }
        });
    }

    function mostrarCategorias(div){
        var data = {
          "process": "mostrarCategorias"
        };
        data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
          type: "POST",
          dataType: "html",
          url: "php/Controll.php",
          data: data,
          success: function(data) {
            $("#"+div).html(data);
          }
        });
    }

    function mostrarCategoriasInTable(){
      var data = {
          "process": "mostrarCategoriasInTable"
        };
        data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
          type: "POST",
          dataType: "html",
          url: "php/Controll.php",
          data: data,
          success: function(data) {
            $("#categoriasEditContent").html("<tr><td><input type='text' class='form-control' name='categoriaNome' id='categoriaNome'></td><td><button type='button' class='btn btn-primary btn-block' onclick='criarCategoria()'>Criar</button></td><td><button type='button' class='btn btn-secondary btn-block' disabled>Excluir</button></td></tr>");
            $("#categoriasEditContent").append(data);
          }
        });
    }

    function criarCategoria(){
      var nome = $("#categoriaNome").val();
      var data = {
        "process": "criarCategoria",
        "nome": nome,
      };
      data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
          type: "POST",
          dataType: "json",
          url: "php/Controll.php",
          data: data,
          success: function(data) {
            if(data.erro){
              $("#categoriaNome").removeClass("is-valid");
              $("#categoriaNome").addClass("is-invalid");
            }else{
              $("#categoriaNome").removeClass("is-invalid");
              $("#categoriaNome").addClass("is-valid");
              mostrarCategoriasInTable();
            }
          }
        });
    }

    function excluirCategoriaModal(id){
      document.getElementById("btn-excluirCategoria").onclick = function() { excluirCategoria(id); }
      $("#excluirCategoriaModal").modal("show");
    }

    function excluirCategoria(id){
      var data = {
        "process": "excluirCategoria",
        "id": id,
      };
      data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
          type: "POST",
          dataType: "json",
          url: "php/Controll.php",
          data: data,
          success: function(data) {
            console.log(data);
            if(data.erro){
              $("#nome"+id).addClass("is-invalid");
              $("#excluirCategoriaModal").modal("hide");
              $("#erroCategoriaEstaSendoUsada").modal("show");
            }else{
              $("#excluirCategoriaModal").modal("hide");
              mostrarCategoriasInTable();
            }
          }
        });
    }

    function editCategoria(id){
      var nome = $("#nome"+id).val();
      var data = {
        "process": "editCategoria",
        "nome": nome,
        "id": id
      };
      data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
          type: "POST",
          dataType: "json",
          url: "php/Controll.php",
          data: data,
          success: function(data) {
            if(data.erro){
              $("#nome"+id).removeClass("is-valid");
              $("#nome"+id).addClass("is-invalid");
            }else{
              $("#nome"+id).removeClass("is-invalid");
              $("#nome"+id).addClass("is-valid");
              $("#excluirCategoriaModal").modal("hide");
            }
          }
        });
    }
    </script>
  </body>
</html>