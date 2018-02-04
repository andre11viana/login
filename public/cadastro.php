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
//recuperando info do formulario
if(isset($_POST["usuario"])){
//1ºresgatando as informações do formulário
    $nome         = $_POST["nome_colab"];
    $departamento = $_POST["dpt"];
    $usuario2     = $_POST["usuario"];
    $pass1        = $_POST["senha"];
  
 //pesquisando login no BD    
$pesquisa_usuario = "SELECT usuario FROM cadastro_login WHERE usuario = '$usuario2' ";
    
$resultado = mysqli_query($conexao, $pesquisa_usuario);  

$array = mysqli_fetch_array($resultado);  

$logarray = $array['usuario'];

if($nome == "" || $nome == null){
    echo"<script language='javascript' type='text/javascript'>alert('O campo login deve ser preenchido');window.location.href='cadastro.php';</script>";
 
    }else{
      if($logarray == $usuario2){
 
        echo"<script language='javascript' type='text/javascript'>alert('Esse login já existe');window.location.href='cadastro.php';</script>";
        die("erro");
 
      }else{
        //inserindo dados
        $consulta  = "INSERT INTO cadastro_login ";
        $consulta .= "(nome_usuario, usuario, senha, departamento ) ";
        $consulta .= " VALUES ";
        $consulta .= "('$nome','$usuario2','$pass1','$departamento') ";
        
        $insert = mysqli_query($conexao,$consulta);
         
        if($insert){
          echo"<script language='javascript' type='text/javascript'>alert('Usuário cadastrado com sucesso!');window.location.href='login.php'</script>";
        }else{
          echo"<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar esse usuário');window.location.href='cadastro.php'</script>";
        }
      }
    }


}


?>



<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inserir</title>
        
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
                  <li><a href="chaves.php">Chaves</a></li>
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
             
                <form action="cadastro.php" method="post">
                    <h2>Cadastro de Login</h2>
                   
                   <input type="text" name="nome_colab" placeholder = "Colaborador">
                   <input type="text" name="dpt" placeholder="Digite o Departamento">  
                   <input type="text" name="usuario" placeholder="Digite o novo usuário">
                   <input type="password" name="senha" placeholder="Senha">  
                   <input type="submit" value="enviar">
                   
                   
                       
                </form>
            <!--fim formulário-->
            
            </div>
        </main>

        
    </body>
</html>

<?php
    //Fechar conexao
    mysqli_close($conexao);
?>