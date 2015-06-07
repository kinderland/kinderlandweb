<div class = "row">
	<?php require_once APPPATH . 'views/include/common_user_left_menu.php'
	?>
	<h1>Inscrições de colonistas:</h1>
	<?php if($summerCamps){
	?>
		<h4>Estão abertas as seguintes campanhas:</h4>
		<?php foreach($summerCamps as $summerCamp) {
		?>
			<a href="<?= $this -> config -> item('url_link'); ?>summercamps/subscribeColonist?id=<?=$summerCamp -> getCampId() ?>">
			<input type="button" value="<?=$summerCamp -> getCampName() ?>" />
			</a>
		<?php } ?>
	<?php } else{ ?>
		Não é possível fazer inscrições no momento.
	<?php } ?>
	<br><br><br>
	<?php if($summerCampInscriptions){ ?>
		Colonistas:
		<table class="table-bordered table table-striped"><thead>
			<th>Cadastro</th>
			<th>Anexos</th>
			<th>Situação</th>
			<th>Contribuição</th>
		</thead>
	<?php
		foreach($summerCampInscriptions as $summerCampInscription){
		?>
		<tr>
			<td><?=$summerCampInscription->getFullname()?>
				<br>
				<?=$this->summercamp_model->getSummerCampById($summerCampInscription->getSummerCampId())->getCampName()?></td>
			<td><button class="button" disabled>Gerenciar documentos</button></td>
			<td><?=$summerCampInscription->getSituation()?></td>
			<td><button class="button" disabled>Pagar</button></td>
		</tr>
	<?php } ?>
		
		</table>
	<?php } ?>
</div>