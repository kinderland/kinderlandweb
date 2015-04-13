<link href="<?=$this->config->item('assets');?>css/datepicker.css" rel="stylesheet" />
<link rel="text/javascript" href="<?=$this->config->item('assets');?>js/datepicker.less.js" />

<script type="text/javascript" charset="utf-8">

var linha = '<tr><td><input type="text" class=" datepickers form-control" placeholder="Data de Início" name="payment_date_start[]"</td><td><input type="text" class=" datepickers form-control" placeholder="Data de Fim" name="payment_date_end[]"</td>			   		<td><input type="text" class="form-control" placeholder="Valor geral" name="full_price[]" id="full_price"></td>			   		<td><input type="text" class="form-control" placeholder="Valor 6-17" name="middle_price[]" id="middle_price"></td>			   		<td><input type="text" class="form-control" placeholder="Valor 0-5" name="children_price[]" id="children_price"></td>			   		<td><input type="number" class="form-control" name="payment_portions[]" id="payment_portions" value="1" min="1" max="5"></td>			   		<td><input type="number" class="form-control" placeholder="%" name="associated_discount[]" id="associated_discount" value="0" min="0" max="100"> </td>			   		<td><img src="<?=$this->config->item('assets')?>images/forms/icon_minus.gif" style="cursor: pointer; cursor: hand;" class="delete""></button></td>				   	</tr>	';

function addTableLine(linhaAAdicionar){
	if(!linhaAAdicionar)
		$('#table > tbody:last').append(linha);
	else
		$('#table > tbody:last').append(linhaAAdicionar);
	datepickers();
	$(".delete").on('click', function(event) {
		$(this).parent().parent().remove();
	});

}

function alertRequiredFields(){
	var error = "";
	if(document.getElementsByName("date_start")[0].value == "")
		error = error.concat("Data de ínicio do periodo do evento\n");
	if(document.getElementsByName("date_finish")[0].value == "")
		error = error.concat("Data de fim do periodo do evento\n");
	if(document.getElementsByName("date_start_show")[0].value == "")
		error = error.concat("Data de ínicio do período de inscrições\n");
	if(document.getElementsByName("date_finish_show")[0].value == "")
		error = error.concat("Data de fim do período de inscrições\n");
	if( 
	   	(parseInt(document.getElementsByName("capacity_male")[0].value) || 0) + 
	   	(parseInt(document.getElementsByName("capacity_female")[0].value) || 0) + 
	   	(parseInt(document.getElementsByName("capacity_nonsleeper")[0].value) || 0 ) 
	   	<= 0
	   )
		error = error.concat("Quantidade de ingressos disponivel <= 0\n");

	if(document.getElementsByName("payment_date_start[]")[0] == undefined)
   		error = error.concat("Não tem data de ínicio de pagamento\n");
	if(error != "")
		alert("Tentaremos salvar o evento, porém faltam alguns dados considerados mínimos para que o cadastro possa ser considerado como completo.\nOs dados incompletos são:\n".concat(error));	
}

function datepickers(){
	$('.datepickers').datepicker();
	$(".datepickers").datepicker("option", "dateFormat", "dd/mm/yy");	
}

$(document).ready(function(){
	datepickers();

	<?php foreach($payments as $payment){ ?>
		addTableLine('<tr><td><input type="text" class=" datepickers form-control" placeholder="Data de Início" name="payment_date_start[]" value="<?=Events::toMMDDYYYY($payment["payment_date_start"])?>"</td><td><input type="text" class=" datepickers form-control" placeholder="Data de Fim" name="payment_date_end[]" value="<?=Events::toMMDDYYYY($payment["payment_date_end"])?>"</td>			   		<td><input type="text" class="form-control" placeholder="Valor geral" name="full_price[]" id="full_price" value="<?=$payment["full_price"]?>"></td>			   		<td><input type="text" class="form-control" placeholder="Valor 6-17" name="middle_price[]" id="middle_price" value="<?=$payment["middle_price"]?>"></td>			   		<td><input type="text" class="form-control" placeholder="Valor 0-5" name="children_price[]" id="children_price" value="<?=$payment["children_price"]?>"></td>			   		<td><input type="number" class="form-control" name="payment_portions[]" id="payment_portions" value="1" min="1" max="5"></td>			   		<td><input type="number" class="form-control" placeholder="%" name="associated_discount[]" id="associated_discount" value="0" min="0" max="100"> </td>			   		<td><img src="<?=$this->config->item('assets')?>images/forms/icon_minus.gif" style="cursor: pointer; cursor: hand;" class="delete""></button></td>				   	</tr>	');
	<?php } ?> 
	
	
});

var string = "";

<?php foreach($errors as $error){
	echo "string = string.concat('$error\\n');";
} ?>

if(string !== ""){
	alert("Os seguintes erros foram encontrados:\n".concat(string));
}

</script>

<form name="event_form" onsubmit="alertRequiredFields()" method="POST" action="<?=$this->config->item('url_link')?>events/completeEvent" id="event_form">
	<div class="row">
		<div class="col-lg-12 middle-content">
			<div class="row">
				<div class="col-lg-8"><h4>Cadastro de evento</h4></div>
			</div>
			<hr />

			<div class="row">
				<div class="form-group">
					<label for="event_name" class="col-lg-2 control-label"> Nome do Evento*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control required" placeholder="Nome do Evento" value="<?=$event_name?>" name="event_name"
							required 
							oninput="setCustomValidity('')"
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"/>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="description" class="col-lg-2 control-label"> Descrição do Evento: </label>
					<div class="col-lg-6">
						<input type="text" class="form-control" placeholder="Descrição do Evento" value="<?=$description?>" name="description"/>					
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="date_start" class="col-lg-2 control-label"> Período do Evento: </label>
					<label for="date_start" class="col-lg-1 control-label"> Início: </label>
					<div class="col-lg-2">
						<input type="text" class=" datepickers form-control" placeholder="Data de Início" value="<?=$date_start?>" name="date_start"/>
					</div>

					<label for="date_finish" class="col-lg-1 control-label"> Fim: </label>
					<div class="col-lg-2">
						<input type="text" class="datepickers form-control" placeholder="Data de Término" value="<?=$date_finish?>" name="date_finish"/>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="date_start" class="col-lg-2 control-label"> Período do Inscrições: </label>
					<label for="date_start_show" class="col-lg-1 control-label"> Início: </label>
					<div class="col-lg-2">
						<input type="text" class="form-control datepickers" placeholder="Início da exibição do evento" value="<?=$date_start_show?>" name="date_start_show"/>
					</div>
					<label for="date_finish_show" class="col-lg-1 control-label"> Fim: </label>
					<div class="col-lg-2">
						<input type="text" class="form-control datepickers" placeholder="Término da exibição do evento" value="<?=$date_finish_show?>" name="date_finish_show"/>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="capacity_male" class="col-lg-4 control-label"> Quantidade máxima de convites: </label>
				</div>
			</div>
			<br/>
			<div class="row">
				<label for="empty-space" class="col-lg-1 control-label"></label>
				<div class="form-group">
					<label for="capacity_male" class="col-lg-2 control-label"> Masculino: </label>
					<div class="col-lg-2">
						<input type="number" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Este campo só aceita números')" class="form-control" placeholder="Pavilhão Masculino" value="<?=$capacity_male?>" name="capacity_male"/>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
			<label for="empty-space" class="col-lg-1 control-label"></label>
				<div class="form-group">
					<label for="capacity_female" class="col-lg-2 control-label"> Feminino: </label>
					<div class="col-lg-2">
						<input type="number" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Este campo só aceita números')" class="form-control" placeholder="Pavilhão feminino" value="<?=$capacity_female?>" name="capacity_female" /> 
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<label for="empty-space" class="col-lg-1 control-label"></label>
				<div class="form-group">
					<label for="capacity_nonsleeper" class="col-lg-2 control-label"> Sem pernoite: </label>
					<div class="col-lg-2">
						<input type="number" oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Este campo só aceita números')" class="form-control" pattern="\d*" placeholder="Sem pernoite" value="<?=$capacity_nonsleeper?>" name="capacity_nonsleeper" />
					</div>
				</div>
			</div>
			<br />
			<div class="row">	
					<label for="capacity_male" class="col-lg-4 control-label"> Períodos para pagamento: </label><br />
				
               <table id="table" name="table" class="table"><tr><th>De</th><th>Até</th><th>Valor</th><th>Valor 6-17 anos</th><th>Valor 0-5 anos</th><th>Parcelas max</th><th>Desconto Sócio</th></tr> 
			   <tbody>
			   </tbody>
			   </table>
			   <button type="button" value="" onclick="addTableLine()">Novo periodo</button>
			</div>
		</div>
	<br />
	<br />
	<br />
	<br />
	<div class="form-group">
		<div class="col-lg-10">
			<button class="btn btn-primary" style="margin-right:40px">Confirmar</button>
				<a href="<?=$this->config->item('url_link')?>events/index"><button  type="button" class="btn btn-warning"
					onClick="history.go(-1);return true;">Voltar</button></a>
		</div>
	</div>
			
</form>
