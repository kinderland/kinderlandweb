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
			var filtroNomeColonista = filtros[0].value;
			var filtroColonia = filtros[1].value;
			var filtroNomeResponsavel = filtros[2].value;
			var year = document.getElementById('anos').value;
			var nomePadrao = "lista_pai_mae_iguais";
			
			
			if(filtroNomeColonista == "" && filtroNomeResponsavel == ""){
				
					if(filtroColonia == false) {

						nomePadrao = nomePadrao.concat("_todas_colonias_".concat(year));
					}
					
					else {
						nomePadrao = nomePadrao.concat("_".concat(filtroColonia).concat("_".concat(year)));
					}

					return nomePadrao;
			}
			else{
				if(filtroNomeResponsavel == "") {
					return nomePadrao.concat("_filtrado_por_colonista_".concat(filtroNomeColonista));
				}				
				else if (filtroNomeColonista == "") {
					return nomePadrao.concat("_filtrado_por_resposavel_".concat(filtroNomeResponsavel));
				}
				else {
					nomePadrao = nomePadrao.concat("_filtrado_por_resposavel_".concat(filtroNomeResponsavel));
					return nomePadrao.concat("_e_por_colonista_".concat(filtroNomeColonista));
				}
			}
		}			
		

        function sendTableToCSV(){
    		var data = [];
    		var table = document.getElementById("tablebody");
    		var name = getCSVName();
    		var tablehead = document.getElementsByTagName("thead")[0];
    		for (var i = 0, row; row = table.rows[i]; i++) {
    			var data2 = []
            	//Nome, retira pega o que esta entre um <> e outro <>
				data2.push(row.cells[0].innerHTML.split("<")[1].split(">")[1]);
            	data2.push(row.cells[2].innerHTML.split("<")[1].split(">")[1]);
            	data.push(data2)
	        } 
	        if(i==0){
   				alert('Não há dados para geração da planilha');
   				return;
	        }
	        var dataToSend = JSON.stringify(data);
	        var columName = ["Nome do Colonista","Nome do Responsável"];
	        var columnNameToSend = JSON.stringify(columName);
	        
	        post('<?= $this -> config -> item('url_link'); ?>reports/toCSV', {data: dataToSend,name: name,columName: columnNameToSend});
		}

		function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
			return '';
		}

		function sortLowerCase(l, r) {
			return l.toLowerCase().localeCompare(r.toLowerCase());
		}

		var selectTodas = {
				element : null,
				values : "auto",
				empty : "Todas",
				multiple : false,
				noColumn : false,
			}

		selectTodos = {
				element : null,
				values : "auto",
				empty : "Todos",
				multiple : false,
				noColumn : false,
			}

		</script>

    </head>
    <style>
    
    div.scroll{
    	
    		width:100%;
    		height:100%;
    		overflow-x:hidden;
    		padding-right:550px;
    
    	}
    
    </style>
    <body>
        <script>
        $(document).ready(function() {
			$('#sortable-table').datatable({
				pageSize : Number.MAX_VALUE,
				sort : [sortLowerCase, true, sortLowerCase, true],
				filters : [true, selectTodas, true, selectTodos],
				filterText : 'Escreva para filtrar... ',
				counterText	: showCounter,
				sortKey : 2
			});
		});
        </script>
        <div class="scroll">
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
                	<form method="GET">
						Ano: <select name="ano_f" onchange="this.form.submit()" id="anos">
					
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
					
					<div class="counter"></div>
					<button class="button" onclick="sendTableToCSV()" value="">Fazer download da tabela abaixo como csv</button> <br></br>
                    <table class="table table-bordered table-striped table-min-td-size" style="width: 1100px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Nome do Colonista </th>
                                <th> Colônia </th>
                                <th> Responsável </th>
                                <th> Status </th>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                          <?php
                          	if(is_array($colonists))
                             foreach ($colonists as $colonist) {
                                ?>
                                <tr>
                                	<td><a id="<?= $colonist->colonist_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?type=report&colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> camp_id ?>"><?= $colonist -> colonist_name ?></a></td>
                                    <td><?= $colonist->camp_name ?></td>
                                    <td><a id="<?= $colonist -> responsable ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> responsable_id ?>"><?= $colonist -> responsable ?></a></td>
                                	<td id="colonist_situation_<?=$colonist->colonist_id?>_<?=$colonist->camp_id?>"><font color="
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
                                </tr>                                   
                                  <?php
                            }
                            ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>