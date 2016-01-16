<?php

    function conectaBanco() {
        $servername = "localhost";
        $username = "root";
        $password = "123456";
	$dbname = "easymarket";

        $conn =  mysqli_connect($servername, $username, $password, $dbname);

        // Check conexão
        if (mysqli_connect_errno())  {
            echo "Falha na conexão - " . mysqli_connect_error();
        }

        return $conn;
    }
?>
