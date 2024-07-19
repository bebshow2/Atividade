<?php
    // Configuração para conexão com banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "BD";

    // Cria a conexão com o banco de dados MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Checa se a conexão foi estabelecida corretamente
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Função para adicionar novos registros de usuário
    if (isset($_POST['action']) && $_POST['action'] == 'create') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $mensagem = $_POST['mensagem'];

        // Monta o comando SQL para inserção de dados na tabela Usuarios
        $sql = "INSERT INTO Usuarios (nome, email, mensagem) VALUES ('$nome', '$email', '$mensagem')";

        // Executa o comando SQL e verifica se foi bem-sucedido
        if ($conn->query($sql) === TRUE) {
            echo "Novo registro criado com sucesso<br>";
        } else {
            echo "Erro ao executar o comando: " . $sql . "<br>" . $conn->error;
        }
    }

    // Função para ler todos os registros de usuários
    if (isset($_POST['action']) && $_POST['action'] && $_POST['action'] == 'read') {
        // Comando SQL para selecionar todos os registros da tabela Usuarios
        $sql = "SELECT id, nome, email, mensagem FROM Usuarios";
        $result = $conn->query($sql);

        // Verifica se há registros retornados
        if ($result->num_rows > 0) {
            // Loop para exibir cada registro encontrado
            while($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"]. " - Nome: " . $row["nome"]. " - Email: " . $row["email"]. " - Mensagem: " .$row["mensagem"] . "<br>";
            }
        } else {
            echo "0 resultados";
        }
    }

    // Função para atualizar um registro de usuário existente
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id'];

    // Construção da consulta SQL inicial
    $sql = "UPDATE Usuarios SET ";

    // Array para armazenar as partes da consulta SQL
    $updates = array();

    // Verifica e adiciona os campos que foram enviados
    if (isset($_POST['nome'])) {
        $nome = $_POST['nome'];
        if (!empty($nome)) {
            $updates[] = "nome='$nome'";
        }
    }
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (!empty($email)) {
            $updates[] = "email='$email'";
        }
    }
    if (isset($_POST['mensagem'])) {
        $mensagem = $_POST['mensagem'];
        if (!empty($mensagem)) {
            $updates[] = "mensagem='$mensagem'";
        }
    }

    // Se houver campos para atualizar, monta a consulta SQL completa
    if (!empty($updates)) {
        $sql .= implode(", ", $updates);
        $sql .= " WHERE id=$id";

        // Executa o comando SQL de atualização e verifica o resultado
        if ($conn->query($sql) === TRUE) {
            echo "Registro atualizado com sucesso<br>";
        } else {
            echo "Erro ao atualizar registro: " . $conn->error;
        }
    } else {
        echo "Nenhum dado foi fornecido para atualização.";
    }
}



    // Função para excluir um registro de usuário
    if (isset($_POST['action']) && $_POST['action'] && $_POST['action'] == 'delete') {
        $id = $_POST['id'];

        // Comando SQL para excluir um registro da tabela Usuarios
        $sql = "DELETE FROM Usuarios WHERE id=$id";

        // Executa o comando SQL de exclusão e verifica o resultado
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
    <!-- Inclui um arquivo CSS externo para estilizar a página -->
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>
    <!-- Formulários HTML para interagir com as funções PHP -->

    <h2>Formulário para Adicionar Usuário</h2>
    <form method="post">
        <input type="hidden" name="action" value="create">
        Nome: <input type="text" name="nome"><br>
        Email: <input type="text" name="email"><br>
        Mensagem: <input type="text" name="mensagem"><br>
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
        Nova Mensagem: <input type="text" name="mensagem"><br>
        <input type="submit" value="Atualizar">
    </form>

    <h2>Formulário para Excluir Usuário</h2>
    <form method="post">
        <input type="hidden" name="action" value="delete">
        ID: <input type="text" name="id"><br>
        <input type="submit" value="Excluir">
    </form>

    <?php
    // Verifica se há mensagens de sucesso ou erro para exibir na página
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        // Determina a classe CSS com base no tipo de mensagem (sucesso ou erro)
        $class = $_GET['class'] == 'error' ? 'error' : 'result';
        // Exibe a mensagem com a classe de estilo apropriada
        echo '<div class="' . $class . '">' . $message . '</div>';
    }
    ?>

</body>
</html>

<?php
    // Fecha a conexão com o banco de dados após todas as operações
    $conn->close();
?>
