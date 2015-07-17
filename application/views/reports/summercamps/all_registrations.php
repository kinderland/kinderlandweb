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

<script>

	var selectTodas = {
			element : null,
			values : "auto",
			empty : "Todas",
			multiple : false,
			noColumn : false,
		}


	</script>

</head>
<body>
	<script>
		$(document).ready(function() {
		$('#sortable-table').datatable({
		pageSize : Number.MAX_VALUE,
		sort : [true],
		filters : [selectTodas],
		filterText : 'Escreva para filtrar... '
		});
	});
	</script>
	
	<div class="main-container-report">
		<div class="row">
			<div class="col-lg-10" bgcolor="red">
				<form method="GET">
					<select name="ano" onchange="this.form.submit()" id="anos">
							<?php
							foreach ( $years as $year ) {
								$selected = "";
								if ($anos == $year)
									$selected = "selected";
								echo "<option $selected id='$year'>$year</option>";
							}
							?>
						</select>
				</form>
				<div id="sortable-table"></div>
				<table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 600px;">
					<tr>
						<th align="right">Inscritos</th>
						<td align='right'>
                                <?php echo $colonist5Count; ?>
                            </td>
					</tr>
					<tr>
						<th align="right">Pré-inscrições em elaboração</th>
						<td align='right'>
                                <?php echo $colonist0Count; ?>
                            </td>
					</tr>
					<tr>
						<th align="right">Pré-inscrições aguardando validação</th>
						<td align='right'>
                                <?php echo $colonist1Count; ?>
                            </td>
					</tr>
					<tr>
						<th align="right" width='200px'>Pré-inscrições não validadas</th>
						<td width="60px" align='right'>
                                <?php echo $colonist6Count; ?>
                            </td>
					</tr>
					<tr>
						<th align="right" width='200px'>Pré-inscrições validadas</th>
						<td width="60px" align='right'>
                                <?php echo $colonist2Count; ?>
                            </td>
					</tr>
					<tr>
						<th align="right" width='200px'>Pré-inscrições na fila de espera</th>
						<td width="60px" align='right'>
                                <?php echo $colonist3Count; ?>
                            </td>
					</tr>
					<tr>
						<th align="right" width='200px'>Pré-inscrições aguardando
							pagamento</th>
						<td width="60px" align='right'>
                                <?php echo $colonist4Count; ?>
                            </td>
					</tr>
					<tr>
						<th align="right" width='200px'>Cancelados</th>
						<td width="60px" align='right'>
                                <?php echo $colonist3NCount; ?>
                            </td>
					</tr>
					<tr>
						<th align="right" width='200px'>Desistentes</th>
						<td width="60px" align='right'>
                                <?php echo $colonist1NCount; ?>
                            </td>
					</tr>
					<tr>
						<th align="right" width='200px'>Excluidos</th>
						<td width="60px" align='right'>
                                <?php echo $colonist2NCount; ?>
                            </td>
					</tr>
					<tr>
						<th align="right" width='200px'>Total</th>
						<td width="60px" align='right'>
                                <?php echo $colonistTCount; ?>
                            </td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
</html>