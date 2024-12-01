<?php
session_start();
include("connect.php");

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// obtem o ID do usuário logado
$email = $_SESSION['email'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($query);
$user_id = $user['id'];

// busca todas as matérias
$subjects_query = mysqli_query($conn, "SELECT * FROM subjects");
$subjects = mysqli_fetch_all($subjects_query, MYSQLI_ASSOC);

// processa a seleção de matérias
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['subject_id'])) {
        $subject_id = (int)$_POST['subject_id'];
        
        // verifica se o usuário já escolheu essa matéria
        $check_query = mysqli_query($conn, "SELECT * FROM user_subjects WHERE user_id='$user_id' AND subject_id='$subject_id'");
        if (mysqli_num_rows($check_query) === 0) {
            mysqli_query($conn, "INSERT INTO user_subjects (user_id, subject_id) VALUES ('$user_id', '$subject_id')");
            echo "<p>Matéria cadastrada com sucesso!</p>";
        } else {
            echo "<p>Você já escolheu esta matéria!</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
            padding: 15%;
        }
        h1 {
            font-size: 50px;
            font-weight: bold;
        }
        h3 {
            font-size: 20px;
        }
        select, button {
            font-size: 16px;
            padding: 10px;
            margin: 10px;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        li {
            font-size: 18px;
        }
    </style>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <div class="container">
        <p class="greeting">
            <h1>Olá, bem-vindo <?php echo htmlspecialchars($user['firstName']) . ' ' . htmlspecialchars($user['lastName']); ?> :)</h1>
        </p>

        <h3>Selecione uma matéria extracurricular:</h3>
        <form method="POST">
            <select name="subject_id" required>
                <option value="">Escolha uma matéria</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?php echo htmlspecialchars($subject['id']); ?>"><?php echo htmlspecialchars($subject['subject_name']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Selecionar</button>
        </form>

        <h3>Matérias já escolhidas:</h3>
        <ul>
            <?php
            // consulta para pegar as matérias associadas ao usuário
            $chosen_subjects_query = mysqli_query($conn, "
                SELECT subjects.subject_name FROM user_subjects 
                INNER JOIN subjects ON user_subjects.subject_id = subjects.id
                WHERE user_subjects.user_id = '$user_id'
            ");
            if (mysqli_num_rows($chosen_subjects_query) > 0) {
                while ($row = mysqli_fetch_assoc($chosen_subjects_query)) {
                    echo "<li>" . htmlspecialchars($row['subject_name']) . "</li>";
                }
            } else {
                echo "<li>Nenhuma matéria escolhida ainda.</li>";
            }
            ?>
        </ul>

        <!-- mostrar as matérias associadas diretamente à tabela users -->
        <h3>Matérias associadas a você:</h3>
        <ul>
            <?php
            // consulta para pegar as matérias associadas ao usuário na tabela users
            $user_subjects = mysqli_query($conn, "
                SELECT subjects.subject_name FROM user_subjects 
                JOIN subjects ON user_subjects.subject_id = subjects.id 
                WHERE user_subjects.user_id = '$user_id'
            ");

            if (mysqli_num_rows($user_subjects) > 0) {
                while ($subject = mysqli_fetch_assoc($user_subjects)) {
                    echo "<li>" . htmlspecialchars($subject['subject_name']) . "</li>";
                }
            } else {
                echo "<li>Nenhuma matéria associada a você.</li>";
            }
            ?>
        </ul>

        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
