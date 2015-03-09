 

	<div class="row">

		<h2> Bem vindo(a), <?=$fullname?>.</h2>
		<br />
		<div class="col-lg-8 col-lg-offset-2">
			<ul class="system-menu-list">
				<li><a href="<?=$this->config->item('url_link');?>events/index">Próximos Eventos</a>
	            <li><a href="<?=$this->config->item('url_link');?>payments/index">Ver todos os pagamentos cielo</a>
				<li><a href="#">Doação Associado Kinderland 2015</a>
				<li><a href="#">Doação Avulsa</a>
				<li><a href="#">Inscrição MiniKinderland 2015 e Kinderland 2016</a>
				<li><a href="<?=$this->config->item('url_link');?>user/edit">Atualizar Cadastro</a>
			</ul>
			
			<a href="<?=$this->config->item('url_link');?>login/logout" class="forgot-pwd">Sair do Sistema</a>
		</div>
	</div>
