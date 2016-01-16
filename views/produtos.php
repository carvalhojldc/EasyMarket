<!DOCTYPE html>

<?php

    include '../models/defSession.php';

    include '../models/produto_m.php';
    include '../models/db.php';

    validaAdmin();
?>

<html>

<?php include 'navTab.php'; ?>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"> Produtos cadastrados</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="dataTable_wrapper">


        <table class="table table-striped table-bordered table-hover" id="produtos">
            <thead>
                <tr>
                    <th> Descrição  </th>
                    <th> Código     </th>
                    <th> Preço      </th>
                    <th> Estoque    </th>
                </tr>
            </thead>
            <tbody>

                <?php

                    $conn = conectaBanco();

                    $run = listarProd($conn);

                        while ( $fila = mysqli_fetch_array($run) ) {

                            $descricao  = $fila[descricao];
                            $codigo     = $fila[codigo];
                            $preco      = $fila[preco];
                            $estoque    = $fila[estoque];

                       echo "
                            <tr>
                                <td> <a href='../views/editProduto.php?codigo=$codigo'>
                                $descricao </a> </td>
                                <td> $codigo    </td>
                                <td> $preco     </td>
                                <td> $estoque   </td>
                            </tr>";
                        }

                ?>

            </tbody>
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

<!-- DataTables JavaScript -->
<script src="../bower_components/datatables/media/js/jquery.dataTables.js"></script>
<script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#produtos').DataTable({
            responsive: true
        });
    });
</script>

</body>

</html>
