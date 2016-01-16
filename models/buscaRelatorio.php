
<?php
	/*
		Resposável por gerar o relatório financeiro
		-> Seja do dia escolhido ou mês
	*/

	include '../models/db.php';
	include '../models/defSession.php';
	include '../models/financeiro_m.php';

	$conn = conectaBanco();

	$data 	= mysqli_real_escape_string($conn, $_POST['palavra']);

	$array = explode("-",$data);
	$len = count($array);
	//echo "<script>alert('$data')</script>";

	$ano = $array[0];
	$mes_num = $array[1];

	$meses = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
				'Setembro', 'Outubro', 'Novembro', 'Dezembro');
	$mes_nome = $meses[$mes_num - 1];

	//echo "<script>alert('Cadastro $ano $mes com sucesso!')</script>";
	//Recupera oque foi selecionado

	if($len == 3) {
		$dia = $array[2];
		$run = vendasDia($conn, $data);
		$str = 'Vendas do dia '. $dia . ' de ' . $mes_nome;
	} else {
		$run = vendasMes($conn, $mes_num, $ano);
		$str = 'Vendas do mês de ' . $mes_nome;
	}

	mysqli_close($conn);


	echo '
	<!-- Vendas por mes -->

		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					'. $str .'
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>Produto</th>
									<th>Quantidade</th>
									<th>Valor R$</th>
								</tr>
							</thead>
							<tbody>';
					$valorTotalVendaM = 0;

					while ( $fila = mysqli_fetch_array($run) ) {

						$descricaoM 	= $fila['descricao'];
						$quantidadeM 	= $fila['quantidadeTotal'];
						$valorM			= $fila['valorTotal'];

						$valorTotalVendaM = $valorTotalVendaM + $valorM;

						echo "
							<tr>
								<td> $descricaoM </td>
								<td> $quantidadeM </td>
								<td> $valorM </td>
							</tr>";
							// END -- Vendas do dia
					}

				echo '
							</tbody>

						</table>

						<h3 class="text-info"  >Valor total das vendas: R$ '. $valorTotalVendaM .' </h3>

					</div>
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->


	<!-- FIM - Vendas por mes -->';
	echo '
	<script src="../bower_components/datatables/media/js/jquery.dataTables.js"></script>
	<script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>';
	echo "
	<script>
	$(document).ready(function() {
		$('#dataTables-example').DataTable({
				responsive: true
		});
	});
	</script>";
?>
