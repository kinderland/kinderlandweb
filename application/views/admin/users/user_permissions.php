<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>ColÃ´nia Kinderland</title>

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
    <style>
    div.scroll{
    	
    	width:100%;
    	height:100%;
    	overflow-x:hidden;
    
    }
    
    .botao {
	    background-color: #428bca;
	    border: none;
	    color: white;
	    padding: 8px 8px;
	    text-align: center;
	    text-decoration: none;
	    display: inline-block;
	    font-size: 10px;
	    margin: 4px 2px;
	    cursor: pointer;
	}

	
	.disabled {
	    opacity: 0.6;
	    
	}

    
    </style>
    <body>
        <script type="text/javascript">


        function post(path, params, method) {
            method = method || "post"; // Set method to post by default if not specified.

            // The rest of this code assumes you are not using a library.
            // It can be made less wordy if you use one.
            var form = document.createElement("form");
            form.setAttribute("method", method);
            form.setAttribute("action", path);

            for (var key in params) {
                if (params.hasOwnProperty(key)) {
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", key);
                    hiddenField.setAttribute("value", params[key]);
                    form.appendChild(hiddenField);
                }
            }

            document.body.appendChild(form);
            form.submit();
        }
                

        	function prepareModal(personId) {
				var users = <?= print_r(json_encode($users), true) ?>;
				var admins = 0; var selectedIsAdmin = false;
				for(var i=0;i<users.length;i++){
			        var user = users[i];
			        if (user['system_admin']==1)
			        	admins++;

			        if (user['person_id'] == personId){
			        	$("#modal_title").text("PermissÃµes concedidas a " + user['fullname']);

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
				var person_id = document.getElementById("person_id").value;	
				if(document.getElementById("system_admin").checked)
					var system_admin = document.getElementById("system_admin").value;
				//alert(system_admin);
				if(document.getElementById("director").checked)
					var director = document.getElementById("director").value;
				//alert(director);
				if(document.getElementById("doctor").checked)
					var doctor = document.getElementById("doctor").value;
				//alert(doctor);
				if(document.getElementById("monitor_instructor").checked)
					var monitor_instructor = document.getElementById("monitor_instructor").value;
				//alert(monitor_instructor);
				if(document.getElementById("secretary").checked)
					var secretary = document.getElementById("secretary").value;
				//alert(secretary);
				if(document.getElementById("coordinator").checked)
					var coordinator = document.getElementById("coordinator").value;
				//alert(coordinator);
				$.post("<?= $this->config->item('url_link'); ?>admin/updatePersonPermissions",
                        {person_id: person_id, system_admin: system_admin, director: director, doctor: doctor, monitor_instructor: monitor_instructor, secretary: secretary, coordinator: coordinator},
                        function (data) {
                            if (data == "true") {
                                alert("Permissão atualizada");
                                location.reload();
                            } else if (data == "false") {
                                alert("Erro na atualização da permissão");
                                location.reload();
                            }

                        }
                        
                );
				
				
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
        <div class="scroll">
        	<div class="main-container-report">
            	<div class = "row">
                	<div class="col-lg-12">
                	<div>
                	
                	
                	<form id="form_selection" method="GET">
							<?php if($letter_chosen == ""){?>
							<th><button name="letter_chosen" class = "botao" onchange="this.form.submit()" value=""id="letra">Todos</button>
							<?php }else{ ?>
								<th><button name="letter_chosen" class = "botao disabled" onchange="this.form.submit()" value=""id="letra">Todos</button>
							<?php }?>
							<?php foreach($letters as $letter){
								if(strcmp($letter,$letter_chosen) == 0) {?>
									<th><button name="letter_chosen" class ="botao" id="letra<?php echo $letter?>" onchange="this.form.submit()" value="<?php echo $letter?>"> <?php echo $letter?></button></th>
							<?php } else{ ?>
								<th><button name="letter_chosen" class ="botao disabled" id="letra<?php echo $letter?>" onchange="this.form.submit()"  value="<?php echo $letter?>"> <?php echo $letter?></button></th>
								
						<?php 	}}?>



						
					</form>
						

                	
                	
                	

                	
                	</div>
                	</div>
                    <table class="table table-bordered table-striped table-min-td-size" style="width: 1000px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Nome </th>
                                <th> Administrador </th>
                                <th> Diretor </th>
                                <th> SecretÃ¡ria </th>
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
													<input type="checkbox" id="system_admin" name="system_admin" <?= ($user->system_admin)?"checked":""?> /> Administrador <br /><br />
				                                    <input type="checkbox" id="director" name="director" <?=($user->director)?"checked":""?> /> Diretor <br /><br />
				                                    <input type="checkbox" id="secretary" name="secretary" <?=($user->secretary)?"checked":""?> /> SecretÃ¡ria <br /><br />
				                                    <input type="checkbox" id="coordinator" name="coordinator" <?=($user->coordinator)?"checked":""?> /> Coordenador <br /><br />
				                                    <input type="checkbox" id="doctor" name="doctor"  <?=($user->doctor)?"checked":""?> /> MÃ©dico <br /><br />
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
     </div>   
    </body>
</html>