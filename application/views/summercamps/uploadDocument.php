<div class = "row">
	<?php require_once APPPATH . 'views/include/common_user_left_menu.php'




	?>
	<?php if($editable) {
	?>
	<h1>Enviar documentos - <?=$document_name ?>:
	</h1>
	<form enctype="multipart/form-data" action="<?= $this -> config -> item('url_link'); ?>summercamps/saveDocument" method="POST">
		<br>
		<input type="hidden" name="camp_id" value="<?=$camp_id ?>" />
		<input type="hidden" name="colonist_id" value="<?=$colonist_id ?>" />
		<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
		Escolha um arquivo para enviar, aceitamos apenas arquivos .pdf, jpg, .jpeg e .png de até 2Mb.
		<br>
		<input type="hidden" name="document_type" value="<?=$document_type ?>" />
		<br>
		<input name="uploadedfile" type="file" />
		<br />
		<input type="submit" value="Enviar documento" />
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

	<a target="_blank" href="<?= $this -> config -> item('url_link'); ?>admin/verifyDocument?camp_id=<?=$camp_id ?>&colonist_id=<?=$colonist_id ?>&document_type=<?=$document_type ?>">
	<button class="button" <?=$hasDocument ?>>
		Ultimo documento enviado
	</button> </a>
	<br>
	<br>
	<input type="button" value="Voltar" onclick="history.back()" />

</div>