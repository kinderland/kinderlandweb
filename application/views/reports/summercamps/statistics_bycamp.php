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
<script type="text/javascript">
	function showSubReport (camp, year, status, associated, gender) {
		if(associated != null)
			var url = "<?= $this->config->item('url_link'); ?>reports/subscriptions?type=2&camp="+camp+"&year="+year+"&status="+status+"&associated="+associated+"&gender="+gender;
		else
			var url = "<?= $this->config->item('url_link'); ?>reports/subscriptions?type=2&camp="+camp+"&year="+year+"&status="+status+"&gender="+gender;
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
    
    	padding-left:13%
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
				</form>
				<div class="pad">
				<table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 800px;">
					
						<tr>
							<th align="right"></th>
							<?php $i = 0; foreach($campsNames as $campName) {
								if($i == 4){
									break;
								}
							?>
							<th align="right" colspan = 2 style="text-align: center"><?php echo $campName;?></th>
							<?php $i++; } ?>
					    <tr>
					    <tr>
							<th align="right"></th>
							<?php $i = 0; foreach($campsNames as $campName) {
								if($i == 4){
									break;
								}
							?>
							<th style="text-align: center">F</th>
							<th style="text-align: center">M</th>
							<?php $i++; } ?>
					    <tr>
							<th align="right">Inscritos</th>
							<?php $i = 0; foreach($campsNames as $camp) {
								if($i == 4){
									break;
								}
								$countsFI[$i] = $countsAssociatedF[$i]->inscrito + $countsNotAssociatedF[$i]->inscrito;
								$countsMI[$i] = $countsAssociatedM[$i]->inscrito + $countsNotAssociatedM[$i]->inscrito;
							?>
							<td align='right'><?php if($countsFI[$i] !=0){?><a onclick="showSubReport('<?= $camp?>', '<?= $year?>', 5, '', 'F')" target="blank"
							> <?php echo $countsFI[$i]; ?></a><?php } else echo $countsFI[$i]; ?></td>
							<td align='right'><?php if($countsMI[$i] !=0){?><a onclick="showSubReport('<?= $camp?>', '<?= $year?>', 5, '', 'M')" target="blank"
							> <?php echo $countsMI[$i]; ?></a><?php } else echo $countsMI[$i]; ?></td>
							<?php $i++; } ?>							
						</tr>
						<tr>
							<th align="right" >Aguardando doação</th>
							<?php $i = 0; foreach($campsNames as $camp) {
								if($i == 4){
									break;
								}
								$countsMA[$i] = $countsAssociatedM[$i]->aguardando_pagamento + $countsNotAssociatedM[$i]->aguardando_pagamento;
								$countsFA[$i] = $countsAssociatedF[$i]->aguardando_pagamento + $countsNotAssociatedF[$i]->aguardando_pagamento;
								
							?>
							<td align='right'><?php if($countsFA[$i] !=0){?><a onclick="showSubReport('<?= $camp?>', '<?= $year?>', 4, '', 'F')" target="blank"
							> <?php echo $countsFA[$i]; ?></a><?php } else echo $countsFA[$i]; ?></td>
							<td align='right'><?php if($countsMA[$i] !=0){?><a onclick="showSubReport('<?= $camp?>', '<?= $year?>', 4, '', 'M')" target="blank"
							> <?php echo $countsMA[$i]; ?></a><?php } else echo $countsMA[$i]; ?></td>
							<?php $i++; } ?>
						</tr>
						<tr>
							<th align="right" width='200px'>Total</th>
							<?php $countsTF = array(); $countsTM = array(); $i = 0; foreach($campsNames as $camp) {
								if($i == 4){
									break;
								}
							?>
							<td align='right'> <?php echo $countsTF[$i] = $countsFI[$i] + $countsFA[$i]; ?> </td>
							<td align='right'> <?php echo $countsTM[$i] = $countsMI[$i] + $countsMA[$i]; ?> </td>
							<?php $i++; } ?>
						</tr>
						<tr>
							<th	align="right" width='200px'>Porcentagem de Inscritos</th>
							<?php $i = 0; foreach($campsNames as $camp) {
								if($i == 4){
									break;
								}
							?>
							<td align='right'> <?php if($countsTF[$i] == 0) echo "0,0"; else echo number_format(($countsFI[$i]/$countsTF[$i])*100,1); ?>%</td>
							<td align='right'> <?php if($countsTM[$i] == 0) echo "0,0"; else echo number_format(($countsMI[$i]/$countsTM[$i])*100,1); ?>%</td>
							<?php $i++; } ?>
	                    </tr>
						<tr>
							<th align="right">Potencial de Inscritos por Colônia</th>
							<?php $i = 0; foreach($campsNames as $camp) {
								if($i == 4){
									break;
								}
							?>
							<td align='right' colspan = "2"> <?php echo $countsTF[$i] + $countsTM[$i];?> </td>
							<?php $i++; } ?>
						</tr>
						<tr>
							<th align="right">Inscritos por Colônia</th>
							<?php $i = 0; foreach($campsNames as $camp) {
								if($i == 4){
									break;
								}
							?>
							<td align='right' colspan = "2"> <?php echo $countsFI[$i] + $countsMI[$i]; ?> </td>
							<?php $i++; } ?>				
						</tr>
						<tr>
							<th align="right">Inscritos por Colônia (%)</th>
							<?php $i = 0; foreach($campsNames as $camp) {
								if($i == 4){
									break;
								}
							?>
							<td align='right' colspan = "2"> <?php if(($countsTF[$i] + $countsTM[$i]) == 0) echo "0,0"; else echo number_format((($countsFI[$i] + $countsMI[$i])/($countsTF[$i] + $countsTM[$i]))*100,1);?>%</td>
							<?php $i++; } ?>				
						</tr>
				</table>
				</div>
		
			</div>
		</div>
	</div>
	</div>
</body>
</html>