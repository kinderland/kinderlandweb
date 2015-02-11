<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Colônia Kinderland</title>
		
		<link href="<?=$this->config->item('assets');?>css/basic.css" rel="stylesheet" />
		<!--<link href="<?=$this->config->item('assets');?>css/old/screen.css" rel="stylesheet" />-->
		<link href="<?=$this->config->item('assets');?>css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?=$this->config->item('assets');?>css/themes/base/jquery-ui.css" />
		<script type="text/javascript" src="<?=$this->config->item('assets');?>js/jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="<?=$this->config->item('assets');?>js/ui/jquery-ui.js"></script>
		<script type="text/javascript" src="<?=$this->config->item('assets');?>js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=$this->config->item('assets');?>js/jquerysettings.js"></script>
		<script type="text/javascript" src="<?=$this->config->item('assets');?>js/validateForms.js"></script>
	</head>
	<body>
		<header class="navbar navbar-sags" role="banner" id="top">
			<div class="container">
				<a class="navbar-brand" href="<?=$this->config->item('url_link')?>system/menu">
					<img src="<?=$this->config->item('assets');?>images/kinderland/logo-kinderland.png" width=140 height=50 />
				</a>
				<div class="navbar-form navbar-right" style="margin-top:20px">
					<?php if(isset($user_id)){ ?>
					<span class="login-span"> 
						Olá, <?=$fullname;?><br /> 
						<a href="<?=$this->config->item('url_link')?>login/logout">Sair do Sistema</a>
					</span>
					<?php } else { ?>

					<a href="<?=$this->config->item('url_link')?>login/signup"><button class="btn btn-primary">Cadastre-se</button></a>

					<?php } ?>
				</div>
			</div>
		</header>

		<div class="main-container">