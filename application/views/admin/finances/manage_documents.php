
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

	<?php if($message){?>
		alert('<?php echo $message;?>');
		<?php }?>


		function sendInfoToModal(colonistName, campName, userName, situation, colonistId, summerCampId, discount){
    		$("#colonist_name").html(colonistName);
    		$("#camp_name").html(campName);
    		$("#user_name").html(userName);
    		$("#situation").html(situation);
    		$("#colonist_id").html(colonistId);
    		$("#summer_camp_id").html(summerCampId);
    		$("#discount").html(discount);
        }
</script>

    <body>
        <div class="scroll">
            <div class="row">
                <?php // require_once APPPATH.'views/include/common_user_left_menu.php'  ?>
                <div class="col-lg-12 middle-content">
                    <a href="<?= $this->config->item("url_link") ?>admin/create_document" >
                        <button id="create" class="btn btn-primary"  value="Criar novo documento" >Criar novo documento</button>
                    </a>
                    <br /><br />
                    <?php
                    if (isset($documents) && count($documents) > 0) {
                        ?>
                        <table class="table"><tr><th>Data</th><th>Tipo</th><th>Valor</th><th>Update de imagem</th><th>Forma de pagamento</th></tr>
                                    <?php
                                    foreach ($documents as $document) {
                                        ?>
                                        
                            <tr>
                                <td>
                                       <?= date_format(date_create($document->getDocumentExpenseDate()), 'd/m/y'); ?></td>

                                <td><?php echo $document->getDocumentExpenseType(); ?> </td>
                                <td><?php echo $document->getDocumentExpenseValue(); ?> </td>
                                <td><?php echo $document->getDocumentExpenseUploadId(); ?> </td>
                                <td><button class="btn btn-primary" onclick="sendInfoToModal()" data-toggle="modal" data-target="#myModal">Pagar</button></td>
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
								<form name="form_password" method="POST" action="<?=$this->config->item('url_link')?>admin/password" id="form_password">	                                         
										<div class="row">
											<div class="form-group">
												<div class="col-lg-6">
												
												
													<input type="hidden" id="colonist_id" name="colonist_id" value="" />
                                                    <input type="hidden" id="discount" name="discount" value="" />
                                                    <input type="hidden" id="summer_camp_id" name="summer_camp_id" value="" />
                                                    													
													<tr>
                                                        <td> Forma de pagamento:</td> 
                                                          <form method="GET">
                   											 <select name="formapagamento_f" id="formaspagamento">
									
									                            <?php
									                            foreach ($formaspagamento as $formapagamento) {
									                                $selected = "";
									                                if ($formapagamento_escolhido == $formapagamento)
									                                    $selected = "selected";
									                                echo "<option $selected value='$formapagamento'>$formapagamento</option>";
									                            }
									                            ?>
	                       									</select>
                                                    </tr>                                        
                                                    <br><br>
                                                    <tr>
                                                        <td> Beneficiário: </td>
                                                    </tr>
                                                     <tr>
                                                        <td> Nome: </td>
                                                        <input id='beneficiary_name'></input> <br>
                                                    </tr>

                                                    <tr>
                                                        <td> CNPJ/CPF: </td>
                                                        <input id='beneficiary_dnumber' name="beneficiary_dnumber"></input> <br>
                                                    </tr>

                                                    <tr>
                                                        <td> Telefone: </td>
                                                        <input id='beneficiary_phone'></input> <br><br>
                                                  
                                                    
                        <table class="table"><tr><th>Banco</th><th>Agência</th><th>Conta</th><th> X </th></tr>
                                    <?php
                                    foreach ($documents as $document) {
                                        ?><tr>
                                <td><a href="<?php echo $this->config->item("url_link"); ?>admin/editDocument/<?php echo $document->getDocumentId() ?>">
                                       <?= date_format(date_create($document->getDocumentExpenseDate()), 'd/m/y'); ?></a></td>

                                <td><?php echo $document->getDocumentExpenseType(); ?> </td>
                                <td><?php echo $document->getDocumentExpenseValue(); ?> </td>
                                <td><?php echo $document->getDocumentExpenseUploadId(); ?> </td>
                                <td><button class="btn btn-primary" onclick="sendInfoToModal()" data-toggle="modal" data-target="#myModal">Cancelar</button></td>
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

