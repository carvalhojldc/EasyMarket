<?php
    function getLista($conn, $codigo) {
        $pedidoCancelado = '0';

        $sql = "SELECT SUM(item_venda.quantidade) as quantidadeCompra, cliente.idCliente, produto.descricao, produto.codigo, produto.preco FROM cliente
                INNER JOIN venda ON cliente.idCliente = venda.id_cliente
                INNER JOIN usuario ON usuario.idUsuario = venda.id_usuario
                INNER JOIN item_venda ON item_venda.id_venda = venda.idVenda
                INNER JOIN produto ON item_venda.id_produto = produto.idProduto
                WHERE cliente.codigo='$codigo' AND statusItem>2 AND statusVenda=1
                GROUP BY produto.descricao
                ORDER BY item_venda.idItem_venda";

        $query = mysqli_query($conn, $sql);

        return $query;

    }

    function finalizarCompra($conn, $idCliente) {

        $sql_venda = "SELECT * FROM venda WHERE id_cliente='$idCliente'";
        $query = mysqli_query($conn, $sql_venda);

        $vendaConcluida = '2';
        $contaFechada = '0';

        while($venda = mysqli_fetch_array($query)) {
            $idVenda = $venda['idVenda'];

            $sql = "UPDATE venda
                    INNER JOIN cliente
                    SET venda.statusVenda='$vendaConcluida', cliente.codigo='$contaFechada'
                    WHERE venda.idVenda='$idVenda' AND venda.id_cliente=cliente.idCliente";

            mysqli_query($conn, $sql);
        }

    }

    function contasEmAberto($conn) {
        $sql = "SELECT cliente.codigo, SUM(item_venda.valorVenda) AS valor FROM venda
                INNER JOIN item_venda ON venda.idVenda = item_venda.id_venda
                INNER JOIN cliente ON cliente.idCliente = venda.id_cliente
                WHERE venda.statusVenda=1 AND item_venda.statusItem>=3
                GROUP BY cliente.codigo";

        $query = mysqli_query($conn, $sql);

        return $query;
    }

    function cancelarVenda($conn, $codigo) {
        /*
            Venda cancelado recebe statusVenda = 0
        */

        $sqlID = "SELECT idCliente FROM cliente WHERE codigo='$codigo'";
        $query = mysqli_query($conn, $sqlID);
        $get = mysqli_fetch_array($query);
        $idCliente = $get['idCliente'];

        $cancelaVenda = "UPDATE venda SET statusVenda='0' WHERE id_cliente='$idCliente'";
        mysqli_query($conn, $cancelaVenda);

        $apagaCliente = "UPDATE cliente SET codigo='0' WHERE idCliente='$idCliente'";
        mysqli_query($conn, $apagaCliente);

    }

////// Cad pedido


    function validaProduto($conn, $codigoProduto) {
        /*
         * Valida o codigo do cliente
         * -- fornecido no ato do pedido
         */

        $sqlP = "SELECT * FROM produto WHERE codigo='$codigoProduto' AND statusProduto!='0'";
        $exProd = mysqli_query($conn, $sqlP);
        if ( !mysqli_num_rows($exProd) ) {
           echo "<script>alert('Produto inválido')</script>";
           exit();
        }
        $getDP=mysqli_fetch_array($exProd);

        return $getDP;
    }



    function estoqueD($idProduto, $quantidade, $conn) {
        /*
            Decrementa o estoque quando um pedido é realizado

            Verifica se o estoque tem condiçoes de suportar o pedido que esta
            sendo realizado
        */

        $sql = "SELECT * FROM produto WHERE idProduto='$idProduto'";
        $query = mysqli_query($conn, $sql);
        $getProd=mysqli_fetch_array($query);
        $estoque = $getProd['estoque'];

        if($estoque != '-') {
            $newEstoque = $estoque - $quantidade;

            $sql = "UPDATE produto SET estoque='$newEstoque' WHERE idProduto='$idProduto'";
            mysqli_query($conn, $sql);
        }
        return 1;
    }


    function venda($conn, $idUsuario, $idCliente) {

        $data = date('Y-m-d h:m:s');
        $statusVenda = '1';
        /*
            $statusVenda = '1';
            statusVenda (0) =  cancelada
            statusVenda (1) =  aberda
            statusVenda (2) =  concluida
        */

        $sqlVenda = "SELECT * FROM venda WHERE id_usuario='$idUsuario' AND id_cliente='$idCliente'"; //
        $sVenda = mysqli_query($conn, $sqlVenda);

        if( !mysqli_num_rows($sVenda) ) { // Verificando a existencia
            $insert_pedido = "INSERT INTO venda (id_usuario, data, id_cliente, statusVenda) VALUE
                    ('$idUsuario', '$data', '$idCliente', '$statusVenda')";
            mysqli_query($conn, $insert_pedido);
            $idVenda = mysqli_insert_id($conn);
        } else {

            // --- Encontrar o id relacionado a tabela VENDA
            $sql = "SELECT idVenda FROM venda WHERE id_cliente='$idCliente' AND id_usuario='$idUsuario'";
            $query = mysqli_query($conn, $sql);
            $getId=mysqli_fetch_array($query);
            $idVenda = $getId['idVenda'];
        }

        return $idVenda;
    }

    function itemDeVenda($conn, $idVenda, $idProduto, $quantidade, $valorTotal) {
        $search = "SELECT * FROM item_venda "
                . "WHERE id_venda='$idVenda' AND id_produto='$idProduto'";

        $run = mysqli_query($conn, $search);

        $statusItem = '4'; // produto recebido no caixa - carrinho
        /*
            $statusItem (0) =  cancelado
            $statusItem (1) =  solicitado
            $statusItem (2) =  pronto
            $statusItem (3) =  entregue
            $statusItem (4) =  do carrinho de compras
        */


        //if( !mysqli_num_rows($run) ) {

            $insert_itemV = "INSERT INTO item_venda (id_venda, id_produto, quantidade, statusItem, valorVenda)"
                    . "VALUE ('$idVenda', '$idProduto', '$quantidade', '$statusItem', '$valorTotal')";

            mysqli_query($conn, $insert_itemV);

        /*} else {

            $getValue=mysqli_fetch_array($run);
            $newQuant = $getValue['quantidade'] + $quantidade;
            $newPrec = $getValue['valorVenda'] + $valorTotal;

            $update = "UPDATE item_venda SET quantidade='$newQuant', valorVenda='$newPrec' "
                    . "WHERE id_venda='$idVenda' AND id_produto='$idProduto'";

            mysqli_query($conn, $update);

        }*/

    }

    function fazerPedido($conn, $codigoProduto, $idCliente , $quantidade) {

        $getDP = validaProduto($conn, $codigoProduto);
        $idProduto = $getDP['idProduto'];
        $valorVenda = $getDP['preco'];

        /* valor do pedido feito*/
        $valorTotal = $valorVenda * $quantidade;

        $idUsuario =  $_SESSION['usuario']['idUsuario'];

        estoqueD($idProduto, $quantidade, $conn)  ;

        /*
         * Insere os dados na tabela venda
         */
        $idVenda = venda($conn, $idUsuario, $idCliente);

        /*
         * Inseres os dados na tabela itemVenda
         */
        itemDeVenda($conn, $idVenda, $idProduto, $quantidade, $valorTotal);

        mysqli_close($conn);

        //echo "<script>alert('Pedido cadastrado com sucesso!')</script>";

    }

 ?>
