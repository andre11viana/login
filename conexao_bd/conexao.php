<?php
  //Criando conexão com banco de dados
  $servidor = "localhost";
  $usuario  =  "root";
  $senha    =  "1234";
  $banco    =  "senac";
  $conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

  // verificando se a conexão foi feita com sucesso
  if(mysqli_connect_errno() ){
  	 die("Conexão falhou: " . mysqli_connect_errno());
  }
?>