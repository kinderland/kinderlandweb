<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">
		<h3> Prezado <?= ($gender=="M")?"sócio":"sócia" ?> <?=$fullname?> </h3>

		<p>
			Você já é <?= ($gender=="M")?"sócio":"sócia" ?> da colônia Kinderland! Deseja continuar contribuindo? Faça uma doação avulsa.
			Para fazer uma doação avulsa clique no botão abaixo.
		</p>

		<!-- Button trigger modal -->
		<a href="<?=$this->config->item('url_link')?>donations/freeDonation">
			<button type="button" class="btn btn-primary btn-sm">
				Doação avulsa
			</button>
		</a>
	</div>
</div>