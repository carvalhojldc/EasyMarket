<!DOCTYPE html>

<?php
    include '../models/defSession.php';

    include '../models/pedidos_m.php';
    include '../models/db.php';

    validaSession();
?>

<html>

<?php include 'navTab.php' ?>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"> Pedidos em aberto</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 ">
            <div class="panel panel-default">
                <div class="panel-body ">
                    <div class="">




<table  class="table table table-striped ">

<?php

    $conn = conectaBanco();

    $run = listarPedidos($conn);

    // status para tabela item_venda
    $cancelado  = '0';
    $solicitado = '1';
    $pronto     = '2';
    $entregue   = '3';
    $caixa      = '4'; /* produto add no caixa, tava no carrinho... */

    if( !mysqli_num_rows($run) ) {
        echo '
        <div class="alert alert-info">
            Nenhum pedido em aberto!
        </div>
        ';
        exit();
    }
        echo '
        <thead>
        <tr>
            <th> Cliente      </th>
            <th> Descrição      </th>
            <th> Código         </th>
            <th> Quantidade     </th>
            <th> Situação       </th>
            <th>        </th>
            <th> Cancelar          </th>


        </tr>
        </thead>
        ';

    while ( $fila = mysqli_fetch_array($run) ) {

        $status = $fila['statusItem'];

        /* exibindo apenas pedidos nesta codicional */
        if($status == $solicitado || $status == $pronto) {

            // tabela item de venda
            $idProduto      = $fila['id_produto'];
            $quantidade     = $fila['quantidade'];
            $idVenda        = $fila['id_venda'];
            $idItemVenda    = $fila['idItem_venda'];

            // tabela produto
            $dataProd   = getDataProd($idProduto, $conn);
            $descricao  = $dataProd['descricao'];
            $codigo     = $dataProd['codigo'];
            $precoUni   = $dataProd['preco'];

            // tabela cliente
            $cliente = getDataVend($idVenda, $conn);

            if($status == $solicitado) {
                $situacao = "<p class='text-success'><b> Solicitado </b></p> ";
            } elseif($status == $pronto) {
                $situacao = "<p class='text-danger'><b> Pedido pronto! </b></p> ";
            }

            $cancelaPedido = 'cancelado-' . $idItemVenda . '-' . $quantidade .'-'. $idProduto;
            $mudaModo = 'normal:' . $idItemVenda;

            /* Definindo o modo */
            if($status == $solicitado ) {
               $modo = "Pronto";
            }  elseif($status == $pronto ) {
               $modo = "Entregue";
            }

            echo '
                <tr>
                    <td> '. $cliente    .' </td>
                    <td> '. $descricao  .' </td>
                    <td> '. $codigo     .' </td>
                    <td> '. $quantidade .' </td>
                    <td> '. $situacao   .' </td>
                    <td>
                <form action="" method="post">
                    <button class="btn2 btn-outline  btn-warning" type="submit" name='.$mudaModo.' > '. $modo .'</button>
                </form>
                <form action="" method="post" onsubmit="return confirm(\'Deseja realmente realizar esta operação?\')" >
                    </td>
                    <td>
                        <button title="Cancelar item" name='.$cancelaPedido.' type="submit" class="btn2 btn-danger btn-circle btn" >
                        <i class="fa fa-times"> </i></button>
                        <input class=" col-lg-3 form" name="quantiCanc" placeholder="Qnt.">
                    </td>
                </tr>
                </form>';


            if( isset($_POST[ $cancelaPedido ]) ) {

                $string = explode("-", $cancelaPedido);

                if( empty($_POST['quantiCanc']) ) {
                    $quantiCanc = $string[2];
                } else {
                    $quantiCanc = $_POST['quantiCanc'];
                }

                $modo = $string[0];
                $idItemVenda = $string[1];
                $quantidate =  $string[2];
                $idProduto =  $string[3];

                if($quantidate < $quantiCanc) {
                    echo "<script>alert('Quantidade INCORRETA, excede o valor real!')</script>";

                } elseif($modo == 'cancelado') {
                    $newQuantidade = $quantidate - $quantiCanc;

                    if($quantiCanc < $quantidate ) {
                        mudaQuantidade($conn, $idItemVenda, $newQuantidade, $idProduto);
                        //echo "<script>alert('--id $idItemVenda nQ $newQuantidade idP $idProduto')</script>";
                    } else {
                        mudaStatus($conn, $cancelado, $idItemVenda);
                    }

                    recuperaEstoque($conn, $idProduto, $quantiCanc);
                    echo "<script>alert('Cancelado $quantiCanc item/itens de $quantidate!')</script>";
                }
                echo"<script>window.open('../views/pedidos.php','_self')</script>";

            } elseif( isset($_POST[ $mudaModo ]) ) {


                $string = explode(":", $mudaModo);
                $idItemVenda = $string[1];

                if($string[0] == 'normal') {
                    //echo "<script>alert('querendo mudar $string[1] -')</script>";
                    $newStatus = $status + 1;

                    mudaStatus($conn, $newStatus, $idItemVenda);
                    echo"<script>window.open('../views/pedidos.php','_self')</script>";
                }
            }

        }
    }
?>

</table>


                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->



</body>

</html>
