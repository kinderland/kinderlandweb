<script type="text/javascript" charset="utf-8">

function validateReset(event){
	event.preventDefault();
	if(validateNotEmptyField("form_reset","email","Email")){
		
		$.get(
            "<?= $this->config->item('url_link') ?>login/checkExistingEmail?email=" + $("#email").val(),
            function (data) {
                if (data === "true") {
                    $("#form_reset").submit();
                } else {
                	alert("Este email não existe, por favor verifique se está escrito corretamente.");
                }
            }
        );
	}
		
}

</script>

<div class="row">
	<div class="col-lg-6 col-lg-push-3 login-middle">
		<form name="form_reset" id="form_reset" class="form-horizontal" action="<?=$this->config->item('url_link')?>login/updateUserPassword"
			method="post">
			<div class="form-group <?php if(isset($error)) echo" has-error"?>">
				<label for="email" class="col-lg-2 control-label"> Email: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" placeholder="Email" id="email"
						name="email" />
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-4 col-lg-offset-2">
					<?php if(isset($error)) echo "Email inválido"?>
					<button class="btn btn-primary" onClick="validateReset(event)">Solicitar nova senha</button>
				</div>
			</div>
		</form>
	</div>
</div>