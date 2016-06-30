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
                var string = "<?= $this->config->item("url_link") ?>admin/togglePostingExpensePayed/".concat($(this).attr("id")).concat("/").concat($("#date_".concat($(this).attr("id"))).val());
                var recarrega = "<?= $this->config->item("url_link") ?>reports/postingExpenses/";
                $.post(string).done(function (data) {
                    if (data == 1){
                        alert("Estado do documento modificado com sucesso");
						window.location = recarrega;
                    }
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
            var table2 = document.getElementById("tablebody2");
            var table3 = document.getElementById("tablebody3");
            var name = getCSVName();
            var tablehead = document.getElementsByTagName("thead")[0];
            var document_type;
            var payed = document.getElementById("qtdpayed");
            var payeds2 = document.getElementsByName("payeds2");
            var payeds3 = document.getElementsByName("payeds3");
            var description2 = document.getElementsByName("document_description2");
            var account_types2 = document.getElementsByName("account_types2");
            var names2 = document.getElementsByName("names2");
            var accounts_name2 = document.getElementsByName("accounts_name2");
            var posting_dates2 = document.getElementsByName("posting_dates2");
            var elements2 = document.getElementsByName("document_type2");
            var description3 = document.getElementsByName("document_description3");
            var account_types3 = document.getElementsByName("account_types3");
            var names3 = document.getElementsByName("names3");
            var accounts_name3 = document.getElementsByName("accounts_name3");
            var posting_dates3 = document.getElementsByName("posting_dates3");
            var elements3 = document.getElementsByName("document_type3");
            var account_type;
            var document_description;
            var document_name;
            var account_name;
            var posting_date;

            if(payed.getAttribute("value") > 0){
	            for (var i = 0, row; row = table2.rows[i]; i++) {

		            if(payeds2[i].getAttribute('id') == 'pago' || payeds2[i].getAttribute('id') == 'caixinha' || payeds2[i].getAttribute('id') == 'deb auto'){
		            
		                var data2 = []
		                //Nome, retira pega o que esta entre um <> e outro <>
		                document_type = elements2[i].getAttribute('id');
		                document_description = description2[i].getAttribute('id');
		                account_type = account_types2[i].getAttribute('id');
		                document_name = names2[i].getAttribute('id');
		                account_name = accounts_name2[i].getAttribute('value');
		                posting_date = posting_dates2[i].getAttribute('value');
		                date_post = posting_date.split("/");
		                posting_date = date_post[1].concat("/").concat(date_post[0]).concat("/").concat(date_post[2]);
		                
		                data2.push(account_name);
		                data2.push(account_type);
		                data2.push(document_description);
		                data2.push(posting_date);
		                data2.push(row.cells[4].innerHTML);
		                data2.push(document_name);
		                data.push(data2);
		            }
	            }

	            for (var i = 0, row; row = table3.rows[i]; i++) {

		            if(payeds3[i].getAttribute('id') == 'pago' || payeds3[i].getAttribute('id') == 'caixinha' || payeds3[i].getAttribute('id') == 'deb auto'){
		            
		                var data2 = []
		                //Nome, retira pega o que esta entre um <> e outro <>
		                document_type = elements3[i].getAttribute('id');
		                document_description = description3[i].getAttribute('id');
		                account_type = account_types3[i].getAttribute('id');
		                document_name = names3[i].getAttribute('id');
		                account_name = accounts_name3[i].getAttribute('value');
		                posting_date = posting_dates3[i].getAttribute('value');
		                date_post = posting_date.split("/");
		                posting_date = date_post[1].concat("/").concat(date_post[0]).concat("/").concat(date_post[2]);
		                
		                data2.push(account_name);
		                data2.push(account_type);
		                data2.push(document_description);
		                data2.push(posting_date);
		                data2.push(row.cells[3].innerHTML);
		                data2.push(document_name);
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
            var columName = ["Conta","Categoria","Descrição do Pagamento","Data do Pagamento", "Valor", "Nome"];
            var columnNameToSend = JSON.stringify(columName);
            post('<?= $this->config->item('url_link'); ?>reports/toCSV', {data: dataToSend, name: name, columName: columnNameToSend});
        }

        function accountUpdate(id,portions){
			var account_name = document.getElementById("accounts_".concat(id).concat("_").concat(portions)).value;

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
                        {id: id, portions: portions, account_name: account_name},
                        function (data) {
                            if (data == "true") {
                                alert("Nome de Conta atribuído com sucesso!");
                                location.reload();
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
            
            <?php if(!$secretary){?>
             <button class="button btn btn-primary col-lg-2" onclick="sendTableToCSV()" value="">Exportar</button>
           <br /> <br />
           <?php }?>
            <!-- VENCIDOS DE MESES ANTERIORES -->
                
                <h2>Vencidos de Meses Anteriores</h2>
                <div class = "row">
                    <div class="col-lg-12 middle-content">
                        <table class="table table-bordered table-striped table-min-td-size" style="width: <?php if(!$secretary) echo "980px"; else echo"630px";?>" id="sortable-table">
                            <thead>
                                <tr>
                                    <th style="width:20px; text-align: center" > Doc </th>
                                    <th style="width:100px; text-align: center"> Tipo </th>
                                <!--<th style="width:160px; text-align: center"> Descrição </th> -->
                                    <th style="width:80px; text-align: center"> Parcela </th>
                                    <th style="width:100px; text-align: center"> Valor </th>
                                    <?php if(!$secretary){?>
                                    <th colspan=2 style="width:300px; text-align: center">Nome de Conta</th>
                                    <th colspan=2 style="width:300px; text-align: center">Pagamento</th>
                               		<?php }?>
                                </tr>
                                <tr>
                                	<?php if(!$secretary){?>
                                	<th></th>
                                	<th></th>
                                <!-- <th></th> -->
                                	<th></th>
                                	<th></th>
                                	<th style="width:200px; text-align: center">Nome</th>
                        			<th style="width:100px; text-align: center">Ação</th>
                        			<th style="width:160px; text-align: center">Data</th>
                        			<th style="width:100px; text-align: center">Pago</th>
                        			<?php }?>
                                </tr>
                            </thead>
                            <tbody id="tablebody1">
                            	<input style="display:none" id="qtdpayed" value="<?= $qtdpayed;?>">
                                <?php
                                
                                if($info1){
                                ?>	
                                <?php foreach ($info1 as $i) {
                                    ?>
                                    <tr>
                                    	<input style="display:none" id="<?= $i -> payment_status;?>" name="payeds1">
                                    	<input style="display:none" id="<?= $i -> document_name;?>" name="names1">
                                    	<input style="display:none" id="<?= $i -> account_type;?>" name="account_types1">
                                    	<input style="display:none" id="<?= $i -> document_description;?>" name="document_description1">
                                        <td id="<?php echo $i->document_type;?>" name="document_type1"><a href="<?php echo $this->config->item("url_link"); ?>admin/viewDocument/<?php echo $i->document_expense_id ?>">
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
                                        <td><?php if($i->posting_type == "Transferência") echo "Transf."; else echo $i->posting_type; ?></td>
                                    <!-- <td id="<?php // $i->document_description ?>" name="document_description"><?php // $i->document_description ?></td> -->
                                        <td id="portions_<?=$i->document_expense_id?>_<?= $i->posting_portions ?>" name = "<?= $i->posting_portions ?>"><?= $i->posting_portions ?>/<?= $portions[$i->document_expense_id]?></td>
                                        <td id="value_<?=$i->document_expense_id?>_<?= $i->posting_portions ?>" name = "<?= $i->posting_value ?>"><?= $i->posting_value ?></td>
                                        <?php if(!$secretary){ ?>
                                        <td><input <?php if ($i->posting_value == "" && $i->posting_portions == "") echo "disabled" ?> type="text" name = "accounts_name1" class="accounts" id="accounts_<?= $i->document_expense_id ?>_<?= $i->posting_portions ?>" value="<?php if($i->account_name) echo $i->account_name; else echo ""; ?>">
									</td>
									<?php if ($i->account_name == "") { ?>
                                        <td><button <?php if ($i->posting_value == "" && $i->posting_portions == "") echo "disabled" ?> class="btn btn-danger" onclick="accountUpdate('<?= $i->document_expense_id ?>', '<?= $i->posting_portions ?>')">Salvar</button></td>
                                    <?php } else { ?>
                                        <td><button <?php if ($i->posting_value == "" && $i->posting_portions == "") echo "disabled" ?> class="btn btn-success" onclick="accountUpdate('<?= $i->document_expense_id ?>', '<?= $i->posting_portions ?>')">Atualizar</button> </td>
                                    <?php } ?>
                                    <div style="text-align: center">
                                    	<td style="align:center"><input <?php if ($i->account_name == "" || $i -> payment_status == "caixinha" || $i -> payment_status == "deb auto") echo "disabled" ?> style="align:center" type="text" class="datepickers required form-control" id="date_<?=$i->document_expense_id?>_<?= $i->posting_portions ?>" name = "posting_dates1" value="<?php echo $i->posting_date; ?>"></td>
                                    	</div>
                                    	<?php if($i -> payment_status == "caixinha"){?>
                                    	<td><span title="<?php echo $i->person_operation;?>" > Caixinha </span></td>
                                    	<?php } else if($i -> payment_status == "deb auto"){?>
                                    	<td> Débito Automático </td>
                                    	<?php } else{?>
                                    	<td><input <?php if($i->payment_status == "pago") echo "checkedInDatabase='true'";  if ($i->account_name == "") echo "disabled"; ?> type="checkbox" data-inverse="true" name="my-checkbox" data-size="mini" id="<?=$i->document_expense_id?>_<?= $i->posting_portions ?>"/> </td>
                                    	<?php } }?>
                                    </tr>
                                    <?php
                                }}
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- BOLETOS DO MÊS -->
                <br/>
                
                <h2>Boletos do Mês</h2>
                <div class = "row">
                    <div class="col-lg-12 middle-content">
                        <table class="table table-bordered table-striped table-min-td-size" style="width: <?php if(!$secretary) echo "1150px"; else echo"800px";?>" id="sortable-table">
                            <thead>
                                <tr>
                                    <th style="width:100px; text-align: center" > Data Venc. </th>
                                    <th style="width:20px; text-align: center" > Doc </th>
                                    <th style="width:100px; text-align: center"> Tipo </th>
                                <!--<th style="width:160px; text-align: center"> Descrição </th> -->
                                    <th style="width:80px; text-align: center"> Parcela </th>
                                    <th style="width:100px; text-align: center"> Valor </th>
                                    <th style="width:70px; text-align: center">Boleto</th>
                                    <?php if(!$secretary){?>
                                    <th colspan=2 style="width:300px; text-align: center">Nome de Conta</th>
                                    <th colspan=2 style="width:300px; text-align: center">Pagamento</th>
                               		<?php }?>
                                </tr>
                                <tr>
                                	<?php if(!$secretary){?>
                                	<th></th>
                                	<th></th>
                                	<th></th>
                                <!-- <th></th> -->
                                	<th></th>
                                	<th></th>
                                	<th></th>
                                	<th style="width:200px; text-align: center">Nome</th>
                        			<th style="width:100px; text-align: center">Ação</th>
                        			<th style="width:160px; text-align: center">Data</th>
                        			<th style="width:100px; text-align: center">Pago</th>
                        			<?php }?>
                                </tr>
                            </thead>
                            <tbody id="tablebody2">
                            	<input style="display:none" id="qtdpayed" value="<?= $qtdpayed;?>">
                                <?php
                                
                                if($info2){
                                ?>	
                                <?php foreach ($info2 as $i) {
                                    ?>
                                    <tr>
                                    	<input style="display:none" id="<?= $i -> payment_status;?>" name="payeds2">
                                    	<input style="display:none" id="<?= $i -> document_name;?>" name="names2">
                                    	<input style="display:none" id="<?= $i -> account_type;?>" name="account_types2">
                                    	<input style="display:none" id="<?= $i -> document_description;?>" name="document_description2">
                                        <td><?php if($i->bank_slip_date != "") echo date("d/m/Y",strtotime($i->bank_slip_date)) ?></td>
                                        <td id="<?php echo $i->document_type;?>" name="document_type2"><a href="<?php echo $this->config->item("url_link"); ?>admin/viewDocument/<?php echo $i->document_expense_id ?>">
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
                                        <td><?php if($i->posting_type == "Transferência") echo "Transf."; else echo $i->posting_type; ?></td>
                                    <!-- <td id="<?php // $i->document_description ?>" name="document_description"><?php // $i->document_description ?></td> -->
                                        <td id="portions_<?=$i->document_expense_id?>_<?= $i->posting_portions ?>" name = "<?= $i->posting_portions ?>"><?= $i->posting_portions ?>/<?= $portions[$i->document_expense_id]?></td>
                                        <td id="value_<?=$i->document_expense_id?>_<?= $i->posting_portions ?>" name = "<?= $i->posting_value ?>"><?= $i->posting_value ?></td>
                                        <td>
                                        <?php if($i->posting_type == "Boleto"){?>
                                        	<a href="<?php echo $this->config->item("url_link"); ?>admin/viewPostingUpload?document_id=<?php echo $i->document_expense_id;?>&portions=<?php echo $i->posting_portions; ?>">
                                        <button <?php
                                        if ($i->posting_expense_upload_id) {
                                            echo "class='btn btn-success'>Atualizar";
                                       } else {
                                            echo "class='btn btn-danger'>Upload";
                                        }
                                        ?> 
                                        </button>
                                        </a>
                                        <?php } if(!$secretary){ ?>
                                    </td>
                                        <td><input <?php if ($i->posting_value == "" && $i->posting_portions == "") echo "disabled" ?> type="text" name = "accounts_name2" class="accounts" id="accounts_<?= $i->document_expense_id ?>_<?= $i->posting_portions ?>" value="<?php if($i->account_name) echo $i->account_name; else echo ""; ?>">
									</td>
									<?php if ($i->account_name == "") { ?>
                                        <td><button <?php if ($i->posting_value == "" && $i->posting_portions == "") echo "disabled" ?> class="btn btn-danger" onclick="accountUpdate('<?= $i->document_expense_id ?>', '<?= $i->posting_portions ?>')">Salvar</button></td>
                                    <?php } else { ?>
                                        <td><button <?php if ($i->posting_value == "" && $i->posting_portions == "") echo "disabled" ?> class="btn btn-success" onclick="accountUpdate('<?= $i->document_expense_id ?>', '<?= $i->posting_portions ?>')">Atualizar</button> </td>
                                    <?php } ?>
                                    <div style="text-align: center">
                                    	<td style="align:center"><input <?php if ($i->account_name == "" || $i -> payment_status == "caixinha" || $i -> payment_status == "deb auto") echo "disabled" ?> style="align:center" type="text" class="datepickers required form-control" id="date_<?=$i->document_expense_id?>_<?= $i->posting_portions ?>" name = "posting_dates2" value="<?php echo $i->posting_date; ?>"></td>
                                    	</div>
                                    	<?php if($i -> payment_status == "caixinha"){?>
                                    	<td><span title="<?php echo $i->person_operation;?>" > Caixinha </span></td>
                                    	<?php } else if($i -> payment_status == "deb auto"){?>
                                    	<td> Débito Automático </td>
                                    	<?php } else{?>
                                    	<td><input <?php if($i->payment_status == "pago") echo "checkedInDatabase='true'";  if ($i->account_name == "") echo "disabled"; ?> type="checkbox" data-inverse="true" name="my-checkbox" data-size="mini" id="<?=$i->document_expense_id?>_<?= $i->posting_portions ?>"/> </td>
                                    	<?php } }?>
                                    </tr>
                                    <?php
                                }}
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                
                <!-- OUTROS LANÇAMENTOS DO MÊS -->  
                <br/>
                
                <h2>Outros Lançamentos do Mês</h2>
                
                <div class = "row">
                    <div class="col-lg-12 middle-content">
                        <table class="table table-bordered table-striped table-min-td-size" style="width: <?php if(!$secretary) echo "980px"; else echo"630px";?>" id="sortable-table">
                            <thead>
                                <tr>
                                    <th style="width:20px; text-align: center" > Doc </th>
                                    <th style="width:100px; text-align: center"> Tipo </th>
                                <!--<th style="width:160px; text-align: center"> Descrição </th> -->
                                    <th style="width:80px; text-align: center"> Parcela </th>
                                    <th style="width:100px; text-align: center"> Valor </th>
                                    <?php if(!$secretary){?>
                                    <th colspan=2 style="width:300px; text-align: center">Nome de Conta</th>
                                    <th colspan=2 style="width:300px; text-align: center">Pagamento</th>
                               		<?php }?>
                                </tr>
                                <tr>
                                	<?php if(!$secretary){?>
                                	<th></th>
                                	<th></th>
                                <!-- <th></th> -->
                                	<th></th>
                                	<th></th>
                                	<th style="width:200px; text-align: center">Nome</th>
                        			<th style="width:100px; text-align: center">Ação</th>
                        			<th style="width:160px; text-align: center">Data</th>
                        			<th style="width:100px; text-align: center">Pago</th>
                        			<?php }?>
                                </tr>
                            </thead>
                            <tbody id="tablebody3">
                            	<input style="display:none" id="qtdpayed" value="<?= $qtdpayed;?>">
                                <?php
                                
                                if($info3){
                                ?>	
                                <?php foreach ($info3 as $i) {
                                    ?>
                                    <tr>
                                    	<input style="display:none" id="<?= $i -> payment_status;?>" name="payeds3">
                                    	<input style="display:none" id="<?= $i -> document_name;?>" name="names3">
                                    	<input style="display:none" id="<?= $i -> account_type;?>" name="account_types3">
                                    	<input style="display:none" id="<?= $i -> document_description;?>" name="document_description3">
                                        <td id="<?php echo $i->document_type;?>" name="document_type3"><a href="<?php echo $this->config->item("url_link"); ?>admin/viewDocument/<?php echo $i->document_expense_id ?>">
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
                                        <td><?php if($i->posting_type == "Transferência") echo "Transf."; else echo $i->posting_type; ?></td>
                                    <!-- <td id="<?php // $i->document_description ?>" name="document_description"><?php // $i->document_description ?></td> -->
                                        <td id="portions_<?=$i->document_expense_id?>_<?= $i->posting_portions ?>" name = "<?= $i->posting_portions ?>"><?= $i->posting_portions ?>/<?= $portions[$i->document_expense_id]?></td>
                                        <td id="value_<?=$i->document_expense_id?>_<?= $i->posting_portions ?>" name = "<?= $i->posting_value ?>"><?= $i->posting_value ?></td>
                                        <?php if(!$secretary){ ?>
                                        <td><input <?php if ($i->posting_value == "" && $i->posting_portions == "") echo "disabled" ?> type="text" name = "accounts_name3" class="accounts" id="accounts_<?= $i->document_expense_id ?>_<?= $i->posting_portions ?>" value="<?php if($i->account_name) echo $i->account_name; else echo ""; ?>">
									</td>
									<?php if ($i->account_name == "") { ?>
                                        <td><button <?php if ($i->posting_value == "" && $i->posting_portions == "") echo "disabled" ?> class="btn btn-danger" onclick="accountUpdate('<?= $i->document_expense_id ?>', '<?= $i->posting_portions ?>')">Salvar</button></td>
                                    <?php } else { ?>
                                        <td><button <?php if ($i->posting_value == "" && $i->posting_portions == "") echo "disabled" ?> class="btn btn-success" onclick="accountUpdate('<?= $i->document_expense_id ?>', '<?= $i->posting_portions ?>')">Atualizar</button> </td>
                                    <?php } ?>
                                    <div style="text-align: center">
                                    	<td style="align:center"><input <?php if ($i->account_name == "" || $i -> payment_status == "caixinha" || $i -> payment_status == "deb auto") echo "disabled" ?> style="align:center" type="text" class="datepickers required form-control" id="date_<?=$i->document_expense_id?>_<?= $i->posting_portions ?>" name = "posting_dates3" value="<?php echo $i->posting_date; ?>"></td>
                                    	</div>
                                    	<?php if($i -> payment_status == "caixinha"){?>
                                    	<td><span title="<?php echo $i->person_operation;?>" > Caixinha </span></td>
                                    	<?php } else if($i -> payment_status == "deb auto"){?>
                                    	<td> Débito Automático </td>
                                    	<?php } else{?>
                                    	<td><input <?php if($i->payment_status == "pago") echo "checkedInDatabase='true'";  if ($i->account_name == "") echo "disabled"; ?> type="checkbox" data-inverse="true" name="my-checkbox" data-size="mini" id="<?=$i->document_expense_id?>_<?= $i->posting_portions ?>"/> </td>
                                    	<?php } }?>
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