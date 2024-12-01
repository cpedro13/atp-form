<?php 

include 'connect.php'; // inclui o arquivo para conexão com o banco de dados

if (isset($_POST['signUp'])) { // verifica se o formulário de cadastro foi enviado
    $firstName = $_POST['fName']; 
    $lastName = $_POST['lName']; 
    $email = $_POST['email']; 
    $password = $_POST['password']; 
    $password = md5($password); // aplica hash MD5 para proteger a senha

    // verifica se o e-mail já existe no banco de dados
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);
    if ($result->num_rows > 0) { // se o e-mail já está cadastrado
        echo "E-mail já cadastrado";
    } else {
        // insere os dados do usuário na tabela 'users'
        $insertQuery = "INSERT INTO users (firstName, lastName, email, password)
                        VALUES ('$firstName', '$lastName', '$email', '$password')";
        if ($conn->query($insertQuery) == TRUE) { 
            header("location: index.php"); // redireciona para a página inicial
        } else {
            echo "Error: " . $conn->error; // exibe o erro caso ocorra
        }
    }
}

if (isset($_POST['signIn'])) { // verifica se o formulário de login foi enviado
    $email = $_POST['email']; 
    $password = $_POST['password']; 
    $password = md5($password); 

    // consulta o banco de dados para verificar e-mail e senha
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) { 
        session_start(); // inicia a sessão
        $row = $result->fetch_assoc(); // obtém os dados do usuário
        $_SESSION['email'] = $row['email']; 
        header("Location: homepage.php"); // redireciona para a página principal
        exit();
    } else { 
        echo "Erro, e-mail ou senha inválidos";
    }
}
?>
