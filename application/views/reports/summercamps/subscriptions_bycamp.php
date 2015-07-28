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
							<option value="0" <?php if(!isset($colonia_escolhida)) echo "selected"; ?>>Todas</option>
							<?php
							foreach ( $camps as $camp ) {
								$selected = "";
								if ($colonia_escolhida == $camp)
									$selected = "selected";
								echo "<option $selected value='$camp'>$camp</option>";
							}
							?>
						</select>
						<select name="opcao_f" onchange="this.form.submit()" id="opcao">
							<?php
							foreach ( $opcoes as $opcao ) {
								$selected = "";
								if ($selecionado == $opcao)
									$selected = "selected";
								echo "<option $selected value='$opcao'>$opcao</option>";
							}
							?>
						</select>
				</form>
				<table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 600px;">
					
						<tr>
							<th align="right"></th>
							<th align="right">Feminino</th>
							<th align="right">Masculino</th>
							<th align="right">Total</th>
					   
						<tr>
							<th align="right">Pré-inscrições em elaboração</th>
							<td align='right'> <?php echo $countsF->elaboracao; ?> </td>
							<td align='right'> <?php echo $countsM->elaboracao; ?> </td>
							<td align='right'> <?php echo $countsT->elaboracao; ?> </td>
						</tr>
						<tr>
							<th align="right">Pré-inscrições aguardando validação</th>
							<td align='right'> <?php echo $countsF->aguardando_validacao; ?> </td>
							<td align='right'> <?php echo $countsM->aguardando_validacao; ?> </td>
							<td align='right'> <?php echo $countsT->aguardando_validacao; ?> </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Pré-inscrições não validadas</th>
							<td align='right'> <?php echo $countsF->nao_validada; ?> </td>
							<td align='right'> <?php echo $countsM->nao_validada; ?> </td>
							<td align='right'> <?php echo $countsT->nao_validada; ?> </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Pré-inscrições validadas</th>
							<td align='right'> <?php echo $countsF->validada; ?> </td>
							<td align='right'> <?php echo $countsM->validada; ?> </td>
							<td align='right'> <?php echo $countsT->validada; ?> </td>
						</tr>
						
						<tr>
							<th align="right" width='200px'>Total</th>
							<td align='right'> <?php echo $countsF->validada + $countsF->nao_validada + 
									$countsF->aguardando_validacao + $countsF->elaboracao; ?> 
	                                </td>
							<td align='right'> <?php echo $countsM->validada + $countsM->nao_validada + 
									$countsM->aguardando_validacao + $countsM->elaboracao; ?> 
	                                </td>
							<td width="60px" align='right'>
	                                <?php echo $countsT->validada + $countsT->nao_validada + 
	                                $countsT->aguardando_validacao + $countsT->elaboracao; ?>
	                            </td>
						</tr>
			</div>
		</div>
	</div>
</body>
</html>