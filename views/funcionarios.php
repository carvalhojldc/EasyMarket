<!DOCTYPE html>

<?php
    include '../models/defSession.php';

    include '../models/db.php';
    include '../models/funcionarios_m.php';
    include '../models/frequencia_m.php';

    validaAdmin();

    // Para definições da frequência
    $getData = date('d-m-Y');
    $dataForBD = date('Y-m-d');

?>

<html>

<?php include 'navTab.php' ?>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"> Funcionários cadastrados</h3>
        </div>

    </div>



    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">

        <table  class="table table-bordered table-striped">


            <thead>
            <tr>
                <th> Nome </th>
                <th> CPF </th>
                <th> Endereço </th>
                <th> Telefone </th>
                <th> Data: <?php echo date('d-m-Y'); ?> </th>
            </tr>
            </thead>


            <?php

                $conn = conectaBanco();

                $run = listar($conn);

                while ( $fila = mysqli_fetch_array($run) ) {
                    $nome           = $fila[nome];
                    $cpf            = $fila[cpf];
                    $endereco       = $fila[endereco];
                    $telefone       = $fila[telefone];
                    $tipoUser       = $fila[tipoUser];
                    $idFuncionario  = $fila[idUsuario];

                    if($tipoUser == 2) {
                        $cargo = '- GRT';
                    }
                    else { $cargo = '';}/*elseif($tipoUser == 3) {
                        $cargo = 'Funcionário';
                    }*/



                    echo "
                    <form action='' method='post'>
                        <tr>
                            <td> <a href='editFuncionario.php?cpf=$cpf'>
                                 $nome $cargo
                            </a> </td>
                            <td> $cpf </td>
                            <td> $endereco </td>
                            <td> $telefone </td>

                            <td>

                     ";

                    if (!controle($dataForBD, $idFuncionario, $conn)) {

                    echo "
                            <button class='btn btn-default' type='submit'
                                name=$idFuncionario >
                                    Lançar ponto</button>
                            </td>
                        </tr>
                    </form> ";

                    } else {
                    echo "
                            <button class='btn btn-success disabled' type='submit'
                                name='NONO' >Compareceu</button>
                            </td>
                        </tr>
                    </form>";
                    }

                    if( isset($_POST[$idFuncionario]) ) {
                        frequencia($dataForBD, $idFuncionario, $conn);
                        echo"<script>window.open('../views/funcionarios.php','_self')</script>";
                    }

                }

            ?>

        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

    </div>
</body>

</html>
