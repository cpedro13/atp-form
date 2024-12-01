<?php
// encerra a sessão atual e limpa os dados armazenados
session_destroy();

// redireciona o usuário para a página inicial (index.php)
header("location: index.php");
?>