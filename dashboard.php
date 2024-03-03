<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.html');
    exit();
}

$nome_usuario = isset($_SESSION['usuario_nome']) ? $_SESSION['usuario_nome'] : '';
$nivel_acesso = isset($_SESSION['nivel_acesso']) ? $_SESSION['nivel_acesso'] : '';

// Verifica se o usuário é um admin
$isAdmin = ($nivel_acesso === 'admin');

include('conexao.php');

// Obtém a lista de usuários para o menu de seleção
$queryUsuarios = "SELECT id, nome FROM usuario";
$resultUsuarios = mysqli_query($conexao, $queryUsuarios);
$listaUsuarios = mysqli_fetch_all($resultUsuarios, MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    // print_r('Nome: ' . $_POST['nome']);
    // print_r('<br>');
    // print_r('Email: ' . $_POST['email']);
    // print_r('<br>');
    // print_r('Telefone: ' . $_POST['telefone']);
    // print_r('<br>');
    // print_r('Sexo: ' . $_POST['genero']);
    // print_r('<br>');
    // print_r('Data de nascimento: ' . $_POST['data_nascimento']);
    // print_r('<br>');
    // print_r('Cidade: ' . $_POST['cidade']);
    // print_r('<br>');
    // print_r('Estado: ' . $_POST['estado']);
    // print_r('<br>');
    // print_r('Endereço: ' . $_POST['endereco']);

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $telefone = $_POST['telefone'];
    $tipo = $_POST['tipo'];


    $result = mysqli_query($conexao, "INSERT INTO clientes(nome,email,endereco,cidade,bairro,telefone,tipo) 
        VALUES ('$nome','$email','$endereco','$cidade','$bairro','$telefone','$tipo')");

    //header('Location: dashboard.php');

    if ($result) {
        echo "<script>setTimeout(function() { document.getElementById('mensagem-sucesso').style.display = 'none'; }, 3000);</script>";
        echo "<h1 id='mensagem-sucesso'>Dados enviados com sucesso.</h1>";
    } else {
        echo "<script>setTimeout(function() { document.getElementById('mensagem-erro').style.display = 'none'; }, 3000);</script>";
        echo "<h1 id='mensagem-erro'>Erro ao enviar os dados. Por favor, tente novamente.</h1>";
    }


}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="dashboard.css">
    <title>Painel</title>
</head>

<style>
    h1 {
        font-size: 20px;
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        background-color: #fa4b00;
        color: white;
        padding: 10px;
        margin-top: 20px;
        max-width: 300px;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<body>


    <div class="container">
        <nav>
            <div class="img">
                <img src="logo-fenix.png" alt="Logo do site">
            </div>
            <ul>
                <li><a href="#" id="registroMenu" onclick="mostrarRegistro()">Registro<i
                            class="ph ph-list-plus"></i></a></li>
                <li><a href="#" id="clientesMenu" onclick="mostrarClientes()">Clientes<i
                            class="ph ph-user-list"></i></a></li>
                <li><a href="#" id="ocorrenciasMenu" onclick="mostrarOcorrencia()">Ocorrências<i
                            class="ph ph-read-cv-logo"></i></a></li>
                <li><a href="#" id="usuariosMenu" onclick="mostrarUsuario()">Usuários<i class="ph ph-users"></i></a>
                </li>
            </ul>
            <div class="btn-sair">
                <a class="botao-sair" href="logout.php"><i class="ph ph-sign-out"></i></a>
            </div>

        </nav>
    </div>



    <!-- Formulário oculto que será mostrado quando a opção ocorrências for selecionado -->
    <div class="container-usuario" id="usuarioContainer" style="display: none;">

        <form id="usuarioForm" onsubmit="return false;">
            <h2>Cadastre um usuário</h2><br>
            <input type="text" id="campo1" name="campo1" placeholder="Campo 1" required>
            <input type="text" id="campo2" name="campo2" placeholder="Campo 2" required>
            <!-- Adicionar mais campos conforme necessário -->
            <button class="btn" onclick="salvarUsuario()">Salvar</button>
            <button class="btn" onclick="limparForm()">Limpar</button>
        </form>
    </div>

    <!-- Formulário oculto que será mostrado quando a opção ocorrências for selecionado -->
    <div class="container-ocorrencias" id="ocorrenciaContainer" style="display: none;">

        <form id="ocorrenciaForm" onsubmit="return false;">
            <h2>Cadastre ocorrências</h2><br>
            <input type="text" id="campo1" name="campo1" placeholder="Campo 1" required>
            <input type="text" id="campo2" name="campo2" placeholder="Campo 2" required>
            <!-- Adicionar mais campos conforme necessário -->
            <button class="btn" onclick="salvarOcorrencia()">Salvar</button>
            <button class="btn" onclick="limparForm()">Limpar</button>
        </form>
    </div>

    <!-- Formulário oculto que será mostrado quando a opção registro for selecionado -->
    <div class="container-registro" id="registroContainer" style="display: none;">

        <form id="registroForm" onsubmit="return false;">
            <h2>Registro</h2><br>
            <select id="clientes-registro">
                <option value="">Selecione...</option>
                <?php
                // Consulta SQL para obter os nomes dos clientes da tabela clientes
                $queryClientes = "SELECT id, nome FROM clientes";
                $resultClientes = mysqli_query($conexao, $queryClientes);

                // Verifica se a consulta foi bem-sucedida
                if ($resultClientes) {
                    // Loop através dos resultados para preencher as opções do menu suspenso
                    while ($row = mysqli_fetch_assoc($resultClientes)) {
                        $clienteId = $row['id'];
                        $clienteNome = $row['nome'];
                        echo "<option value='$clienteId'>$clienteNome</option>";
                    }
                } else {
                    echo "<option value=''>Erro ao carregar clientes</option>";
                }
                ?>
            </select>
            <input type="text" id="campo2" name="campo2" placeholder="Campo 2" required>
            <!-- Adicionar mais campos conforme necessário -->
            <button class="btn" onclick="salvarRegistro()">Salvar</button>
            <button class="btn" onclick="limparForm()">Limpar</button>
        </form>
    </div>

    <div class="container-clientes" id="clientesContainer" style="display: none;">

        <!-- Formulário oculto que será mostrado quando a opção clientes for selecionada -->
        <label>Cadastro de Cliente</label>
        <button class="btn" onclick="mostrarFormularioCadastro()">Cadastrar Cliente</button><br><br>
        <!-- Formulário de cadastro de cliente -->
        <div id="formularioCadastro" style="display: none;">
            <form action="dashboard.php" id="formularioCadastro" method="post">
                <input type="text" id="nome" name="nome" placeholder="Nome" required><br>
                <input type="text" id="email" name="email" placeholder="E-mail" required><br>
                <input type="text" id="endereco" name="endereco" placeholder="Endereço" required><br>
                <input type="text" id="cidade" name="cidade" placeholder="Cidade" required><br>
                <input type="text" id="bairro" name="bairro" placeholder="Bairro" required><br>
                <input type="text" id="telefone" name="telefone" placeholder="Telefone" required><br>
                <select id="tipo" name="tipo" required>
                    <option value="">Selecione o tipo</option>
                    <option value="residencial">Residencial</option>
                    <option value="comercial">Comercial</option>
                </select><br>
                <input type="submit" name="submit" id="submit">
            </form>
        </div>

        <h2>Formulário Cliente</h2>

        <form action="dashboard.php" method="post">
            <label for="clientes">Selecione um Cliente:</label>
            <select name="clientes" id="clientes" onchange="mostrarFormularioCliente()">


                <?php
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

                // Consulta SQL para obter todos os clientes
                $sql = "SELECT id, nome FROM clientes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Exibir opções do menu suspenso com os clientes
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum cliente encontrado</option>";
                }
                $conn->close();
                ?>
            </select>
            <br><br>
            <input type="submit" value="Selecionar">

            <h2>Formulário Cliente</h2>

            <?php
            // Verificar se um cliente foi selecionado
            if (isset($_POST['clientes'])) {
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
                    echo "<option value='residencial' " . ($row['tipo'] == 'residencial' ? 'selected' : '') . ">Residencial</option>";
                    echo "<option value='comercial' " . ($row['tipo'] == 'comercial' ? 'selected' : '') . ">Comercial</option>";
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
        </form>
    </div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function mostrarRegistro() {
            document.getElementById("registroContainer").style.display = "block";
            document.getElementById("clientesContainer").style.display = "none"; // Esconde o container de clientes, se estiver visível
            document.getElementById("ocorrenciaContainer").style.display = "none";
            document.getElementById("usuarioContainer").style.display = "none";
        }

        function mostrarClientes() {
            document.getElementById("clientesContainer").style.display = "block";
            document.getElementById("registroContainer").style.display = "none"; // Esconde o container de registro, se estiver visível
            document.getElementById("ocorrenciaContainer").style.display = "none";
            document.getElementById("usuarioContainer").style.display = "none";
        }

        function mostrarOcorrencia() {
            document.getElementById("clientesContainer").style.display = "none";
            document.getElementById("registroContainer").style.display = "none";
            document.getElementById("ocorrenciaContainer").style.display = "block"; // Esconde o container de registro, se estiver visível
            document.getElementById("usuarioContainer").style.display = "none";
        }

        function mostrarUsuario() {
            document.getElementById("clientesContainer").style.display = "none";
            document.getElementById("registroContainer").style.display = "none";
            document.getElementById("ocorrenciaContainer").style.display = "none";
            document.getElementById("usuarioContainer").style.display = "block"; // Esconde o container de registro, se estiver visível
        }

        function mostrarFormulario() {
            var selectCliente = document.getElementById("clientes");
            var formulario = document.getElementById("formulario");

            if (selectCliente.value !== "") {
                formulario.style.display = "block";
                // Preencher o código do cliente, recuperá-lo de acordo com o valor selecionado
                var codigoCliente = selectCliente.value;
                document.getElementById("codigo").value = codigoCliente;
            } else {
                formulario.style.display = "none";
            }
        }

        function mostrarFormularioCadastro() {
            var formularioCadastro = document.getElementById("formularioCadastro");
            var selectClientes = document.getElementById("clientes");
            var labelClientes = document.querySelector("label[for='clientes']");
            var h2Clientes = document.querySelector("#clientesselect h2");
            var clienteForm = document.getElementById("clienteForm");

            if (formularioCadastro.style.display === "none") {
                formularioCadastro.style.display = "block";
                selectClientes.style.display = "none"; // Esconder apenas o formulário de seleção de clientes
                labelClientes.style.display = "none"; // Esconder o label
                h2Clientes.style.display = "none"; // Esconder o h2
                clienteForm.style.display = "none";
            } else {
                formularioCadastro.style.display = "none";
                selectClientes.style.display = "block"; // Mostrar apenas o formulário de seleção de clientes
                labelClientes.style.display = "block"; // Mostrar o label
                h2Clientes.style.display = "block"; // Mostrar o h2
                clienteForm.style.display = "block";
            }
        }

        function salvarRegistro() {
            // adicionar a lógica para salvar o registro
            console.log("Registro salvo!");
        }

        //function salvarCliente() {
        // adicionar a lógica para salvar o cliente
        //console.log("Cliente salvo!");
        // }

        function salvarOcorrencia() {
            // adicionar a lógica para salvar o registro
            console.log("Registro salvo!");
        }

        function salvarUsuario() {
            // adicionar a lógica para salvar o registro
            console.log("Registro salvo!");
        }

        function excluirCliente() {
            //  adicionar a lógica para excluir o cliente
            console.log("Cliente excluído!");
        }

        function salvarCliente() {
            // adicionar a lógica para salvar o cliente
            console.log("Cliente salvo!");
        }

        function limparForm() {
            document.getElementById("registroForm").reset();
        }

        function mostrarFormularioCliente() {
            var formularioCliente = document.getElementById("formulario");
            formularioCliente.style.display = "block";
        }

        document.getElementById("clientes").addEventListener("change", function () {
            var selectElement = document.getElementById("clientes");
            var formulario = document.getElementById("formulario");
            var registroForm = document.getElementById("registroForm");
            if (selectElement.value === "") {
                formulario.style.display = "none"; // Oculta o formulário se "Selecione..." for selecionado
                registroForm.style.display = "block";
            } else {
                formulario.style.display = "block"; // Exibe o formulário para outras opções selecionadas
                registroForm.style.display = "block";
            }
        });

        function excluirCliente() {
            //  adicionar a lógica para excluir o cliente
            console.log("Cliente excluído!");
        }
    </script>



    <?php
    // Exibir botão de edição apenas para admin
    if ($isAdmin) {
        echo '<div class="formularios">';
    }


    ?>

</body>

</html>