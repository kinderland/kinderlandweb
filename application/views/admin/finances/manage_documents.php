
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
$(function() {
    $("#sortable-table").tablesorter({widgets: ['zebra']});
    $(".datepicker").datepicker();
});

$( document ).ready(function() {
	  $("[name='my-checkbox']").bootstrapSwitch();
	  $("[name='my-checkbox']").each(function( index ) {
	  	if($(this).attr("checkedInDatabase") != undefined)
	  		$(this).bootstrapSwitch('state', true, true);
	  });
	  $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
	    var string = "<?=$this->config->item("url_link")?>finances/toggleEnable/".concat($(this).attr("id"));
	    var recarrega = "<?=$this->config->item("url_link")?>admin/manageDocuments/";
	    $.post( string ).done(function( data ) {
	        if(data == 1)
			    alert( "Documento modificado com sucesso" );
			else{
				alert( "Problema ao modificar o estado do documento" );
				window.location=recarrega;
			}
			});
	  });
	});



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
		
		function sendInfoToModal(documentExpenseId, dateNow){
			alert("Oi");
			$("#documentexpenseId").html(documentExpenseId);
			$("#dateNow").html(dateNow);
        }
</script>

    <body>
        <div class="scroll">
            <div class="row">
                <?php // require_once APPPATH.'views/include/common_user_left_menu.php'  ?>
                <div class="col-lg-12 middle-content">

                    <a href="<?= $this->config->item("url_link") ?>admin/documentCreate" >

                    <a href="<?= $this->config->item("url_link") ?>admin/createDocument" >

                        <button id="create" class="btn btn-primary"  value="Criar novo documento" >Criar novo documento</button>
                    </a>
                    <br /><br />
                    <?php
                    if (isset($documents) && count($documents) > 0) {
                        ?>
                        <table class="table"><tr><th>Data</th><th>Tipo</th><th>Valor</th><th>Update de imagem</th><th>Forma de pagamento</th></tr>
                        
                        
                         		<script>
									function formaPagamento(){
									
										var documentexpenseId = document.getElementById("documentexpenseId").textContent;
										
								 		var postingDate = document.getElementById("dateNow").textContent;
								 		var postingValue = document.getElementById("postingValue").value;
								 		var postingType = document.getElementById("postingType").value;
								 		alert(postingType);
								 		var accountName = "aluguel";
								 		var portions = 1;
								 		

								 		$.post('<?= $this->config->item('url_link');?>admin/postingExpense',
			            						{documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, accountName: accountName, portions: portions},
			            						function(data){
			            							if(data=="true"){
			            								alert("Pagamento cadastrado com sucesso!");
			            								location.reload();
			            							}
			            							else if(data == "false"){
			            								alert("Não foi possível cadastrar o pagamento!");
			            								location.reload();
			            							}
			            						}
			            				);		



									}

                        		</script>                       	
                        

                                    <?php
                                    foreach ($documents as $document) {
                                        ?>
                                        
                            <tr>
                                <td>
                                       <?= date_format(date_create($document->documentexpenseDate), 'd/m/y'); ?></td>

                                <td><a href="<?php echo $this->config->item("url_link"); ?>admin/editDocument/<?php echo $document->documentexpenseId ?>">
                                    <?php echo $document->documentexpenseType; ?></a> </td>
                                <td><?php echo $document->documentexpenseValue; ?> </td>
                                <td><?php echo $document->documentexpenseUploadId; ?> </td>
                                <?php if($document->paid == false){?>
                                <td><button class="btn btn-primary" onclick="sendInfoToModal('<?= $document->documentexpenseId ?>', '<?= date('Y-m-d') ?>')" data-toggle="modal" data-target="#myModal">Pagar</button></td>
                                <?php } else {?>
                                <td> Pago </td>
                                <?php }?>
                                </tr>
                                <?php
                            }
                            ?> </table>
                        <?php
                    } else {
                        ?>
                        <h3>
                            Nenhum documento registrado.
                        </h3>
                        <?php
                    }
                    
                    
                    
                    ?>
                    
                    
                </div>
                </div>
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
								<form name="form_postingExpense" method="POST" action="<?=$this->config->item('url_link')?>admin/postingExpense" id="form_postingExpense">	                                         
										<div class="row">
											<div class="form-group">
												<div class="col-lg-6">
												
												<td> Forma de pagamento:</td> 
                                                          <form method="GET">
                   											 <select name="postingType" id="postingType">
									
									                            <option value="Crédito"  >Crédito</option>
											                    <option value="Dinheiro" >Dinheiro</option>  
											                    <option  value="Débito">Débito</option>  
											                    <option value="boleto">Boleto</option> 
											                    <option value="no_select">--Selecione-- </option>
											                </select>
												
													<input type="hidden" id="documentexpenseId" name="documentexpenseId" value="" />
                                                    <input type="hidden" id="dateNow" name="dateNow" value="" />	
                                                    <input type="hidden" id="postingType" name="postingType" value="<?php echo $selected; ?>" >												
													<tr>
                                                                                               
                                                    <br><br>
                                                    <tr> 
                                                    	<td> Valor: </td>
                                                    	<input type="text" id="postingValue" name="postingValue" ></input> <br>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td> Beneficiário: </td>
                                                    </tr>
                                                     <tr>
                                                        <td> Nome: </td>
                                                        <input type="text" id="beneficiary_name"></input> <br>
                                                    </tr>

                                                    <tr>
                                                        <td> CNPJ/CPF: </td>
                                                        <input type="text" id="beneficiary_dnumber" name="beneficiary_dnumber"></input> <br>
                                                    </tr>

                                                    <tr>
                                                        <td> Telefone: </td>
                                                        <input type="text" id="beneficiary_phone"></input> <br><br>
                                                  
                                                    
                        <table class="table"><tr><th>Banco</th><th>Agência</th><th>Conta</th><th> X </th></tr>
                                    <?php
                                    foreach ($banks as $bank) {
                                        ?><tr>
								<input type="hidden" id="person_id" name="person_id" value="" />
                                <td><?php echo $bank->getBankNumber(); ?> </td>
                                <td><?php echo $bank->getBankAgency(); ?> </td>
                                <td><?php echo $bank->getAccountNumber(); ?> </td>
                                <td><input type="checkbox" id="account_selected" name="account_selected" <?= ($bank->getBankDataId())?"checked":""?> /></td>

                                </tr>
                                <?php
                            }	
                            ?> </table>
													
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-warning" data-dismiss="modal">Fechar</button>
							<button class="btn btn-warning" onClick="formaPagamento()">Confirmar</button>

					</div>
				</div>
			</div>
        </div>
                </body>
            </div>
        </div>
    </div>
</body>
</html>

