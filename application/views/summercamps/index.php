	<?php require_once APPPATH . 'views/include/common_user_left_menu.php'
	?>
	
	<?php
	function insertFigure($object, $summer_camp_id, $colonist_id, $document_id) {
		if ($object -> summercamp_model -> hasDocument($summer_camp_id, $colonist_id, $document_id)) {
			echo '<img src="' . $object -> config -> item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';

		} else {
			echo '<img src="' . $object -> config -> item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
		}
	}
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
			<td>
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/editSubscriptionColonist?colonistId=<?=$summerCampInscription -> getColonistId() ?>&summerCampId=<?=$summerCampInscription -> getSummerCampId() ?>"><?=$summerCampInscription -> getFullname() ?></a>
				<br>				<?=$this -> summercamp_model -> getSummerCampById($summerCampInscription -> getSummerCampId()) -> getCampName() ?></td>

				
			<td>
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_MEDICAL_FILE ?>">
					Ficha Médica </a>      
					<?=insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_MEDICAL_FILE) ?>                   
<br><br>	
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_TRIP_AUTHORIZATION ?>">
					Autorização de viagem </a>                         
					<?=insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_TRIP_AUTHORIZATION) ?>                   
<br><br>	
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_IDENTIFICATION_DOCUMENT ?>">
					Documento de identificação </a>                         
					<?=insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_IDENTIFICATION_DOCUMENT) ?>                   
<br><br>	
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_GENERAL_RULES ?>">
					Normas gerais </a>                         
					<?=insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_GENERAL_RULES) ?>                   
<br><br>	
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_PHOTO_3X4 ?>">
					Photo 3x4 </a>                         
					<?=insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_PHOTO_3X4) ?>                   
<br><br>	
			</td>
			<td><?=$summerCampInscription -> getSituation() ?></td>
			<td><button class="button" disabled>Pagar</button></td>
		</tr>
	<?php } ?>
		
		</table>
	<?php } ?>
</div>