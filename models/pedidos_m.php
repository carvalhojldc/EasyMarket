
<?php

    function listarPedidos($conn) {

        /*
            statusItem
             0 -> deletado
             1 -> solicitado
             2 -> pronto
             3 -> servido
             4 -> produto levado no caixa, carrinho
        */

        $sql = "SELECT * FROM item_venda WHERE statusItem>'0' AND statusItem<3";
        $pedido = mysqli_query($conn, $sql);

        return $pedido;
    }


    function getDataProd($idProduto, $conn) {
        $sql = "SELECT * FROM produto WHERE idProduto='$idProduto'";
        $query = mysqli_query($conn, $sql);
        $getProd=mysqli_fetch_array($query);

        return $getProd;
    }

    function getDataVend($idVenda, $conn) {

        /*
            Retorna o codigo do cliente
        */
        $sql = "SELECT * FROM venda
                INNER JOIN cliente ON venda.id_cliente = cliente.idCliente
                WHERE venda.idVenda='$idVenda'";

        $query = mysqli_query($conn, $sql);
        $exibe=mysqli_fetch_array($query);

        return  $exibe[codigo];
    }

    function mudaStatus($conn, $selected_val, $idItemVenda) {

        /*
            Muda o status do item
            Ex: pronto, entregue...
        */
        $update = "UPDATE item_venda SET statusItem ='$selected_val' "
                . "WHERE idItem_venda='$idItemVenda'";

        mysqli_query($conn, $update);
    }

    function recuperaEstoque($conn, $idProduto, $quantidade) {
        /*
            Restaura o ESTOQUE
            Ex: pede duas cervejas, mas depois cancela uma delas
            Ex2: cancela as duas cervejas
        */
        $sql = "SELECT estoque FROM produto
                WHERE idProduto='$idProduto'";

        $query = mysqli_query($conn, $sql);
        $exibe=mysqli_fetch_array($query);

        $estoque = $exibe['estoque'];

        if($estoque != '-') {

            $oldEstoque = $estoque + $quantidade;

            $update = "UPDATE produto SET estoque ='$oldEstoque' "
                . "WHERE idProduto='$idProduto'";

            mysqli_query($conn, $update);
        }
    }


    function mudaQuantidade($conn, $idItemVenda, $newQuantidade, $idProduto) {
        /*
            Para quando parte de um pedido é cancelado
            Ex: pede duas cervejas, mas depois cancela uma delas

        */

        $sql = "SELECT * FROM produto WHERE idProduto='$idProduto'";
        $query = mysqli_query($conn, $sql);
        $getProd=mysqli_fetch_array($query);

        $valorUnitario = $getProd['preco'];

        $newValor = $valorUnitario * $newQuantidade;

        $update = "UPDATE item_venda
                    SET quantidade ='$newQuantidade', valorVenda='$newValor'
                    WHERE idItem_venda='$idItemVenda'";

        mysqli_query($conn, $update);
    }

?>
