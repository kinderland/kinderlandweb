 
<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo -->
	<div id="logo-login">
		<a href="index.html"><img src="<?=$this->config->item('assets');?>images/kinderland/logo.png" width="200" height="70" alt="" /></a>
	</div>
	<!-- end logo -->
	
	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->
	<div id="loginbox">
	
	<!--  start login-inner -->
	<div id="login-inner">
		<h2> Bem vindo(a), <?=$fullname?>.</h2>
		<br />
		<ul class="system-menu-list">
			<li><a href="">Próximos Eventos</a>
			<li><a href="">Doação Associado Kinderland 2015</a>
			<li><a href="">Doação Avulsa</a>
			<li><a href="">Inscrição MiniKinderland 2015 e Kinderland 2016</a>
			<li><a href="<?=$this->config->item('url_link');?>user/edit">Atualizar Cadastro</a>
		</ul>
		
		<a href="<?=$this->config->item('url_link');?>login/logout" class="forgot-pwd">Sair do Sistema</a>
		
	</div>
 	<!--  end login-inner -->
	<div class="clear"></div>
</div>
<!--  end loginbox -->
 

</div>
<!-- End: login-holder -->
</body>
</html>