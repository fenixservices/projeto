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