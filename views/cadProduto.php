<!DOCTYPE html>

<?php
    // Validar a SESSION

    include '../models/defSession.php';

    validaAdmin();
?>

<html>

	<?php
		include 'navTab.php';
	?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"> Cadastro de produto </h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

             <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Preencha os campos abaixo
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">


<form role="form" action="" method="post">

    <div class="form-group">
        <input class="form-control" name="descricaoProd" placeholder="Descrição" required>

        <input class="form-control" name="codigo" placeholder="Código de indentificação" required>

        <input class="form-control" id="maskPreco" name="preco" placeholder="Preço (R$)" required>

        <input class="form-control" name="estoque" placeholder="Estoque">
    </div>


    <input type="submit" class="btn btn-outline btn-primary" name="cadastro" value="Cadastrar produto">

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





</body>

</html>





<?php

    include '../models/cadProduto_m.php';

	if( isset($_POST['cadastro']) ) {

            if(cadastraProd()) {
                //echo "<script> window.open('../views/produtos.php','_self') </script>";
            }
        }
?>
