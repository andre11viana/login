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
    // tabela de chaves
    $ch = "SELECT * FROM chaves ";
    $consulta_ch = mysqli_query($conexao, $ch);
    if(!$consulta_ch) {
        die("erro no banco");
    }
?>



<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Listagem</title>
        
        <!-- estilo -->
        <link href="_css/css_listagem.css" rel="stylesheet">
        
       
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
        
       <ol>
               <li><a href="chaves.php">Chaves</a></li>
               <li><a href="logout.php">Logout</a></li>
       </ol>

        <div id="titulo">
          <h2>Listagem da localização das chaves</h2>
        </div>

        <div id="relacao">
          <ul>
             <li>Colaborador</li>
             <li>Departamento</li>
             <li>Sala</li>
          </ul>
        </div>

      <main>         
            <div id="janela1">            
                <?php
                    while($linha = mysqli_fetch_assoc($consulta_ch)) {
                ?>
                <ul>
                    <li><?php echo ($linha["colaborador"]) ?></li>
                    <li><?php echo ($linha["departamento"]) ?></li>
                    <li><?php echo ($linha["sala"]) ?></li>
                    <li><a href="alteracao.php?codigo=<?php echo $linha["IDchaves"] ?>">Alterar</a> </li>
                    <li><a href="exclusao.php?codigo=<?php echo $linha["IDchaves"] ?>">Excluir</a> </li>
                </ul>
                <?php
                    }
                ?>
            </div>
        </main>

       
    </body>
</html>

<?php
    // Fechar conexao
    mysqli_close($conexao);
?>