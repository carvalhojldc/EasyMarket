<!DOCTYPE html>

<?php

    include '../models/defSession.php';
    include '../models/db.php';
    include '../models/caixa_m.php';
    validaSession();
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
                     Caixa
                 </div>
                 <div class="panel-body">

                     <div class="row">
                         <div class="col-lg-3">


                         <form action="" method="post">
                             <input class="form-control form-control-caixa" name="codigoCliente" placeholder="Digite o código do cliente" required>
                             <button class="btn btn-outline btn-primary" type="submit" name="cliente">Procurar</button>
                        <?php
                            if( isset($_POST['cliente']) ) {
                                $codigo = $_POST['codigoCliente'];
                                echo "<script> window.open('../views/caixa2.php?data=$codigo','_self') </script>";
                            }
                        ?>

                         </form>

                         </div>
                     </div>
                 </div>

             </div>


             <div class="panel panel-default">
                 <div class="panel-heading">
                     Contas em aberto
                 </div>

                 <div class="panel-body">



                        <?php

                            $conn = conectaBanco();

                            $run = contasEmAberto($conn);

                            if(!mysqli_num_rows($run)) {
                                echo '
                                <div class="alert alert-info">
                                    Nenhuma conta em aberto!
                                </div>
                                ';
                            } else {
                                echo '<table  class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th> Cliente  </th>
                                        <th> Valor (R$) </th>
                                        <th> Cancelar </th>
                                    </tr>
                                   </thead>';

                            }

                                while ( $fila = mysqli_fetch_array($run) ) {

                                    $codigo  = $fila['codigo'];
                                    $valor     = $fila['valor'];

                               echo '
                                    <tr>
                                        <td>'. $codigo  .'  </td>
                                        <td> '. $valor    .' </td>
                                        <td>
                                            <form role="form" action="" method="post" onsubmit="return confirm(\'Deseja realmente cancelar esta venda?\')" >
                                                <button title="Cancelar conta" name='.$codigo.' type="submit" class="btn2 btn-danger btn-circle btn">
                                                <i class="fa fa-times"  ></i></button>
                                            </form>
                                        </td>
                                    </tr>';

                                    if( isset($_POST[ $codigo ]) ) {

                                        cancelarVenda($conn, $codigo);
                                        echo "<script> window.open('../views/caixa.php','_self') </script>";

                                    }
                                }
                                echo '</table>';
                        ?>


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
