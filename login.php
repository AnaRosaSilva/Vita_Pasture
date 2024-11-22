<?php
// Conexão com o banco de dados
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'sistema';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Erro de conexão: ' . $conn->connect_error);
}

// Captura de dados do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = md5($_POST['senha']); // Criptografando a senha para comparar

    // Consulta ao banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login bem-sucedido
        session_start();
        $_SESSION['usuario'] = $email;
        header('Location: pagina_principal.php');
        exit; // Certifique-se de encerrar o script após o redirecionamento
    } else {
        // Login falhou
        echo "<script>alert('E-mail ou senha inválidos!'); window.location.href='login.html';</script>";
        exit; // Encerre o script após exibir a mensagem
    }
}
?>