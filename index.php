<?php
    // Configuração de conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "BD";

    // Cria a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Checa a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Função para adicionar dados
    if (isset($_POST['action']) && $_POST['action'] == 'create') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];

        $sql = "INSERT INTO Usuarios (nome, email) VALUES ('$nome', '$email')";

        if ($conn->query($sql) === TRUE) {
            echo "Novo registro criado com sucesso<br>";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }

    // Função para ler dados
    if (isset($_POST['action']) && $_POST['action'] == 'read') {
        $sql = "SELECT id, nome, email FROM Usuarios";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output de dados em cada linha
            while($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"]. " - Nome: " . $row["nome"]. " - Email: " . $row["email"]. "<br>";
            }
        } else {
            echo "0 resultados";
        }
    }

    // Função para atualizar dados
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];

        $sql = "UPDATE Usuarios SET nome='$nome', email='$email' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Registro atualizado com sucesso<br>";
        } else {
            echo "Erro ao atualizar registro: " . $conn->error;
        }
    }

    // Função para excluir dados
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM Usuarios WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Registro excluído com sucesso<br>";
        } else {
            echo "Erro ao excluir registro: " . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>

    <h2>Formulário para Adicionar Usuário</h2>
    <form method="post">
        <input type="hidden" name="action" value="create">
        Nome: <input type="text" name="nome"><br>
        Email: <input type="text" name="email"><br>
        <input type="submit" value="Adicionar">
    </form>

    <h2>Formulário para Ler Usuários</h2>
    <form method="post">
        <input type="hidden" name="action" value="read">
        <input type="submit" value="Ler">
    </form>

    <h2>Formulário para Atualizar Usuário</h2>
    <form method="post">
        <input type="hidden" name="action" value="update">
        ID: <input type="text" name="id"><br>
        Novo Nome: <input type="text" name="nome"><br>
        Novo Email: <input type="text" name="email"><br>
        <input type="submit" value="Atualizar">
    </form>

    <h2>Formulário para Excluir Usuário</h2>
    <form method="post">
        <input type="hidden" name="action" value="delete">
        ID: <input type="text" name="id"><br>
        <input type="submit" value="Excluir">
    </form>

    <?php
    // Verificar se há mensagens de sucesso ou erro para exibir
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        $class = $_GET['class'] == 'error' ? 'error' : 'result';
        echo '<div class="' . $class . '">' . $message . '</div>';
    }
    ?>

</body>
</html>

<?php
    // Fecha a conexão com o banco de dados
    $conn->close();
?>
