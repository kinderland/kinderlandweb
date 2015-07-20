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
</script>
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


</head>
<body>
	
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
						</select>
						<select name="colonia_f" onchange="this.form.submit()" id="colonia">
							<option value="0" <?php if(!isset($colonia_escolhida)) echo "selected"; ?>>Todos</option>
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
					style="max-width: 600px;">
					    <tr>
							<th align="right">Inscritos</th>
							<td align='right'>
	                                <?php echo $counts->inscrito; ?>
	                            </td>
						</tr>
						<tr>
							<th align="right">Pré-inscrições em elaboração</th>
							<td align='right'>
	                                <?php echo $counts->elaboracao; ?>
	                            </td>
						</tr>
						<tr>
							<th align="right">Pré-inscrições aguardando validação</th>
							<td align='right'>
	                                <?php echo $counts->aguardando_validacao; ?>
	                            </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Pré-inscrições não validadas</th>
							<td width="60px" align='right'>
	                                <?php echo $counts->nao_validada; ?>
	                            </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Pré-inscrições validadas</th>
							<td width="60px" align='right'>
	                                <?php echo $counts->validada; ?>
	                            </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Pré-inscrições na fila de espera</th>
							<td width="60px" align='right'>
	                                <?php echo $counts->fila_espera; ?>
	                            </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Pré-inscrições aguardando
								pagamento</th>
							<td width="60px" align='right'>
	                                <?php echo $counts->aguardando_pagamento; ?>
	                            </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Cancelados</th>
							<td width="60px" align='right'>
	                                <?php echo $counts->cancelado; ?>
	                            </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Desistentes</th>
							<td width="60px" align='right'>
	                                <?php echo $counts->desistente; ?>
	                            </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Excluidos</th>
							<td width="60px" align='right'>
	                                <?php echo $counts->excluido; ?>
	                            </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Total</th>
							<td width="60px" align='right'>
	                                <?php echo $counts->inscrito + $counts->excluido + $counts->desistente 
	                                + $counts->cancelado + $counts->aguardando_pagamento + $counts->fila_espera + $counts->validada
	                                + $counts->nao_validada + $counts->aguardando_validacao + $counts->elaboracao; ?>
	                            </td>
						</tr>	
				</table>
			</div>
		</div>
	</div>
</body>
</html>