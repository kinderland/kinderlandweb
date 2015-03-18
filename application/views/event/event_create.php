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
					<label for="eventname" class="col-lg-2 control-label"> Nome do Evento*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Nome do Evento" name="eventname" 
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
					<label for="price" class="col-lg-2 control-label"> Preço*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Preço" name="price" 
							required 
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="private" class="col-lg-2 control-label"> Privado*: </label>
					<div class="col-lg-4">

						<input type="radio" placeholder="Privado"
							name="private" value="no" checked/>Não
						
						
						<input type="radio" class="" style="margin-left:10px"  placeholder="Privado"
							name="private" value="yes"/>Sim
	
					</div>
				</div>
			</div>
			<br />

			<br /><br /><br />

			<div class="form-group">
				<div class="col-lg-10">
					<button class="btn btn-primary" style="margin-right:40px" onClick="validateForm()">Confirmar</button>
					<a href="<?=$this->config->item('url_link')?>events/index"><button class="btn btn-warning">Voltar</button></a>
				</div>
			</div>
			
		</form>
	</div>
</div>
