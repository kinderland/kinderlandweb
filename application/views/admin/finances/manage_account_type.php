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
			var account_type_name = $("#account_type_name").val();
			var missing = "";
			var error = ""; 

			if(account_type_name == "")
				missing = missing.concat("Nome da Categoria\n");

			if(account_type_name != ""){
				var name = account_type_name.split("");
				if(name.length > 50){
					error = error.concat("Nome da Categoria não pode ter mais que 50 caracteres\n");
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
				
				$.post("<?php  echo $this->config->item('url_link');?>admin/checkIfAccountTypeNameExists", {account_type_name: account_type_name}, 
				function(data){
					if(data==true){						
						$.post("<?= $this->config->item('url_link');?>admin/newAccountTypeName",{account_type_name: account_type_name},
							function(data){
								if(data){
									alert("Categoria criada com sucesso!");
									location.reload();	
								}
								else{
									alert("Houve um erro na criação da Categoria. Tente novamente!");	
								}
							});
					}
					else{
						
						alert("A Categoria já existe. Tente Novamente com outro nome.");
					}
				});
			}
		}

		function deleteAccountTypeName(account_type_id){
			
			$.post("<?php  echo $this->config->item('url_link');?>admin/checkIfAccountTypeNameIsInUse", {account_type_id: account_type_id}, 
					function(data){
						if(data==true){						
							$.post("<?= $this->config->item('url_link');?>admin/deleteAccountTypeName",{account_type_id: account_type_id},
								function(data){
									if(data){
										alert("Categoria excluída com sucesso!");
										location.reload();	
									}
									else{
										alert("Houve um erro na exclusão da Categoria. Tente novamente!");	
									}
								});
						}
						else{
							
							alert("Categoria já está sendo usada. Ela não pode ser excluída.");
						}
					});
		}
		
        </script>
        <div class="scroll">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
								Nova Categoria
							</button>
                <div class = "row">
                    <div class="col-lg-12 middle-content">
                        <table class="table table-bordered table-striped table-min-td-size" style="width:300px" id="sortable-table">
                            <thead>
                                <tr>
                                    <th> Nome </th>
                                    <th> Ação </th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                                <?php                                
                                if($accountTypes){
                                foreach ($accountTypes as $a) {
                                    ?>
                                    <tr>
                                        <td><?= $a->name ?></td>
                                        <td><button type="button" class="btn btn-danger" onclick="deleteAccountTypeName('<?= $a->account_type_id?>')">Excluir</button></td>
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
					<h4 class="modal-title" id="create_account_type_name">Criar Categoria</h4>
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
											<label for="account_type_name" style="width: 170px; margin-bottom:0px; margin-top:7px; padding-right:0px" class="col-lg-1 control-label"> Nome da Categoria*: </label>
											<div style="width: 350px; padding-left:0px" class="col-lg-2 control-label">
												<input  style="width: 360px" type="text" class="form-control" placeholder="Nome da Categoria"
													name="account_type_name" value="<?php echo $account_type_name; ?>" id="account_type_name" />
											</div>
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