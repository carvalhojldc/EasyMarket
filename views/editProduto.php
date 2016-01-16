<!DOCTYPE html>

<?php
    // Validar a SESSION

    include '../models/defSession.php';
    include '../models/produto_m.php';
    include '../models/db.php';

    validaAdmin();

    $codigo = $_GET['codigo'];

    $conn = conectaBanco();

    $run = getDadosProd($conn, $codigo);

    $dados = mysqli_fetch_array($run);

    $descricao  = $dados[descricao];
    $preco      = $dados[preco];
    $estoque    = $dados[estoque];
    $idProduto  = $dados[idProduto];

?>

<html>

<?php include 'navTab.php'; ?>

<div id="page-wrapper">

    <div class="row">
       <div class="col-lg-12">
           <h3 class="page-header">
              Produto: <?php echo $descricao ?>
          </h3>
           <ol class="breadcrumb">
               <li>
                   <i class="fa  fa-shopping-cart"></i> <a href="produtos.php"> Produtos cadastrados</a>
               </li>
               <li class="active">
                   <i class="fa   fa-edit"></i> <?php echo $descricao ?>
               </li>
           </ol>
       </div>
   </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Dados cadastrados
                </div>
                <div class="panel-body">
                    <div class="table-responsive">


<form role="form" action="" method="post" >


    <table class="table  table-striped">


        <thead>
        <tr>
            <th> Descrição      </th>
            <th> Código        </th>
            <th> Preço       </th>
            <th> Estoque   </th>

        </tr>
        </thead>


        <tr>
          <td>
            <input class="form-control" name='descricao' value="<?php echo $descricao ?>" >
          </td>
          <td>
              <input class="form-control" name='codigo' value="<?php echo $codigo ?>" disabled>
          </td>
          <td>
              <input class="form-control" name='preco' value="<?php echo $preco ?>">
          </td>
          <td>
              <input class="form-control" name='estoque' value="<?php echo $estoque ?>">
          </td>
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

                    <form role="form" action="" method="post" onsubmit="return confirm('Deseja realmente excluir o produto?')" >

                    <input class="btn btn-outline btn-danger" type="submit" name="delete"
                           value="Excluir produto">

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


    if(isset($_POST['update']) ) {

        if ( updateProd($codigo, $conn) ) {
            echo"<script>window.open('../views/produtos.php','_self')</script>";
        }

    } elseif(isset($_POST['delete'])) {

        deleteProd($codigo, $conn);
        echo"<script>window.open('../views/produtos.php','_self')</script>";
    }
?>
