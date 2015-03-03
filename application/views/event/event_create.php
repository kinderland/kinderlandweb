
<script type="text/javascript" charset="utf-8">

function validateForm(){
	 (!validateNotEmptyField("signup_form","cep","CEP")
	 	return false;

function callMasks(){

	$("input[name='date_start']").mask("99/99/9999");
	$("input[name='date_finish']").mask("99/99/9999");

}

</script>

<div class="row">
	<div class="col-lg-12 middle-content">
		<div class="row">
			<div class="col-lg-8"><h4>Cadastro de evento</h4></div>
			<div class="col-lg-4"><h6><span class="red_letters">Campos com * são de preenchimento obrigatório.</span></h6></div>
		</div>
		<hr />

		<form name="event_create" method="POST" action="<?=$this->config->item('url_link')?>event/completeEvent" id="event_create">
			<div class="row">
				<div class="form-group">
					<label for="eventname" class="col-lg-1 control-label"> Nome do Evento*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Nome do Evento"
							name="eventname" />
					</div>

					<label for="description" class="col-lg-1 control-label"> Descrição do Evento*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Descrição do Evento"
							name="description" />
					</div>

				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="date_start" class="col-lg-1 control-label"> Data de Início*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Data de Início"
							name="date_start" />
					</div>

					<label for="date_finish" class="col-lg-1 control-label"> Data de Término*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Data de Término"
							name="date_finish" />
					</div>

					<label for="price" class="col-lg-1 control-label"> Preço*: </label>
					<div class="col-lg-3">
						<input type="price" class="form-control" placeholder="Preço"
							name="price" />
					</div>
				</div>
			</div>
			<br />

			<br /><br /><br />

			<div class="form-group">
				<div class="col-lg-10">
					<button class="btn btn-primary" style="margin-right:40px" onClick="validateFormInfo()">Confirmar</button>
					<a href="<?=$this->config->item('url_link')?>login/index"><button class="btn btn-warning">Voltar</button></a>
				</div>
			</div>
			
		</form>
	</div>
</div>
