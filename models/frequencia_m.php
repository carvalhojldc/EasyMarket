<?php

    function controle($data, $idFuncionario, $conn) {
        
        /*
         * Para nao lançar frequencia de forma repetida     
         **/

        $sql = "SELECT * FROM frequencia WHERE data='$data' AND id_usuario=$idFuncionario";
		$freq_query = mysqli_query($conn, $sql);

        if ( mysqli_num_rows($freq_query) ) {

            return 1;
        }
        else {

            return 0;
        }
    }

    function frequencia($data, $idFuncionario, $conn) {
        
        /*
         * inserir frequencia no sistema
         * verifica por meio de controle se a frequencia ja nao foi inserida
         */

        if ( !controle($data, $idFuncionario, $conn) ) {

            $sql = "INSERT INTO frequencia (data, id_usuario) "
                ."VALUES ('$data', '$idFuncionario')";
            mysqli_query($conn, $sql);
        }
    }

    function listarFreq($idFuncionario, $conn) {
        
        /*
         * lista a frequencia de um 
         * determinado funcionario
         */
        
        $sql = "SELECT data FROM frequencia WHERE id_usuario=$idFuncionario";
        $freq_query = mysqli_query($conn, $sql);

        return $freq_query;

    }

 ?>
