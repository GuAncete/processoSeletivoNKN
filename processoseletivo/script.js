document.addEventListener('DOMContentLoaded', function() {
    
    validacaoCadastrar();
});



function formatarTelefone(input) {
    var telefone = input.value.replace(/\D/g, '');
    telefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3');
    input.value = telefone;
  }

function validacaoCadastrar() {
    document.getElementById('cadastro').addEventListener('submit', function(event) {
        const senha = document.querySelector('input[name="senha"]').value;
        const confirmarSenha = document.getElementById('confirmarsenha').value;
        const dataNascimento = new Date(document.getElementById('datanascimento').value);
        const dataAtual = new Date();
        const email = document.querySelector('input[name="email"]').value;

     

        if (
            validarEmail(email) ||
            validarData(dataNascimento, dataAtual) || 
            validarIdade(dataNascimento, dataAtual) ||
            validarSenha(senha) ||
            validarComparacaoSenha(senha, confirmarSenha)) {

            event.preventDefault(); 
        }
    });
}

function validarComparacaoSenha(senha, confirmarSenha) {
    if (senha !== confirmarSenha) {
        alert('As senhas não coincidem. Por favor, tente novamente.');
        return true;
    }
    return false;
}

function validarSenha(senha) {
    if ((senha.length < 6) || !(/\d/.test(senha))) {
        alert('A senha deve ter no mínimo 6 caracteres e incluir pelo menos um número.');
        return true;
    }
    return false;
}


function validarData(dataNascimento, dataAtual) {
    if (dataNascimento > dataAtual) {
        alert('A data de nascimento não pode ser uma data futura. Por favor, insira uma data válida.');
        return true;
    }
    return false;
}

function validarIdade(dataNascimento, dataAtual) {
    const idade = dataAtual.getFullYear() - dataNascimento.getFullYear();
    const mes = dataAtual.getMonth() - dataNascimento.getMonth();
    const dia = dataAtual.getDate() - dataNascimento.getDate();

    if (idade < 18 || (idade === 18 && (mes < 0 || (mes === 0 && dia < 0)))) {
        alert('Você precisa ter pelo menos 18 anos para se cadastrar.');
        return true;
    }
    return false;
}

function validarEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Por favor, insira um endereço de e-mail válido.');
        return true;
    }
    return false;
}

