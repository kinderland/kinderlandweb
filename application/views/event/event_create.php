<script type="text/javascript" charset="utf-8">

function validateForm(){
	$("#event_form").submit();
}

</script>

<div class="row">
	<div class="col-lg-12 middle-content">
		<div class="row">
			<div class="col-lg-8"><h4>Cadastro de evento</h4></div>
		</div>
		<hr />

		<form name="event_form" method="POST" action="<?=$this->config->item('url_link')?>events/completeEvent" id="event_form">
			<div class="row">
				<div class="form-group">
					<label for="event_name" class="col-lg-2 control-label"> Nome do Evento*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Nome do Evento" name="event_name" 
							required 
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="description" class="col-lg-2 control-label"> Descrição do Evento*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Descrição do Evento" name="description" 
							required 
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="date_start" class="col-lg-2 control-label"> Data de Início*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Data de Início" name="date_start" 
							required 
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="date_finish" class="col-lg-2 control-label"> Data de Término*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Data de Término" name="date_finish"
							required 
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')" />
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="date_start_show" class="col-lg-2 control-label"> Data de Início da Exibição*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Início da exibição do evento" name="date_start_show" 
							required 
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="date_finish_show" class="col-lg-2 control-label"> Data de Término da Exibição*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Término da exibição do evento" name="date_finish_show" 
							required 
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="capacity_male" class="col-lg-2 control-label"> Capacidade Masculino*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Capacidade pavilhão masculino" name="capacity_male" 
							required 
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="capacity_female" class="col-lg-2 control-label"> Capacidade Feminino*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Capacidade pavilhão feminino" name="capacity_female" 
							required 
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>
				</div>
			</div>
			<br />
			<div class="row">	

					<label for="enabled" class="col-lg-2 control-label"> Habilitado*: </label>
					<div class="col-lg-4">

						<input type="radio" placeholder="Habilitado"
							name="enabled" value="FALSE" checked/>Não
						
						
						<input type="radio" class="" style="margin-left:10px"  placeholder="Habilitado"
							name="enabled" value="TRUE"/>Sim
	
					</div>
				</div>
			</div>
			<br />

			<br /><br /><br />

			<div class="form-group">
				<div class="col-lg-10">
					<button class="btn btn-primary" style="margin-right:40px" onClick="validateForm()">Confirmar</button>
					<a href="<?=$this->config->item('url_link')?>events/index"><button class="btn btn-warning"
						onClick="history.go(-1);return true;">Voltar</button></a>
				</div>
			</div>
			
		</form>
	</div>
</div>
