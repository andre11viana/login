<?php require_once("../conexao_bd/conexao.php"); ?>

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
 if( isset($_POST["nomefuncionario"]) ) {
        $nome    = $_POST["nomefuncionario"];
        $depart  = $_POST["departamento"];
        $sl      = $_POST["sala"];
        $cID     = $_POST["IDchaves"];

        $alter = "UPDATE chaves ";
        $alter .= "SET ";
        $alter .= "colaborador = '{$nome}', ";
        $alter .= "departamento = '{$depart}', ";
        $alter .= "sala = '{$sl}' ";
        $alter .= "WHERE IDchaves = {$cID} ";
        $operacao_alterar = mysqli_query($conexao, $alter);
        if(!$operacao_alterar) {
            die("Erro na alteracao");   
        } else {
            header("location:listagem.php");   
        }





}

// Consulta a tabela chaves
    $ch = "SELECT * ";
    $ch .= "FROM chaves ";
    if(isset($_GET["codigo"]) ) {
        $id = $_GET["codigo"];
        $ch .= "WHERE IDchaves = {$id} ";
    }else{
        $ch .="WHERE IDchaves = 1 ";
    } 
    
    $con_chaves = mysqli_query($conexao,$ch);
    if(!$con_chaves) {
        die("Erro na consulta");
    }

    $info_chaves = mysqli_fetch_assoc($con_chaves);


?>






<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso PHP INTEGRACAO</title>
        
        <!-- estilo -->
        <link href="_css/estilo.css" rel="stylesheet">
        <link href="_css/alteracao.css" rel="stylesheet">
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
                         
        </div>

       <?php
        }
       ?>


        </header>
     
        <main>  
            <div id="janela_formulario">
                <form action="alteracao.php" method="post">
                    <h2>Alteração</h2>
                    
                    <label for="nomefuncionario">Nome do Funcionário</label>
                    <input type="text" value="<?php echo($info_chaves["colaborador"]) ?>" name="nomefuncionario" id="nomefuncionario">

                    <label for="departamento">Departamento</label>
                    <input type="text" value="<?php echo($info_chaves["departamento"]) ?>" name="departamento" id="departamento">
                    
                    <label for="sala">Sala</label>
                    <input type="text" value="<?php echo($info_chaves["sala"]) ?>" name="sala" id="sala">                     

                    <input type="hidden" name="IDchaves" value="<?php echo($info_chaves["IDchaves"]) ?>">
                    <input type="submit" value="Confirmar alteração">                    
                </form>   
            </div>
        </main>

        
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conexao);
?>