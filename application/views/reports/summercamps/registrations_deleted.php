<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Colônia Kinderland</title>

<link href="<?= $this->config->item('assets'); ?>css/basic.css"
	rel="stylesheet" />
<!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
<link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css"
	rel="stylesheet" />
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css">
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>
<script type="text/javascript">
	function showSubReport (camp, year, status, associated, gender) {
		if(associated != null)
			var url = "<?= $this->config->item('url_link'); ?>reports/subscriptions?type=1&camp="+camp+"&year="+year+"&status="+status+"&associated="+associated+"&gender="+gender;
		else
			var url = "<?= $this->config->item('url_link'); ?>reports/subscriptions?type=1&camp="+camp+"&year="+year+"&status="+status+"&gender="+gender;
		window.open(url, '_blank');
	}
</script>
<style>
	a {
		cursor: pointer;
	}
	
	div.scroll{
    	
    	width:100%;
    	height:100%;
    	overflow-x:hidden;
    
    }
</style>
</head>
<body>
	<div class="scroll">
	<div class="main-container-report">
		<div class="row">
			<div class="col-lg-10" bgcolor="red">
				<form method="GET">
					<select name="ano_f" onchange="this.form.submit()" id="anos">
					
							<?php
							foreach ( $years as $year ) {
								$selected = "";
								if ($ano_escolhido == $year)
									$selected = "selected";
								echo "<option $selected value='$year'>$year</option>";
							}
							?>
						</select> <select name="colonia_f" onchange="this.form.submit()"
						id="colonia">
						<option value="Todas"
							<?php if(!isset($colonia_escolhida)) echo "selected"; ?>>Todas</option>
							<?php
							foreach ( $camps as $camp ) {
								$selected = "";
								if ($colonia_escolhida == $camp)
									$selected = "selected";
								echo "<option $selected value='$camp'>$camp</option>";
							}
							?>
						</select>
				</form>
				<table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 700px;">

					<tr>
						<th align="right"></th>
						<th align="right" colspan=2 style="text-align: center">Feminino</th>
						<th align="right" colspan=2 style="text-align: center">Masculino</th>
					
					
					<tr>
					
					
					<tr>
						<th align="right"></th>
						<th align="right">Sócio</th>
						<th align="right">Não Sócio</th>
						<th align="right">Sócio</th>
						<th align="right">Não Sócio</th>
					
					
					<tr>
							<?php if(!isset($colonia_escolhida)) { $colonia_escolhida = 'Todas';} ?>
							<th align="right">Pré-inscrições Canceladas</th>
						<td align='right'><?php if($countsAssociatedF->cancelado !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $year?>', -3, 'true', 'F')" target="blank"
							><?php echo $countsAssociatedF->cancelado; ?></a><?php } else echo $countsAssociatedF->cancelado; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->cancelado !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $year?>', -3, 'false', 'F')" target="blank"
							> <?php echo $countsNotAssociatedF->cancelado; ?></a><?php } else echo $countsNotAssociatedF->cancelado; ?> </td>
						<td align='right'><?php if($countsAssociatedM->cancelado !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $year?>', -3, 'true', 'M')" target="blank"
							> <?php echo $countsAssociatedM->cancelado; ?></a><?php } else echo $countsAssociatedM->cancelado; ?> </td>
						<td align='right'><?php if($countsNotAssociatedM->cancelado !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $year?>', -3, 'false', 'M')" target="blank"
							> <?php echo $countsNotAssociatedM->cancelado; ?></a><?php } else echo $countsNotAssociatedM->cancelado; ?> </td>
					</tr>
					<tr>
						<th align="right">Pré-inscrições Desistentes</th>
						<td align='right'><?php if($countsAssociatedF->desistente !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $year?>', -1, 'true', 'F')" target="blank"
							> <?php echo $countsAssociatedF->desistente; ?></a><?php } else echo $countsAssociatedF->desistente; ?> </td>
						<td align='right'><?php if($countsNotAssociatedF->desistente !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $year?>', -1, 'false', 'F')" target="blank"
							> <?php echo $countsNotAssociatedF->desistente; ?></a><?php } else echo $countsNotAssociatedF->desistente; ?> </td>
						<td align='right'><?php if($countsAssociatedM->desistente !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $year?>', -1, 'true', 'M')" target="blank"
							> <?php echo $countsAssociatedM->desistente; ?></a><?php } else echo $countsAssociatedM->desistente; ?> </td>
						<td align='right'><?php if($countsNotAssociatedM->desistente !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $year?>', -1, 'false', 'M')" target="blank"
							> <?php echo $countsNotAssociatedM->desistente; ?></a><?php } else echo $countsNotAssociatedM->desistente; ?> </td>
					</tr>
					<tr>
						<th align="right" width='200px'>Pré-inscrições Excluídas</th>
						<td align='right'><?php if($countsAssociatedF->excluido !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $year?>', -2, 'true', 'F')" target="blank"
							> <?php echo $countsAssociatedF->excluido; ?></a><?php } else echo $countsAssociatedF->excluido; ?> </td>
						<td align='right'><?php if($countsNotAssociatedF->excluido !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $year?>', -2, 'false', 'F')" target="blank"
							> <?php echo $countsNotAssociatedF->excluido; ?></a><?php } else echo $countsNotAssociatedF->excluido; ?> </td>
						<td align='right'><?php if($countsAssociatedM->excluido !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $year?>', -2, 'true', 'M')" target="blank"
							> <?php echo $countsAssociatedM->excluido; ?></a><?php } else echo $countsAssociatedM->excluido; ?> </td>
						<td align='right'><?php if($countsNotAssociatedM->excluido !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $year?>', -2, 'false', 'M')" target="blank"
							> <?php echo $countsNotAssociatedM->excluido; ?></a><?php } else echo $countsNotAssociatedM->excluido; ?> </td>
					</tr>
					<tr>
						<th align="right" width='200px'>Total</th>
						<td align='right'> <?php echo $countsAssociatedF->cancelado + $countsAssociatedF->desistente + $countsAssociatedF->excluido; ?> </td>
						<td align='right'> <?php echo $countsNotAssociatedF->cancelado + $countsNotAssociatedF->desistente + $countsNotAssociatedF->excluido; ?> </td>
						<td align='right'> <?php echo $countsAssociatedM->cancelado + $countsAssociatedM->desistente + $countsAssociatedM->excluido; ?> </td>
						<td align='right'> <?php echo $countsNotAssociatedM->cancelado + $countsNotAssociatedM->desistente + $countsNotAssociatedM->excluido; ?> </td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	</div>
</body>
</html>