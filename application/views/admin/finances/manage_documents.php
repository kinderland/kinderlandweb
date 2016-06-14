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
                var string = "<?= $this->config->item("url_link") ?>admin/toggleDocumentPayed/".concat($(this).attr("id"));
                var recarrega = "<?= $this->config->item("url_link") ?>admin/manage_documents/";
                $.post(string).done(function (data) {
                    if (data == 1)
                        alert("Estado do documento modificado com sucesso");
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

        function sendInfoToModalEdit(postingValue, postingDate, postingType, postingPortions, postingBankNumber, postingAgency, postingAccount, postingNumberCheque, documentExpenseId) {
            $("#documentexpenseId").html(documentExpenseId);

            alert(postingType);
			alert(postingPortions);
            if(postingType == "Transferência")
            	$("#posting_Type").prop('selectedIndex', '5');
            else if(postingType == "Dinheiro")
            	$("#posting_Type").prop('selectedIndex', '4');
            else if(postingType == "Boleto")
            	$("#posting_Type").prop('selectedIndex', '1');
            else if(postingType == "Crédito")
            	$("#posting_Type").prop('selectedIndex', '3');
            else if(postingType == "Cheque")
            	$("#posting_Type").prop('selectedIndex', '2');
            
            if (postingType == "Crédito") {
            	document.getElementById("ChequeEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "none";
                document.getElementById("BoletoEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "";
                
                document.getElementById("postingValueCreditoEdit").value = postingValue;
                document.getElementById("postingDateCreditoEdit").value = postingDate;
                document.getElementById("postingPortionsCreditoEdit").value = postingPortions;                
                
            }

            if (postingType == "Dinheiro") {
            	document.getElementById("ChequeEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "none";
                document.getElementById("BoletoEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "";

                document.getElementById("postingValueDinheiroEdit").value = postingValue;
                document.getElementById("postingDateDinheiroEdit").value = postingDate;
            }
            if(postingType == "Cheque"){
                document.getElementById("DinheiroEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "none";
                document.getElementById("BoletoEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "none";
                document.getElementById("ChequeEdit").style.display = "";

	            document.getElementById("postingNumberChequeEdit").value = postingNumberCheque;
	            document.getElementById("postingValueChequeEdit").value = postingValue;
	            document.getElementById("postingDateChequeEdit").value = postingDate; 
            }          

            if (postingType == "Transferência") {
            	document.getElementById("ChequeEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "none";
                document.getElementById("BoletoEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "";
                
                document.getElementById("postingValueTransferenciaEdit").value = postingValue;
                document.getElementById("postingDateTransferenciaEdit").value = postingDate;
                document.getElementById("postingBankNumberTransferenciaEdit").value = postingBankNumber;
                document.getElementById("postingAgencyTransferenciaEdit").value = postingAgency;
                document.getElementById("postingAccountTransferenciaEdit").value = postingAccount;
            }

            if(postingType == "Boleto"){
            	document.getElementById("ChequeEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "none";
                document.getElementById("BoletoEdit").style.display = "";

            }

        }


        

		function sendInfoToModal(documentExpenseId){
			$("#documentexpenseId").html(documentExpenseId);
		}

		function editarFormaPagamento(){
			var documentexpenseId = document.getElementById("documentexpenseId").textContent;
            var postingType = "Crédito";
            alert(documentexpenseId);
            alert(postingType);
            if (postingType == "Dinheiro") {

                var postingValue = document.getElementById("postingValueDinheiroEdit").value;
                var postingDate = document.getElementById("postingDateDinheiroEdit").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/updatePostingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType},
                        function (data) {
                            if (data == "true") {
                                alert("Edição cadastrado com sucesso!");
                                location.reload();
                            } else if (data == "false") {
                                alert("Não foi possível editar o pagamento!");
                                location.reload();
                            }
                        }
                );
            }

            if (postingType == "Cheque") {

                var postingValue = document.getElementById("postingValueChequeEdit").value;
                var postingDate = document.getElementById("postingDateChequeEdit").value;
                var postingNumberCheque = document.getElementById("postingNumberChequeEdit").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/updatePostingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, postingNumberCheque: postingNumberCheque},
                        function (data) {
                            if (data == "true") {
                                alert("Edição cadastrado com sucesso!");
                                location.reload();
                            } else if (data == "false") {
                                alert("Não foi possível editar o pagamento!");
                                location.reload();
                            }
                        }
                );
            }

            if (postingType == "Transferência") {

                var postingValue = document.getElementById("postingValueTransferenciaEdit").value;
                var postingDate = document.getElementById("postingDateTransferenciaEdit").value;
                var postingBankNumber = document.getElementById("postingBankNumberTransferenciaEdit").value;
                var postingAgency = document.getElementById("postingAgencyTransferenciaEdit").value;
                var postingAccount = document.getElementById("postingAccountTransferenciaEdit").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/updatePostingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, postingNumberCheque: postingNumberCheque},
                        function (data) {
                            if (data == "true") {
                                alert("Edição cadastrado com sucesso!");
                                location.reload();
                            } else if (data == "false") {
                                alert("Não foi possível editar o pagamento!");
                                location.reload();
                            }
                        }
                );
            }

            if (postingType == "Crédito") {
				
                var postingValue = document.getElementById("postingValueCreditoEdit").value;
                var postingDate = document.getElementById("postingDateCreditoEdit").value;
                alert(postingValue);
                $.post('<?= $this->config->item('url_link'); ?>admin/updatePostingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType},
                        function (data) {
                            if (data == "true") {
                                alert("Edição cadastrado com sucesso!");
                                location.reload();
                            } else if (data == "false") {
                                alert("Não foi possível editar o pagamento!");
                                location.reload();
                            }
                        }
                );
            }

		}
        function formaPagamento() {

            var documentexpenseId = document.getElementById("documentexpenseId").textContent;
            var postingType = document.getElementById("postingType").value;

            if (postingType == "Crédito") {

                var portions = document.getElementById("postingPortionsCredito").value;
                var postingValue = document.getElementById("postingValueCredito").value;
                var postingDate = document.getElementById("postingDateCredito").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, portions: portions},
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


            if (postingType == "Débito") {

                var postingValue = document.getElementById("postingValueDebito").value;
                var postingDate = document.getElementById("postingDateDebito").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType},
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

            if (postingType == "Dinheiro") {

                var postingValue = document.getElementById("postingValueDinheiro").value;
                var postingDate = document.getElementById("postingDateDinheiro").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType},
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
            if (postingType == "Cheque") {

                var numberCheque = document.getElementById("postingNumberCheque").value;
                var postingValue = document.getElementById("postingValueCheque").value;
                var postingDate = document.getElementById("postingDateCheque").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, numberCheque: numberCheque},
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
            if (postingType == "Transferência") {
                var postingValue = document.getElementById("postingValueTransferencia").value;
                var postingDate = document.getElementById("postingDateTransferencia").value;
                var bankNumber = document.getElementById("postingBankNumberTransferencia").value;
                var bankAgency = document.getElementById("postingAgencyTransferencia").value;
                var accountNumber = document.getElementById("postingAccountTransferencia").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, bankNumber: bankNumber, bankAgency: bankAgency, accountNumber: accountNumber},
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
            if (postingType == "Boleto") {
                var portions = document.getElementById("postingPortionsBoleto").value;
                var postingValue = "";
                var postingDate = "";
                for (var i = 1; i <= portions; i++) {
                    if (i != portions) {
                        postingValue = postingValue.concat(document.getElementById("postingValueBoleto".concat(i)).value).concat("/");
                        postingDate = postingDate.concat(document.getElementById("postingDateBoleto".concat(i)).value).concat("/");
                    } else {
                        postingValue = postingValue.concat(document.getElementById("postingValueBoleto".concat(i)).value);
                        postingDate = postingDate.concat(document.getElementById("postingDateBoleto".concat(i)).value);
                    }
                }
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, portions: portions},
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
        }


		function limpaDiv(){
			
			document.getElementById("postingType").selectedIndex = 0;
			document.getElementById("Cheque").style.display = "none";
            document.getElementById("Crédito").style.display = "none";
            document.getElementById("Dinheiro").style.display = "none";
            document.getElementById("Transferência").style.display = "none";
            document.getElementById("Boleto").style.display = "none";

			document.getElementById("postingValueCredito").value = null;
			document.getElementById("postingDateCredito").value = null;
			document.getElementById("postingPortionsCredito").value = "Selecione";
			
			document.getElementById("postingValueCheque").value = null;
			document.getElementById("postingDateCheque").value = null;
			document.getElementById("postingNumberCheque").value = null;

			document.getElementById("postingValueDinheiro").value = null;
			document.getElementById("postingDateDinheiro").value = null;

			document.getElementById("postingValueTransferencia").value = null;
			document.getElementById("postingDateTransferencia").value = null;
			document.getElementById("postingBankNumberTransferencia").value = null;
			document.getElementById("postingAgencyTransferencia").value = null;
			document.getElementById("postingAccountTransferencia").value = null;					
			
			document.getElementById("postingPortionsBoleto").value = "Selecione";
            for (var i = 1; i <= 10; i++) {
            	document.getElementById("Boleto".concat(i)).style.display = "none";
            	document.getElementById("postingValueBoleto".concat(i)).value = null;
    			document.getElementById("postingDateBoleto".concat(i)).value = null;
                
            }
			



			
                

            

		}

        function paymentType() {
        	var rads = document.getElementsByName("formadepagamento");
      	  	var tipo;
      	  	var type;
      	  	for(var i = 0; i < rads.length; i++){
      	   		if(rads[i].checked){
      	    		tipo = rads[i].value;
      	   		}
      	   	}
      	   	
      	   	if(tipo == "caixinha"){
          	   	type = "Dinheiro";
      	   	}
      	   	else if(tipo == "debitoa"){
          	   	type = "Crédito";
      	   	}
      	   	else{
      	   		var type = document.getElementById("postingType").value;
      	   	}
           	   
            if (type == "Boleto") {
                document.getElementById("Cheque").style.display = "none";
                document.getElementById("Crédito").style.display = "none";
                document.getElementById("Dinheiro").style.display = "none";
                document.getElementById("Transferência").style.display = "none";
                document.getElementById("Boleto").style.display = "";

            } else if (type == "Cheque") {
                document.getElementById("Boleto").style.display = "none";
                document.getElementById("Crédito").style.display = "none";
                document.getElementById("Dinheiro").style.display = "none";
                document.getElementById("Transferência").style.display = "none";
                document.getElementById("Cheque").style.display = "";

            } else if (type == "Crédito") {
                document.getElementById("Boleto").style.display = "none";
                document.getElementById("Cheque").style.display = "none";
                document.getElementById("Dinheiro").style.display = "none";
                document.getElementById("Transferência").style.display = "none";
                document.getElementById("Crédito").style.display = "";

            } else if (type == "Débito") {
                document.getElementById("Boleto").style.display = "none";
                document.getElementById("Cheque").style.display = "none";
                document.getElementById("Crédito").style.display = "none";
                document.getElementById("Dinheiro").style.display = "none";
                document.getElementById("Transferência").style.display = "none";
                document.getElementById("Débito").style.display = "";

            } else if (type == "Dinheiro") {
                document.getElementById("Boleto").style.display = "none";
                document.getElementById("Cheque").style.display = "none";
                document.getElementById("Crédito").style.display = "none";
                document.getElementById("Transferência").style.display = "none";
                document.getElementById("Dinheiro").style.display = "";

            } else if (type == "Transferência") {
                document.getElementById("Boleto").style.display = "none";
                document.getElementById("Cheque").style.display = "none";
                document.getElementById("Crédito").style.display = "none";
                document.getElementById("Dinheiro").style.display = "none";
                document.getElementById("Transferência").style.display = "";

            }

        }

        function postingPortions() {
            var portions = document.getElementById("postingPortionsBoleto").value;
            for (var i = 1; i <= 10; i++) {
                if (i <= portions) {
                    document.getElementById("Boleto".concat(i)).style.display = "";
                } else {
                    document.getElementById("Boleto".concat(i)).style.display = "none";
                }
            }

        }

        function accountUpdate(id, date, value) {
            var account_name = document.getElementById("accounts_".concat(id)).value;

            var names = document.getElementById("accountsNames").value;
            names = names.split("/");

            var ok = 0;

            for (var i = 0; i < names.length; i++) {
                if (account_name.localeCompare(names[i]) == 0) {
                    ok = 1;
                    break;
                }
            }

            if (ok == 1) {
                $.post('<?= $this->config->item('url_link'); ?>admin/updateAccountName',
                        {id: id, date: date, value: value, account_name: account_name},
                        function (data) {
                            if (data == "true") {
                                alert("Nome de Conta atribuído com sucesso!");
                            } else if (data == "false") {
                                alert("Ocorreu um erro na atribuição de Nome de Conta!");
                                location.reload();
                            }
                        }
                );
            } else {
                alert("Nome de conta inválido. Insira um nome existente!");
            }
        }

        $(function () {
            var availableTags = document.getElementById("accountsNames").value;
            availableTags = availableTags.split("/");

            $(".accounts").autocomplete({
                source: availableTags
            });
        });

    </script>

    <?php
    $secretary = false;
    foreach ($this->session->userdata('user_types') as $type) {
        if ($type == 4) {
            $secretary = true;
        } else if ($type == 2) {
            $secretary = false;
            break;
        }
    }
    ?>

    <body>
        <div class="scroll">
            <form method="GET">
                <input type="hidden" name="option" value="<?= $option ?>"/>
                Ano: <select name="year" onchange="this.form.submit()" id="year">
<?php
foreach ($years as $y) {
    $selected = "";
    if ($y == $year)
        $selected = "selected";
    echo "<option $selected value='$y'>$y</option>";
}
?>
                </select>

                Mês: <select name="month" onchange="this.form.submit()" id="month">
                    <option value="0" >Todos</option>
<?php

function getMonthName($m) {
    switch ($m) {
        case 1: return "Janeiro";
        case 2: return "Fevereiro";
        case 3: return "Março";
        case 4: return "Abril";
        case 5: return "Maio";
        case 6: return "Junho";
        case 7: return "Julho";
        case 8: return "Agosto";
        case 9: return "Setembro";
        case 10: return "Outubro";
        case 11: return "Novembro";
        case 12: return "Dezembro";
    }
}

for ($m = 1; $m <= 12; $m++) {
    $selected = "";
    if ($m == $month)
        $selected = "selected";
    echo "<option $selected value='$m'>" . getMonthName($m) . "</option>";
}
?>
                </select>
            </form>
            <div class="row">
<?php // require_once APPPATH.'views/include/common_user_left_menu.php'   ?>
                <div class="col-lg-12 middle-content">

                    <a href="<?= $this->config->item("url_link") ?>admin/createDocument" >
                        <input style="display:none" id="accountsNames" value="<?php echo $accountNames; ?>">

                        <button id="create" class="btn btn-primary"  value="Criar novo documento" >Novo documento</button>
                    </a>


                    <br /><br />
<?php
if (isset($documents)) {
    ?>
                        <table class="table table-bordered table-striped table-min-td-size" style="width:900px" id="sortable-table">
                            <tr>
                                <th style="width:70px; text-align: center">Data</th>
                                <th style="width:20px; text-align: center">Tipo</th>
                                <th style="width:70px; text-align: center">Valor</th>
                                <th style="width:200px; text-align: center">Descrição</th>
                                <th style="width:70px; text-align: center">Imagem</th>
                                <th style="width:200px; text-align:center">Forma de Pagamento</th>
                            </tr>
    <?php
    foreach ($documents as $document) {
        ?>

                                <tr>
                                    <td>
        <?= date_format(date_create($document->document_date), 'd/m/y'); ?></td>

                                    <td><a href="<?php echo $this->config->item("url_link"); ?>admin/editDocument/<?php echo $document->document_expense_id ?>">
        <?php
        switch ($document->document_type) {
            case "nota fiscal":
                echo "NF";
                break;
            case "cupom fiscal":
                echo "CF";
                break;
            case "recibo":
                echo "rec";
                break;
            case "boleto":
                echo "bol";
                break;
        }
        ?></a> </td>
                                    <td><?php echo $document->document_value; ?> </td>
                                    <td><?php echo $document->document_description; ?></td>
                                    <td><a href="<?php echo $this->config->item("url_link"); ?>admin/viewDocumentUpload?document_id=<?php echo $document->document_expense_id; ?>">
                                            <button <?php
                                    if ($document->document_expense_upload_id) {
                                        echo "class='btn btn-success'>Atualizar";
                                    } else {
                                        echo "class='btn btn-danger'>Upload";
                                    }
        ?> 
                                        </button>
                                    </a>
                                </td>
        <?php if ($document->posting_value == "" && $document->posting_date == "") { ?>
                                    <td><button class="btn btn-danger" onclick="sendInfoToModal('<?= $document->document_expense_id ?>')" data-toggle="modal" data-target="#myModal">Tipo</button></td>
                                <?php } else { ?>
                                    <td><button class="btn btn-success" onclick="sendInfoToModalEdit('<?= $document->posting_value ?>', '<?= $document->posting_date ?>', '<?= $document->posting_type ?>', '<?= $document->posting_portions ?>', '<?= $document->bank_number ?>', '<?= $document->bank_agency ?>', '<?= $document->account_number ?>', '<?= $document->check_number ?>', '<?= $document->document_expense_id ?>')" data-toggle="modal" data-target="#meuModalEditar">Tipo</button> </td>
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
		<div id="thisdiv">
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
                                    <form method="GET">
                                        <input type="radio" name="formadepagamento" value="apagar" onclick="paymentType()" checked> A pagar
                                        <input type="radio" name="formadepagamento" value="caixinha" onclick="paymentType()"> Caixinha
                                        <input type="radio" name="formadepagamento"  value="debitoa" onclick="paymentType()"> Débito automático
                                    </form>
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <label for="postingType" style="width: 170px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Tipo de Pagamento: </label>
                                            <div style="width: 210px; padding-left:0px" class="col-lg-2 control-label">    
                                                <select style="width: 190px" class="form-control" name="postingType" id="postingType" onchange="paymentType()" >
                                                    <option value="Selecione" selected> - Selecione - </option>
                                                    <option value="Boleto">Boleto</option> 
                                                    <option value="Cheque">Cheque</option>
                                                    <option value="Crédito" >Crédito</option>
                                                    <option value="Dinheiro" >Dinheiro</option>  
                                                    <option value="Transferência">Transferência</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>          


                                <input type="hidden" id="documentexpenseId" name="documentexpenseId" value="" />	
                                <input type="hidden" id="postingType" name="postingType" value="" >		
                                <br/>



                                <div id = "Boleto" style="display: none">                                                            		
                                    <tr>
                                    <label for="postingPortionsBoleto" style="width: 170px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Número de parcelas: </label>
                                    <div style="width: 350px; padding-left:0px" class="col-lg-2 control-label">
                                        <select style="width: 190px" class="form-control" name="postingPortionsBoleto" id="postingPortionsBoleto" onchange="postingPortions()" >
                                            <option value="Selecione"> - Selecione - </option>
<?php for ($i = 1; $i <= 10; $i++) { ?>
                                                <option value="<?= $i ?>"> <?php echo $i ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </tr> <br/><br/><br/>
<?php for ($i = 1; $i <= 10; $i++) { ?>
                                        <tr>
                                        <div class="col-lg-12 control_label" id="Boleto<?php echo $i ?>" style="display: none; padding-left:0px" >
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="postingValueBoleto<?php echo $i ?>" style="width: 50px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Valor: </label>
                                                    <div style="width: 210px; padding-left:0px" class="col-lg-2 control-label">
                                                        <input style="width: 200px" class="form-control" type="text" id="postingValueBoleto<?php echo $i ?>" name="postingValueBoleto<?php echo $i ?>" ></input> 
                                                    </div>
                                                    <label for="postingDateBoleto<?php echo $i ?>" style="width: 50px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label">Data </label>
                                                    <div style="width: 210px; padding-left:0px" class="col-lg-2 control-label">
                                                        <input style="width: 200x" class="form-control" type="text" id="postingDateBoleto<?php echo $i ?>" name="postingDateBoleto<?php echo $i ?>" ></input> 
                                                        <br/><br/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </tr>

<?php } ?>
                                    <br>
                                    <tr>
                                    
                                </div>



                                <div id = "Cheque" style="display: none">
                                    <tr> 
                                        <td> Número do Cheque: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingNumberCheque" name="postingNumberCheque" ></input> <br><br>
                                    </tr>
                                    <tr>
                                        <td> Data: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingDateCheque" name="postingDateCheque" ></input> <br><br>

                                    </tr>

                                    <tr> 
                                        <td> Valor: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingValueCheque" name="postingValueCheque" ></input> <br><br>
                                    

                                    </tr>

                                </div>

                                <div id = "Crédito" style="display: none">

                                    <tr> 
                                        <td> Valor: </td><br/>
                                    <input style="width: 200px" class="form-control" type="text" id="postingValueCredito" name="postingValueCredito" ></input> <br><br>
                                    </tr><br/>
                                    <tr>
                                        <td> Número de parcelas: </td><br/>
                                    <div style="width: 350px; padding-left:0px" class="col-lg-2 control-label">
                                        <select style="width: 190px" class="form-control" name="postingPortionsCredito" id="postingPortionsCredito"  >
                                            <option value="Selecione"> - Selecione - </option>
<?php for ($i = 1; $i <= 10; $i++) { ?>
                                                <option value="<?= $i ?>"> <?php echo $i ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </tr> <br/><br/><br/>
                                    <tr>
                                        <td> Data: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingDateCredito" name="postingDateCredito" ></input> <br><br>
                                    
                                    </tr>

                                </div>                                                            
                                <div id = "Dinheiro" style="display: none"> 
                                    <td> Valor: </td><br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingValueDinheiro" name="postingValueDinheiro" ></input> <br><br>
                                    </tr>
                                    <tr>
                                        <td> Data: </td><br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingDateDinheiro" name="postingDateDinheiro" ></input> <br><br>
                                    
                                    </tr>

                                </div>

                                <div id = "Transferência" style="display: none"> 
                                    <td> Valor: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingValueTransferencia" name="postingValueTransferencia" ></input> <br><br>
                                    </tr>
                                    <tr>
                                        <td> Data: </td><br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingDateTransferencia" name="postingDateTransferencia" ></input> <br><br>

                                    </tr>
                                    <tr> 
                                        <td> Banco: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingBankNumberTransferencia" name="postingBankNumberTransferencia" ></input> <br><br>
                                    </tr>
                                    <tr> 
                                        <td> Agência: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingAgencyTransferencia" name="postingAgencyTransferencia" ></input> <br><br>
                                    </tr>
                                    <tr> 
                                        <td> Conta: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingAccountTransferencia" name="postingAccountTransferencia" ></input> <br><br>
                                    
                                    </tr>


                                </div>
                                <div class="modal-footer">
                                        <div class="col-lg-7 control_label">
                                            <button class="btn btn-primary" onClick="formaPagamento()">Salvar</button>  
                                            <button class="btn btn-warning" data-dismiss="modal" onClick="limpaDiv()">Fechar</button> 
                                        </div>  
                                    </div>

                                    

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
        
        
        
        
       <div class="modal fade" id="meuModalEditar" tabindex="-1" role="dialog" aria-labelledby="solicitar-convite" aria-hidden="true">
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
                                    <form method="GET">
                                        <input type="radio" name="formadepagamento" value="apagar" onclick="paymentType()" checked> A pagar
                                        <input type="radio" name="formadepagamento" value="caixinha" onclick="paymentType()"> Caixinha
                                        <input type="radio" name="formadepagamento"  value="debitoa" onclick="paymentType()"> Débito automático
                                    </form>
                                    
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <label for="postingType" style="width: 170px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Tipo de Pagamento: </label>
                                            <div style="width: 210px; padding-left:0px" class="col-lg-2 control-label">    
                                                <select style="width: 190px" class="form-control" name="postingType" id="posting_Type" onchange="paymentType()" >
                                                    <option> - Selecione - </option>
                                                    <option value="Boleto">Boleto</option> 
                                                    <option value="Cheque">Cheque</option>
                                                    <option value="Crédito" >Crédito</option>
                                                    <option value="Dinheiro" >Dinheiro</option>  
                                                    <option value="Transferência">Transferência</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    </div>


                                <input type="hidden" id="documentexpenseId" name="documentexpenseId" value="" />	
                                <input type="hidden" id="postingType" name="postingType" value="" >		
                                <br/>



                                <div id = "BoletoEdit" style="display: none">                                                            		
                                    <tr>
                                    <label for="postingPortionsBoleto" style="width: 170px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Número de parcelas: </label>
                                    <div style="width: 350px; padding-left:0px" class="col-lg-2 control-label">
                                        <select style="width: 190px" class="form-control" name="postingPortionsBoleto" id="postingPortionsBoletoEdit" value="" onchange="postingPortions()" >
                                            <option> - Selecione - </option>
<?php for ($i = 1; $i <= 10; $i++) { ?>
                                                <option value="<?= $i ?>"> <?php echo $i ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </tr> <br/><br/><br/>
<?php for ($i = 1; $i <= 10; $i++) { ?>
                                        <tr>
                                        <div class="col-lg-12 control_label" id="Boleto<?php echo $i ?>" style="display: none; padding-left:0px" >
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="postingValueBoleto<?php echo $i ?>" style="width: 50px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Valor: </label>
                                                    <div style="width: 210px; padding-left:0px" class="col-lg-2 control-label">
                                                        <input style="width: 200px" class="form-control" type="text" id="postingValueBoletoEdit<?php echo $i ?>" value="" name="postingValueBoleto<?php echo $i ?>" ></input> 
                                                    </div>
                                                    <label for="postingDateBoleto<?php echo $i ?>" style="width: 50px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label">Data </label>
                                                    <div style="width: 210px; padding-left:0px" class="col-lg-2 control-label">
                                                        <input style="width: 200x" class="form-control" type="text" id="postingDateBoletoEdit<?php echo $i ?>" value="" name="postingDateBoleto<?php echo $i ?>" ></input> 
                                                        <br/><br/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </tr>

<?php } ?>
                                    <br>
                                    
                                </div>



                                <div id = "ChequeEdit" style="display: none">
                                    <tr> 
                                        <td> Número do Cheque: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingNumberChequeEdit" value="" name="postingNumberCheque" ></input> <br><br>
                                    </tr>
                                    <tr>
                                        <td> Data: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingDateChequeEdit" value="" name="postingDateCheque" ></input> <br><br>

                                    </tr>

                                    <tr> 
                                        <td> Valor: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingValueChequeEdit" value="" name="postingValueCheque" ></input> <br><br>
                                    

                                    </tr>

                                </div>

                                <div id = "CréditoEdit" style="display: none">

                                    <tr> 
                                        <td> Valor: </td><br/>
                                    <input style="width: 200px" class="form-control" type="text" id="postingValueCreditoEdit" value="" name="postingValueCredito" ></input> <br><br>
                                    </tr><br/>
                                    <tr>
                                        <td> Número de parcelas: </td><br/>
                                    <div style="width: 350px; padding-left:0px" class="col-lg-2 control-label">
                                        <select style="width: 190px" class="form-control" name="postingPortionsCreditoEdit" value="" id="postingPortionsCredito"  >
                                            <option> - Selecione - </option>
<?php for ($i = 1; $i <= 10; $i++) { ?>
                                                <option value="<?= $i ?>"> <?php echo $i ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </tr> <br/><br/><br/>
                                    <tr>
                                        <td> Data: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingDateCreditoEdit" value="" name="postingDateCredito" ></input> <br><br>
                                    
                                    </tr>

                                </div>                                                            
                                <div id = "DinheiroEdit" style="display: none"> 
                                    <td> Valor: </td><br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingValueDinheiroEdit" value="" name="postingValueDinheiro" ></input> <br><br>
                                    </tr>
                                    <tr>
                                        <td> Data: </td><br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingDateDinheiroEdit" value="" name="postingDateDinheiro" ></input> <br><br>
                                    
                                    </tr>

                                </div>

                                <div id = "TransferênciaEdit" style="display: none"> 
                                    <td> Valor: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingValueTransferenciaEdit" value="" name="postingValueTransferencia" ></input> <br><br>
                                    </tr>
                                    <tr>
                                        <td> Data: </td><br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingDateTransferenciaEdit" value="" name="postingDateTransferencia" ></input> <br><br>

                                    </tr>
                                    <tr> 
                                        <td> Banco: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingBankNumberTransferenciaEdit" value="" name="postingBankNumberTransferencia" ></input> <br><br>
                                    </tr>
                                    <tr> 
                                        <td> Agência: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingAgencyTransferenciaEdit" value="" name="postingAgencyTransferencia" ></input> <br><br>
                                    </tr>
                                    <tr> 
                                        <td> Conta: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingAccountTransferenciaEdit" value="" name="postingAccountTransferencia" ></input> <br><br>
                                    
                                    </tr>


                                </div>
                                <div class="modal-footer">
                                        <div class="col-lg-7 control_label">
                                            <button class="btn btn-primary" onClick="editarFormaPagamento()">Salvar</button>  
                                            <button class="btn btn-warning" data-dismiss="modal" onClick="limpaDiv()">Fechar</button> 
                                        </div>  
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
       
</div>

</body>


</html>