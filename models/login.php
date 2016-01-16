<?php
    include '../models/db.php';
    //include '../models/controleFrequencia.php';

    function validarLogin($cpf, $senha) {
        /*
            Validar cpf e senha
            E retronar array com nome, tipo e id no usuario
        */

        $conn = conectaBanco();
        $usuarioExluido = 0;

        $sql = "SELECT nome, tipoUser, idUsuario
                FROM usuario
                WHERE cpf='$cpf' AND senha='$senha' AND tipoUser!='$usuarioExluido'";

        $query = mysqli_query($conn, $sql);

        mysqli_close($conn);

        if ( mysqli_num_rows($query) ) {
            $dataArray=mysqli_fetch_array($query);

            return $dataArray;
        }

        /* Caso de usuário não encontrado no banco de dados */
        return 0;
    }

    function login() {
        $cpf = $_POST["cpf"];
        $senha = $_POST["senha"];

        if( $getArray = validarLogin($cpf, $senha) ) {

            $tipoUsuario = $getArray[tipoUser]; // P/ controle de acesso

            /*
                Restrições de acesso

                $tipoUsuario [tipoUser]
                    1 -> dono
                    2 -> gerente
                    3 -> demais funcionários
                    0 -> usuários desativados
            */
            $dono           = '1';
            $gerente        = '2';
            $funcionario    = '3';

            /*
                para controle de sessão

                temos um arrray para controlar a sessão do usuário, onde temos o seu nome, tipo e id
            */
            $_SESSION['usuario']=$getArray;

            if($tipoUsuario == $gerente || $tipoUsuario == $dono) {
                /* Se for gerente ou o dono, será aberta a página do financeiro */
                echo "<script> window.open('../views/financeiro.php','_self') </script>";

            } elseif ($tipoUsuario == $funcionario) {
                /* Funcionário comum é mandado direto para o página de pedidos */
                echo "<script> window.open('../views/pedidos.php','_self') </script>";
            }

        } else {
            echo "<script> alert('Usuário e/ou senha incorreto!') </script>";
        }
    }
?>
