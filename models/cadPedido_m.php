<?php

    include '../models/db.php';

    function validaProduto($conn, $codigoProduto) {
        /*
         * Valida o codigo do cliente
         * -- fornecido no ato do pedido
         */

 	$produtoExluido = '0'; /* Produto de foi excluido anteriormente, e recebeu 0 no status */

        $sqlP = "SELECT * FROM produto WHERE codigo='$codigoProduto' AND statusProduto!='$produtoExluido'";
        $exProd = mysqli_query($conn, $sqlP);

        if ( !mysqli_num_rows($exProd) ) {
           echo "<script>alert('ERRO! Produto inválido! :(')</script>";
           exit();
        }

        $getDP=mysqli_fetch_array($exProd);

        return $getDP;
    }

    function validaCliente($conn, $codigoCliente) {
        /*
         * Valida o codigo do produto
         * -- fornecido no ato do pedido
         */

         /*
            Quando o cliente sai da loja o codigo
            dele é setado para 0
         */

        $sqlC = "SELECT * FROM cliente WHERE codigo='$codigoCliente'";
        $exCli = mysqli_query($conn, $sqlC);

        if ( !mysqli_num_rows($exCli) ) {
           echo "<script>alert('ERRO! Cliente inválido! :(')</script>";
           exit();
        }

        $getDC=mysqli_fetch_array($exCli);

        return $getDC;
    }

    function controlaEstoque($conn, $idProduto, $quantidade, $estoque) {
        /*
            Decrementa o estoque quando um pedido é realizado

            Verifica se o estoque tem condiçoes de suportar o pedido que esta
            sendo realizado
        */

        if($estoque != '-') {
            if($estoque < $quantidade) {
                echo "<script>alert('ABASTECER ESTOQUE! Solicitado = $quantidade und. Disponível = $estoque und.')</script>";
                return 0;
            }

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
            statusVenda (0) =  cancelada
            statusVenda (1) =  aberda
            statusVenda (2) =  concluida
        */

        $sqlVenda = "SELECT * FROM venda WHERE id_usuario='$idUsuario' AND id_cliente='$idCliente'"; //
        $sVenda = mysqli_query($conn, $sqlVenda);

        if( !mysqli_num_rows($sVenda) ) { /* Verificando a existencia dessa venda, relacao funcionario cliente */
            $insert_pedido = "INSERT INTO venda (id_usuario, data, id_cliente, statusVenda) VALUE
                    ('$idUsuario', '$data', '$idCliente', '$statusVenda')";
            mysqli_query($conn, $insert_pedido);
            $idVenda = mysqli_insert_id($conn); /* ID referente a esta venda */
        } else {

            /* --- Encontrar o id relacionado a essa venda */
            $sql = "SELECT idVenda FROM venda WHERE id_cliente='$idCliente' AND id_usuario='$idUsuario'";
            $query = mysqli_query($conn, $sql);
            $getId=mysqli_fetch_array($query);
            $idVenda = $getId['idVenda'];
        }

        return $idVenda;
    }

    function itemDeVenda($conn, $idVenda, $idProduto, $quantidade, $valorTotal) {

        $statusItem = '1'; // pedido encaminhado
        /*
            $statusItem (0) =  cancelado
            $statusItem (1) =  solicitado
            $statusItem (2) =  pronto
            $statusItem (3) =  entregue
            $statusItem (4) =  feito no caixa
        */

        $insert_itemV = "INSERT INTO item_venda (id_venda, id_produto, quantidade, statusItem, valorVenda)"
                . "VALUE ('$idVenda', '$idProduto', '$quantidade', '$statusItem', '$valorTotal')";

        mysqli_query($conn, $insert_itemV);

    }

    function fazerPedido() {

        $conn = conectaBanco();

	/* Dados do formulário*/
        $codigoProduto  = $_POST['codigoProduto'];
        $codigoCliente  = $_POST['codigoCliente'];
        $quantidade     = $_POST['quantidade']; /* Quantidade solitada */

        $getDP = validaProduto($conn, $codigoProduto);
        $getDC = validaCliente($conn, $codigoCliente);

        /* Se o cliente e produto foram validados, partimos para o cadastro do pedido */

        $estoque    = $getDP['estoque'];
        $valorVenda = $getDP['preco'];
        $valorTotal = $valorVenda * $quantidade; /* valor do pedido */

        /* As operações são feitas com base no id */
        $idUsuario = $_SESSION['usuario']['idUsuario']; /* Quem está realizando a venda */
        $idCliente = $getDC['idCliente'];
        $idProduto = $getDP['idProduto']; // **

        if( controlaEstoque($conn, $idProduto, $quantidade, $estoque) ) {

            /*
             * Insere os dados na tabela venda
             */
            $idVenda = venda($conn, $idUsuario, $idCliente);
            /*
                Repeticao de dados na tabela venda é evitada
                Sendo assim, é verificado se não existe uma venda desta já cadastrada

                Venda é a relação de um funcionario com o cliente
                -> garçom1 atente cliente1 -> 1 venda
                -> garçom2 atente cliente1 -> outra venda
            */

            /*
             * Inseres os dados na tabela itemVenda
             */
            itemDeVenda($conn, $idVenda, $idProduto, $quantidade, $valorTotal);
            /*
                A repetição de valores na tabela item_venda não é evitado
                Afim de listar os pedidos em ordem
            */

            mysqli_close($conn);

            echo "<script>alert('Pedido cadastrado com sucesso!')</script>";
        }
    }

 ?>
