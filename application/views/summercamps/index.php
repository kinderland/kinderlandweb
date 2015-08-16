<script>
	function excluir(camp_id, colonist_id, name,subscribed) {
		
		if (confirm("Tem certeza que deseja excluir o colonista "+name+" ?")) {
			if(subscribed){
				if(confirm("Eventuais devoluções de valores devem ser tratados diretamente com a secretaria da Associação Kinderland.")){
					window.location.replace("<?= $this -> config -> item('url_link'); ?>summercamps/deleteColonist?camp_id="+camp_id+"&colonist_id="+colonist_id);
				}
			} else{
				window.location.replace("<?= $this -> config -> item('url_link'); ?>summercamps/deleteColonist?camp_id="+camp_id+"&colonist_id="+colonist_id);		
			}
		}
	}

	function returnToEditSubscription(camp_id, colonist_id){
		if (confirm("Ao voltar para a elaboração, você poderá editar todas as informações da inscrição. Ao final da edição, não se esqueça de 'enviar pré-inscrição' para que seja realizado o processo de validação. Confirma o retorno para elaboração?")) {
			window.location.replace("<?= $this -> config -> item('url_link'); ?>summercamps/invalidateSubscription?camp_id="+camp_id+"&colonist_id="+colonist_id);
		}
	}

</script>

<div class="row">
<?php require_once APPPATH . 'views/include/common_user_left_menu.php'
?>

<?php
function insertFigure($object, $summer_camp_id, $colonist_id, $document_id, $validation) {
	if ($object -> summercamp_model -> hasDocument($summer_camp_id, $colonist_id, $document_id)) {
		if ($validation) {
			if ($validation -> verifyDocument($document_id)) {
				echo '<img src="' . $object -> config -> item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
				return 1;
			} else {
				echo '<img src="' . $object -> config -> item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
				return 0;
			}
		} else {
			echo '<img src="' . $object -> config -> item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
			return 1;
		}
	} else {
		echo '<img src="' . $object -> config -> item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
		return 0;
	}
}

function insertFigureRegister($object, $validation) {
	if ($validation) {
		if ($validation -> verifySubscription()) {
			echo '<img src="' . $object -> config -> item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
			return 1;
		} else {
			echo '<img src="' . $object -> config -> item('assets') . 'images/payment/redicon.png" alt="Falta preencher" title="Falta preencher" width="20px" height="20px"/>';
			return 0;
		}
	} else {
		echo '<img src="' . $object -> config -> item('assets') . 'images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/>';
		return 1;
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
	<input class=" btn btn-primary" type="button" value="<?=$summerCamp -> getCampName() ?>" />
	</a>
	<?php } ?>
	<?php } else{ ?>
	Não é possível fazer inscrições no momento.
	<?php } ?>
	<?php if($summerCampInscriptions){
	?>
	<br />
	<br />
	<p>Ao final do preenchimento dos dados da pré-inscrição, quando todos os ítens estiverem marcados com um
	<img src="<?= $this -> config -> item('assets') ?>images/payment/greenicon.png" alt="Preenchido" title="Preenchido" width="20px" height="20px"/> 
, não esquecer de <b>ENVIAR</b> a pré-inscrição </p>
	
	
	<table class="table-bordered table table-striped">
		<thead>
			<th>Inscrição</th>
			<th></th>
			<th>Ação</th>
			<th>Status</th>
		</thead>
		<?php
			foreach($summerCampInscriptions as $summerCampInscription){
				if($summerCampInscription -> getSituationId() === SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED)
					$subscribed = "true";
				else
					$subscribed = "false";

				$documents = 0;
				$validation = $this->validation_model->getColonistValidationInfoObject($summerCampInscription->getColonistId(),$summerCampInscription->getSummerCampId());
				if(
					$summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_CANCELLED ||
					$summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_EXCLUDED ||
					$summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_GIVEN_UP
				)
				continue;
		?>
		<tr>
			<td><?php if ($summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN ||
($summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS &&  !$validation->verifySubscription())){
			?>
			<a href="<?= $this -> config -> item('url_link'); ?>summercamps/editSubscriptionColonistForm?colonistId=<?=$summerCampInscription -> getColonistId() ?>&summerCampId=<?=$summerCampInscription -> getSummerCampId() ?>">Cadastro:</a><?php } else { ?>
			<a href="<?= $this -> config -> item('url_link'); ?>summercamps/viewColonistInfo?colonistId=<?=$summerCampInscription -> getColonistId() ?>&summerCampId=<?=$summerCampInscription -> getSummerCampId() ?>">Cadastro:</a><?php } ?>
			<?=$summerCampInscription -> getFullname() ?>
			<br>
			Colônia: <?=$this -> summercamp_model -> getSummerCampById($summerCampInscription -> getSummerCampId()) -> getCampName() ?>
			<hr>
			<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_MEDICAL_FILE ?>"> Ficha Médica </a>
			<br>
			<br>
			<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_TRIP_AUTHORIZATION ?>"> Autorização de viagem </a>
			<br>
			<br>
			<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_GENERAL_RULES ?>"> Normas gerais </a>
			<br>
			<br>
			<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_IDENTIFICATION_DOCUMENT ?>"> Documento de identificação </a>
			<br>
			<br>
			<a href="<?= $this -> config -> item('url_link'); ?>summercamps/uploadDocument?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>&document_type=<?=DOCUMENT_PHOTO_3X4 ?>"> Foto 3x4 </a></td>
			<td><?php $documents += insertFigureRegister($this, $validation); ?>

			<br>
			<br>
			<hr>
			<?php $documents += insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_MEDICAL_FILE, $validation); ?>
			<br>
			<br>
			<?php $documents += insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_TRIP_AUTHORIZATION, $validation); ?>
			<br>
			<br>
			<?php $documents += insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_GENERAL_RULES, $validation); ?>
			<br>
			<br>
			<?php $documents += insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_IDENTIFICATION_DOCUMENT, $validation); ?>
			<br>
			<br>
			<?php $documents += insertFigure($this, $summerCampInscription -> getSummerCampId(), $summerCampInscription -> getColonistId(), DOCUMENT_PHOTO_3X4, $validation); ?>
			<br>
			<br>
			</td>
			
			<td>
				<?php if($summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS || 
					$summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN ){
				?>
				<a href="<?= $this -> config -> item('url_link'); ?>summercamps/sendPreSubscription?documents=<?=$documents ?>&camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>">
				<button class="btn btn-primary">
					Enviar pré-inscrição
				</button> </a>
				<?php } ?>
				<br>

				<?php if($summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION ){
				?>
				<button class="btn btn-warning" onclick="returnToEditSubscription(<?=$summerCampInscription -> getSummerCampId() ?>, <?=$summerCampInscription -> getColonistId() ?>)">
					Voltar para elaboração
				</button>
				<?php } ?>
				<br>

				<?php 
				$summerCampPayment = $this->summercamp_model->getSummerCampPaymentPeriod($summerCampInscription -> getSummerCampId());
				 
					if($summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_PENDING_PAYMENT && $summerCampPayment ){
						if($summerCampInscription->getDiscount() < 100) {
							$discount = 1-($summerCampInscription->getDiscount()/100);
				?>
							<a href="<?= $this -> config -> item('url_link'); ?>summercamps/paySummerCampSubscription?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>">
							<button class="btn btn-primary">
							Pagar R$ <?=floor($summerCampPayment->getPrice()*$discount)?>,00 
							</button> </a>	
				<?php		
						} 
				else 
				{ 
				?>
							<a href="<?= $this -> config -> item('url_link'); ?>summercamps/paySummerCampSubscription?camp_id=<?=$summerCampInscription -> getSummerCampId() ?>&colonist_id=<?=$summerCampInscription -> getColonistId() ?>">
							<button class="btn btn-primary">
							Inscrever 
							</button> </a>	

				
				<?php 	} 
					  } ?>
				<br>
				<button class="btn btn-warning" onclick='excluir(<?=$summerCampInscription -> getSummerCampId() ?>,<?=$summerCampInscription -> getColonistId() ?>,"<?=$summerCampInscription -> getFullname() ?>",<?=$subscribed?>)' class="btn">
					Excluir pré inscrição
				</button>
			</td>

			<td>
				<?php
					for($i=0;$i<=6;$i++){
						$color = "style='color:grey'";
						if($statusArray[$i]["database_id"] === $summerCampInscription -> getSituationId())
							$color = "style='color:green; font-weight:bold'";
				?>
				<p <?=$color ?> >
					<?= $statusArray[$i]["text"] ?>
				</p><?php
				}
						
					if($summerCampInscription -> getSituationId() < 0)
					$color = "style='color:green'";
					else
					$color = "style='color:grey'";
					echo "<p $color>";
					echo $statusArray[7]["text"]."/".$statusArray[8]["text"]."/".$statusArray[9]["text"];
					echo "</p>"
					?>
				<?php
				if ($summerCampInscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS) {
					echo $validation -> describeValidation();
				}
				?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php } ?>
</div>

</div>