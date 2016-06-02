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
        function datepickers() {
            $('.datepickers').datepicker();
            $(".datepickers").datepicker("option", "dateFormat", "dd/mm/yy");
        }
        $(function () {
            $("#sortable-table").tablesorter({widgets: ['zebra']});
            $(".datepicker").datepicker();
            $("#sortable-table").removeClass("tablesorter tablesorter-default");
        });
        $(document).ready(function () {
            $("[name='my-checkbox']").bootstrapSwitch();
            $("[name='my-checkbox']").each(function (index) {
                if ($(this).attr("checkedInDatabase") != undefined)
                    $(this).bootstrapSwitch('state', true, true);
            });
            datepickers();
            $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function (event, state) {
                var string = "<?= $this->config->item("url_link") ?>admin/togglePostingExpensePayed/".concat($(this).attr("id")).concat("/").concat($("#value_".concat($(this).attr("id"))).attr("name")).concat("/").concat($("#portions_".concat($(this).attr("id"))).attr("name")).concat("/").concat($("#date_".concat($(this).attr("id"))).attr("value"));
                var recarrega = "<?= $this->config->item("url_link") ?>reports/postingExpenses/";
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

        function getCSVName() {

            var nomePadrao = "lancamentos-";
            var mes = $("#month").val();
            var ano = $("#year").val();
            var mesReal = "";

            switch(mes) {
	            case "0":
	            	mesReal = "todos-os-meses-";
	                break;
	            case "1":
	            	mesReal="janeiro-";
	                break;
	            case "2":
	            	mesReal="fevereiro-";
	                break;
	            case "3":
	            	mesReal="março-";
	                break;
	            case "4":
	            	mesReal="abril-";
	                break;
	            case "5":
	            	mesReal="maio-";
	                break;
	            case "6":
	            	mesReal="junho-";
	                break;
	            case "7":
	            	mesReal="julho-";
	                break;
	            case "8":
	            	mesReal="agosto-";
	                break;
	            case "9":
	            	mesReal="setembro-";
	                break;
	            case "10":
	            	mesReal="outubro-";
	                break;
	            case "11":
	            	mesReal="novembro-";
	                break;
	            case "12":
	            	mesReal="dezembro-";
	                break;
	        }
            
            nomePadrao = nomePadrao.concat(mesReal);
            nomePadrao = nomePadrao.concat(ano);
            
            return nomePadrao;
        }


        function sendTableToCSV() {
            var data = [];
            var table = document.getElementById("tablebody");
            var name = getCSVName();
            var elements = document.getElementsByName("document_type");
            var tablehead = document.getElementsByTagName("thead")[0];
            var document_type;
            var payed = document.getElementById("qtdpayed");
            var payeds = document.getElementsByName("payeds");
            var description = document.getElementsByName("document_description");
            var document_description;

            if(payed.getAttribute("name") > 0){
	            for (var i = 0, row; row = table.rows[i]; i++) {

		            if(payeds[i].getAttribute('id') == 't'){
		            
		                var data2 = []
		                //Nome, retira pega o que esta entre um <> e outro <>
		                document_type = elements[i].getAttribute('id');
		                document_description = description[i].getAttribute('id');
		                
		                data2.push(row.cells[7].innerHTML);
		                data2.push(row.cells[8].innerHTML);
		                data2.push(document_description);
		                data2.push(row.cells[0].innerHTML);
		                data2.push(row.cells[5].innerHTML);
		                data2.push(document_type);
		                data.push(data2);
		            }
	            }
            } else {
                var i = 0;
            }
            if (i == 0) {
                alert('Não há dados para geração da planilha');
                return;
            }


            var dataToSend = JSON.stringify(data);
            var columName = ["Nome de Conta","Categoria","Descrição","Data", "Valor", "Tipo de Documento"];
            var columnNameToSend = JSON.stringify(columName);
            post('<?= $this->config->item('url_link'); ?>reports/toCSV', {data: dataToSend, name: name, columName: columnNameToSend});
        }

        function accountUpdate(id,portions,value){
			var account_name = document.getElementById("accounts_".concat(id)).value;

			var names = document.getElementById("accountsNames").value;
			names = names.split("/");

			var ok = 0;

			for(var i = 0; i < names.length; i++){
				if(account_name.localeCompare(names[i]) == 0){
					ok = 1;
					break;
				}
			}	

			if(ok == 1){
				$.post('<?= $this->config->item('url_link'); ?>admin/updateAccountName',
                        {id: id, portions: portions, value: value, account_name: account_name},
                        function (data) {
                            if (data == "true") {
                                alert("Nome de Conta atribuído com sucesso!");
                            } else if (data == "false") {
                                alert("Ocorreu um erro na atribuição de Nome de Conta!");
                                location.reload();
                            }
                        }
                );
			}else{
				alert("Nome de conta inválido. Insira um nome existente!");
			}		
		}

		$(function() {
		    var availableTags = document.getElementById("accountsNames").value;
		    availableTags = availableTags.split("/");

		    $(".accounts").autocomplete({
			      source: availableTags
			});
		  });

        </script>
        <body>
        <br />
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
                    <option value="0" <?php if (!isset($mes)) echo "selected"; ?>>Todos</option>
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
            <input style="display:none" id="accountsNames" value="<?php echo $accountNames;?>">
             <button class="button btn btn-primary col-lg-2" onclick="sendTableToCSV()" value="">Exportar</button>
            <br /> <br />
           
                <div class = "row">
                    <div class="col-lg-12 middle-content">
                        <table class="table table-bordered table-striped table-min-td-size" style="width:1200px" id="sortable-table">
                            <thead>
                                <tr>
                                    <th style="width:100px; text-align: center" > Data Venc. </th>
                                    <th style="width:20px; text-align: center" > Doc </th>
                                    <th style="width:150px; text-align: center"> Tipo </th>
                                <!--<th style="width:160px; text-align: center"> Descrição </th> -->
                                    <th style="width:80px; text-align: center"> Parcela </th>
                                    <th style="width:100px; text-align: center"> Valor </th>
                                    <th style="width:70px; text-align: center">Boleto</th>
                                    <th colspan=2 style="width:300px; text-align: center">Nome de Conta</th>
                                    <th colspan=2 style="width:300px; text-align: center">Pagamento</th>
                                </tr>
                                <tr>
                                	<th></th>
                                	<th></th>
                                	<th></th>
                                <!-- <th></th> -->
                                	<th></th>
                                	<th></th>
                                	<th></th>
                                	<th style="width:200px; text-align: center">Nome</th>
                        			<th style="width:100px; text-align: center">Ação</th>
                        			<th style="width:150px; text-align: center">Data</th>
                        			<th style="width:100px; text-align: center">Pago</th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                                <?php
                                
                                if($info){
                                ?>	<input style="display:none" id="qtdpayed" name="<?= $qtdpayed;?>">
                                <?php foreach ($info as $i) {
                                    ?>
                                    <tr>
                                    	<input style="display:none" id="<?= $i -> payed;?>" name="payeds">
                                        <td><?php if($i->posting_date != "") echo date("d/m/Y",strtotime($i->posting_date)) ?></td>
                                        <td id="<?php echo $i->document_type;?>" name="document_type"><a href="<?php echo $this->config->item("url_link"); ?>admin/viewDocument/<?php echo $i->document_expense_id ?>">
                                            <?php switch($i->document_type){
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
                                            
                                            ?> </a></td>
                                        <td><?= $i->posting_type ?></td>
                                    <!-- <td id="<?php // $i->document_description ?>" name="document_description"><?php // $i->document_description ?></td> -->
                                        <td id="portions_<?=$i->document_expense_id?>" name = "<?= $i->posting_portions ?>"><?= $i->posting_portions ?>/<?= $portions[$i->document_expense_id]?></td>
                                        <td id="value_<?=$i->document_expense_id?>" name = "<?= $i->posting_value ?>"><?= $i->posting_value ?></td>
                                        <td>
                                        <?php if($i->posting_type == "Boleto"){?>
                                        	<a href="<?php echo $this->config->item("url_link"); ?>admin/viewDocumentUpload?document_id=<?php echo $i->document_expense_id;?>">
                                        <button <?php
                                     //   if ($i->document_expense_upload_id) {
                                     //       echo "class='btn btn-success'>Atualizar";
                                     //   } else {
                                            echo "class='btn btn-danger'>Upload";
                                      //  }
                                        ?> 
                                        </button>
                                        </a>
                                        <?php } ?>
                                    </td>
                                        <td><input <?php if ($i->posting_value == "" && $i->posting_value == "") echo "disabled" ?> type="text" class="accounts" id="accounts_<?= $i->document_expense_id ?>" value="<?php if($i->account_name) echo $i->account_name; else echo ""; ?>">
									</td>
									<?php if ($i->account_name == "") { ?>
                                        <td><button <?php if ($i->posting_value == "" && $i->posting_portions == "") echo "disabled" ?> class="btn btn-danger" onclick="accountUpdate('<?= $i->document_expense_id ?>', '<?= $i->posting_portions ?>','<?= $i->posting_value ?>')">Salvar</button></td>
                                    <?php } else { ?>
                                        <td><button <?php if ($i->posting_value == "" && $i->posting_portions == "") echo "disabled" ?> class="btn btn-success" onclick="accountUpdate('<?= $i->document_expense_id ?>', '<?= $i->posting_portions ?>','<?= $i->posting_value ?>')">Atualizar</button> </td>
                                    <?php } ?>
                                    <div style="text-align: center">
                                    	<td><input <?php if ($i->account_name == "") echo "disabled" ?> style="align:center" type="text" class="datepickers required form-control" id="date_<?=$i->document_expense_id?>" value="<?php echo $i->posting_date; ?>"></td>
                                    	</div>
                                    	<td><input <?php if ($i->account_name == "") echo "disabled" ?> type="checkbox" data-inverse="true" name="my-checkbox" data-size="mini" id="<?=$i->document_expense_id?>" 
        							<?php if($i->payed == "t") echo "checkedInDatabase='true'";?> /> </td>
                                    </tr>
                                    <?php
                                }}
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </body>
</html>