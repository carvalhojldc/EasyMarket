
<?php

    function getDadosUser($conn, $cpf) {

        $sql = "SELECT nome, senha, endereco, telefone, idUsuario FROM usuario "
                ."WHERE cpf='$cpf' AND tipoUser!='0'";

        $run = mysqli_query($conn, $sql);

        return $run;
    }

    function updateUser($cpf, $conn) {

        $nome       = $_POST['nome'];
        $senha      = $_POST['senha'];
        $endereco   = $_POST['endereco'];
        $telefone   = $_POST['telefone'];

        $sql = "UPDATE usuario SET nome='$nome', senha='$senha', endereco='$endereco', telefone='$telefone'
                WHERE cpf='$cpf' AND tipoUser!='0'";

        $run = mysqli_query($conn, $sql);

        if($run) {
            echo "<script> alert('Atualização realizada com sucesso.') </script>";

            return 1;
        }

        return 0;

    }

    function deleteUser($cpf, $conn) {
        /*
            Omitir funcionário, definir tipoUser como 0
            ->> senha recebe null
        */

        $sql = "UPDATE usuario SET tipoUser='0', senha='null' WHERE cpf='$cpf'";

        $run = mysqli_query($conn, $sql);

        if($run) {
            echo "<script> alert('Funcionário excluído.') </script>";
        }
    }

    function listar($conn) {

        /*
            Nao listar o usuario atual (gerente) do sistema e o dono, muito menos
            o usuario que foi excluido
        */

        $except = $_SESSION['usuario']['idUsuario'];

        $sql = "SELECT nome, cpf, endereco, telefone, tipoUser, idUsuario FROM usuario "
                ."WHERE not tipoUser<'2' AND idUsuario!=$except ORDER BY nome";

        $run= mysqli_query($conn, $sql);

        return $run;
    }


?>
