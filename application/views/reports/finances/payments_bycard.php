<?php
function imprimeDados($result, $tipo, $cartao) {
	$total = 0;
	if (isset($result[$tipo][$cartao])) {
		foreach ($result[$tipo][$cartao] as $resultado)
			$total += $resultado;
	}
	echo "<td>$total</td>";
	for ($i = 1; $i <= 6; $i++) { echo "<td>";
		if (isset($result[$tipo][$cartao][$i]))
			echo $result[$tipo][$cartao][$i];
		else
			echo 0;

		echo "</td>";
	}

}
?>

<div class = "row">
	<div class="col-lg-10" bgcolor="red">
		<h5>Número de sócios contribuintes: <?php echo $associates ?> </h5>

		<link href="http://www.kinderlandteste.com/kinderlandweb/assets/css/basic.css" rel="stylesheet" />
		<!--<link href="http://www.kinderlandteste.com/kinderlandweb/assets/css/old/screen.css" rel="stylesheet" />-->
		<link href="http://www.kinderlandteste.com/kinderlandweb/assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="http://www.kinderlandteste.com/kinderlandweb/assets/css/themes/base/jquery-ui.css" />
		<link rel="stylesheet" href="http://www.kinderlandteste.com/kinderlandweb/assets/css/bootstrap-switch.min.css">
		</script>
		<script type="text/javascript" src="http://www.kinderlandteste.com/kinderlandweb/assets/js/jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="http://www.kinderlandteste.com/kinderlandweb/assets/js/ui/jquery-ui.js"></script>
		<script type="text/javascript" src="http://www.kinderlandteste.com/kinderlandweb/assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="http://www.kinderlandteste.com/kinderlandweb/assets/js/jquerysettings.js"></script>
		<script type="text/javascript" src="http://www.kinderlandteste.com/kinderlandweb/assets/js/jquery/jquery.redirect.js"></script>
		<script type="text/javascript" src="http://www.kinderlandteste.com/kinderlandweb/assets/js/formValidationFunctions.js"></script>
		<script type="text/javascript" src="http://www.kinderlandteste.com/kinderlandweb/assets/js/bootstrap-switch.min.js"></script>
		<script type="text/javascript" src="http://www.kinderlandteste.com/kinderlandweb/assets/js/jquery/jquery.mask.js"></script>
		<script type="text/javascript" src="http://www.kinderlandteste.com/kinderlandweb/assets/js/jquery.tablesorter.js"></script>
		<script type="text/javascript" src="http://www.kinderlandteste.com/kinderlandweb/assets/js/jquery.tablesorter.widgets.js"></script>

		
		<a href="<?= $this -> config -> item('url_link'); ?>reports/payments_bycard">
		<button class="btn btn-primary" style="margin: 0px auto; ">Todos os pagamentos</button>
		</a>
		<a href="<?= $this -> config -> item('url_link'); ?>reports/payments_bycard?type=captured">
		<button class="btn btn-primary" style="margin: 0px auto; ">Pagamentos finalizados</button>
		</a>
		<a href="<?= $this -> config -> item('url_link'); ?>reports/payments_bycard?type=canceled">
		<button class="btn btn-primary" style="margin: 0px auto; ">Pagamentos cancelados</button>
		</a>
		
		<br>
		<table class="table table-bordered table-striped" style="max-width: 850px;">
			<tr>
				<td colspan="8"> Crédito: </td> <?php $tipo = "credito"; ?>
			</tr>
			<tr>
				<td> Bandeira do cartão: </td>
				<td> Total: </td>
				<td> À vista: </td>
				<td> 2x: </td>
				<td> 3x: </td>
				<td> 4x: </td>
				<td> 5x: </td>
				<td> 6x: </td>
			</tr>
			<tr>
				<td> Amex </td>
				<?php $cartao = "amex";
					imprimeDados($result, $tipo, $cartao);
				?>
			</tr>
			<tr>
				<td > Mastercard </td>
				<?php $cartao = "mastercard";
					imprimeDados($result, $tipo, $cartao);
				?>
			</tr>
			<tr>
				<td > Visa </td>
				<?php $cartao = "visa";
					imprimeDados($result, $tipo, $cartao);
				?>
			</tr>
			<tr>
				<td > Totais crédito </td>
				<td ><?php $total = 0;
					foreach ($credito as $resultado)
						$total += $resultado;
					echo $total;
				?>
				<td><?php echo $credito[1]?></td>
				<td><?php echo $credito[2]?></td>
				<td><?php echo $credito[3]?></td>
				<td><?php echo $credito[4]?></td>
				<td><?php echo $credito[5]?></td>
				<td><?php echo $credito[6]?></td>
				</td>
			</tr>
			<tr>
				<td colspan="8"> Débito: </td>
			</tr>
			<tr>
				<td colspan=2> Maestro </td>
				<td colspan=6><?php if(isset ($result["debito"]["mastercard"][1])) echo $result["debito"]["mastercard"][1]; else echo 0; ?></td>
			</tr>
			<tr>
				<td colspan=2> Visa Electron </td>
				<td colspan=6><?php if(isset ($result["debito"]["visa"][1])) echo $result["debito"]["visa"][1]; else echo 0;?></td>
			</tr>
			<tr>
				<td colspan=2> Total débito </td>
				<td colspan=6><?php echo $debito; ?></td>
			</tr>
		</table>
	</div>
</div>