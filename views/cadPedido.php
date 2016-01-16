<?php

    include '../models/defSession.php';

    include '../models/cadPedido_m.php';

    validaSession();

?>


<html>

    <?php include 'navTab.php' ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"> Realizar pedido </h3>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Preencha os campos abaixo
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">

<form role="form" action="" method="post" >
    <div class="form-group" >
        <input class="form-control" name='codigoProduto' placeholder="Código do produto" required>
        <input class="form-control" name='codigoCliente' placeholder="Código do cliente" required>
        <input class="form-control" name='quantidade' placeholder="Quantidade" required>

        <button class=" btn btn-outline btn-primary" type="submit" name="encaminhar">Encaminhar</button>
    </div>
</form>
                            </div>
                        </div>
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

<?php

    if(isset($_POST['encaminhar'])) {
        fazerPedido();
        /* Função responsável pelo cadastro de pedidos */
    }
?>
