<?php
//usando require_once para chamar a pasta conexao_bd
require_once("../conexao_bd/conexao.php");
?>

<?php
//função sessão
session_start();

?>

<?php
//se não estiver defino $_SESSION enviar para pág de login
//protegendo página
  if(!isset($_SESSION['usercolab'])){
      header("location:login.php");
     
    }
?>

<?php
//recuperando info do formulario
if(isset($_POST["nomecolab"])){
//1ºresgatando as informações do formulário
    $colaborador     = $_POST["nomecolab"];
    $depar           = $_POST["depar"];
    $unidade         = $_POST["unidade"];
    $sala            = $_POST["sala"]; 

    //inserindo informação no BD
    $inserir  = "INSERT INTO chaves ";
    $inserir .= "(colaborador, departamento, unidade, sala) ";
    $inserir .= "VALUES ";
    $inserir .= "('$colaborador','$depar','$unidade', '$sala')";
    
    $operacao_inserir = mysqli_query($conexao,$inserir);
    if(!$operacao_inserir){
        die("Erro no banco");
  }else{
     header("location:listagem.php");
  }

}


?>


<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sala Chaves</title>
        
        <!-- estilo -->
        <link href="_css/css_chaves.css" rel="stylesheet">
       
    </head>

    <body>
       <header>
       <?php
       //criando rotina de saudação
       //verificando se a variável de sessão está habilitada
       if(isset($_SESSION['usercolab'])){
          $user_saudacao = $_SESSION['usercolab'];

          //consultando BD para saber o nome do usuário
          $rotina_saudacao  = "SELECT nome_usuario ";
          $rotina_saudacao .= "FROM cadastro_login ";
          $rotina_saudacao .= "WHERE IDlogin = {$user_saudacao} ";

          $saudacao_login = mysqli_query($conexao,$rotina_saudacao);

          if(!$saudacao_login){
            die("Erro");
          }
          //se não der erro  $saudacao_login vai receber ele mesmo em um array 
          $saudacao_login = mysqli_fetch_assoc($saudacao_login);
          $nome_prof = $saudacao_login['nome_usuario'];
       ?>

        <div id="header_saudacao">
            <h4>Bem vindo: <?php echo  $nome_prof ?></h4>
              <nav>
                <ul>
                  <li><a href="cadastro.php">Cadastro</a></li>
                  <li><a href="listagem.php">Listagem</a></li>
                  <li><a href="logout.php">Logout</a></li>
                </ul>
              </nav>  

            
        </div>

       <?php
        }
       ?>
      

       </header>
        
        <main>  

            <div id ="janela_formulario"> 
             <!--formulário-->
                <form action="chaves.php" method="post">
                  <h2>Controle de Chaves<h2>
                   <input type="text" name="nomecolab" placeholder = "Colaborador">
                   <input type="text" name="depar" placeholder = "Departamento">
                   <input type="text" name="unidade" placeholder="Unidade">                 
                   <input type="text" name="sala" placeholder="SALA">  
                   <input type="submit" value="Enviar">    
                </form>
            <!--fim formulário-->          
            </div>
        </main>

       
    </body>
</html>

 <?php
    //fechando conexão com o banco
     mysqli_close($conexao);

  ?>