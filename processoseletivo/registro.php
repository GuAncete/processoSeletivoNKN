<?php
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['whatsapp'];
    $data_nascimento = $_POST['datanascimento'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];


    $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);


    $sql = "SELECT * FROM usuario WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('O e-mail já está cadastrado. Por favor, use outro e-mail.'); history.back();</script>";
            $stmt->close();
            $conn->close();
            exit();
        }
        $stmt->close();
    } else {
        echo "<script>alert('Erro na preparação: " . $conn->error . "'); history.back();</script>";
        exit();
    }


    $sql = "INSERT INTO usuario (nome, email, whatsapp, datanascimento, senha) VALUES (?, ?, ?, ?, ?)";



    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $nome, $email, $telefone, $data_nascimento, $senha_criptografada);
        if ($stmt->execute()) {
            echo "<script>
                    alert('Obrigado! Cadastro realizado com sucesso. Você será redirecionado.');
                    window.location.href = 'https://www.nknbank.com.br/';
                  </script>";


            //Foi uma tentativa de enviar o email, mas pelo oque pesquisei precisaria estar hospedado em um servidor
            $arquivo = "
                        <html>
                        <p><b>Nome: </b>NKN</p>
                        <p><b>E-mail: </b>gustavoaancete@gmail.com</p>
                        <p><b>Mensagem: </b> Seja bem vindo ao NKN Bank</p>
                        </html>
                        ";

            $destino = $email;
            $assunto = "Confirmação de cadastro";

            $headers  = "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\n";
            $headers .= "From: NKN Bank <gustavoaancete@gmail.com>";

            mail($destino, $assunto, $arquivo, $headers);
            echo "<meta http-equiv='refresh' content='10;URL=../contato.html'>";
        } else {
            echo "<script>alert('Erro ao cadastrar: " . $stmt->error . "'); history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Erro na preparação: " . $conn->error . "'); history.back();</script>";
    }




    $conn->close();
}
