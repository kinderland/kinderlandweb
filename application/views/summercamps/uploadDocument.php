<div class = "row">
	<?php require_once APPPATH . 'views/include/common_user_left_menu.php' ?>
	<?php if($editable) {
	?>
	<div class="col-lg-10">
	<h1>Enviar documentos - <?=$document_name ?>:
	</h1>
	<h4>Se algum documento já foi enviado, um novo envio de documento substituirá o anterior. 
	Apenas o último documento enviado será considerado para validação</h4>
	<form enctype="multipart/form-data" action="<?= $this -> config -> item('url_link'); ?>summercamps/saveDocument" method="POST">
		<br>
		<input type="hidden" name="camp_id" value="<?=$camp_id ?>" />
		<input type="hidden" name="colonist_id" value="<?=$colonist_id ?>" />
		<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
		Escolha um arquivo para enviar, aceitamos apenas arquivos .pdf, jpg, .jpeg e .png de até 2MB.
		<br>
		<p style="color:red; font-weight: bold;">
		<?php if($document_type == DOCUMENT_TRIP_AUTHORIZATION_SIGNED){?>
		Atenção: Para assinar e realizar o envio, imprima antes o PDF da autorização de viagem que pode ser acessada na coluna Inscrição.
		<?php } else if ($document_type == DOCUMENT_IDENTIFICATION_DOCUMENT){?>
		Atenção: documentos que tenham frente e verso, ambos são necessários. E documentos de identidade devem conter os nomes dos pais.
		<?php }?>
		</p>
		<input type="hidden" name="document_type" value="<?=$document_type ?>" />
		<br>
		<input  type="file" name="uploadedfile" <?php if($status == '5') {?> class="btn btn-primary" disabled <?php } else{ ?> class="btn btn-primary" <?php }?> /> 
		<br />
		<input type="submit" value="<?php if($document_type == DOCUMENT_TRIP_AUTHORIZATION_SIGNED){ echo "enviar autorização assinada"; } else if($document_type == DOCUMENT_PHOTO_3X4){ echo "enviar foto 3x4"; }else if($document_type == DOCUMENT_IDENTIFICATION_DOCUMENT){ echo "enviar documento"; } else if($document_type == DOCUMENT_MEDICAL_CARD){ echo "enviar carteira plano de saude"; }?>" <?php if($status == '5') {?> class="btn btn-primary" disabled <?php } else{ ?> class="btn btn-primary" <?php }?> /> 
		<?php if(isset($extra)) { ?>
		<br><br>
		O último documento enviado tinha o seguinte problema: <?=$extra?>
		<?php } ?>
		
	</form>
	<br>
	<br>

	<?php } else { ?>
	<h1>Verificar documentos - <?=$document_name ?>:
	</h1>

	<?php } ?>
	
	<script>

		function confirmDocument(camp_id,colonist_id,document_type){
			if(document_type == 3)
				var status = 'Documento';
			else if (document_type == 5)
				var status = 'Foto';

			$.post("<?= $this->config->item('url_link'); ?>summercamps/confirmDocument",
                    { camp_id: camp_id,colonist_id:colonist_id, document_type: document_type },
                        function ( data ){
                            if(data == "true"){

                            	location.replace("<?= $this->config->item('url_link'); ?>summercamps/index");
                            	
                            	if(document_type == 3)
                                	alert('Documento confirmado com sucesso!');
                            	else if (document_type == 5)
                            		alert('Foto confirmada com sucesso!');
                        		
                            }
                            else
                                alert("Erro ao confirmar.");
                        }
                );


		}

	</script>

	<a target="_blank" href="<?= $this -> config -> item('url_link'); ?>admin/verifyDocument?camp_id=<?=$camp_id ?>&colonist_id=<?=$colonist_id ?>&document_type=<?=$document_type ?>">
	<button class="btn btn-primary" <?=$hasDocument ?>>
	<?php if($document_type == DOCUMENT_TRIP_AUTHORIZATION_SIGNED){?>
	visualizar última autorização enviada
	<?php } else if ($document_type == DOCUMENT_PHOTO_3X4){?>
	visualizar última foto enviada
	<?php } else if ($document_type == DOCUMENT_IDENTIFICATION_DOCUMENT){?>
	visualizar último documento enviado
	<?php } else if ($document_type == DOCUMENT_MEDICAL_CARD){?>
	visualizar últiaocarteira do plano de saude enviada
	<?php }?>
	</button> </a>
	<?php 
	$oldSubscriptionRestored = $this -> summercamp_model -> isOldSubscriptionRestored($camp_id ,$colonist_id);
	
	if($oldSubscriptionRestored){
		if($document_type == 3){
			if($oldSubscriptionRestored->identification_document == 'f') {?>
					<button class="btn btn-success" onclick="confirmDocument(<?= $camp_id ?>,<?= $colonist_id ?>,<?= $document_type ?>)">
							Confirmar documento recuperado do ano anterior
						</button>
		<?php } } else if($document_type == 5){
			
			if($oldSubscriptionRestored->photo == 'f') {?>
<!--
					<button class="btn btn-success" onclick="confirmDocument(<?= $camp_id ?>,<?= $colonist_id ?>,<?= $document_type ?>)">
							Confirmar foto recuperada do ano anterior
						</button>
-->

	<?php }} }
	?>
	<br>
	<br>
	<input class="btn btn-warning" type="button" value="Voltar" onclick="history.back()" />
	</div>
	

</div>
