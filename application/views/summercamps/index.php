	<?php require_once APPPATH . 'views/include/common_user_left_menu.php'
	?>
	
	<?php
	function insertFigure($object, $summer_camp_id, $colonist_id, $document_id) {
		if ($object -> summercamp_model -> hasDocument($summer_camp_id, $colonist_id, $document_id)) {
			echo '<img src="' . $object -> config -> item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
			return 1;
		} else {
			echo '<img src="' . $object -> config -> item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
			return 0;
		}
	}
	?>
<div class = "col-lg-10">
	<h1>Inscrições de colonistas:</h1>
	<?php if($summerCamps){
	?>
		<h4>Adicionar colonista na colônia:</h4>
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
			<th>Ação</th>
		</thead>
	<?php
		foreach($summerCampInscriptions as $summerCampInscription){
			$documents = 0;
			if(
				$summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_CANCELLED ||
				$summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_EXCLUDED ||
				$summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_GIVEN_UP 			
			)
			continue;
		?>
		<tr>
			<td>
				<?php if ($summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS || 
				$summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN){?>
					<a href="<?= $this -> config -> item('url_link'); ?>summercamps/editSubscriptionColonistForm?colonistId=<?=$summerCampInscription -> getColonistId() ?>&summerCampId=<?=$summerCampInscription -> getSummerCampId() ?>"><?=$summerCampInscription -> getFullname() ?></a>
				<?php } else { ?>
					<a href="<?= $this -> config -> item('url_link'); ?>summercamps/viewColonistInfo?colonistId=<?=$summerCampInscription -> getColonistId() ?>&summerCampId=<?=$summerCampInscription -> getSummerCampId() ?>"><?=$summerCampInscription -> getFullname() ?></a>
				<?php } ?>
				<br>				<?=$this -> summercamp_model -> getSummerCampById($summerCampInscription -> getSummerCampId()) -> getCampName() ?></td>
				
			<td>
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_MEDICAL_FILE ?>">
					Ficha Médica </a>      
					<?php $documents += insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_MEDICAL_FILE); ?>                   
<br><br>	
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_TRIP_AUTHORIZATION ?>">
					Autorização de viagem </a>                         
					<?php $documents += insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_TRIP_AUTHORIZATION); ?>                   
<br><br>	
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_IDENTIFICATION_DOCUMENT ?>">
					Documento de identificação </a>                         
					<?php $documents += insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_IDENTIFICATION_DOCUMENT); ?>                   
<br><br>	
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_GENERAL_RULES ?>">
					Normas gerais </a>                         
					<?php $documents += insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_GENERAL_RULES); ?>                   
<br><br>	
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_PHOTO_3X4 ?>">
					Photo 3x4 </a>                         
					<?php $documents += insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_PHOTO_3X4); ?>                   
<br><br>	
			</td>
			<td>
				<?php
				echo $summerCampInscription -> getSituation();
				if ($summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS) {
					echo "<br><br>";
					echo "Atualize as informações como solicitado por e-mail e envie novamente a pré-inscrição";
				}
				?>
			</td>
			<td>
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/sendPreSubscription?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>">
					<?php
					if ($documents == 5 && 
					($summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS 
					|| $summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN))
						$sendPreSubscription = "";
					else
						$sendPreSubscription = "disabled";
					?>					
					<button class="button" <?=$sendPreSubscription ?> >Enviar pré-inscrição</button>
				</a>
				<br>
				<?php if($summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_PENDING_PAYMENT ){?>
				<button class="button" disabled>Pagar</button></td>
				<?php } ?>
		</tr>
	<?php } ?>
		
		</table>
	<?php } ?>
</div>