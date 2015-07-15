<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this -> config -> item('assets'); ?>css/basic.css" rel="stylesheet" />
        <link href="<?= $this -> config -> item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/bootstrap-switch.min.css">
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/theme.default.css" />
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/ui/jquery-ui.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquerysettings.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery/jquery.redirect.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/formValidationFunctions.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/bootstrap-switch.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery/jquery.mask.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>datatable/js/datatable.min.js"></script>
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>datatable/css/datatable-bootstrap.min.css" />
		

    </head>
    <body>
    	<script type="text/javascript">
    		function openValidationTab(colonist_id, summer_camp_id) {
    			$("#validation_tab_"+colonist_id+"_"+summer_camp_id).fadeIn();
    		}
    		function closeValidationTab(colonist_id, summer_camp_id) {
    			$("#validation_tab_"+colonist_id+"_"+summer_camp_id).fadeOut();
    		}

            function sendValidationErrorEmail(colonist_id, summer_camp_id) {
                $.post("<?= $this->config->item('url_link') ?>admin/sendValidationEmail",
                    {
                        'colonist_id': colonist_id,
                        'summer_camp_id': summer_camp_id
                    },
                    function (data) {
                        if (data == "true") {
                            alert("Email enviado!");
                        } else {
                            alert("Ocorreu um erro ao enviar o email");
                        }
                    }
                );

            }

            function confirmValidation(colonist_id, colonist_name, summer_camp_id) {
                if(confirm("Deseja realmente confirmar o a validação do colonista "+colonist_name+"?")) {
                    var formName = "#form_validation_"+colonist_id+"_"+summer_camp_id;
                    var radioGender = $(formName + ' input[name=gender]:checked').val();
                    if(radioGender != "true" && radioGender != "false"){
                        alert("Validação de sexo não foi selecionada.");
                        return;
                    }

                    var radioIdentity = $(formName + ' input[name=identity]:checked').val();
                    if(radioIdentity != "true" && radioIdentity != "false"){
                        alert("Validação de identidade não foi selecionada.");
                        return;
                    }

                    var radioPicture = $(formName + ' input[name=picture]:checked').val();
                    if(radioPicture != "true" && radioPicture != "false"){
                        alert("Validação de foto não foi selecionada.");
                        return;
                    }

                    var radioBirthdate = $(formName + ' input[name=birthday]:checked').val();
                    if(radioBirthdate != "true" && radioBirthdate != "false"){
                        alert("Validação de data de nascimento não foi selecionada.");
                        return;
                    }

                    var radioParentsName = $(formName + ' input[name=parents_name]:checked').val();
                    if(radioParentsName != "true" && radioParentsName != "false"){
                        alert("Validação de nome dos pais não foi selecionada.");
                        return;
                    }

                    var radioName = $(formName + ' input[name=colonist_name]:checked').val();
                    if(radioName != "true" && radioName != "false"){
                        alert("Validação de nome completo do colonista não foi selecionada.");
                        return;
                    }

                    $.post("<?= $this->config->item('url_link') ?>admin/confirmValidation",
                        {
                            'colonist_id': colonist_id,
                            'summer_camp_id': summer_camp_id,
                            'gender': radioGender,
                            'birthday': radioBirthdate,
                            'parents_name': radioParentsName,
                            'colonist_name': radioName,
                            'picture': radioPicture,
                            'identity': radioIdentity
                        },
                        function (data) {
                            if (data !== "") {
                                alert(data);
                                $("#colonist_situation_"+colonist_id+"_"+summer_camp_id).html(data);
                            } else {
                                alert("Ocorreu um erro ao confirmar validação do colonista");
                            }
                        });
                }
            }

            function saveValidation(colonist_id, summer_camp_id){
                var formName = "#form_validation_"+colonist_id+"_"+summer_camp_id;
                var radioGender = $(formName + ' input[name=gender]:checked').val();
                var radioIdentity = $(formName + ' input[name=identity]:checked').val();
                var radioPicture = $(formName + ' input[name=picture]:checked').val();
                var radioBirthdate = $(formName + ' input[name=birthday]:checked').val();
                var radioParentsName = $(formName + ' input[name=parents_name]:checked').val();
                var radioName = $(formName + ' input[name=colonist_name]:checked').val();

                var msgGender = $(formName + ' input[name=msg_gender]').val();
                var msgIdentity = $(formName + ' input[name=msg_identity]').val();
                var msgPicture = $(formName + ' input[name=msg_picture]').val();
                var msgBirthdate = $(formName + ' input[name=msg_birthday]').val();
                var msgParentsName = $(formName + ' input[name=msg_parents_name]').val();
                var msgName = $(formName + ' input[name=msg_colonist_name]').val();

                if(radioGender == "true")
                    $(formName + ' input[name=msg_gender]').val("");
                if(radioIdentity == "true")
                    $(formName + ' input[name=msg_identity]').val("");
                if(radioPicture == "true")
                    $(formName + ' input[name=msg_picture]').val("");
                if(radioBirthdate == "true")
                    $(formName + ' input[name=msg_birthday]').val("");
                if(radioParentsName == "true")
                    $(formName + ' input[name=msg_parents_name]').val("");
                if(radioName == "true")
                    $(formName + ' input[name=msg_colonist_name]').val("");

                $.post("<?= $this->config->item('url_link') ?>admin/updateColonistValidation",
                    {
                        'colonist_id': colonist_id,
                        'summer_camp_id': summer_camp_id,
                        'gender': radioGender,
                        'birthday': radioBirthdate,
                        'parents_name': radioParentsName,
                        'colonist_name': radioName,
                        'picture': radioPicture,
                        'identity': radioIdentity,
                        'msg_gender': msgGender,
                        'msg_birthday': msgBirthdate,
                        'msg_parents_name': msgParentsName,
                        'msg_colonist_name': msgName,
                        'msg_picture': msgPicture,
                        'msg_identity': msgIdentity
                    },
                    function (data) {
                        if (data == "true") {
                            alert("Validação salva com sucesso");
                        } else {
                            alert("Ocorreu um erro ao confirmar validação do colonista");
                        }
                    }
                );
            }

    	</script>

        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
					
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 700px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Nome do Colonista </th>
                                <th> Colônia </th>
                                <th> Responsável </th>
                                <th> Status da inscrição </th>
                                <th> Ações </th>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php
                            foreach ($colonists as $colonist) {
                            ?>
                                <tr>
                                    <td><a id="<?= $colonist -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> summer_camp_id ?>"><?= $colonist -> colonist_name ?></a></td>
                                    <td><?= $colonist -> camp_name ?></td>
                                    <td><a id="<?= $colonist -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> person_user_id ?>"><?= $colonist -> user_name ?></a></td>
                                    <td id="colonist_situation_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>"><?= $colonist -> situation_description ?></td>
                                    <td>
                                    	<?php
                                    		if($colonist->situation == SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION || $colonist->situation == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN || $colonist->situation == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS){
                                    	?>
                                    	   <a onClick="openValidationTab(<?=$colonist->colonist_id?>, <?=$colonist->summer_camp_id?>)">Checklist</a> <br />
                                           <a onClick="confirmValidation(<?=$colonist->colonist_id?>, '<?=$colonist->colonist_name?>', <?=$colonist->summer_camp_id?>)">Submeter</a> <br />
                                    	<?php
                                    		}
                                    	?>
                                    </td>
                                </tr>
                                <tr id="validation_tab_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>" style="display:none">
                                	<td colspan="5">
		                            	<form id="form_validation_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>" name="form_validation_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>">
		                            		<input type="hidden" name="colonist_id" value="<?=$colonist->colonist_id?>" />
		                            		<input type="hidden" name="summer_camp_id" value="<?=$colonist->summer_camp_id?>" />
		                            		<table class="table table-bordered table-striped table-min-td-size">
		                            			<thead>
						                            <tr>
						                                <th> Item de validação </th>
						                                <th> Situação </th>
						                                <th> Justificativa </th>
						                            </tr>
						                        </thead>
						                        <tbody>
						                        	<tr>
						                        		<td> Sexo </td>
						                        		<td> 
						                        			<input type="radio" name="gender" value="true" <?= (isset($colonist->colonist_gender_ok) && $colonist->colonist_gender_ok == "t")?"checked":"" ?> /> Sim 
                                                            <input type="radio" name="gender" value="false" <?= (isset($colonist->colonist_gender_ok) && $colonist->colonist_gender_ok == "f")?"checked":"" ?> /> Não 
						                        		</td>
						                        		<td>
						                        			<input type="text" name="msg_gender" class="form-control" value="<?= $colonist->colonist_gender_msg ?>"/>
						                        		</td>
						                        	</tr>

						                        	<tr>
                                                        <td> Nome completo do colonista </td>
                                                        <td> 
                                                            <input type="radio" name="colonist_name" value="true" <?= (isset($colonist->colonist_name_ok) && $colonist->colonist_name_ok == "t")?"checked":"" ?> /> Sim 
                                                            <input type="radio" name="colonist_name" value="false" <?= (isset($colonist->colonist_name_ok) && $colonist->colonist_name_ok == "f")?"checked":"" ?> /> Não 
                                                        </td>
                                                        <td>
                                                            <input type="text" name="msg_colonist_name" class="form-control" value="<?= $colonist->colonist_name_msg ?>"/>
                                                        </td>
                                                    </tr>

						                        	<tr>
						                        		<td> Nome completo dos pais </td>
						                        		<td> 
                                                            <input type="radio" name="parents_name" value="true" <?= (isset($colonist->colonist_parents_name_ok) && $colonist->colonist_parents_name_ok == "t")?"checked":"" ?> /> Sim 
                                                            <input type="radio" name="parents_name" value="false" <?= (isset($colonist->colonist_parents_name_ok) && $colonist->colonist_parents_name_ok == "f")?"checked":"" ?> /> Não 
                                                        </td>
                                                        <td>
                                                            <input type="text" name="msg_parents_name" class="form-control" value="<?= $colonist->colonist_parents_name_msg ?>"/>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td> Data de nascimento </td>
                                                        <td> 
                                                            <input type="radio" name="birthday" value="true" <?= (isset($colonist->colonist_birthday_ok) && $colonist->colonist_birthday_ok == "t")?"checked":"" ?> /> Sim 
                                                            <input type="radio" name="birthday" value="false" <?= (isset($colonist->colonist_birthday_ok) && $colonist->colonist_birthday_ok == "f")?"checked":"" ?> /> Não 
                                                        </td>
                                                        <td>
                                                            <input type="text" name="msg_birthday" class="form-control" value="<?= $colonist->colonist_birthday_msg ?>"/>
                                                        </td>
                                                    </tr>

						                        	<tr>
						                        		<td> <a target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/verifyDocument?colonist_id=<?= $colonist -> colonist_id ?>&camp_id=<?= $colonist -> summer_camp_id ?>&document_type=3">Documento de identificação</a> </td>
						                        		<td> 
						                        			<input type="radio" name="identity" value="true" <?= (isset($colonist->colonist_identity_ok) && $colonist->colonist_identity_ok == "t")?"checked":"" ?>  /> Sim 
                                                            <input type="radio" name="identity" value="false" <?= (isset($colonist->colonist_identity_ok) && $colonist->colonist_identity_ok == "f")?"checked":"" ?>  /> Não 
						                        		</td>
						                        		<td>
						                        			<input type="text" name="msg_identity" class="form-control" value="<?= $colonist->colonist_identity_msg ?>"/>
						                        		</td>
						                        	</tr>

						                        	<tr>
						                        		<td> <a target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/verifyDocument?colonist_id=<?= $colonist -> colonist_id ?>&camp_id=<?= $colonist -> summer_camp_id ?>&document_type=5"> Foto 3x4 </a> </td>
						                        		<td> 
						                        			<input type="radio" name="picture" value="true" <?= (isset($colonist->colonist_picture_ok) && $colonist->colonist_picture_ok == "t")?"checked":"" ?> /> Sim 
                                                            <input type="radio" name="picture" value="false" <?= (isset($colonist->colonist_picture_ok) && $colonist->colonist_picture_ok == "f")?"checked":"" ?> /> Não 
						                        		</td>
						                        		<td>
						                        			<input type="text" name="msg_picture" class="form-control" value="<?= $colonist->colonist_picture_msg ?>"/>
						                        		</td>
						                        	</tr>
						                        </tbody>
		                            		</table>
		                            	</form>
                                        <button class="btn btn-primary" onClick="saveValidation(<?=$colonist->colonist_id?>, <?=$colonist->summer_camp_id?>)"
                                                <?= ($colonist->situation == SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "":" style='display:none'" ?>>Salvar</button>
		                            	<button class="btn btn-warning" onClick="closeValidationTab(<?=$colonist->colonist_id?>, <?=$colonist->summer_camp_id?>)">Fechar</button>
		                            </td>
	                            </tr>
                            <?php 
							}
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>