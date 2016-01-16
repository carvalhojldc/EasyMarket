<?php

    /*
        Definições para restrigir o acesso
        a tipos de paginas de acordo com
        o tipo de usuario - $_SESSION['usuario'][1]
    */

    session_start();

    function validaSession() { // Define area comum - funcionario, gerente e dono
        if(!$_SESSION['usuario']) {
            header("Location: ../views/index.php");
        }
    }

    function validaAdmin() { // Define area de acesso restrito - gerente e dono
        if(!$_SESSION['usuario'] || $_SESSION['usuario']['tipoUser'] == 3) { // Funcionarios não possuem acesso
            header("Location: ../views/index.php");
        }
    }

?>
