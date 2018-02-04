<?php
//usando require_once para chamar a pasta conexao_bd
require_once("../conexao_bd/conexao.php");
?>

<?php



//função sessão
session_start();
session_destroy($_SESSION['user_prof']);
header('location:login.php');

?>
 
<?php
    //fechando conexão com o banco
     mysqli_close($conexao);

?>