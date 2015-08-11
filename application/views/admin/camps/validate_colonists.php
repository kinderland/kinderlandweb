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
                if(confirm("Deseja realmente confirmar a validação do colonista "+colonist_name+"?")) {
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
                                $("#colonist_situation_"+colonist_id+"_"+summer_camp_id).html(data);
                                $("#submit_btn_"+colonist_id+"_"+summer_camp_id).hide();
                                $("#save_btn_"+colonist_id+"_"+summer_camp_id).hide();
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
					<form method="GET">
					<select name="ano_f" onchange="this.form.submit()" id="anos">
					
							<?php
							foreach ( $years as $year ) {
								$selected = "";
								if ($ano_escolhido == $year)
									$selected = "selected";
								echo "<option $selected value='$year'>$year</option>";
							}
							?>
						</select>
					<br> </br>
					<table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 600px;">
					<thead>
						<tr>
							<th>Colônia</th>
							<th>Validadas</th>
							<th>Não Validadas</th>
							<th>Aguardando Validação</th>	
					    </tr>
					</thead>
					<tbody>
						<?php
                            foreach ($campCount as $count) {
                            ?>
                       <tr>
                       		<td style="text-align:left"><?php echo $count -> camp_name?></td>
                       		<td><?=$count -> validated?></td>
                       		<td><?=$count -> validated_with_errors?></td>
                       		<td><?=$count -> waiting_validation?></td>
                       	</tr>	
                       		<?php
                                }
                        ?>           					
					</tbody>
				</table>
				<b>Colônia:</b>
					<select name="colonia_f" onchange="this.form.submit()" id="colonia">
							<option value="0" <?php if(!isset($colonia_escolhida)) echo "selected"; ?>>Todas</option>
							<?php
							foreach ( $camps as $camp ) {
								$selected = "";
								if ($colonia_escolhida == $camp)
									$selected = "selected";
								echo "<option $selected value='$camp'>$camp</option>";
							}
							?>
						</select>
						<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status:</b>
						<select name="status_f" onchange="this.form.submit()" id="status">
							
							<?php
							foreach ( $status as $situation ) {
								$selected = "";
								if ($status_escolhido == $situation)
									$selected = "selected";
								echo "<option $selected value='$situation'>$situation</option>";
							}
							?>
						</select>
						
				</form>
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
                                    <td id="colonist_situation_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>"><font color="
                                <?php
                                    switch ($colonist->situation) {
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION: echo "#061B91"; break;
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED: echo "#017D50"; break;
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS: echo "#FF0000"; break;
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN: echo "#555555"; break;
                                    }
                                ?>"><?= $colonist -> situation_description ?></td>
                                    <td>
                                    	<?php
                                    		if($colonist->situation == SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION || $colonist->situation == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN || $colonist->situation == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS){
                                    	?>
                                    	   <a onClick="openValidationTab(<?=$colonist->colonist_id?>, <?=$colonist->summer_camp_id?>)">Checklist</a> <br />
                                    	<?php
                                    		}
                                    	?>
                                        <?php
                                            if($colonist->situation == SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION){
                                        ?>
                                           <button class="btn btn-primary" id="submit_btn_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>" onClick="confirmValidation(<?=$colonist->colonist_id?>, '<?=$colonist->colonist_name?>', <?=$colonist->summer_camp_id?>)">Submeter</button> <br />
                                        <?php
                                            }
                                        ?>
                                        <?php
                                            if($colonist->situation == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED){
                                        ?>
                                           <img src="<?= $this->config->item('assets')?>images/kinderland/confirma.png" width="30" height="30" />
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
						                        		<td> Sexo <img src="<?= $this->config->item('assets')?>images/kinderland/help.png" width="15" height="15"
                                                            title="Certificar que o sexo informado para o(a) colonista confere com o documento de identificação. Caso não seja possível identificar pelo documento ou nome do(a) colonista, contactar o responsável pela inscrição antes de validar."/></td>
						                        		<td> 
						                        			<input type="radio" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="gender" value="true" <?= (isset($colonist->colonist_gender_ok) && $colonist->colonist_gender_ok == "t")?"checked":"" ?> /> Sim 
                                                            <input type="radio" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="gender" value="false" <?= (isset($colonist->colonist_gender_ok) && $colonist->colonist_gender_ok == "f")?"checked":"" ?> /> Não 
						                        		</td>
						                        		<td>
						                        			<input type="text" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="msg_gender" class="form-control" value="<?= $colonist->colonist_gender_msg ?>"/>
						                        		</td>
						                        	</tr>

						                        	<tr>
                                                        <td> Nome completo do colonista <img src="<?= $this->config->item('assets')?>images/kinderland/help.png" width="15" height="15"
                                                            title="Verificar se o nome informado para o(a) colonista confere com o documento de identificação, incluindo todos nomes intermediários e sobrenomes. Validar somente caso pelo menos o primeiro nome e um dos sobrenomes estejam corretos e digitados exatamente como no documento."/> </td>
                                                        <td> 
                                                            <input type="radio" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="colonist_name" value="true" <?= (isset($colonist->colonist_name_ok) && $colonist->colonist_name_ok == "t")?"checked":"" ?> /> Sim 
                                                            <input type="radio" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="colonist_name" value="false" <?= (isset($colonist->colonist_name_ok) && $colonist->colonist_name_ok == "f")?"checked":"" ?> /> Não 
                                                        </td>
                                                        <td>
                                                            <input type="text" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="msg_colonist_name" class="form-control" value="<?= $colonist->colonist_name_msg ?>"/>
                                                        </td>
                                                    </tr>

						                        	<tr>
						                        		<td> Nome completo dos pais <img src="<?= $this->config->item('assets')?>images/kinderland/help.png" width="15" height="15"
                                                            title="Verificar se os nomes informados para os(as) responsáveis pelo colonista conferem com o documento de identificação. Validar somente caso pelo menos o primeiro nome e um dos sobrenomes estejam corretos e digitados exatamente como no documento. Este dado é opcional e assim, pode-se validar caso não conste no cadastro do(a) colonista."/>
                                                        </td>
						                        		<td> 
                                                            <input type="radio" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="parents_name" value="true" <?= (isset($colonist->colonist_parents_name_ok) && $colonist->colonist_parents_name_ok == "t")?"checked":"" ?> /> Sim 
                                                            <input type="radio" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="parents_name" value="false" <?= (isset($colonist->colonist_parents_name_ok) && $colonist->colonist_parents_name_ok == "f")?"checked":"" ?> /> Não 
                                                        </td>
                                                        <td>
                                                            <input type="text" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="msg_parents_name" class="form-control" value="<?= $colonist->colonist_parents_name_msg ?>"/>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td> Data de nascimento / Ano Escolar <img src="<?= $this->config->item('assets')?>images/kinderland/help.png" width="15" height="15"
                                                            title="Verificar se a data de nascimento informada no cadastro do(a) colonista confere com o documento de identificação. Além disso, é necessário atentar para colonista(s) com idade consistente com o ano escolar. Também checar se o ano escolar/idade correspondem à temporada de colônia escolhida. Validar apenas se a inscrição estiver de acordo com todos estes casos."/>
                                                        </td>
                                                        <td> 
                                                            <input type="radio" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="birthday" value="true" <?= (isset($colonist->colonist_birthday_ok) && $colonist->colonist_birthday_ok == "t")?"checked":"" ?> /> Sim 
                                                            <input type="radio" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="birthday" value="false" <?= (isset($colonist->colonist_birthday_ok) && $colonist->colonist_birthday_ok == "f")?"checked":"" ?> /> Não 
                                                        </td>
                                                        <td>
                                                            <input type="text" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="msg_birthday" class="form-control" value="<?= $colonist->colonist_birthday_msg ?>"/>
                                                        </td>
                                                    </tr>

						                        	<tr>
						                        		<td> <a target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/verifyDocument?colonist_id=<?= $colonist -> colonist_id ?>&camp_id=<?= $colonist -> summer_camp_id ?>&document_type=3">Documento de identificação</a> 
                                                            <img src="<?= $this->config->item('assets')?>images/kinderland/help.png" width="15" height="15"
                                                            title="Verificar se o documento de identificação está legível. É necessário também checar se o tipo de documento é o mesmo informado no cadastro. O arquivo só pode conter um único documento do(a) colonista em processo de inscrição."/>
                                                        </td>
						                        		<td> 
						                        			<input type="radio" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="identity" value="true" <?= (isset($colonist->colonist_identity_ok) && $colonist->colonist_identity_ok == "t")?"checked":"" ?>  /> Sim 
                                                            <input type="radio" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="identity" value="false" <?= (isset($colonist->colonist_identity_ok) && $colonist->colonist_identity_ok == "f")?"checked":"" ?>  /> Não 
						                        		</td>
						                        		<td>
						                        			<input type="text" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="msg_identity" class="form-control" value="<?= $colonist->colonist_identity_msg ?>"/>
						                        		</td>
						                        	</tr>

						                        	<tr>
						                        		<td> <a target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/verifyDocument?colonist_id=<?= $colonist -> colonist_id ?>&camp_id=<?= $colonist -> summer_camp_id ?>&document_type=5"> Foto 3x4 </a> 
                                                            <img src="<?= $this->config->item('assets')?>images/kinderland/help.png" width="15" height="15"
                                                            title="Verificar se a foto do(a) colonista está legível e exibe apenas o rosto. O arquivo só pode conter uma única foto do(a) colonista em processo de inscrição."/>
                                                        </td>
						                        		<td> 
						                        			<input type="radio" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="picture" value="true" <?= (isset($colonist->colonist_picture_ok) && $colonist->colonist_picture_ok == "t")?"checked":"" ?> /> Sim 
                                                            <input type="radio" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="picture" value="false" <?= (isset($colonist->colonist_picture_ok) && $colonist->colonist_picture_ok == "f")?"checked":"" ?> /> Não 
						                        		</td>
						                        		<td>
						                        			<input type="text" <?= ($colonist->situation != SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "disabled":"" ?> name="msg_picture" class="form-control" value="<?= $colonist->colonist_picture_msg ?>"/>
						                        		</td>
						                        	</tr>
						                        </tbody>
		                            		</table>
		                            	</form>
                                        <button id="save_btn_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>" class="btn btn-primary" onClick="saveValidation(<?=$colonist->colonist_id?>, <?=$colonist->summer_camp_id?>)"
                                                <?= ($colonist->situation == SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION) ? "":" style='display:none'" ?>>Salvar</button>
		                            	<button class="btn btn-warning" onClick="closeValidationTab(<?=$colonist->colonist_id?>, <?=$colonist->summer_camp_id?>)">Fechar</button>
                                        <br><br><br><br>
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