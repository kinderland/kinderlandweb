<div class = "row">
	<?php require_once APPPATH . 'views/include/common_user_left_menu.php'
	?>
	<h1>Enviar documentos - <?=$document_name?>:</h1>
	<form enctype="multipart/form-data" action="<?= $this -> config -> item('url_link'); ?>summercamps/saveDocument" method="POST">
		<br>	
		<input type="hidden" name="camp_id" value="<?=$camp_id?>" /><input type="hidden" name="colonist_id" value="<?=$colonist_id?>" /> 
		<input type="hidden" name="MAX_FILE_SIZE" value="2000000" /> Escolha um arquivo para enviar, aceitamos apenas arquivos .pdf, jpg, .jpeg e .png de até 2Mb.
		<br>
		<input type="hidden" name="document_type" value="<?=$document_type?>" /> 
		<br>
		<input name="uploadedfile" type="file" /><br /> <input type="submit" value="Enviar documento" /> </form>
	</form>
	
<br><br><br><br>
	<a href="<?= $this -> config -> item('url_link'); ?>summercamps/verifyDocument?camp_id=<?=$camp_id ?>&colonist_id=<?=$colonist_id ?>&document_type=<?=$document_type?>">
		<button class="button" <?=$hasDocument?>>Ultimo documento enviado</button>
	</a>


</div>