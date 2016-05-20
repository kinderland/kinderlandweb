<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css" rel="stylesheet" />
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css">
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>datatable/js/datatable.min.js"></script>
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>datatable/css/datatable-bootstrap.min.css" />


    </head>
    <body>
        <script>
        $(function() {
            $(".sortable-table").tablesorter();
            $(".datepicker").datepicker();
        });

        function validateFormInfo(){
			var account_name = $("#account_name").val();
			var account_type = $("#account_type").val();
			var account_description = $("#account_description").val();
			var missing = "";
			var error = ""; 

			if(account_name == "")
				missing = missing.concat("Nome de Conta\n");
			if(account_type == "")
				missing = missing.concat("Categoria\n");
			if(account_description == "")
				missing = missing.concat("Descrição\n");

			if(account_name != ""){
				var name = account_name.split("");
				if(name.length > 30){
					error = error.concat("Nome de Conta não pode ter mais que 30 caracteres\n");
				}
			}

			if(account_description != ""){
				var description = account_description.split("");
				if(description.length > 50){
					error = error.concat("Descrição não pode ter mais que 50 caracteres\n");
				}
			}	

			if(missing != "" || error != "") {
				if(missing != "" && error != ""){
					alert("Os seguintes campos precisam ser preenchidos:\n\n".concat(missing).concat("\nOs seguintes campos apresentaram um erro:\n\n").concat(error));
				}else if(missing != "" && error == ""){
					alert("Os seguintes campos precisam ser preenchidos:\n\n".concat(missing));
				}else if(error != "" && missing == ""){
					alert("\nOs seguintes campos apresentaram um erro:\n\n".concat(error));
				}
			}
						
			else{
				
				$.post("<?php  echo $this->config->item('url_link');?>admin/checkIfAccountNameExists", {account_name: account_name}, 
				function(data){
					if(data==true){						
						$.post("<?= $this->config->item('url_link');?>admin/newAccountName",{account_name: account_name, account_type: account_type, account_description: account_description},
							function(data){
								if(data){
									alert("Nome de Conta criado com sucesso!");
									location.reload();	
								}
								else{
									alert("Houve um erro na criação do Nome de Conta. Tente novamente!");	
								}
							});
					}
					else{
						
						alert("O Nome de Conta já existe. Tente Novamente com outro nome.");
					}
				});
			}
		}

		function deleteAccountName(account_name){
			
			$.post("<?php  echo $this->config->item('url_link');?>admin/checkIfAccountNameIsInUse", {account_name: account_name}, 
					function(data){
						if(data==true){						
							$.post("<?= $this->config->item('url_link');?>admin/deleteAccountName",{account_name: account_name},
								function(data){
									if(data){
										alert("Nome de Conta excluído com sucesso!");
										location.reload();	
									}
									else{
										alert("Houve um erro na exclusão do Nome de Conta. Tente novamente!");	
									}
								});
						}
						else{
							
							alert("O Nome de Conta já está sendo usado. Ele não pode ser excluído.");
						}
					});
		}
		
        </script>
        <div class="scroll">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
								Novo Nome de Conta
							</button>
                <div class = "row">
                    <div class="col-lg-12 middle-content">
                        <table class="table table-bordered table-striped table-min-td-size" style="width:600px" id="sortable-table">
                            <thead>
                                <tr>
                                    <th> Nome </th>
                                    <th> Descrição </th>
                                    <th> Categoria </th>
                                    <th> Ação </th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                                <?php                                
                                if($accounts){
                                foreach ($accounts as $a) {
                                    ?>
                                    <tr>
                                        <td><?= $a->account_name ?></td>
                                        <td><?= $a->account_description ?></td>
                                        <td><?= $a->account_type ?></td>
                                        <td><button type="button" class="btn btn-danger" onclick="deleteAccountName('<?= $a->account_name?>')">Excluir</button></td>
                                    </tr>
                                    <?php
                                }}
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
   <!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="solicitar-convite" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="create_account_name">Criar Nome de Conta</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 middle-content">
								<div class="row">
									
								</div>

								<div>
								</div>
																
								<div name="form_subscribe" id="form_subscribe">
									<div class="row">
										<div class="form-group">
											<label for="account_name" style="width: 150px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Nome da Conta*: </label>
											<div style="width: 350px; padding-left:0px" class="col-lg-2 control-label">
												<input  style="width: 360px" type="text" class="form-control" placeholder="Nome da Conta"
													name="account_name" value="<?php echo $account_name; ?>" id="account_name" />
											</div>
											</div>
											</div>
											<br />
											<div class="row">
											<div class="form-group">
											<label style="width: 100px;margin-bottom:0px; margin-top:7px; padding-right:0px" for="account_type" class="col-lg-1 control-label"> Categoria*: </label>
											<div style="width: 360px;" class="col-lg-2 control-label">
												<select  class="form-control" id="account_type" name="account_type">
													<option value="" selected>-- Selecione --</option>
													<?php
														if($accountTypes){
									                    foreach ($accountTypes as $at) {
									                        echo "<option $selected value='$at->account_type_id'>".$at->name."</option>";
									                    }}
									                 ?>
												</select>
											</div>
										</div>
									</div>
									<br />

									<div class="row">
										<div class="form-group">
											<label for="account_description" style="width: 100px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Descrição*: </label>
											
												<input  style="width: 300px" type="text" class="form-control" placeholder="Descrição"
													name="account_description" value="<?php echo $account_description; ?>" id="account_description" />
											</div>
											</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
						<button type="button" class="btn btn-primary" onClick="validateFormInfo()">Confirmar</button>
					</div>
				</div>
			</div>
		</div>
		
<!-- Fim do Modal -->
    </body>
</html>