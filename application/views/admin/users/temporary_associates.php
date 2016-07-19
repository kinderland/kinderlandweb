<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css"
              rel="stylesheet" />
      <!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css"
              rel="stylesheet" />
        <link rel="stylesheet"
              href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet"
              href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css">
        <link rel="stylesheet"
              href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
        <script type="text/javascript"
        src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>

    </head>
    <script>

    function temporaryAssociateDelete(associate_id){

        if(confirm("Tem certeza que deseja excluir?")){

	    	$.post('<?= $this->config->item('url_link'); ?>admin/deleteTemporaryAssociate',
	                {associate_id: associate_id},
	                function (data) {
	                    if (data == "true") {
	                        alert("CPF indicado excluído com sucesso");
	                        location.reload();
	                    } else if (data == "false") {
	                        alert("Ocorreu um erro na exclusão do CPF indicado!");
	                        location.reload();
	                    }
	                }
	        );
        }

    }

    function temporaryAssociateUpdate(associate_id,type){
        
		var cpf = document.getElementById("cpf").value;

		$.post('<?= $this->config->item('url_link'); ?>admin/checkCPF',
                    {cpf: cpf},
                    function (data) {
                        if(data == "true"){
                            var name = <?php echo json_encode($name);?>;
                            $.post('<?= $this->config->item('url_link'); ?>admin/checkSubscription',
                                    {associate_id: associate_id},
                                    function (data) {
                                        if(data == "true"){
				                            if(confirm("Deseja indicar ".concat(name[cpf]," para realizar pré-inscrição?"))){
				                            	$.post('<?= $this->config->item('url_link'); ?>admin/updateTemporaryAssociate',
				                                        {cpf: cpf, associate_id: associate_id, type:type},
				                                        function (data) {
				                                            if (data == "true") {
				                                                alert("CPF indicado Cadastrado com sucesso");
				                                                location.reload();
				                                            } else if (data == "false") {
				                                                alert("Ocorreu um erro no cadastro do CPF indicado!");
				                                                location.reload();
				                                            }
				                                        }
				                                );
				
				                            }
                                        }else if(data == "false"){
                                            alert("Para indicar um CPF, o sócio não pode realizar pré-inscrições este ano. Caso deseje indicar, exclua suas pré-inscrições");

                                        }
                                    }
                               );
                        }
                        else if(data == "false"){
                            alert("Esse CPF não está cadastrado no site ou é inválido para o processo. Tente novamente!");
                        }
                    }
         );	
	}

    function validateNumberInput(evt) {

        var key_code = (evt.which) ? evt.which : evt.keyCode;
        if ((key_code >= 48 && key_code <= 57) || key_code == 9 || key_code == 8) {
            return true;
        }
        return false;
    }

    </script>
    
    
    
    <body>
    
    <div class="row">
    <?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
    
    <div class="col-lg-10 middle-content">
    	<h2>Indicar CPF</h2>
    	
   		<h4><p>Ao indicar um CPF, o sócio nao poderá realizar pré-inscricões e o indicado só poderá realizar uma única pré-inscricão.</p></h4>
    
    	<div class = "row">
                    <div class="col-lg-12 middle-content">
                        <table class="table table-bordered table-striped table-min-td-size" style="width: 500px" id="sortable-table">
                            <thead>
                                <tr>
                                	<?php if($temporaryAssociate){?>
                                    <th style="width:200px; text-align: center" > Nome </th>
                                    <?php }?>
                                    <th colspan=2 style="width:400px; text-align: center">Cadastro</th>
                                </tr>
                                <tr>
                                	<?php if($temporaryAssociate){?>
                                	<th></th>
                                	<?php }?>
                                	<th style="width:100px; text-align: center">CPF</th>
                        			<th style="width:200px; text-align: center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                            		<?php if($temporaryAssociate){?>
                            		<td><?= $temporaryAssociate->fullname?></td>
                            		<?php }?>
                                    <td>
                                    	<input style="width:110px;"type="text" name = "cpf" maxlength="11" onkeypress="return validateNumberInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')" id="cpf" value="<?php if ($temporaryAssociate) echo $temporaryAssociate->cpf; else echo ""; ?>">
									
									</td>
									<?php if ($temporaryAssociate) {?>
                                        <td><button class="btn btn-success" onclick="temporaryAssociateUpdate('<?= $temporaryAssociate->associate_id ?>','atualizar')">Atualizar</button>
                                        <button class="btn btn-danger" onclick="temporaryAssociateDelete('<?= $this->session->userdata("user_id") ?>')">Excluir</button>
                                        </td>
                                    <?php } else { ?>
                                        <td><button class="btn btn-danger" onclick="temporaryAssociateUpdate('<?= $this->session->userdata("user_id") ?>','salvar')">Salvar</button></td>
                                    <?php } ?>
                            
                            </tbody>
                            
                          </table>
                          
                       </div>
                       
                     </div>
                     </div>
             </div>
    
    </body>
</html>