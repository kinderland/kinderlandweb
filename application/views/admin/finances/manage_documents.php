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

    <script>
	    function datepickers() {
	        $('.datepickers').datepicker();
	        $(".datepickers").datepicker("option", "dateFormat", "dd/mm/yy");
	    }
	    
        $(function () {
            $("#sortable-table").tablesorter({widgets: ['zebra']});
            $(".datepicker").datepicker();
        });
        
        $(document).ready(function () {
        	datepickers();
        	$('#sortable-table').datatable({
				pageSize : Number.MAX_VALUE,
				sort : [true, false, false, false, false, false]			
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

        function sendInfoToModalEdit(payment_status, postingValue, postingDate, postingType, postingPortions, postingBankNumber, postingAgency, postingAccount, postingNumberCheque, documentExpenseId, payment_status) {
            $("#documentexpenseId").html(documentExpenseId);
            $("#paymentStatus").html(payment_status);

            var rads = document.getElementsByName("formadepagamentoEdit");
            
      	  	for(var i = 0; i < rads.length; i++){
      	   		if(rads[i].value == payment_status){
      	   			rads[i].checked = true;
      	   		}else
      	   			rads[i].checked =  false;
      	   	}
			
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

        	if(payment_status == 'caixinha'){
        		document.getElementById("posting_Type").disabled = true;
        	}else if(payment_status == 'deb auto'){
        		document.getElementById("posting_Type").disabled = true;
        	}
            
            if (postingType == "Crédito") {
            	document.getElementById("ChequeEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "none";
                document.getElementById("BoletoEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "";
                
                document.getElementById("postingValueCreditoEdit").value = postingValue*postingPortions;
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

                datas = postingDate.split("-");
                valores = postingValue.split("-");

                for(var i = 1; i <= datas.length-1 ; i++){ 
                	document.getElementById("BoletoEdit".concat(i)).style.display = "";
                	document.getElementById("postingValueBoletoEdit".concat(i)).value = valores[i-1];
                	document.getElementById("postingDateBoletoEdit".concat(i)).value = datas[i-1]; 
                }

                $("#postingPortionsBoletoEdit").prop('selectedIndex', i-1);
            }

        }

		function sendInfoToModal(documentExpenseId){
			$("#documentexpenseId").html(documentExpenseId);
		}

		function editarFormaPagamento(){
			var paymentStatus = document.getElementById("paymentStatus").textContent;

			if(paymentStatus == ("pago" || "caixinha" || "deb auto")){
				t = confirm("O documento já se encontra pago. Caso prossiga, as informações de pagamento serão excluidas. Confirma?");
				if(t == false){
					return;
				}
			}
			
			var rads = document.getElementsByName("formadepagamentoEdit");
      	  	var payment_type;
      	  	for(var i = 0; i < rads.length; i++){
      	   		if(rads[i].checked){
      	   			payment_type = rads[i].value;
      	   		}
      	   	}
      	   	var status = "edit";
      	   	
			var documentexpenseId = document.getElementById("documentexpenseId").textContent;
			
			var postingType = document.getElementById("posting_Type").value;
			
            if (postingType == "Dinheiro") {
                
                var postingDate;
                if(document.getElementById("postingDateDinheiroEdit")){
                	postingDate = document.getElementById("postingDateDinheiroEdit").value;
                }
                else{
                	postingDate = null;
                }

                var postingValue = document.getElementById("postingValueDinheiroEdit").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, payment_type: payment_type, status: status},
                        function (data) {
                            if (data == "true") {
                                alert("Edição cadastrada com sucesso!");
                                location.reload();
                            } else if (data == "false") {
                                alert("Não foi possível editar o pagamento!");
                                location.reload();
                            }
                        }
                );
            }

            else if (postingType == "Cheque") {

                var postingValue = document.getElementById("postingValueChequeEdit").value;
                var postingNumberCheque = document.getElementById("postingNumberChequeEdit").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingValue: postingValue, postingType: postingType, numberCheque: postingNumberCheque, status: status},
                        function (data) {
                            if (data == "true") {
                                alert("Edição cadastrada com sucesso!");
                                location.reload();
                            } else if (data == "false") {
                                alert("Não foi possível editar o pagamento!");
                                location.reload();
                            }
                        }
                );
            }

            else if (postingType == "Transferência") {

                var postingValue = document.getElementById("postingValueTransferenciaEdit").value;
                var postingBankNumber = document.getElementById("postingBankNumberTransferenciaEdit").value;
                var postingAgency = document.getElementById("postingAgencyTransferenciaEdit").value;
                var postingAccount = document.getElementById("postingAccountTransferenciaEdit").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingValue: postingValue, postingType: postingType, bankNumber: postingBankNumber, bankAgency: postingAgency, accountNumber: postingAccount, status: status},
                        function (data) {
                            if (data == "true") {
                                alert("Edição cadastrada com sucesso!");
                                location.reload();
                            } else if (data == "false") {
                                alert("Não foi possível editar o pagamento!");
                                location.reload();
                            }
                        }
                );
            }

            else if (postingType == "Crédito") {
            	var portions = document.getElementById("postingPortionsCreditoEdit").value;
                var postingValue = document.getElementById("postingValueCreditoEdit").value;
                var postingDate = document.getElementById("postingDateCreditoEdit").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, portions: portions, status: status},
                        function (data) {
                            if (data == "true") {
                                alert("Edição cadastrada com sucesso!");
                                location.reload();
                            } else if (data == "false") {
                                alert("Não foi possível editar o pagamento!");
                                location.reload();
                            }
                        }
                );
            }
            else if (postingType == "Boleto") {
                var portions = document.getElementById("postingPortionsBoletoEdit").value;
                var postingValue = "";
                var postingDate = "";
                for (var i = 1; i <= portions; i++) {
                    if (i != portions) {
                        postingValue = postingValue.concat(document.getElementById("postingValueBoletoEdit".concat(i)).value).concat("/");
                        postingDate = postingDate.concat(document.getElementById("postingDateBoletoEdit".concat(i)).value).concat("/");
                    } else {
                        postingValue = postingValue.concat(document.getElementById("postingValueBoletoEdit".concat(i)).value);
                        postingDate = postingDate.concat(document.getElementById("postingDateBoletoEdit".concat(i)).value);
                    }
                }
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, portions: portions, status: status},
                        function (data) {
                            if (data == "true") {
                                alert("Edição cadastrada com sucesso!");
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
        	var rads = document.getElementsByName("formadepagamento");
      	  	var payment_type;
      	  	for(var i = 0; i < rads.length; i++){
      	   		if(rads[i].checked){
      	   			payment_type = rads[i].value;
      	   		}
      	   	}
            var documentexpenseId = document.getElementById("documentexpenseId").textContent;
            var postingType = document.getElementById("postingType").value;
            var status = "new";

            if (postingType == "Crédito") {

                var portions = document.getElementById("postingPortionsCredito").value;
                var postingValue = document.getElementById("postingValueCredito").value;
                var postingDate = document.getElementById("postingDateCredito").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, portions: portions, status: status},
                        function (data) {
                            if (data.localeCompare("true") == 0) {
                                alert("Pagamento cadastrado com sucesso!");
                                location.reload();
                            } else if (data.localeCompare("false") == 0) {
                                alert("Não foi possível cadastrar o pagamento!");
                                location.reload();
                            }
                        }
                );
            }
                
            else if (postingType == "Dinheiro") {

                var postingValue = document.getElementById("postingValueDinheiro").value;
                var postingDate;
                if(document.getElementById("postingDateDinheiro")){
                	postingDate = document.getElementById("postingDateDinheiro").value;
                }
                else{
                	postingDate = null;
                }
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, payment_type: payment_type, status: status},
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
            else if (postingType == "Cheque") {

                var numberCheque = document.getElementById("postingNumberCheque").value;
                var postingValue = document.getElementById("postingValueCheque").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingValue: postingValue, postingType: postingType, numberCheque: numberCheque, status: status},
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
            else if (postingType == "Transferência") {
                var postingValue = document.getElementById("postingValueTransferencia").value;
                var bankNumber = document.getElementById("postingBankNumberTransferencia").value;
                var bankAgency = document.getElementById("postingAgencyTransferencia").value;
                var accountNumber = document.getElementById("postingAccountTransferencia").value;
                $.post('<?= $this->config->item('url_link'); ?>admin/postingExpense',
                        {documentexpenseId: documentexpenseId, postingValue: postingValue, postingType: postingType, bankNumber: bankNumber, bankAgency: bankAgency, accountNumber: accountNumber, status: status},
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
            else if (postingType == "Boleto") {
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
                        {documentexpenseId: documentexpenseId, postingDate: postingDate, postingValue: postingValue, postingType: postingType, portions: portions, status: status},
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


		function limpaDivEdit(){

			var rads = document.getElementsByName("formadepagamentoEdit");
      	  	for(var i = 0; i < rads.length; i++){
      	   		if(rads[i].value == 'a pagar'){
      	    		rads[i].checked = true;
      	   		}
      	   		else {
      	   			rads[i].checked = false;
      	   		}          	   		
      	   	}
			
			document.getElementById("posting_Type").selectedIndex = 0;
			document.getElementById("ChequeEdit").style.display = "none";
            document.getElementById("CréditoEdit").style.display = "none";
            document.getElementById("DinheiroEdit").style.display = "none";
            document.getElementById("TransferênciaEdit").style.display = "none";
            document.getElementById("BoletoEdit").style.display = "none";

			document.getElementById("postingValueCreditoEdit").value = null;
			document.getElementById("postingDateCreditoEdit").value = null;
			document.getElementById("postingPortionsCreditoEdit").value = "Selecione";
			
			document.getElementById("postingValueChequeEdit").value = null;
			document.getElementById("postingNumberChequeEdit").value = null;

			document.getElementById("postingValueDinheiroEdit").value = null;

			if(document.getElementById("postingDateDinheiroEdit") != null)
				document.getElementById("postingDateDinheiroEdit").value = null;

			document.getElementById("postingValueTransferenciaEdit").value = null;
			document.getElementById("postingBankNumberTransferenciaEdit").value = null;
			document.getElementById("postingAgencyTransferenciaEdit").value = null;
			document.getElementById("postingAccountTransferenciaEdit").value = null;					
			
			document.getElementById("postingPortionsBoletoEdit").value = "Selecione";
            for (var i = 1; i <= 10; i++) {
            	document.getElementById("BoletoEdit".concat(i)).style.display = "none";
            	document.getElementById("postingValueBoletoEdit".concat(i)).value = null;
    			document.getElementById("postingDateBoletoEdit".concat(i)).value = null;
                
            }   

            document.getElementById("posting_Type").disabled = false;

		}

		function limpaDiv(){

			var rads = document.getElementsByName("formadepagamento");
      	  	for(var i = 0; i < rads.length; i++){
      	   		if(rads[i].value == 'a pagar'){
      	    		rads[i].checked = true;
      	   		}
      	   		else {
      	   			rads[i].checked = false;
      	   		}          	   		
      	   	}
			
			document.getElementById("postingType").selectedIndex = 0;
			document.getElementById("Cheque").style.display = "none";
            document.getElementById("Crédito").style.display = "none";
            document.getElementById("Dinheiro").style.display = "none";
            document.getElementById("Transferência").style.display = "none";
            document.getElementById("Boleto").style.display = "none";
            document.getElementById("DinheiroDate").style.display = "none";

			document.getElementById("postingValueCredito").value = null;
			document.getElementById("postingDateCredito").value = null;
			document.getElementById("postingPortionsCredito").value = "Selecione";
			
			document.getElementById("postingValueCheque").value = null;
			document.getElementById("postingNumberCheque").value = null;

			document.getElementById("postingValueDinheiro").value = null;
			document.getElementById("postingDateDinheiro").value = null;

			document.getElementById("postingValueTransferencia").value = null;
			document.getElementById("postingBankNumberTransferencia").value = null;
			document.getElementById("postingAgencyTransferencia").value = null;
			document.getElementById("postingAccountTransferencia").value = null;					
			
			document.getElementById("postingPortionsBoleto").value = "Selecione";
            for (var i = 1; i <= 10; i++) {
            	document.getElementById("Boleto".concat(i)).style.display = "none";
            	document.getElementById("postingValueBoleto".concat(i)).value = null;
    			document.getElementById("postingDateBoleto".concat(i)).value = null;
                
            }    

            document.getElementById("postingType").disabled = false;        

		}

		function paymentTypeEdit() {
        	
      	  	var type;
      	  	
      	   	type = document.getElementById("posting_Type").value;

           	   
            if (type == "Boleto") {
                document.getElementById("ChequeEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "none";
                document.getElementById("BoletoEdit").style.display = "";

            } else if (type == "Cheque") {
                document.getElementById("BoletoEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "none";
                document.getElementById("ChequeEdit").style.display = "";

            } else if (type == "Crédito") {
                document.getElementById("BoletoEdit").style.display = "none";
                document.getElementById("ChequeEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "";

            } else if (type == "Débito") {
                document.getElementById("BoletoEdit").style.display = "none";
                document.getElementById("ChequeEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "none";
                document.getElementById("DébitoEdit").style.display = "";

            } else if (type == "Dinheiro") {
                document.getElementById("BoletoEdit").style.display = "none";
                document.getElementById("ChequeEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "";

            } else if (type == "Transferência") {
                document.getElementById("BoletoEdit").style.display = "none";
                document.getElementById("ChequeEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "";

            }

        }

        function paymentRadioType(){
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
          	  	$("#postingType").prop('selectedIndex', '4');
          		document.getElementById("DinheiroDate").style.display = "";
          		document.getElementById("Boleto").style.display = "none";
                document.getElementById("Cheque").style.display = "none";
                document.getElementById("Crédito").style.display = "none";
                document.getElementById("Transferência").style.display = "none";
                document.getElementById("Dinheiro").style.display = "";
                document.getElementById("postingType").disabled = true;
      	   	}
      	   	else if(tipo == "deb auto"){
          	   	type = "Dinheiro";
          	  	$("#postingType").prop('selectedIndex', '4');
          		document.getElementById("DinheiroDate").style.display = "";
          		document.getElementById("Boleto").style.display = "none";
                document.getElementById("Cheque").style.display = "none";
                document.getElementById("Crédito").style.display = "none";
                document.getElementById("Transferência").style.display = "none";
                document.getElementById("Dinheiro").style.display = "";
                document.getElementById("postingType").disabled = true;
      	   	}
      	   	else{
      	   		limpaDiv();
      	   		document.getElementById("postingType").disabled = false;
      	   		var type = document.getElementById("postingType").value;      	   		
      	   	}

      	   	
        }

        function paymentRadioTypeEdit(){
        	var rads = document.getElementsByName("formadepagamentoEdit");
      	  	var tipo;
      	  	var type;
      	  	for(var i = 0; i < rads.length; i++){
      	   		if(rads[i].checked){
      	    		tipo = rads[i].value;
      	   		}
      	   	}
      	   	
      	   	if(tipo == "caixinha"){
          	   	type = "Dinheiro";
          	  	$("#posting_Type").prop('selectedIndex', '4');
          		document.getElementById("DinheiroDateEdit").style.display = "";
          		document.getElementById("BoletoEdit").style.display = "none";
                document.getElementById("ChequeEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "";
                document.getElementById("posting_Type").disabled = true;
      	   	}
      	   	else if(tipo == "deb auto"){
          	   	type = "Dinheiro";
          	  	$("#posting_Type").prop('selectedIndex', '4');
          		document.getElementById("DinheiroDateEdit").style.display = "";
          		document.getElementById("BoletoEdit").style.display = "none";
                document.getElementById("ChequeEdit").style.display = "none";
                document.getElementById("CréditoEdit").style.display = "none";
                document.getElementById("TransferênciaEdit").style.display = "none";
                document.getElementById("DinheiroEdit").style.display = "";
                document.getElementById("posting_Type").disabled = true;
      	   	}
      	   	else{
      	   		limpaDivEdit();
      	   		document.getElementById("posting_Type").disabled = false;
      	   		var type = document.getElementById("posting_Type").value;      	   		
      	   	}

      	   	
        }

        function paymentType() {

        	var type = document.getElementById("postingType").value;  
            
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
        function postingPortionsEdit() {
            var portions = document.getElementById("postingPortionsBoletoEdit").value;
            for (var i = 1; i <= 10; i++) {
                if (i <= portions) {
                    document.getElementById("BoletoEdit".concat(i)).style.display = "";
                } else {
                    document.getElementById("BoletoEdit".concat(i)).style.display = "none";
                }
            }

        }

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
                                    <td><?= number_format($document->document_value,2,',','') ?> </td>
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
                                    <td><button class="btn btn-success" onclick="<?php if($document->posting_type == 'Boleto'){ ?>sendInfoToModalEdit('<?= $document->payment_status ?>','<?= $boleto[$document->document_expense_id]->posting_value ?>', '<?= $boleto[$document->document_expense_id]->posting_date ?>'<?php } else{?>sendInfoToModalEdit('<?= $document->payment_status ?>','<?= $document->posting_value ?>', '<?= $document->posting_date ?>' <?php }?>, '<?= $document->posting_type ?>', '<?php if($document->posting_type == 'Crédito') echo $posting_portions_credito[$document->document_expense_id]; else echo $document->posting_portions; ?>', '<?= $document->bank_number ?>', '<?= $document->bank_agency ?>', '<?= $document->account_number ?>', '<?= $document->check_number ?>', '<?= $document->document_expense_id ?>', '<?= $payment_status[$document->document_expense_id];?>')" data-toggle="modal" data-target="#meuModalEditar">Tipo</button> </td>
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
                                        <input type="radio" name="formadepagamento" value="a pagar" onclick="paymentRadioType()" checked> A pagar </input>
                                        <input type="radio" name="formadepagamento" value="caixinha" onclick="paymentRadioType()"> Caixinha </input>
                                        <input type="radio" name="formadepagamento"  value="deb auto" onclick="paymentRadioType()"> Débito automático </input>
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
                                                        <input style="width: 200px" class="form-control" type="text" id="postingValueBoleto<?php echo $i ?>" name="postingValueBoleto<?php echo $i ?>Edit" ></input> 
                                                    </div>
                                                    <label for="postingDateBoleto<?php echo $i ?>" style="width: 50px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label">Data </label>
                                                    <div style="width: 210px; padding-left:0px" class="col-lg-2 control-label">
                                                        <input style="width: 200x" class="datepickers form-control" type="text" id="postingDateBoleto<?php echo $i ?>" name="postingDateBoleto<?php echo $i ?>" ></input> 
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
                                    <input style="width: 200px" class="datepickers form-control" type="text" id="postingDateCredito" name="postingDateCredito" ></input> <br><br>
                                    
                                    </tr>

                                </div>                                                            
                                <div id = "Dinheiro" style="display: none"> 
                                <tr>
                                    <td> Valor: </td><br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingValueDinheiro" name="postingValueDinheiro" ></input> <br><br>
                                    </tr>
                                    
                                 <div id="DinheiroDate" style="display: none"> 
                                    <tr>
                                        <td> Data: </td><br>
                                    <input style="width: 200px" class="datepickers form-control" type="text" id="postingDateDinheiro" name="postingDateDinheiro" ></input> <br><br>
                                    
                                    </tr>
                                    </div>
                                    

                                </div>

                                <div id = "Transferência" style="display: none"> 
                                    <td> Valor: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingValueTransferencia" name="postingValueTransferencia" ></input> <br><br>
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
                                        <input type="radio" name="formadepagamentoEdit" value="a pagar" onclick="paymentRadioTypeEdit()" checked> A pagar
                                        <input type="radio" name="formadepagamentoEdit" value="caixinha" onclick="paymentRadioTypeEdit()"> Caixinha
                                        <input type="radio" name="formadepagamentoEdit"  value="deb auto" onclick="paymentRadioTypeEdit()"> Débito automático
                                    </form>
                                    
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <label for="postingType" style="width: 170px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Tipo de Pagamento: </label>
                                            <div style="width: 210px; padding-left:0px" class="col-lg-2 control-label">    
                                                <select style="width: 190px" class="form-control" name="postingType" id="posting_Type" onchange="paymentTypeEdit()" >
                                                    <option selected> - Selecione - </option>
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
                                <input type="hidden" id="paymentStatus" name="paymentStatus" value="" />	
                                <input type="hidden" id="postingType" name="postingType" value="" >		
                                <br/>



                                <div id = "BoletoEdit" style="display: none">                                                            		
                                    <tr>
                                    <label for="postingPortionsBoleto" style="width: 170px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Número de parcelas: </label>
                                    <div style="width: 350px; padding-left:0px" class="col-lg-2 control-label">
                                        <select style="width: 190px" class="form-control" name="postingPortionsBoleto" id="postingPortionsBoletoEdit" value="" onchange="postingPortionsEdit()" >
                                            <option value="Selecione"> - Selecione - </option>
											<?php for ($i = 1; $i <= 10; $i++) { ?>
                                                <option value="<?= $i ?>"> <?php echo $i ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </tr> <br/><br/><br/>
											<?php for ($i = 1; $i <= 10; $i++) { ?>
                                        <tr>
                                        <div class="col-lg-12 control_label" id="BoletoEdit<?php echo $i ?>" style="display: none; padding-left:0px" >
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="postingValueBoleto<?php echo $i ?>" style="width: 50px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Valor: </label>
                                                    <div style="width: 210px; padding-left:0px" class="col-lg-2 control-label">
                                                        <input style="width: 200px" class="form-control" type="text" id="postingValueBoletoEdit<?php echo $i ?>" value="" name="postingValueBoleto<?php echo $i ?>" ></input> 
                                                    </div>
                                                    <label for="postingDateBoleto<?php echo $i ?>" style="width: 50px; padding-left:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label">Data </label>
                                                    <div style="width: 210px; padding-left:0px" class="col-lg-2 control-label">
                                                        <input style="width: 200x" class="datepickers form-control" type="text" id="postingDateBoletoEdit<?php echo $i ?>" value="" name="postingDateBoleto<?php echo $i ?>" ></input> 
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
                                        <select style="width: 190px" class="form-control" name="postingPortionsCreditoEdit" value="" id="postingPortionsCreditoEdit"  >
                                            <option> - Selecione - </option>
<?php for ($i = 1; $i <= 10; $i++) { ?>
                                                <option value="<?= $i ?>"> <?php echo $i ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </tr> <br/><br/><br/>
                                    <tr>
                                        <td> Data: </td> <br>
                                    <input style="width: 200px" class="datepickers form-control" type="text" id="postingDateCreditoEdit" value="" name="postingDateCredito" ></input> <br><br>
                                    
                                    </tr>

                                </div>                                                            
                                <div id = "DinheiroEdit" style="display: none"> 
                                    <td> Valor: </td><br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingValueDinheiroEdit" value="" name="postingValueDinheiro" ></input> <br><br>
                                    </tr>
                                    
                                <div id="DinheiroDateEdit" style="display: none"> 
                                    <tr>
                                        <td> Data: </td><br>
                                    <input style="width: 200px" class="datepickers form-control" type="text" id="postingDateDinheiroEdit" name="postingDateDinheiroEdit" ></input> <br><br>
                                    
                                    </tr>
                                </div>

                                </div>

                                <div id = "TransferênciaEdit" style="display: none"> 
                                    <td> Valor: </td> <br>
                                    <input style="width: 200px" class="form-control" type="text" id="postingValueTransferenciaEdit" value="" name="postingValueTransferencia" ></input> <br><br>
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
                                            <button class="btn btn-warning" data-dismiss="modal" onClick="limpaDivEdit()">Fechar</button> 
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