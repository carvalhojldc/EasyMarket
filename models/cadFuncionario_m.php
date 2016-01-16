<?php

    include '../models/db.php';

    function cadastra() {
	 	/*
	 		Responsável pelo cadastro de
	 		novos funcionários
	 	*/

        $nome 		= $_POST['nome'];
        $cpf 		= $_POST['cpf'];
        $senha 		= $_POST['senha'];
        $endereco 	= $_POST['endereco'];
        $telefone 	= $_POST['telefone'];

        if( empty($_POST['tipo_usuario']) ){
            $tipo_usuario = '3';
            /* Funcionário comum, situaçao onde o gerente esta realizando o cadastro */
        } else  {
            $tipo_usuario = $_POST['tipo_usuario'];
        }

        $conn = conectaBanco();

        $usuarioExcluido = '0';

        $sql = "SELECT * FROM usuario WHERE cpf='$cpf' AND tipoUser!='$usuarioExcluido'";
        $cpf_query = mysqli_query($conn, $sql);

        if ( !mysqli_num_rows($cpf_query) ) {

            $sql_insert = "INSERT INTO usuario (nome, cpf, senha, endereco, telefone, tipoUser)
                            VALUE ('$nome', '$cpf', '$senha', '$endereco', '$telefone', '$tipo_usuario')";

            if( mysqli_query($conn, $sql_insert) ) {

                echo "<script>alert('Cadastro realizado com sucesso!')</script>";
            }
        } else {

            echo "<script>alert('ERRO, CPF ($cpf) já cadastrado!')</script>";
        }

        mysqli_close($conn);
    }

?>
