<?php
//usando require_once para chamar a pasta conexao_bd
require_once("../conexao_bd/conexao.php");
?>

<?php
//função sessão
session_start();

?>


<?php

//testando se à variável $_POST foi configurada
if( isset($_POST['usuario'])){

//coletando dados do formulário
  $usuario = $_POST['usuario'];
  $pass    = $_POST['senha'];

//comparando registro de usuario e senha no BD
  $login =  "SELECT * ";
  $login .= "FROM cadastro_login ";
  $login .= "WHERE usuario = '{$usuario}' and senha = '{$pass}' ";

  $result = mysqli_query($conexao, $login);
  //verificando se houve falha na consulta ao BD
  if(!$result){
    die ("Erro ao consultar base dados");
  }
 //criando uma array para comparar registros do BD
  $info = mysqli_fetch_assoc( $result);
 
 // se não houver registro a consulta retorna vazia
 // empty vai verificar se o array pesquisado tem o elemento procurado 
 if(empty($info)){
    $msg = "Login sem sucesso.";

 }else{
    //criando variável de sessão após login ter sido realizado com sucesso
    //obs: deve ser criado antes do HEADER e nunca após ele
    $_SESSION["usercolab"] = $info["IDlogin"];
    header("location:chaves.php");
 } 

}


?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link href="_css/css_login.css" rel = "stylesheet">
    </head>

    <body>
     
     <main> 
          
        
         <div id = "janela_login">
            <form action="login.php" method="post">
               
               <h2>Login</h2>
              
                <input type="text" name="usuario" placeholder="Usuário">
                <input type="password" name="senha" placeholder="Digite sua senha">
                <input type="submit" value="Login">
           
               <?php 
                  //exibindo mensagem de erro ao logar para o usuário
                  // se a variável estiver defina é porquê deu erro          
                  if( isset($msg)){                
                ?>
                  <p><?php echo $msg ?></p>
                <?php            
                  }
                ?>
               
            </form>
            
            
         </div>

        </main>


    </body>
   
</html>
 <?php
    //fechando conexão com o banco
     mysqli_close($conexao);

  ?>