<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
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
				
					<select class="form-control" id="report_type" name="report_type" onchange="this.form.submit()">
						<option value="" selected>-- Selecione --</option>
						<option value="panel">Painel</option>
						<option value="op2">Opção 2</option>
						<option value="op3">Opção 3</option>
					</select>
					<span class="pull-right"><button onclick="printFunction()">Imprimir</button></span>
				
				</div>
				</form>	

			</div>

			

			<div>
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
			 

			<div>
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
					<div>	
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