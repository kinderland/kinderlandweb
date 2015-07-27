<script type="text/javascript">

	function sendEmail(){
		if($("#message").val() != "" && $("#subject").val() != ""){
			$("#form_send_email").submit();
		} else {
			alert("Preencha todos os campos antes de enviar o email.");
		}
	}

</script>

<div class="row">
	<div class="col-lg-8 col-lg-offset-2">
		<h3> Envio de email para: <?=$person->getFullname()?> </h3>

		<form class="form-horizontal" action="<?=$this->config->item('url_link')?>admin/sendEmail"
			method="post" id="form_send_email">
			<input type="hidden" name="user_id" value="<?=$person->getPersonId();?>" />
			<div class="form-group">
				<label for="user_email" class="col-lg-2 control-label"> Destinatário: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" placeholder="E-mail destinatário"
						name="user_email" value="<?=$person->getEmail();?>" disabled />
				</div>
			</div>

			<div class="form-group">
				<label for="subject" class="col-lg-2 control-label"> Assunto: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" placeholder="Assunto"
						name="subject" id="subject" />
				</div>
			</div>

			<div class="form-group">
				<label for="message" class="col-lg-2 control-label"> Mensagem: </label>
				<div class="col-lg-10">
					<textarea class="form-control" name="message" id="message" rows="15"></textarea>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<div class="col-lg-2 col-lg-offset-4">
			<button class="btn btn-primary" onClick="sendEmail()">Enviar</button>
		</div>
		<div class="col-lg-2">
			<button class="btn btn-warning" style="margin-right:40px" onClick="history.back(-1)">Voltar</button>
		</div>
	</div>
</div>
