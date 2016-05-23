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
        $(function () {
            $("#sortable-table").tablesorter({widgets: ['zebra']});
            $(".datepicker").datepicker();
        });
        $(document).ready(function () {
            $("[name='my-checkbox']").bootstrapSwitch();
            $("[name='my-checkbox']").each(function (index) {
                if ($(this).attr("checkedInDatabase") != undefined)
                    $(this).bootstrapSwitch('state', true, true);
            });
            $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function (event, state) {
                var string = "<?= $this->config->item("url_link") ?>finances/toggleEnable/".concat($(this).attr("id"));
                var recarrega = "<?= $this->config->item("url_link") ?>admin/manageDocuments/";
                $.post(string).done(function (data) {
                    if (data == 1)
                        alert("Documento modificado com sucesso");
                    else {
                        alert("Problema ao modificar o estado do documento");
                        window.location = recarrega;
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

        function sendInfoToModal(documentExpenseId, dateNow) {
            $("#documentexpenseId").html(documentExpenseId);
            $("#dateNow").html(dateNow);
        }
    </script>

    <body>
        <div class="scroll">
            <div class="row">
                <?php // require_once APPPATH.'views/include/common_user_left_menu.php'  ?>
                <div class="col-lg-12 middle-content">

                    <a href="<?= $this->config->item("url_link") ?>admin/createDocument" >

                        <button id="create" class="btn btn-primary"  value="Criar novo documento" >Novo lançamento</button>
                    </a>

             
                    <br /><br />
                    <?php
                    if (isset($documents)) {
                        ?>
                        <table class="table"><tr><th>Data</th><th>Tipo</th><th>Valor</th><th>Imagem</th><th>Forma de pagamento</th></tr>


                            <script>
                                function formaPagamento() {

                                    var documentexpenseId = document.getElementById("documentexpenseId").textContent;

                                    var postingDate = document.getElementById("dateNow").textContent;
                                    var postingValue = document.getElementById("postingValue").value;
                                    var postingType = document.getElementById("postingType").value;
                                    
                                    alert(postingType);
                                    var accountName = "aluguel";
                                    if(postingType == "Crédito"){
                                    	var portions = document.getElementById("atributoChave").value;
                                    	alert(portions);
                                    }

                                    
                                    	
	
                                    $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                                            {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, accountName: accountName, portions: portions},
                                            function (data) {
                                                if (data == "true") {
                                                    alert("Pagamento cadastrado com sucesso!");
                                                    location.reload();
                                                } else if (data == "false") {
                                                    alert("Não foi possível cadastrar o pagamento!");
                                                    location.reload();
                                                }
                                            }
                                    );
                                }


                                function paymentType() {
                                    var type = document.getElementById("postingType").value;
                                    
                                    if(type == "Boleto"){
                                    	document.getElementById("Cheque").style.display = "none";
                                    	document.getElementById("Crédito").style.display = "none";
                                    	document.getElementById("Débito").style.display = "none";
                                    	document.getElementById("Dinheiro").style.display = "none";
                                    	document.getElementById("Transferência").style.display = "none";
                                    	
                                    	document.getElementById("Boleto").style.display = ""; 
                                    	                                   	
                                    }else if(type == "Cheque"){
                                    	document.getElementById("Boleto").style.display = "none";
                                    	document.getElementById("Crédito").style.display = "none";
                                    	document.getElementById("Débito").style.display = "none";
                                    	document.getElementById("Dinheiro").style.display = "none";
                                    	document.getElementById("Transferência").style.display = "none";
                                    	
                                    	document.getElementById("Cheque").style.display = ""; 
                                    	
                                    }else if(type == "Crédito"){
                                    	document.getElementById("Boleto").style.display = "none";
                                    	document.getElementById("Cheque").style.display = "none";
                                    	document.getElementById("Débito").style.display = "none";
                                    	document.getElementById("Dinheiro").style.display = "none";
                                    	document.getElementById("Transferência").style.display = "none";
                                    	
                                    	document.getElementById("Crédito").style.display = ""; 
                                    	
                                    }else if(type == "Débito"){
                                    	document.getElementById("Boleto").style.display = "none";
                                    	document.getElementById("Cheque").style.display = "none";
                                    	document.getElementById("Crédito").style.display = "none";
                                    	document.getElementById("Dinheiro").style.display = "none";
                                    	document.getElementById("Transferência").style.display = "none";
                                    	
                                    	document.getElementById("Débito").style.display = ""; 
                                    	
                                    }else if(type == "Dinheiro"){
                                    	document.getElementById("Boleto").style.display = "none";
                                    	document.getElementById("Cheque").style.display = "none";
                                    	document.getElementById("Crédito").style.display = "none";
                                    	document.getElementById("Débito").style.display = "none";
                                    	document.getElementById("Transferência").style.display = "none";
                                    	
                                    	document.getElementById("Dinheiro").style.display = ""; 
                                    	
                                    }else if(type == "Transferência"){
                                    	document.getElementById("Boleto").style.display = "none";
                                    	document.getElementById("Cheque").style.display = "none";
                                    	document.getElementById("Crédito").style.display = "none";
                                    	document.getElementById("Débito").style.display = "none";
                                    	document.getElementById("Dinheiro").style.display = "none";
                                    	
                                    	document.getElementById("Transferência").style.display = ""; 
                                    	
                                    }
                                    
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
                                    <td><a href="<?php echo $this->config->item("url_link"); ?>admin/viewDocumentUpload?document_id=<?php echo $document->documentexpenseId;?>">
                                        <button class="btn btn-primary"><?php
                                        if ($document->documentexpenseUploadId) {
                                            echo "Visualizar";
                                        } else {
                                            echo "Upload";
                                        }
                                        ?> 
                                        </button>
                                        </a>
                                    </td>
                                    <?php if ($document->paid == false) { ?>
                                        <td><button class="btn btn-primary" onclick="sendInfoToModal('<?= $document->documentexpenseId ?>', '<?= date('Y-m-d') ?>')" data-toggle="modal" data-target="#myModal">Pagar</button></td>
                                    <?php } else { ?>
                                        <td> Pago </td>
                                    <?php } ?>
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
                                <h4 class="modal-title" id="modal_title">Forma de Pagamento</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12 middle-content">
                                        	                                         
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                    	<label for="postingType" style="width: 170px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Tipo de Pagamento: </label>
                                                          <div style="width: 210px; padding-left:0px" class="col-lg-2 control-label">    
                                                              <select style="width: 190px" class="form-control" name="postingType" id="postingType" onchange="paymentType()" >
                                                                <option> - Selecione - </option>
                                                                <option value="Boleto">Boleto</option> 
                                                                <option value="Cheque">Cheque</option>
                                                                <option value="Crédito" >Crédito</option>
                                                                <option value="Débito">Débito</option>  
                                                                <option value="Dinheiro" >Dinheiro</option>  
                                                                <option value="Transferência">Transferência</option>

                                                               </select>
                                                             </div>
                                                     </div>
                                                  </div>
                                               </div>          
                                                           

                                                            <input type="hidden" id="documentexpenseId" name="documentexpenseId" value="" />
                                                            <input type="hidden" id="dateNow" name="dateNow" value="" />	
                                                            <input type="hidden" id="postingType" name="postingType" value="" >		
                                                            <br><br>
                                                            
                                                            										
                                                            <div id = "Boleto" style="display: none">
                                                            	<div id = "Boleto1">
                                                            		
	                                                            	<tr> 
		                                                                <td> Valor: </td>
		                                                            	<input style="width: 360px" class="form-control" type="text" id="postingValueBoleto1" name="postingValueBoleto1" ></input> 
	                                                            		<td> Data de Vencimento: </td>
		                                                            	<input style="width: 360px" class="form-control" type="text" id="postingDateBoleto1" name="postingDateBoleto1" ></input>  
		                                                            	<button class="btn btn-primary" onClick="boleto('1')">Salvar</button>                                                           	
	                                                            	</tr>
	                                                            </div>

                                                            </div>
                                                            
                                                            <div id = "Cheque" style="display: none">
                                                            	<tr> 
	                                                                <td> Número do Cheque: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingNumberCheque" name="postingNumberCheque" ></input>
                                                            	</tr>
                                                            	<tr> 
	                                                                <td> Valor: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingValueCheque" name="postingValueCheque" ></input> 
                                                            	</tr>
                                                            	<tr>
                                                            		<td> Data: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingDateCheque" name="postingDateCheque" ></input> <br>
                                                            	
                                                            	</tr>

                                                            </div>
                                                            
                                                            <div id = "Crédito" style="display: none">
                                                            	<tr> 
	                                                                <td> Valor: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingValueCredito" name="postingValueCredito" ></input> 
                                                            	</tr>
                                                            	<tr> 
	                                                                <td> Número de Parcelas: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingPortionsCredito" name="postingPortionsCredito" ></input>
                                                            	</tr>
                                                            	<tr>
                                                            		<td> Data: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingDateCredito" name="postingDateCredito" ></input> <br>
                                                            	
                                                            	</tr>

                                                            </div>
                                                            
                                                            <div id = "Débito" style="display: none">
                                                            	<tr> 
	                                                                <td> Valor: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingValueDebito" name="postingValueDebito" ></input> 
                                                            	</tr>
                                                            	<tr>
                                                            		<td> Data: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingDateDebito" name="postingDateDebito" ></input> <br>
                                                            	
                                                            	</tr>

                                                            </div>
                                                            
                                                            <div id = "Dinheiro" style="display: none">
                                                            	<tr> 
	                                                                <td> Valor: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingValueDinheiro" name="postingValueDinheiro" ></input> 
                                                            	</tr>
                                                            	<tr>
                                                            		<td> Data: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingDateDinheiro" name="postingDateDinheiro" ></input> <br>
                                                            	
                                                            	</tr>

                                                            </div>
                                                            
                                                            <div id = "Transferência" style="display: none">
                                                            	<tr> 
	                                                                <td> Valor: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingValueTransferencia" name="postingValueTransferencia" ></input> 
                                                            	</tr>
                                                            	<tr>
                                                            		<td> Data: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingDateTransferencia" name="postingDateTransferencia" ></input> <br>
                                                            	
                                                            	</tr>
                                                            	<tr> 
	                                                                <td> Banco: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingBankNumberTransferencia" name="postingBankNumberTransferencia" ></input> 
                                                            	</tr>
                                                            	<tr> 
	                                                                <td> Agência: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingAgencyTransferencia" name="postingAgencyTransferencia" ></input> 
                                                            	</tr>
                                                            	<tr> 
	                                                                <td> Conta: </td>
	                                                            	<input style="width: 360px" class="form-control" type="text" id="postingAccountTransferencia" name="postingAccountTransferencia" ></input> 
                                                            	</tr>

                                                            </div>

                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                            	<button class="btn btn-primary" onClick="formaPagamento()">Confirmar</button>
                                <button class="btn btn-danger" data-dismiss="modal">Fechar</button>
                            </div>
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