<!DOCTYPE html>

<?php

    include '../models/defSession.php';

    include '../models/funcionarios_m.php';
    include '../models/frequencia_m.php';
    include '../models/db.php';

    validaAdmin();

    $cpf = $_GET['cpf'];

    $conn = conectaBanco();
    $run = getDadosUser($conn, $cpf);
    $dados = mysqli_fetch_array($run);

    $nome           = $dados['nome'];
    $senha          = $dados['senha'];
    $endereco       = $dados['endereco'];
    $telefone       = $dados['telefone'];
    $idFuncionario  = $dados['idUsuario'];

?>

<html>

<?php include 'navTab.php'; ?>

<div id="page-wrapper">

    <div class="row">
       <div class="col-lg-12">
           <h3 class="page-header">
               Funcionário: <?php echo $nome ?>
           </h3>
           <ol class="breadcrumb">
               <li>
                   <i class="fa fa-users"></i> <a href="funcionarios.php"> Funcionários cadastrados</a>
               </li>
               <li class="active">
                   <i class="fa  fa-user"></i> <?php echo $nome ?>
               </li>
           </ol>
       </div>
   </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Atualizar cadastro
                </div>
                <div class="panel-body">
                    <div class="table-responsive">


<form role="form" action="" method="post" >

    <table class="table  table-striped">

    <thead>
    <tr>
        <th> Nome       </th>
        <th> CPF        </th>
        <th> Senha      </th>
        <th> Endereço   </th>
        <th> Telefone   </th>

    </tr>
    </thead>

    <tr>
      <td> <input class="form-control" name='nome' value="<?php echo $nome ?>" > </td>
      <td> <input class="form-control" name='cpf' value="<?php echo $cpf ?>" disabled> </td>
      <td> <input class="form-control" name='senha' value="<?php echo $senha ?>"> </td>
      <td> <input class="form-control" name='endereco' value="<?php echo $endereco ?>"> </td>
      <td> <input class="form-control" name='telefone' value="<?php echo $telefone ?>"> </td>
    </tr>

    </table>
    <button class="btn btn-outline btn-success" type="submit" name="update">Atualizar dados</button>

</form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Frequência
                </div>

                <div class="panel-body">
                    <div class="table-responsive">


<form role="form" action="" method="post" >


<table class="table  table-striped">


    <thead>
    <tr>
        <th>  Data </th>
    </tr>
    </thead>


<?php


    $run = listarFreq($idFuncionario, $conn);

    while ( $fila = mysqli_fetch_array($run) ) {
        $data = $fila[data];

        echo " <tr> <td> $data </td> </tr> ";
    }

?>

</table>


</form>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">

<form role="form" action="" method="post" onsubmit="return confirm('Deseja realmente excluir o funcionário?')">

    <button class="btn btn-outline btn-danger" type="submit" name="delete">
        Excluir funcionário</button>

</form>

                </div>
            </div>
        </div>
    </div>



</div>



    </div>
</body>

</html>



<?php


    if( isset($_POST['update']) ) {

        if (updateUser($cpf, $conn) ) {
            echo"<script>window.open('../views/funcionarios.php','_self')</script>";

        }

    } elseif( isset($_POST['delete']) ) {

        deleteUser($cpf, $conn);
        echo"<script>window.open('../views/funcionarios.php','_self')</script>";
    }
?>
