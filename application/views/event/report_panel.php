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
	
	</head>
	<body>

		<div class="row">
			<?php // require_once APPPATH.'views/include/common_user_left_menu.php'?>
			<div class="col-lg-10 middle-content">
				<script type="text/javascript">
		
					function getPriceByAgeGroup(prices, ageGroup){
						if(ageGroup == 1)
							return prices.children_price;
						else if(ageGroup == 2)
							return prices.middle_price;
						else
							return prices.full_price;
					}
		
					
					function printFunction(){
		    			window.print();
					}	
		
					function validateFormInfo(){
						$("#form_subscribe").submit();
					}

					function selectType(){
						$value = document.getElementById("report_type").value;

						if($value == ""){
							document.getElementById("option1").style.display="none";
							document.getElementById("option2").style.display="none";
							document.getElementById("option3").style.display="none";
							return;
						}
						else if($value == "panel"){
							document.getElementById("option1").style.display="";
							document.getElementById("option2").style.display="none";
							document.getElementById("option3").style.display="none";
						}
						else if($value == "op2"){
							document.getElementById("option1").style.display="none";
							document.getElementById("option2").style.display="";
							document.getElementById("option3").style.display="none";
						}
						else if($value == "op3"){
							document.getElementById("option1").style.display="none";
							document.getElementById("option2").style.display="none";
							document.getElementById("option3").style.display="";
						}

						validateFormInfo();
					}
		
				</script>
		
				<div class='row'>
					<div class="col-lg-3">
						<form name="event_panel" method="POST" action="<?=$this->config->item('url_link')?>events/loadReportPanel" id="event_panel" >
						<select  class="form-control" id="event_id" name="event_id" >
								<option value="" selected>-- Selecione --</option>
								<?php
									foreach($events as $event) {
								?>
								<option value="<?=$event->getEventId()?>"><?=$event->getEventName()?></option>
								<?php } ?>
						</select>
		
						</br>
						<div>
						
							<select class="form-control" id="report_type" name="report_type" onchange="selectType()">
								<option value="" selected>-- Selecione --</option>
								<option value="panel">Painel</option>
								<option value="op2">Opção 2</option>
								<option value="op3">Opção 3</option>
							</select>
							<span class="pull-right"><button onclick="printFunction()">Imprimir</button></span>
						
						</div>
						</form>	
		
					</div>
		
					
		
					<div id="option1">
						<div class="col-lg-10">
							<table class="table">
							<tr style="outline: thin solid">
							  	<td>Ingressos</td>
							    <td>Feminino</td>
							    <td>Masculino</td>		
							    <td>Sem Pernoite</td>
							    <td>Total</td>
							</tr>
							<tr>
							  	<td>Disponibilizado</td>
							    <td>...</td>
							    <td>...</td>		
							    <td>...</td>
							    <td>...</td>
							</tr>
							<tr>
							  	<td>Vendido</td>
							    <td>...</td>
							    <td>...</td>		
							    <td>...</td>
							    <td>...</td>
							</tr>
							<tr>
							  	<td>Disponível</td>
							    <td>...</td>
							    <td>...</td>		
							    <td>...</td>
							    <td>...</td>
							</tr>
							</table>
						
					</div>
				</div>
					 
		
					<div id="option2">
						<div class="col-lg-10">
		
							<table class="table">
							<tr style="outline: thin solid">
							  	<td>Por faixa etária</td>
							    <td>Feminino +18</td>
							    <td>6 - 17</td>		
							    <td>0 - 5</td>
							    <td>Masculino +18</td>
							    <td>6 - 17</td>		
							    <td>0 - 5</td>
							</tr>
							<tr>
							  	<td>Vendido</td>
							    <td>...</td>
							    <td>...</td>		
							    <td>...</td>
							    <td>...</td>
							    <td>...</td>		
							    <td>...</td>
							</tr>
							</table>
						</div>
					</div>
		
					<div>&nbsp;</div>
					<div>&nbsp;</div>
					<br />
					
						<div>
							<div id="option3">
								<div class="col-lg-10">
		
							<table class="table">
		
							<tr style="outline: thin solid">
							  	<td>Financeiro</td>
							    <td>+18</td>
							    <td>6 - 17</td>	
							    <td>0 - 5</td>		
							    <td>Sem Pernoite</td>
							    <td>Total</td>
							</tr>
							<tr>
							  	<td>Sem desconto</td>
							    <td>...</td>
							    <td>...</td>	
							    <td>...</td>		
							    <td>...</td>
							    <td>...</td>
							</tr>
							<tr>
							  	<td>Com desconto sócio</td>
							    <td>...</td>
							    <td>...</td>	
							    <td>...</td>		
							    <td>...</td>
							    <td>...</td>
							</tr>
							<tr>
							  	<td>Total</td>
							    <td>...</td>
							    <td>...</td>	
							    <td>...</td>		
							    <td>...</td>
							    <td>...</td>
							</tr>
							</table>
							</div>
					</div>
				</div>
			</div>
			</div>
			</div>
			</body>
			</html>