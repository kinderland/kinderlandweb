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
		<h1> Bem vindo(a), <?=$fullname?>.</h1>
		<br />

		<p><a href="">Doação Associado Kinderland 2015</a></p>
		<p><a href="">Doação Avulsa</a></p>
		<p><a href="">Inscrição MiniKinderland 2015 e Kinderland 2016</a></p>
		<p><a href="<?=$this->config->item('url_link');?>user/edit">Atualizar Cadastro</a></p>
		<p><a href="<?=$this->config->item('url_link');?>login/index" class="forgot-pwd">Sair do Sistema</a></p>

	</div>
 	<!--  end login-inner -->
	<div class="clear"></div>
</div>
<!--  end loginbox -->
 

</div>
<!-- End: login-holder -->
</body>
</html>