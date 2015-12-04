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
        <script>

        	function prepareModal(personId) {
				var users = <?= print_r(json_encode($users), true) ?>;
				var admins = 0; var selectedIsAdmin = false;
				for(var i=0;i<users.length;i++){
			        var user = users[i];
			        if (user['system_admin']==1)
			        	admins++;

			        if (user['person_id'] == personId){
			        	$("#modal_title").text("Permissões concedidas a " + user['fullname']);

			        	$("#person_id").val(user['person_id']);
			        	$("#system_admin").prop('checked', user['system_admin']==1);
			        	$("#director").prop('checked', user['director']==1);
			        	$("#coordinator").prop('checked', user['coordinator']==1);
			        	$("#doctor").prop('checked', user['doctor']==1);
			        	$("#secretary").prop('checked', user['secretary']==1);
			        	$("#monitor_instructor").prop('checked', user['monitor_instructor']==1);
			        	if (user['system_admin']==1)
			        		selectedIsAdmin = true;
			        }
			    }
			    if(admins < 2 && selectedIsAdmin)
			    	$("#system_admin").attr('disabled', true);
			    else
			    	$("#system_admin").attr('disabled', false);

			}

			function updatePersonPermissions() {
				$("#form_update_permissions").submit();
			}

			$( document ).ready(function() {
				$('#sortable-table').datatable({
						pageSize:         Number.MAX_VALUE,
						sort: [function (l, r) { return l.toLowerCase().localeCompare(r.toLowerCase()); 
					}, true, true, true, true, true, true],
					filters: [true],
					filterText: 'Escreva para filtrar... '
				});
			});
			
        </script>
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 600px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Nome </th>
                                <th> Administrador </th>
                                <th> Diretor </th>
                                <th> Secretária </th>
                                <th> Coordenador </th>
                                <th> Médico </th>
                                <th> Monitor </th>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php
                            	foreach ($users as $user) {
                            ?>
                                <tr>
                                    <td><a onclick="prepareModal(<?=$user->person_id ?>)" data-toggle="modal" data-target="#myModal"><?= $user->fullname ?></a></td>
                                    <td><input type="checkbox" disabled <?=($user->system_admin)?"checked":""?> /></td>
                                    <td><input type="checkbox" disabled <?=($user->director)?"checked":""?> /></td>
                                    <td><input type="checkbox" disabled <?=($user->secretary)?"checked":""?> /></td>
                                    <td><input type="checkbox" disabled <?=($user->coordinator)?"checked":""?> /></td>
                                    <td><input type="checkbox" disabled <?=($user->doctor)?"checked":""?> /></td>
                                    <td><input type="checkbox" disabled <?=($user->monitor_instructor)?"checked":""?>/></td>
                                </tr>
                            <?php
								}
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="solicitar-convite" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="modal_title"></h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-6 middle-content">
									<form name="form_update_permissions" method="POST" action="<?=$this->config->item('url_link')?>admin/updatePersonPermissions" id="form_update_permissions">
										
										<div class="row">
											<div class="form-group">
												<div class="col-lg-6">
													<input type="hidden" id="person_id" name="person_id" value="" />
													<input type="checkbox" id="system_admin" name="system_admin" <?=($user->system_admin)?"checked":""?> /> Administrador <br /><br />
				                                    <input type="checkbox" id="director" name="director" <?=($user->director)?"checked":""?> /> Diretor <br /><br />
				                                    <input type="checkbox" id="secretary" name="secretary" <?=($user->secretary)?"checked":""?> /> Secretária <br /><br />
				                                    <input type="checkbox" id="coordinator" name="coordinator" <?=($user->coordinator)?"checked":""?> /> Coordenador <br /><br />
				                                    <input type="checkbox" id="doctor" name="doctor" <?=($user->doctor)?"checked":""?> /> Médico <br /><br />
				                                    <input type="checkbox" id="monitor_instructor" name="monitor_instructor" <?=($user->monitor_instructor)?"checked":""?>/> Monitor/Instrutor
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
							<button type="button" class="btn btn-primary" onClick="updatePersonPermissions()">Salvar</button>
						</div>
					</div>
				</div>
			</div>
        </div>
    </body>
</html>