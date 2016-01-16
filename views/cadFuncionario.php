<!DOCTYPE html>

<?php

    include '../models/defSession.php';
    include '../models/cadFuncionario_m.php';

    validaAdmin();

    $dono = '1';
?>

<html>


    <?php include 'navTab.php' ?>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"> Cadastro de funcionário </h3>
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
        <input class="form-control" name='nome' placeholder="Nome" required>
        </div>
    <div class="form-group" >
        <input class="form-control" id="campoCPF" name='cpf' placeholder="CPF" required>
        </div>
    <div class="form-group" >
        <input class="form-control" name='senha' placeholder="Senha" required>
        </div>
    <div class="form-group" >
        <input class="form-control" name='endereco' placeholder="Endereço" required>
        </div>
    <div class="form-group" >
        <input class="form-control" name='telefone' placeholder="Telefone" required>
        <?php
            if($tipoUsuario == $dono) {
                echo
                "<div class='radio'>
                    <label>
                        <input type='radio' name='tipo_usuario' id='optionsRadios1' value='2'> Gerente
                    </label>
                </div>
                <div class='radio'>
                    <label>
                        <input type='radio' name='tipo_usuario' id='optionsRadios2' value='3' checked> Funcionário comum
                    </label>
                </div> ";
            }
        ?>
        </div>
<div class="form-group" >
        <input class="btn btn-outline btn-primary" type="submit" name="cadastro" value="Cadastrar">
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

    if( isset($_POST['cadastro']) ) {
        cadastra();
	/* Função para cadastro de funcionários */
    }

?>
