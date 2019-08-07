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
			var url = "<?= $this->config->item('url_link'); ?>reports/subscriptions?camp="+camp+"&year="+year+"&status="+status+"&associated="+associated+"&gender="+gender;
		else
			var url = "<?= $this->config->item('url_link'); ?>reports/subscriptions?camp="+camp+"&year="+year+"&status="+status+"&gender="+gender;

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
    
    div.pad{
    
    	padding-left:16%
    }
    
</style>
</head>
<body>
	<div class="scroll">
	<div class="main-container-report">
		<div class="row">
			<div class="col-lg-10" bgcolor="red">
				<form method="GET">
					Ano: <select name="ano_f" onchange="this.form.submit()" id="anos">
					
							<?php
							foreach ( $years as $year ) {
								$selected = "";
								if ($ano_escolhido == $year)
									$selected = "selected";
								echo "<option $selected value='$year'>$year</option>";
							}
							?>
						</select> 
						Colônia: <select name="colonia_f" onchange="this.form.submit()"
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
				<div class="pad">
				<table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 1200px;">

					<tr>
						<th align="right"></th>
						<th align="right" colspan=2 style="text-align: center">Feminino</th>
						<th align="right" colspan=2 style="text-align: center">Masculino</th>
					
					
					<tr>
					
<!--					
					<tr>
						<th align="right" width='700px'></th>
						<th align="right">Sócio</th>					
						<th align="right">Não Sócio</th> 
						<th align="right">Sócio</th>
						<th align="right">Não Sócio</th>				
-->

					<tr>
							<?php if(!isset($colonia_escolhida)) { $colonia_escolhida = 'Todas';} ?>
<!--							
							<th align="right">1. Pré-inscrições em elaboração</th>
						<td align='right'><?php if($countsAssociatedF->elaboracao !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 0, 'true', 'F')" target="blank"
							> <?php echo $countsAssociatedF->elaboracao; ?></a><?php } else echo $countsAssociatedF->elaboracao; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->elaboracao !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 0, 'false', 'F')" target="blank"
							> <?php echo $countsNotAssociatedF->elaboracao; ?></a><?php } else echo $countsNotAssociatedF->elaboracao; ?></td>
-->
							<th align="right">1. Pré-inscrições em elaboração</th>
						<td colspan="2"><?php if($countsAssociatedF->elaboracao + $countsNotAssociatedF->elaboracao  !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 0, 'F')" target="blank"
							> <?php echo $countsAssociatedF->elaboracao + $countsNotAssociatedF->elaboracao; ?></a><?php } else echo $countsAssociatedF->elaboracao + $countsNotAssociatedF->elaboracao; ?></td>
<!--



						<td align='right'><?php if($countsAssociatedM->elaboracao !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 0, 'true', 'M')" target="blank"
							> <?php echo $countsAssociatedM->elaboracao; ?></a><?php } else echo $countsAssociatedM->elaboracao; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->elaboracao !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 0, 'false', 'M')" target="blank"
							> <?php echo $countsNotAssociatedM->elaboracao; ?></a><?php } else echo $countsNotAssociatedM->elaboracao; ?></td>
-->

						<td colspan="2"><?php if($countsAssociatedM->elaboracao + $countsNotAssociatedM->elaboracao !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 0, 'M')" target="blank"
							> <?php echo $countsAssociatedM->elaboracao + $countsNotAssociatedM->elaboracao; ?></a><?php } else echo $countsAssociatedM->elaboracao + $countsNotAssociatedM->elaboracao; ?></td>

					</tr>
					<tr>
						<th align="right">2. Pré-inscrições aguardando validação</th>
<!--						
						<td align='right'><?php if($countsAssociatedF->aguardando_validacao !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 1, 'true', 'F')" target="blank"
							> <?php echo $countsAssociatedF->aguardando_validacao; ?></a><?php } else echo $countsAssociatedF->aguardando_validacao; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->aguardando_validacao !=0) {?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 1, 'false', 'F')" target="blank"
							> <?php echo $countsNotAssociatedF->aguardando_validacao; ?></a><?php } else echo $countsNotAssociatedF->aguardando_validacao; ?></td>
						<td align='right'><?php if($countsAssociatedM->aguardando_validacao !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 1, 'true', 'M')" target="blank"
							> <?php echo $countsAssociatedM->aguardando_validacao; ?></a><?php } else echo $countsAssociatedM->aguardando_validacao; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->aguardando_validacao !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 1, 'false', 'M')" target="blank"
							> <?php echo $countsNotAssociatedM->aguardando_validacao; ?></a><?php } else echo $countsNotAssociatedM->aguardando_validacao; ?></td>
-->
						<td colspan="2"><?php if($countsAssociatedF->aguardando_validacao + $countsNotAssociatedF->aguardando_validacao !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 1, 'F')" target="blank"
							> <?php echo $countsAssociatedF->aguardando_validacao + $countsNotAssociatedF->aguardando_validacao; ?></a><?php } else echo $countsAssociatedF->aguardando_validacao + $countsNotAssociatedF->aguardando_validacao; ?></td>

						<td colspan="2"><?php if($countsAssociatedM->aguardando_validacao +$countsNotAssociatedM->aguardando_validacao !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 1, 'M')" target="blank"
							> <?php echo $countsAssociatedM->aguardando_validacao +$countsNotAssociatedM->aguardando_validacao; ?></a><?php } else echo $countsAssociatedM->aguardando_validacao + $countsNotAssociatedM->aguardando_validacao; ?></td>
					</tr>
					<tr>
<!--
						<th align="right" width='200px'>3. Pré-inscrições não validadas</th>
						<td align='right'><?php if($countsAssociatedF->nao_validada !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 6, 'true', 'F')" target="blank"
							> <?php echo $countsAssociatedF->nao_validada; ?></a><?php } else echo $countsAssociatedF->nao_validada; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->nao_validada !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 6, 'false', 'F')" target="blank"
							> <?php echo $countsNotAssociatedF->nao_validada; ?></a><?php } else echo $countsNotAssociatedF->nao_validada; ?></td>
						<td align='right'><?php if($countsAssociatedM->nao_validada !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 6, 'true', 'M')" target="blank"
							> <?php echo $countsAssociatedM->nao_validada; ?></a><?php } else echo $countsAssociatedM->nao_validada; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->nao_validada !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 6, 'false', 'M')" target="blank"
							> <?php echo $countsNotAssociatedM->nao_validada; ?></a><?php } else echo $countsNotAssociatedM->nao_validada; ?></td>
-->
						<th align="right" width='200px'>3. Pré-inscrições não validadas</th>
						<td colspan="2"><?php if($countsAssociatedF->nao_validada + $countsNotAssociatedF->nao_validada  !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 6, 'F')" target="blank"
							> <?php echo $countsAssociatedF->nao_validada + $countsNotAssociatedF->nao_validada; ?></a><?php } else echo $countsAssociatedF->nao_validada + $countsNotAssociatedF->nao_validada; ?></td>
						<td colspan="2"><?php if($countsAssociatedM->nao_validada + $countsNotAssociatedM->nao_validada !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 6, 'M')" target="blank"
							> <?php echo $countsAssociatedM->nao_validada + $countsNotAssociatedM->nao_validada; ?></a><?php } else echo $countsAssociatedM->nao_validada + $countsNotAssociatedM->nao_validada; ?></td>
					</tr>
					<tr>
<!--
						<th align="right">Subtotal(1+2+3)</th>
						<td align='right'><?php echo $subt1AF = $countsAssociatedF->nao_validada+$countsAssociatedF->aguardando_validacao+$countsAssociatedF->elaboracao; ?></td>
						<td align='right'><?php echo $subt1NF = $countsNotAssociatedF->nao_validada+$countsNotAssociatedF->aguardando_validacao+$countsNotAssociatedF->elaboracao; ?></td>
						<td align='right'><?php echo $subt1AM = $countsAssociatedM->nao_validada+$countsAssociatedM->aguardando_validacao+$countsAssociatedM->elaboracao; ?></td>
						<td align='right'><?php echo $subt1NM = $countsNotAssociatedM->nao_validada+$countsNotAssociatedM->aguardando_validacao+$countsNotAssociatedM->elaboracao; ?></td>
-->
						<th align="right">Subtotal(1+2+3)</th>
						<td colspan="2"><?php echo $subt1AF = $countsAssociatedF->nao_validada+$countsAssociatedF->aguardando_validacao+$countsAssociatedF->elaboracao + $countsNotAssociatedF->nao_validada+$countsNotAssociatedF->aguardando_validacao+$countsNotAssociatedF->elaboracao; ?></td>

						<td colspan="2"><?php echo $subt1AM = $countsAssociatedM->nao_validada+$countsAssociatedM->aguardando_validacao+$countsAssociatedM->elaboracao + $countsNotAssociatedM->nao_validada+$countsNotAssociatedM->aguardando_validacao+$countsNotAssociatedM->elaboracao; ?></td>
					</tr>
					<tr>
<!--
						<th align="right" width='200px'>4. Pré-inscrições validadas</th>
						<td align='right'><?php if($countsAssociatedF->validada !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 2, 'true', 'F')" target="blank"
							> <?php echo $countsAssociatedF->validada; ?></a><?php } else echo $countsAssociatedF->validada; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->validada !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 2, 'false', 'F')" target="blank"
							> <?php echo $countsNotAssociatedF->validada; ?></a><?php } else echo $countsNotAssociatedF->validada; ?></td>
						<td align='right'><?php if($countsAssociatedM->validada !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 2, 'true', 'M')" target="blank"
							> <?php echo $countsAssociatedM->validada; ?></a><?php } else echo $countsAssociatedM->validada; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->validada !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 2, 'false', 'M')" target="blank"
							> <?php echo $countsNotAssociatedM->validada; ?></a><?php } else echo $countsNotAssociatedM->validada; ?></td>
-->
						<th align="right" width='200px'>4. Pré-inscrições validadas</th>

						<td colspan="2"><?php if($countsAssociatedF->validada + $countsNotAssociatedF->validada !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 2, 'F')" target="blank"
							> <?php echo $countsAssociatedF->validada + $countsNotAssociatedF->validada; ?></a><?php } else echo $countsAssociatedF->validada + $countsNotAssociatedF->validada; ?></td>
						<td colspan="2"><?php if($countsAssociatedM->validada + $countsNotAssociatedM->validada !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 2, 'M')" target="blank"
							> <?php echo $countsAssociatedM->validada + $countsNotAssociatedM->validada; ?></a><?php } else echo $countsAssociatedM->validada + $countsNotAssociatedM->validada; ?></td>
					</tr>
					<tr>
<!--
						<th align="right">Subtotal(1+2+3+4)</th>
						<td align='right'><?php echo $subt1AF+$countsAssociatedF->validada; ?></td>
						<td align='right'><?php echo $subt1NF+$countsNotAssociatedF->validada; ?></td>
						<td align='right'><?php echo $subt1AM+$countsAssociatedM->validada; ?></td>
						<td align='right'><?php echo $subt1NM+$countsNotAssociatedM->validada; ?></td>
-->
						<th align="right">Subtotal(1+2+3+4)</th>
						<td colspan="2"><?php echo $subt1AF+$countsAssociatedF->validada + $subt1NF+$countsNotAssociatedF->validada; ?></td>
						<td colspan="2"><?php echo $subt1AM+$countsAssociatedM->validada + $subt1NM+$countsNotAssociatedM->validada; ?></td>
					</tr>
					<tr>
						<th align="right">5. Pré-inscrições validadas por Pavilhão</th>
						<td colspan="2"><?php echo $countsAssociatedF->validada+$countsNotAssociatedF->validada; ?></td>
						<td colspan="2"><?php echo $countsAssociatedM->validada+$countsNotAssociatedM->validada; ?></td>
						
					</tr>
					<tr>
<!--
						<th align="right" width='200px'>6. Pré-inscrições na fila de espera</th>
						<td align='right'><?php if($countsAssociatedF->fila_espera !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 3, 'true', 'F')" target="blank"
							> <?php echo $countsAssociatedF->fila_espera; ?></a><?php } else echo $countsAssociatedF->fila_espera; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->fila_espera !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 3, 'false', 'F')" target="blank"
							> <?php echo $countsNotAssociatedF->fila_espera; ?></a><?php } else echo $countsNotAssociatedF->fila_espera; ?></td>
						<td align='right'><?php if($countsAssociatedM->fila_espera !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 3, 'true', 'M')" target="blank"
							> <?php echo $countsAssociatedM->fila_espera; ?></a><?php } else echo $countsAssociatedM->fila_espera; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->fila_espera !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 3, 'false', 'M')" target="blank"
							> <?php echo $countsNotAssociatedM->fila_espera; ?></a><?php } else echo $countsNotAssociatedM->fila_espera; ?></td>
-->
						<th align="right" width='200px'>6. Pré-inscrições na fila de espera</th>
						<td colspan="2"><?php if($countsAssociatedF->fila_espera + $countsNotAssociatedF->fila_espera !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 3, 'F')" target="blank"
							> <?php echo $countsAssociatedF->fila_espera + $countsNotAssociatedF->fila_espera; ?></a><?php } else echo $countsAssociatedF->fila_espera + $countsNotAssociatedF->fila_espera; ?></td>
						<td colspan="2"><?php if($countsAssociatedM->fila_espera + $countsNotAssociatedM->fila_espera !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 3, 'M')" target="blank"
							> <?php echo $countsAssociatedM->fila_espera + $countsNotAssociatedM->fila_espera; ?></a><?php } else echo $countsAssociatedM->fila_espera + $countsNotAssociatedM->fila_espera; ?></td>
					</tr>
					<tr>
<!--
						<th align="right" width='200px'>7. Pré-inscrições aguardando doação</th>
						<td align='right'><?php if($countsAssociatedF->aguardando_pagamento !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 4, 'true', 'F')" target="blank"
							> <?php echo $countsAssociatedF->aguardando_pagamento; ?></a><?php } else echo $countsAssociatedF->aguardando_pagamento; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->aguardando_pagamento !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 4, 'false', 'F')" target="blank"
							> <?php echo $countsNotAssociatedF->aguardando_pagamento; ?></a><?php } else echo $countsNotAssociatedF->aguardando_pagamento; ?></td>
						<td align='right'><?php if($countsAssociatedM->aguardando_pagamento !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 4, 'true', 'M')" target="blank"
							> <?php echo $countsAssociatedM->aguardando_pagamento; ?></a><?php } else echo $countsAssociatedM->aguardando_pagamento; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->aguardando_pagamento !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 4, 'false', 'M')" target="blank"
							> <?php echo $countsNotAssociatedM->aguardando_pagamento; ?></a><?php } else echo $countsNotAssociatedM->aguardando_pagamento; ?></td>
-->
						<th align="right" width='200px'>7. Pré-inscrições aguardando doação</th>
						<td colspan="2"><?php if($countsAssociatedF->aguardando_pagamento + $countsNotAssociatedF->aguardando_pagamento !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 4, 'F')" target="blank"
							> <?php echo $countsAssociatedF->aguardando_pagamento + $countsNotAssociatedF->aguardando_pagamento; ?></a><?php } else echo $countsAssociatedF->aguardando_pagamento + $countsNotAssociatedF->aguardando_pagamento; ?></td>
						<td colspan="2"><?php if($countsAssociatedM->aguardando_pagamento + $countsNotAssociatedM->aguardando_pagamento !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 4, 'M')" target="blank"
							> <?php echo $countsAssociatedM->aguardando_pagamento + $countsNotAssociatedM->aguardando_pagamento; ?></a><?php } else echo $countsAssociatedM->aguardando_pagamento + $countsNotAssociatedM->aguardando_pagamento; ?></td>
					</tr>
					<tr>
<!--
						<th align="right">Subtotal(4+6+7)</th>
						<td align='right'><?php echo $countsAssociatedF->aguardando_pagamento+$countsAssociatedF->fila_espera+$countsAssociatedF->validada ?></td>
						<td align='right'><?php echo $countsNotAssociatedF->aguardando_pagamento+$countsNotAssociatedF->fila_espera+$countsNotAssociatedF->validada; ?></td>
						<td align='right'><?php echo $countsAssociatedM->aguardando_pagamento+$countsAssociatedM->fila_espera+$countsAssociatedM->validada; ?></td>
						<td align='right'><?php echo $countsNotAssociatedM->aguardando_pagamento+$countsNotAssociatedM->fila_espera+$countsNotAssociatedM->validada; ?></td>
-->
						<th align="right">Subtotal(4+6+7)</th>
						<td colspan="2"><?php echo $countsAssociatedF->aguardando_pagamento+$countsAssociatedF->fila_espera+$countsAssociatedF->validada + $countsNotAssociatedF->aguardando_pagamento+$countsNotAssociatedF->fila_espera+$countsNotAssociatedF->validada ?></td>
						<td colspan="2"><?php echo $countsAssociatedM->aguardando_pagamento+$countsAssociatedM->fila_espera+$countsAssociatedM->validada + $countsNotAssociatedM->aguardando_pagamento+$countsNotAssociatedM->fila_espera+$countsNotAssociatedM->validada; ?></td>
					</tr>
					<!-- 
					<tr>
						<th align="right">Subtotal</th>
						<td align='right'><?php //echo $sumAssociatedF = $countsAssociatedF->aguardando_pagamento+$countsAssociatedF->fila_espera+$countsAssociatedF->validada+$countsAssociatedF->nao_validada+$countsAssociatedF->aguardando_validacao+$countsAssociatedF->elaboracao; ?></td>
						<td align='right'><?php //echo $sumNotAssociatedF = $countsNotAssociatedF->aguardando_pagamento+$countsNotAssociatedF->fila_espera+$countsNotAssociatedF->validada+$countsNotAssociatedF->nao_validada+$countsNotAssociatedF->aguardando_validacao+$countsNotAssociatedF->elaboracao; ?></td>
						<td align='right'><?php //echo $sumAssociatedM = $countsAssociatedM->aguardando_pagamento+$countsAssociatedM->fila_espera+$countsAssociatedM->validada+$countsAssociatedM->nao_validada+$countsAssociatedM->aguardando_validacao+$countsAssociatedM->elaboracao; ?></td>
						<td align='right'><?php //echo $sumNotAssociatedM = $countsNotAssociatedM->aguardando_pagamento+$countsNotAssociatedM->fila_espera+$countsNotAssociatedM->validada+$countsNotAssociatedM->nao_validada+$countsNotAssociatedM->aguardando_validacao+$countsNotAssociatedM->elaboracao; ?></td>
					</tr> -->
					<tr>
<!--
						<th align="right">8. Inscritos</th>
						<td align='right'><?php if($countsAssociatedF->inscrito !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 5, 'true', 'F')" target="blank"
							> <?php echo $countsAssociatedF->inscrito; ?></a><?php } else echo $countsAssociatedF->inscrito; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->inscrito !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 5, 'false', 'F')" target="blank"
							> <?php echo $countsNotAssociatedF->inscrito; ?></a><?php } else echo $countsNotAssociatedF->inscrito; ?></td>
						<td align='right'><?php if($countsAssociatedM->inscrito !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 5, 'true', 'M')" target="blank"
							> <?php echo $countsAssociatedM->inscrito; ?></a><?php } else echo $countsAssociatedM->inscrito; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->inscrito !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 5, 'false', 'M')" target="blank"
							> <?php echo $countsNotAssociatedM->inscrito; ?></a><?php } else echo $countsNotAssociatedM->inscrito; ?></td>
-->
						<th align="right">8. Inscritos</th>
						<td colspan="2"><?php if($countsAssociatedF->inscrito + $countsNotAssociatedF->inscrito !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 5, 'F')" target="blank"
							> <?php echo $countsAssociatedF->inscrito + $countsNotAssociatedF->inscrito; ?></a><?php } else echo $countsAssociatedF->inscrito + $countsNotAssociatedF->inscrito; ?></td>
						<td colspan="2"><?php if($countsAssociatedM->inscrito + $countsNotAssociatedM->inscrito !=0){?><a onclick="showSubReport('<?= $colonia_escolhida?>', '<?= $ano_escolhido?>', 5, 'M')" target="blank"
							> <?php echo $countsAssociatedM->inscrito + $countsNotAssociatedM->inscrito; ?></a><?php } else echo $countsAssociatedM->inscrito + $countsNotAssociatedM->inscrito; ?></td>
					</tr>
					<tr>
						<th align="right">9. Inscritos por Pavilhão</th>
						<td colspan="2"><?php echo $countsAssociatedF->inscrito+$countsNotAssociatedF->inscrito; ?></td>
						<td colspan="2"><?php echo $countsAssociatedM->inscrito+$countsNotAssociatedM->inscrito; ?></td>
						
					</tr>
					<!-- 
					<tr>
						<th align="right">Total</th>
						<td align='right'><?php // echo $sumAssociatedF+$countsAssociatedF->inscrito; ?></td>
						<td align='right'><?php //echo $sumNotAssociatedF+$countsNotAssociatedF->inscrito; ?></td>
						<td align='right'><?php //echo $sumAssociatedM+$countsAssociatedM->inscrito; ?></td>
						<td align='right'><?php //echo $sumNotAssociatedM+$countsNotAssociatedM->inscrito; ?></td>
					</tr> -->
					<tr>
						<th align="right">10. Vagas Oferecidas</th>
						<td colspan="2"> <?php echo $vacancyFemale; ?>
							
						
						<td colspan="2"> <?php echo $vacancyMale; ?>
	                    
					</tr>
					<tr>
						<th align="right">11. Vagas Disponíveis (10-9-7)</th>
						<td colspan="2"> <?php echo $vacancyFemale - ($countsAssociatedF->aguardando_pagamento 
						+ $countsAssociatedF->inscrito + $countsNotAssociatedF->aguardando_pagamento 
						+ $countsNotAssociatedF->inscrito); ?>
							
						
						<td colspan="2"> <?php echo $vacancyMale - ($countsAssociatedM->aguardando_pagamento 
						+ $countsAssociatedM->inscrito + $countsNotAssociatedM->aguardando_pagamento 
						+ $countsNotAssociatedM->inscrito); ?>
	                    
					</tr>
				<!-- </table>
				<table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 400px;">

					<tr>
						<th align="right"><p>Potencial de Inscritos</p> <p>(Inscritos + Aguardando Pagamento)</p> </th>
						<td width="60px" align='center'><br><p> <?php echo $potInscritos = $countsT->aguardando_pagamento 
						+ $countsT->inscrito; ?> </p></td>
					</tr>
					<tr>
						<th align="right">Porcentagem de Inscritos</th>
						<td width="60px" align='right'><?php 
						if($potInscritos)
							echo number_format(($countsT->inscrito/$potInscritos)*100,1);
						 else echo "0.0";
						 echo "%"; ?>  </td>
					</tr>-->
				</table> 
				</div>
			</div>
		</div>
	</div>
	</div>
</body>
</html>