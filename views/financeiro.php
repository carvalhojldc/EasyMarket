<!DOCTYPE html>

<?php
    // Validar a SESSION

    include '../models/db.php';
    include '../models/defSession.php';
    include '../models/financeiro_m.php';

    validaAdmin();

    $conn = conectaBanco();
?>

<html>


<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">

$(function(){

	//PESQUISA DE FORMULÀRIO
	$("#form-pesquisa").submit(function(e){
		e.preventDefault();

        var btn = $(this).find("input[type=submit]:focus" );
		var pesquisa = $("#pesquisa").val();

        //alert(pesquisa);

		if(pesquisa == '') {
			alert('Informe sua Pequisa!');
		} else {
			var dados = {
				palavra : pesquisa,
			}
			$.post('../models/buscaRelatorio.php', dados, function(retorna){
				$(".resultado").html(retorna);
			});
		}
	});

    $("#form-pesquisa2").submit(function(e){
        e.preventDefault();

        var btn = $(this).find("input[type=submit]:focus" );
        var pesquisa = $("#pesquisa2").val();

        //alert(pesquisa);

        if(pesquisa == '') {
            alert('Informe sua Pequisa!');
        } else {
            var dados = {
                palavra : pesquisa,
            }
            $.post('../models/buscaRelatorio.php', dados, function(retorna){
                $(".resultado").html(retorna);
            });
        }
    });

});
</script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->

        <?php include 'navTab.php' ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"> Balanço financeiro</h3>
                </div>
            </div>

        <div class="col-lg-3  panel-body">
            <b>Gerar relatório (mês):</b>
            <form id="form-pesquisa" action="" method="post">
                <input class="form-control" name="pesquisa" id="pesquisa" type="month">
                <input class="btn btn-outline btn-default" type="submit" name="enviar" value="Gerar mês">
            </form>
        </div>

        <div class="col-lg-3  panel-body">
            <b>Gerar relatório (dia):</b>
            <form id="form-pesquisa2" action="" method="post">
                <input class="form-control" name="pesquisa" id="pesquisa2" type="date">
                <input class="btn btn-outline btn-default" type="submit" name="enviar" value="Gerar dia">
            </form>
        </div>



        <div class="row">
            <p class="resultado"></p>
        </div>

            <!-- Vendas por dia -->
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Vendas do dia de hoje - <?php echo date('d/m/Y')?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="diaAtual">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th>Quantidade</th>
                                            <th>Valor R$</th>
                                        </tr>
                                    </thead>
                                    <tbody>

            <?php
                $dataD = date('Y-m-d');
                $queryD = vendasDia($conn, $dataD);
                $valorTotalVendaD = '0';
                while ( $filaD = mysqli_fetch_array($queryD) ) {

                    $descricaoD  = $filaD['descricao'];
                    $quantidadeD = $filaD['quantidadeTotal'];
                    $valorD      = $filaD['valorTotal'];
                    $valorTotalVendaD = $valorTotalVendaD + $valorD;
                    echo "
                        <tr>
                            <td> $descricaoD </td>
                            <td> $quantidadeD </td>
                            <td> $valorD </td>
                        </tr>";
            }
            ?>
                                    </tbody>

                                </table>
                                <h3 class="text-info"  >Valor total das vendas: R$ <?php echo $valorTotalVendaD ?> </h3>
                            </div>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- FIM - Vendas por dia -->


            <!-- Vendas dos últimos 7 dias -->
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Vendas dos últimos 7 dias
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="seteDias">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Produto</th>
                                            <th>Quantidade</th>
                                            <th>Valor R$</th>
                                        </tr>
                                    </thead>
                                    <tbody>

            <?php
                $query7d = getLastSeven($conn); /* Buscando as datas dos últmos 7 dias que ocorreram vendas*/

                $valorTotalVendaD = 0;
                while ( $getDate = mysqli_fetch_array($query7d) ) { /* Para cada data buscar as vendas... */
                    $data7d = $getDate['0'];
                    $queryVenda7d = vendasDia($conn, $data7d);

                    while ( $filaD = mysqli_fetch_array($queryVenda7d) ) {
                        $descricaoD  = $filaD['descricao'];
                        $quantidadeD = $filaD['quantidadeTotal'];
                        $valorD      = $filaD['valorTotal'];
                        $valorTotalVendaD = $valorTotalVendaD + $valorD;
                        echo "
                            <tr>
                                <td> $data7d </td>
                                <td> $descricaoD </td>
                                <td> $quantidadeD </td>
                                <td> $valorD </td>
                            </tr>";
                        }
                }
            ?>
                                    </tbody>

                                </table>

                                <h3 class="text-info"  >Valor total das vendas: R$ <?php echo $valorTotalVendaD ?> </h3>
                            </div>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- FIM _ Vendas dos últimos 7 dias -->







        </div>
        <!-- /#page-wrapper -->


            <!-- DataTables JavaScript -->
 <script src="../bower_components/datatables/media/js/jquery.dataTables.js"></script>
 <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

 <script>
 $(document).ready(function() {
     $('#diaAtual').DataTable({
             responsive: true
     });
     $('#seteDias').DataTable({
             responsive: true
     });

 });
 </script>


</body>

</html>
