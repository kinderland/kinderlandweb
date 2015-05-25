<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this -> config -> item('assets'); ?>css/basic.css" rel="stylesheet" />
        <!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
        <link href="<?= $this -> config -> item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/bootstrap-switch.min.css"></script>
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/theme.default.css" />
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/ui/jquery-ui.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquerysettings.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery/jquery.redirect.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/formValidationFunctions.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/bootstrap-switch.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery/jquery.mask.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery.tablesorter.js"></script>

    </head>
<?php

function formatarEMostrar($valor, $opcao) {
	if ($opcao == PAYMENT_REPORTBYCARD_VALUES)
		echo 'R$: ' . $valor . ',00';
	else
		echo $valor;
}

function imprimeDados($result, $tipo, $cartao, $opcao = 2) {
	$total = 0;
	if (isset($result[$tipo][$cartao])) {
		foreach ($result[$tipo][$cartao] as $resultado)
			$total += $resultado;
	}
	echo "<td style='text-align: center;'>";
	formatarEMostrar($total, $opcao);
	echo "</td>";

	for ($i = 1; $i <= 6; $i++) { echo "<td>";
		if (isset($result[$tipo][$cartao][$i]))
			formatarEMostrar(intval($result[$tipo][$cartao][$i]), $opcao);
		else
			formatarEMostrar(0, $opcao);

		echo "</td>";
	}

}
?>
<body>
	<div class = "row">
		<div class="col-lg-10" bgcolor="red">
			<h4>Número de sócios contribuintes: <?php echo $associates ?> </h4>
			<h4>Número de doações avulsas: <?php echo $avulsas ?> </h4>

	<!--		
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
	-->	
			<table class="table table-bordered table-striped table-min-td-size" style="max-width: 600px;">
				<tr>
					<td colspan="8"> <h4> <b>Cartão de crédito: </b></h4> </td> <?php $tipo = "credito"; ?>
				</tr>
				<tr>
					<td style="text-align: right;"><h4> <b> Bandeira do cartão </b></h4> </td>
					<td style="text-align: center;"><h4> <b> Total </b></h4> </td>
					<td><h4> <b> 1x </b></h4></td>
					<td><h4> <b> 2x </b></h4></td>
					<td><h4> <b> 3x </b></h4></td>
					<td><h4> <b> 4x </b></h4></td>
					<td><h4> <b> 5x </b></h4></td>
					<td><h4> <b> 6x </b></h4></td>
				</tr>
				<tr>
					<td style="text-align: right;"> Amex </td>
					<?php $cartao = "amex";
						imprimeDados($result, $tipo, $cartao, $option);
					?>
				</tr>
				<tr>
					<td style="text-align: right;"> Mastercard </td>
					<?php $cartao = "mastercard";
						imprimeDados($result, $tipo, $cartao, $option);
					?>
				</tr>
				<tr>
					<td style="text-align: right;"> Visa </td>
					<?php $cartao = "visa";
						imprimeDados($result, $tipo, $cartao, $option);
					?>
				</tr>
				<tr>
					<td style="text-align: right;"> Totais crédito </td>
					<td style="text-align: center;"><?php $total = 0;
						foreach ($credito as $resultado)
							$total += $resultado;
						formatarEMostrar($total, $option);
					?>
					</td>
					<?php
						for ($i = 1; $i <= 6; $i++) {
							echo "<td>";
							formatarEMostrar($credito[$i], $option);
							echo "</td>";
						}
					?>
				</tr>
			</table>
			<table class="table table-bordered table-striped table-min-td-size" style="max-width: 600px;">
				<tr>
					<td colspan="2" style="text-align: center;"> <h4> <b>Cartão de débito: </b></h4> </td>
				</tr>
				<tr>
					<td style="text-align: right;"><h4> <b> Bandeira do cartão </b></h4> </td>
					<td style="text-align: center;"><h4> <b> Total </b></h4> </td>

				</tr>
				<tr>
					<td style="text-align: right;"> Maestro </td>
					<td style="text-align: center;"><?php
					if (isset($result["debito"]["mastercard"][1]))
						echo formatarEMostrar(intval($result["debito"]["mastercard"][1]), $option);
					else
						echo formatarEMostrar(0, $option);
		 			?></td>
				</tr>
				<tr>
					<td style="text-align: right;"> Visa Electron </td>
					<td style="text-align: center;"><?php
					if (isset($result["debito"]["visa"][1]))
						echo formatarEMostrar(intval($result["debito"]["visa"][1]), $option);
					else
						echo formatarEMostrar(0, $option);
					?></td>
				</tr>
				<tr>
					<td style="text-align: right;"> Total débito </td>
					<td style="text-align: center;"><?php echo formatarEMostrar($debito, $option); ?></td>
				</tr>
			</table>
		</div>
	</div>
</body>