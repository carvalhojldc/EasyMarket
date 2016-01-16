<!DOCTYPE html>

<?php

    include '../models/defSession.php';
    include '../models/db.php';
    include '../models/caixa_m.php';

    validaSession();

    $conn = conectaBanco();

    $codigoCliente = $_GET['data'];

 ?>

 <html>

 <?php include 'navTab.php' ?>


 <div id="page-wrapper">
     <div class="row">
         <div class="col-lg-12">
             <h1 >  </h1>
         </div>
     </div>

     <div class="row">
         <div class="col-lg-12">
             <div class="panel panel-default">
                 <div class="panel-heading">
                     CAIXA - Cliente <?php echo $codigoCliente ?>
                 </div>

                 <div class="panel-body">
                     <div class="row">
                         <div class="col-lg-12">

<table class="table">
 <form action="" method="post">


<?php
        $q_lista = getLista($conn, $codigoCliente);

        if( mysqli_num_rows($q_lista) ) {
             echo '
                  <thead>
                  <tr>

                      <th> Produto          </th>
                      <th> Código           </th>
                      <th> Quantidade       </th>
                      <th> Valor unitário   </th>
                      <th> Valor            </th>
                  </tr>
                  </thead>
                ';


                $soma =  '0';

                while($venda = mysqli_fetch_array($q_lista)) {
                    $idCliente = $venda['idCliente'];
                    $valorUnitario = $venda['preco'];
                    $quantidade   = $venda['quantidadeCompra'];
                    $descricao    = $venda['descricao'];
                    $codigo    = $venda['codigo'];
                    $valorTotal = $quantidade * $valorUnitario;

                       echo '
                            <tr>

                                <td > '. $descricao .'</td>
                                <td > '. $codigo          .'</td>
                                <td > '. $quantidade      .'</td>
                                <td > '. $valorUnitario   .'</td>
                                <td > '. $valorTotal      .'</td>
                           </tr>
                       ';
                       $soma = $soma + $valorTotal;
                   }

            echo '
            </tbody>
            </table>

                <h3 class="text-info"  >Valor total: R$ '. $soma .' </h3>

                <div class="col-lg-4 panel panel-default panel-heading">
                <input class="form-control form-control-caixa" name="produto" placeholder="Código do produto"  >
                        <input class="form-control form-control-caixa" name="quantidade" placeholder="Quantidade"  >
                        <input class=" form-control btn-primary" type="submit" name="cadastrar" value="Adicionar produto" onsubmit="return confirm("Exluir produto?")">
                </div>
     </form>


            ';

            if( isset($_POST['finalizar']) ) {
                //echo "<script>alert(' Conta $idCliente! ')</script>";
                finalizarCompra($conn, $idCliente);

                echo "<script>alert(' Conta finalizada! ')</script>";
                echo "<script> window.open('../views/caixa.php','_self') </script>";
            }

            if( isset($_POST['cadastrar']) ) {

                $codigoProduto  = $_POST['produto'];
                $quantidade     = $_POST['quantidade'];

                //echo "<script>alert(' $codigoProduto - $idCliente - $quantidade')</script>";
                fazerPedido($conn, $codigoProduto, $idCliente , $quantidade);

                echo "<script> window.open('../views/caixa2.php?data=$codigoCliente','_self') </script>";
            }

        }
        else {
            echo "<script>alert('ERRO! CONTA NÃO ENCONTRADA!')</script>";
            echo "<script> window.open('../views/caixa.php','_self') </script>";
        }
?>

                         </div>
                     </div>
                 </div>



             </div>

             <div class="panel panel-default">
                 <div class="panel-heading">
                        <form action="" method="post" onsubmit="return confirm('Finalizar conta?')">
                     <button class="btn  btn-danger" type="submit" name="finalizar">Finalizar compra</button>
                 </form>
                 </div>
             </div>
         </div>
     </div>
     <!-- /.row -->
 </div>
 <!-- /#page-wrapper -->

 </div>
 <!-- /#wrapper -->

 </body>

 </html>
