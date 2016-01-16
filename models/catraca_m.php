<?php

    function liberaSaida($conn, $idCliente) {
        $sqlVenda = "SELECT * FROM venda "
                . "WHERE id_cliente='$idCliente'";
        $sVenda = mysqli_query($conn, $sqlVenda); 
        
        /*
         * statusVenda (0) =  cancelada
         * statusVenda (1) =  aberda
         * statusVenda (2) =  concluida
         */
        
        $status = $sVenda['statusVenda'];
        
        if($status == 1) {
            return 0;
        }
        return 1;
    }
    
    function entrada($conn) {
        
        $min = 444;
        $max = 999;
        $gera = rand($min,$max);

        $sql = "INSERT INTO cliente (codigo) VALUE ($gera)";

        if(mysqli_query($conn, $sql)) {
            echo "<script>alert('Cliente $gera  entrou na padaria')</script>";
        }
        else {
            echo "<script>alert(' falha ')</script>";
        }
    }
?>