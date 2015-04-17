<script type="text/javascript" charset="utf-8">

function validateLogin(){
	
	if(!validateNotEmptyField("login_form","login","Nome de usuário") || !validateNotEmptyField("login_form","password","Senha"))
		return false;

		$("#login-middle").submit();
}

</script>

<div class="row">
	<div class="col-lg-6 col-lg-push-3 login-middle">
		<form name="login-middle" class="form-horizontal" action="<?=$this->config->item('url_link')?>login/loginSuccessful"
			method="post">
			<div class="form-group <?php if(isset($error)) echo" has-error"?>">
				<label for="login" class="col-lg-2 control-label"> Login: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" placeholder="Login"
						name="login" />
				</div>
			</div>

			<div class="form-group <?php if(isset($error)) echo" has-error"?>">
				<label for="password" class="col-lg-2 control-label"> Senha: </label>
				<div class="col-lg-10">
					<input type="password" class="form-control" placeholder="Senha"
						name="password" />
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-4 col-lg-offset-2">
					<button class="btn btn-primary" onClick="validateLogin()">Entrar</button>
					
				</div>

				<div class="col-lg-4 col-lg-offset-2">
					<a href="<?=$this->config->item('url_link')?>login/resetPassword"> Esqueci minha senha </a>
				</div>
			</div>
			<?php if(isset($error)) { ?>
				<div class="col-lg-12">
					<p align="center"><strong>Login e/ou senha incorretos.</strong></p>
				</div>
			<?php } ?>
			<?php if(isset($resetPassword)) { ?>
				<div class="col-lg-12">
					<p align="center"><strong>Uma nova senha foi enviada para seu email.</strong></p>
				</div>
			<?php } ?>
		</form>
	</div>
</div>