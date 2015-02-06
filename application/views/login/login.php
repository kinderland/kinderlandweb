<script type="text/javascript" charset="utf-8">

function validateLogin(){
	
	if(!validateNotEmptyField("login_form","login","Nome de usuário") || !validateNotEmptyField("login_form","password","Senha"))
		return false;

		$("#login_form").submit();
}

</script>
<body id="login-bg"> 
 
<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo -->
	<div id="logo-login">
		<a href="index.html"><img src="<?=$this->config->item('assets');?>images/kinderland/logo.png" width="156" height="40" alt="" /></a>
	</div>
	<!-- end logo -->
	
	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->
	<div id="loginbox">
	
	<!--  start login-inner -->
	<div id="login-inner">

	<form name="login_form" method="POST" action="<?=$this->config->item('url_link')?>login/loginSuccessful" id="login_form">
			<?php 
			if ($error == true)
				echo "Login e/ou senha inválidos."
			?> 
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Nome de usuário</th>
			<td><input type="text" id="login" name="login" class="login-inp" /></td>
		</tr>
		<tr>
			<th>Senha</th>
			<td><input type="password" value=""  onfocus="this.value=''" id="password" name="password" class="login-inp" /></td>
		</tr>
		<tr>
			<th></th>
			<td><input type="button" class="submit-login" onClick="validateLogin()"/></td>

		</tr>
		</table>
	</div>
 	<!--  end login-inner -->
	<div class="clear"></div>
	<a href="<?=$this->config->item('url_link')?>login/signup" class="forgot-pwd">Fazer o cadastro</a>
</div>
<!--  end loginbox -->
 

</div>
<!-- End: login-holder -->
</body>
</html>