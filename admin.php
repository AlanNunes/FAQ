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
          <button type="button" class="btn btn-light btn-block" data-toggle="modal" data-target="#contribuirFAQ" onclick="mostrarCategorias()"><span class="oi oi-plus"></span>  Perguntas</button>
        </div>
        <div class="col-6 col-md-4">
          <button type="button" class="btn btn-light btn-block"><span class="oi oi-plus"></span>  Categorias</button>
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
            <form>
              <div id="contribuirAlert">aaa</div>
              <div class="form-group">
                <label for="categorias">Selecione uma Categoria</label>
                <select class="form-control" id="categorias">
                </select>
              </div>
              <div class="form-group">
                <label for="pergunta">Informe a Pergunta</label>
                <textarea class="form-control" id="pergunta" rows="3"></textarea>
              </div>
              <div class="form-group">
                <label for="resposta">Informe a Resposta</label>
                <textarea class="form-control" id="resposta" rows="3"></textarea>
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
            <p style="float: right">Equipe NEAD</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
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
      listPerguntas();
    });

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
          dataType: "html",
          url: "php/Controll.php",
          data: data,
          success: function(data) {
            console.log(data);
            if(data == -2){
              // Erro
              alert('Erro desconhecido');
            }else if(data == -1 ){
              alert(data);
              $("#contribuirAlert").html("<div class='alert alert-warning' role='alert>Preencha todos os campos.</div>");
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
            console.log(data);
            $("#semResposta").html(data);
          }
        });
    }

    function mostrarCategorias(){
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
            $("#categorias").append(data);
          }
        });
      }
    </script>
  </body>
</html>