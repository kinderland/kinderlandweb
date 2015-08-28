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
		
		<script>

		function post(path, params, method) {
			method = method || "post"; // Set method to post by default if not specified.

	    	// The rest of this code assumes you are not using a library.
			// It can be made less wordy if you use one.
		    var form = document.createElement("form");
		    form.setAttribute("method", method);
		    form.setAttribute("action", path);

		    for(var key in params) {
		        if(params.hasOwnProperty(key)) {
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

		function getCSVName(){
			var filtros = $(".datatable-filter");
			var filtroNomeColonista = filtros[1].value;
			var e = document.getElementById("colonia");
			var filtroColonia = filtros[2].value;
			var filtroNomeResponsavel = filtros[3].value;
			var filtroStatus = filtros[0].value;
			var nomePadrao = "inscricoes";
			
			
			if(filtroNomeColonista == "" && filtroNomeResponsavel == ""){
				
					if(filtroColonia == false) {

						nomePadrao = nomePadrao.concat("_todas_colonias");
					}
					
					else {
						nomePadrao = nomePadrao.concat("_".concat(filtroColonia));
					}
					
					
					if(filtroStatus == false) {
						return nomePadrao.concat("_todos_status");
					}
					else {

						if(filtroStatus == "Cancelado") {
							return nomePadrao.concat("_cancelados");
						}
						else if(filtroStatus == "Excluido") {
							return nomePadrao.concat("_excluidos");
						}
						else if(filtroStatus == "Desistente") {
							return nomePadrao.concat("_desistentes");
						}
						else if(filtroStatus == "Pré-inscrição em elaboração") {
							return nomePadrao.concat("_em_elaboração");
						}
						else if(filtroStatus == "Pré-inscrição aguardando validação") {
							return nomePadrao.concat("_aguardando_validação");
						}
						else if(filtroStatus == "Pré-inscrição validada") {
							return nomePadrao.concat("_validados");
						}
						else if(filtroStatus == "Pré-inscrição na fila de espera") {
							return nomePadrao.concat("_em_fila_espera");
						}
						else if(filtroStatus == "Pré-inscrição aguardando pagamento") {
							return nomePadrao.concat("_aguardando_pagamento");
						}
						else if(filtroStatus == "Pré-inscrição não validada") {
							return nomePadrao.concat("_não_validados");
						}
						else if(filtroStatus == "Inscrito") {
							return nomePadrao.concat("_inscritos");
						}						
					}
			}
			else{
				if(filtroNomeResponsavel == "") {
					return nomePadrao.concat("_filtrado_por_colonista_".concat(filtroNomeColonista));
				}				
				else if (filtroNomeColonista == "") {
					return nomePadrao.concat("_filtrado_por_responsavel_".concat(filtroNomeResponsavel));
				}
				else {
					nomePadrao = nomePadrao.concat("_filtrado_por_responsavel_".concat(filtroNomeResponsavel));
					return nomePadrao.concat("_e_por_colonista_".concat(filtroNomeColonista));
				}
			}
		}			
		

        function sendTableToCSV(){
    		var data = [];
    		var table = document.getElementById("tablebody");
    		var name = getCSVName();
    		var elements = document.getElementsByName('responsavel');
    		var tablehead = document.getElementsByTagName("thead")[0];
    		for (var i = 0, row; row = table.rows[i]; i++) {
    			var data2 = []
            	//Nome, retira pega o que esta entre um <> e outro <>
				var email = elements[i].getAttribute( 'id' );
				
				data2.push(email);
            	data2.push(row.cells[3].innerHTML.split("<")[1].split(">")[1]);
            	data.push(data2)
	        } 
	        if(i==0){
   				alert('Não há dados para geração da planilha');
   				return;
	        }
	        var dataToSend = JSON.stringify(data);
	        var columName = ["Email","Nome"];
	        var columnNameToSend = JSON.stringify(columName);
	        
	        post('<?= $this -> config -> item('url_link'); ?>reports/toCSV', {data: dataToSend,name: name,columName: columnNameToSend});
		}

		var selectTodas = {
				element : null,
				values : "auto",
				empty : "Todas",
				multiple : false,
				noColumn : false,
			}
		
		var selectTodos = {
				element : null,
				values : "auto",
				empty : "Todos",
				multiple : false,
				noColumn : false,
			}
		
		function sortLowerCase(l, r) {
			return l.toLowerCase().localeCompare(r.toLowerCase());
		}

		function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
			return 'Apresentando ' + totalRow + ' inscrições, de um total de ' + totalRowUnfiltered+ ' inscrições';
		}

		</script>

    </head>
    <body>
        <script>
        $(document).ready(function() {
			$('#sortable-table').datatable({
				pageSize : Number.MAX_VALUE,
				sort : [true, sortLowerCase,true, sortLowerCase],
				filters : [selectTodos, true, selectTodas, true],
				filterText : 'Escreva para filtrar... ',
				counterText	: showCounter
			});
		});
        </script>
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
                	<form method="GET">
						<select name="ano_f" onchange="this.form.submit()" id="anos">
					
							<?php
							foreach ( $years as $year ) {
								$selected = "";
								if ($ano_escolhido == $year)
									$selected = "selected";
								echo "<option $selected value='$year'>$year</option>";
							}
							?>
						</select>
					</form>
					<div class="counter"></div> <br>
					<button class="button" onclick="sendTableToCSV()" value="">Fazer download da tabela abaixo como csv</button> <br></br>
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 700px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th>Status da Inscrição</th>
                                <th>Nome do Colonista</th>
                                <th>Colônia</th>
                                <th>Responsável</th>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php
                            foreach ($colonists as $colonist) {
                                ?>
                                <tr>
	                                <td id="colonist_situation_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>"><font color="
	                                <?php
	                                    switch ($colonist->situation) {
	                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION: echo "#061B91"; break;
	                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED: echo "#017D50"; break;
	                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS: echo "#FF0000"; break;
	                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN: echo "#555555"; break;
	                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_CANCELLED: echo "#FF0000"; break;
	                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_EXCLUDED: echo "#FF0000"; break;
	                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_GIVEN_UP: echo "#FF0000"; break;
	                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_QUEUE: echo "#555555"; break;
	                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_PENDING_PAYMENT: echo "#061B91"; break;
	                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED: echo "#017D50"; break;
	                                    }
	                                ?>"><?= $colonist -> situation_description ?></td>
	                               
                                    <td><a id="<?= $colonist->colonist_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> summer_camp_id ?>"><?= $colonist -> colonist_name ?></a></td>
                                    <td><?= $colonist->camp_name ?></td>
                                    <td><a name= "responsavel" id="<?= $colonist -> email ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> person_user_id ?>"><?= $colonist -> user_name ?></a></td>
                                 </tr>
	                                <?php
	                            }
	                            ?>    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
