<?php

	function hasPermission($permissions, $permissionRequested){
		foreach($permissions as $permission)
			if($permission == $permissionRequested)
				return true;

		return false;
	}

?>
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

			<!--TO DO: Completar hrefs com os links para as devidas chamadas quando estiverem prontas-->

			<?php if(hasPermission($permissions, COMMON_USER)) { ?>
				<li><a href="<?=$this->config->item('url_link');?>user/menu">Sistema de usuários comuns</a>
			<?php } ?>

			<?php if(hasPermission($permissions, SYSTEM_ADMIN)) { ?>
            	<li><a href="#">Painel do Administrador</a>
            <?php } ?>

            <?php if(hasPermission($permissions, DIRECTOR)) { ?>
				<li><a href="#">Painel do Diretor</a>
			<?php } ?>

			<?php if(hasPermission($permissions, SECRETARY)) { ?>
				<li><a href="#">Painel da Secretária</a>
			<?php } ?>

			<?php if(hasPermission($permissions, COORDINATOR)) { ?>
				<li><a href="#">Painel do Coordenador</a>
			<?php } ?>
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