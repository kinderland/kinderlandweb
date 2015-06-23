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
    	</script>

        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
					
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 600px; font-size:15px" id="sortable-table">
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
                                    <td><a id="<?= $colonist -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> person_colonist_id ?>"><?= $colonist -> colonist_name ?></a></td>
                                    <td><?= $colonist -> camp_name ?></td>
                                    <td><a id="<?= $colonist -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> person_user_id ?>"><?= $colonist -> user_name ?></a></td>
                                    <td><?= $colonist -> situation_description ?></td>
                                    <td>
                                    	<button class="btn btn-primary" onClick="openValidationTab(<?=$colonist->colonist_id?>, <?=$colonist->summer_camp_id?>)">Validar</button>
                                    </td>
                                </tr>
                                <tr id="validation_tab_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>" style="display:none">
                                	<td colspan="5">
		                            	<form method='post' name="form_validation_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>" action="<?= $this->config->item('url_link') ?>admin/validateUser">
		                            		<input type="hidden" name="colonist_id" value="<?=$colonist->colonist_id?>" />
		                            		<input type="hidden" name="summer_camp_id" value="<?=$colonist->summer_camp_id?>" />
		                            		<table class="table table-bordered table-striped table-min-td-size">
		                            			<thead>
						                            <tr>
						                                <th> Item de validação </th>
						                                <th> Situação </th>
						                                <th> Mensagem </th>
						                            </tr>
						                        </thead>
						                        <tbody>
						                        	<tr>
						                        		<td> Ficha cadastral </td>
						                        		<td> 
						                        			<input type="checkbox" name="register_data" value="ok" <?= (isset($colonist->colonist_data_ok) && $colonist->colonist_data_ok == "t")?"checked":"" ?> /> Ok 
						                        		</td>
						                        		<td>
						                        			<input type="text" name="msg_register_data" class="form-control" value="<?= $colonist->colonist_data_msg ?>"/>
						                        		</td>
						                        	</tr>
<!--
						                        	<tr>
						                        		<td> Ficha médica </td>
						                        		<td> 
						                        			<input type="checkbox" name="medical_report" value="ok" /> Ok 
						                        		</td>
						                        		<td>
						                        			<input type="text" name="msg_medical_report" class="form-control"/>
						                        		</td>
						                        	</tr>
-->
<!--
						                        	<tr>
						                        		<td> Autorização de viagem </td>
						                        		<td> 
						                        			<input type="checkbox" name="travel_permission" value="ok" /> Ok 
						                        		</td>
						                        		<td>
						                        			<input type="text" name="msg_travel_permission" class="form-control"/>
						                        		</td>
						                        	</tr>
-->
						                        	<tr>
						                        		<td> Identidade </td>
						                        		<td> 
						                        			<input type="checkbox" name="identity" value="ok" <?= (isset($colonist->colonist_identity_ok) && $colonist->colonist_identity_ok == "t")?"checked":"" ?>  /> Ok 
						                        		</td>
						                        		<td>
						                        			<input type="text" name="msg_identity" class="form-control" value="<?= $colonist->colonist_identity_msg ?>"/>
						                        		</td>
						                        	</tr>
<!--
						                        	<tr>
						                        		<td> Termos gerais </td>
						                        		<td> 
						                        			<input type="checkbox" name="terms_and_conditions" value="ok" /> Ok 
						                        		</td>
						                        		<td>
						                        			<input type="text" name="msg_terms_and_conditions" class="form-control"/>
						                        		</td>
						                        	</tr>
-->
						                        	<tr>
						                        		<td> Foto 3x4 </td>
						                        		<td> 
						                        			<input type="checkbox" name="picture" value="ok" <?= (isset($colonist->colonist_picture_ok) && $colonist->colonist_picture_ok == "t")?"checked":"" ?> /> Ok 
						                        		</td>
						                        		<td>
						                        			<input type="text" name="msg_picture" class="form-control" value="<?= $colonist->colonist_picture_msg ?>"/>
						                        		</td>
						                        	</tr>
						                        </tbody>
		                            		</table>

		                            		<input type="submit" class="btn btn-primary" onClick="closeValidationTab(<?=$colonist->colonist_id?>, <?=$colonist->summer_camp_id?>)" value="Salvar" />
		                            	</form>
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