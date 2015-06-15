<div class = "row">
	<?php require_once APPPATH . 'views/include/common_user_left_menu.php'
	?>
	<h1>Upload de documentos:</h1>
	<form enctype="multipart/form-data" action="<?= $this -> config -> item('url_link'); ?>summercamps/saveDocument" method="POST">
		Selecione o tipo do documento <select disabled><option>Ainda não implementado</option></select><br>	
		<input type="hidden" name="camp_id" value="<?=$camp_id?>" /><input type="hidden" name="colonist_id" value="<?=$colonist_id?>" /> 
		<input type="hidden" name="MAX_FILE_SIZE" value="2000000" /> Choose a file to upload: 
		<input name="uploadedfile" type="file" /><br /> <input type="submit" value="Upload File" /> </form>

</div>