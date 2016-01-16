<?php


    function vendasDia($conn, $data) { // $data -> Y-d-m

        $sql = "SELECT SUM(item_venda.quantidade) AS quantidadeTotal, produto.descricao, SUM(item_venda.valorVenda) AS valorTotal FROM venda
            INNER JOIN item_venda ON venda.idVenda = item_venda.id_venda
            INNER JOIN produto ON item_venda.id_produto = produto.idProduto
            WHERE venda.statusVenda=2 AND DATE(venda.data)='$data' AND item_venda.statusItem>=3
            GROUP BY produto.descricao";

        $query = mysqli_query($conn, $sql);

        return $query;
    }

    function vendasMes($conn, $mes, $ano) {

        $sql = "SELECT SUM(item_venda.quantidade) AS quantidadeTotal, produto.descricao, SUM(item_venda.valorVenda) AS valorTotal FROM venda
            INNER JOIN item_venda ON venda.idVenda = item_venda.id_venda
            INNER JOIN produto ON item_venda.id_produto = produto.idProduto
            WHERE venda.statusVenda=2 AND MONTH(venda.data)='$mes' AND YEAR(venda.data)='$ano' AND item_venda.statusItem>=3
            GROUP BY produto.descricao";

        $query = mysqli_query($conn, $sql);

        return $query;
    }

    function getLastSeven($conn) {

        /*
            Buscando as datas associadas e salvando
            elas no formato Y-m-d
        */
        $sqlData = "SELECT  DATE(venda.data) FROM venda
            INNER JOIN item_venda ON venda.idVenda = item_venda.id_venda
            INNER JOIN produto ON item_venda.id_produto = produto.idProduto
            WHERE venda.statusVenda=2 AND data >= DATE_SUB(now(), INTERVAL 7 DAY) AND item_venda.statusItem>=3
            GROUP BY DATE_FORMAT(DATA, '%Y %m %d')";

        $queryData = mysqli_query($conn, $sqlData);

        return $queryData;
    }


    function getVendaPorDia($conn, $intervalo) {

        /*
            Buscando as datas associadas e salvando
            elas no formato Y-m-d
        */
        $sqlData = "SELECT  DATE(venda.data) FROM venda
            INNER JOIN item_venda ON venda.idVenda = item_venda.id_venda
            INNER JOIN produto ON item_venda.id_produto = produto.idProduto
            WHERE venda.statusVenda=2 AND data >= DATE_SUB(now(), INTERVAL 7 DAY) AND item_venda.statusItem>=3 
            GROUP BY DATE_FORMAT(DATA, '%Y %m %d')";

        $queryData = mysqli_query($conn, $sqlData);

        return $queryData;
    }



?>
