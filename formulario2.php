!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário Cliente</title>
</head>
<body>

<h2>Formulário Cliente</h2>

<?php
// Verificar se um cliente foi selecionado
if(isset($_POST['clientes'])) {
    // Conexão com o banco de dados (substitua pelas suas credenciais)
    $servername = "localhost";
    $username = "root";
    $password = "6438";
    $dbname = "fenixlogin";

    // Criar conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Preparar e executar consulta para obter os dados do cliente selecionado
    $cliente_id = $_POST['clientes'];
    $sql = "SELECT * FROM clientes WHERE id = $cliente_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exibir os dados do cliente no formulário
        $row = $result->fetch_assoc();
        echo "<form>";
        echo "<label for='nome'>Nome:</label>";
        echo "<input type='text' id='nome' name='nome' value='" . $row['nome'] . "'><br><br>";
        echo "<label for='email'>Email:</label>";
        echo "<input type='text' id='email' name='email' value='" . $row['email'] . "'><br><br>";
        echo "<label for='endereco'>Endereço:</label>";
        echo "<input type='text' id='endereco' name='endereco' value='" . $row['endereco'] . "'><br><br>";
        echo "<label for='cidade'>Cidade:</label>";
        echo "<input type='text' id='cidade' name='cidade' value='" . $row['cidade'] . "'><br><br>";
        echo "<label for='bairro'>Bairro:</label>";
        echo "<input type='text' id='bairro' name='bairro' value='" . $row['bairro'] . "'><br><br>";
        echo "<label for='telefone'>Telefone:</label>";
        echo "<input type='text' id='telefone' name='telefone' value='" . $row['telefone'] . "'><br><br>";
        echo "<label for='tipo'>Tipo:</label>";
        echo "<select name='tipo' id='tipo'>";
        echo "<option value='residencial' ". ($row['tipo'] == 'residencial' ? 'selected' : '') . ">Residencial</option>";
        echo "<option value='comercial' ". ($row['tipo'] == 'comercial' ? 'selected' : '') . ">Comercial</option>";
        echo "</select><br><br>";
        echo "</form>";
    } else {
        echo "Nenhum cliente encontrado.";
    }
    $conn->close();
} else {
    echo "Por favor, selecione um cliente.";
}
?>

</body>
</html>