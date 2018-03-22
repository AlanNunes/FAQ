<?php
session_start();
if(isset($_SESSION["id"])){
  Header("Location: logout.php");
}
require_once('php/DataBase.php');
$db = new DataBase();
$conn = $db->getConnection();

$alert = "<div class='alert alert-info' role='alert'>Olá ! Faça seu login.</div>";
if (isset($_POST['login'])) {
  if(!empty($_POST['email']) && !empty($_POST['senha'])){
    $email = safe_data($_POST["email"]);
    $senha = safe_data($_POST["senha"]);
    $senha = hash('sha256', $senha);
    $sql = "SELECT userId, userNome, userEmail, userSenha FROM users WHERE userEmail = '".$email."' AND userSenha = '".$senha."'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      $_SESSION["id"] = $row["userId"];
      $_SESSION["nome"] = $row["userNome"];
      $_SESSION["email"] = $row["userEmail"];
      Header("Location: admin.php");
    }else{
      $alert = "<div class='alert alert-warning' role='alert'>Email ou senha incorretos.</div>";
    }
  }else{
    $alert = "<div class='alert alert-warning' role='alert'>Preencha todos os campos.</div>";
  } 
}

function safe_data($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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
      .header img{
        margin-left: 10x;
        float: left;
      }
      .header h1 {
        color: #e5e5e5;
      }
    </style>
  </head>
  <body>
  <center>
  <div class="header">
    <!-- <img src="assets/imgs/logo/logo.jpg" width="60px" height="60px"> -->
    <h1>UGB/FERP</h1>
  </div>

  <div class="loginPainel">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <?php echo $alert ?>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">Digite seu email institucional.</small>
      </div>
      <div class="form-group">
        <label for="senha">Senha:</label>
        <input type="password" class="form-control" id="senha" name="senha" placeholder="Password">
        <small id="emailHelp" class="form-text text-muted">Por favor, informe sua senha.</small>
      </div>
      <p>
        <button type="submit" class="btn btn-primary" name="login">Acessar</button>
      </p>
    </form>
  </div>

  </center>
    <script src="js/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <script src="js/bootstrap.min.js"></script>
    <script>

    </script>
  </body>
</html>