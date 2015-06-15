	<?php require_once APPPATH . 'views/include/common_user_left_menu.php'
	?>

<div class = "col-lg-10">
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
			<td>
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>">
					<button class="button" >Enviar documentos</button> </a><br><br>	
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/verifyDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>">
					<button class="button" >Verificar documentos</button> </a>
			</td>
			<td><?=$summerCampInscription->getSituation()?></td>
			<td><button class="button" disabled>Pagar</button></td>
		</tr>
	<?php } ?>
		
		</table>
	<?php } ?>
</div>