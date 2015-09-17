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
			var filtroColonia = $("#colonia option:selected").text();
			var filtroGenero = $("#genero option:selected").text();
			var nomePadrao = "fila-de-espera-";
			
			nomePadrao = nomePadrao.concat(filtroColonia);
			nomePadrao = nomePadrao.concat("-");
			return nomePadrao.concat(filtroGenero);		
			
		}			
		

        function sendTableToCSV(){
    		var data = [];
    		var table = document.getElementById("tablebody");
    		var name = getCSVName();
    		var status;
    		var tablehead = document.getElementsByTagName("thead")[0];
    		for (var i = 0, row; row = table.rows[i]; i++) {
    			var data2 = []

    			status = row.cells[3].innerHTML;
    			status = status.split(">");
    			status = status[1];
    			status = status.split("<");
            	//Nome, retira pega o que esta entre um <> e outro <>
            	data2.push(row.cells[0].innerHTML);
            	data2.push(row.cells[1].innerHTML.split("<")[1].split(">")[1]);
            	data2.push(row.cells[2].innerHTML.split("<")[1].split(">")[1]);
            	data2.push(status[0]);
            	data.push(data2)
	        } 
	        if(i==0){
   				alert('Não há dados para geração da planilha');
   				return;
	        }
	        var dataToSend = JSON.stringify(data);
	        var columName = ["Posição","Colonista","Responsável","Status"];
	        var columnNameToSend = JSON.stringify(columName);
	        
	        post('<?= $this -> config -> item('url_link'); ?>reports/toCSV', {data: dataToSend,name: name,columName: columnNameToSend});
		}

        function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
			return '';
		}


		</script>

    </head>
    <body>
        <script>
        $(document).ready(function() {
			$('#sortable-table').datatable({
				pageSize : Number.MAX_VALUE,
				sort : [false, false, false, false],
				filterText : 'Escreva para filtrar... ',
				counterText : showCounter,
				sortKey : 0
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
						<select name="colonia_f" onchange="this.form.submit()" id="colonia">
							<?php if (!(isset($discountsT) && isset($discountsI) && !is_null($discountsT) && !is_null($discountsI))){ ?>
							<option value="0" <?php if(!isset($colonia_escolhida)) echo "selected"; ?>>-- Selecionar --</option>
							<?php }
							foreach ( $camps as $camp ) {
								$selected = "";
								if ($colonia_escolhida == $camp)
									$selected = "selected";
								echo "<option $selected value='$camp'>$camp</option>";
							}
							?>
						</select>
						<select name="genero_f" onchange="this.form.submit()" id="genero">
					
							<?php
							foreach ( $genders as $gender ) {
								$selected = "";
								if ($genero_escolhido == $gender)
									$selected = "selected";
								echo "<option $selected value='$gender'>$gender</option>";
							}
							?>
						</select>
					</form>
					<div class="counter"></div> <br>
					<?php if (isset($colonia_escolhida) && isset($colonists)){ ?>
					<button class="button" onclick="sendTableToCSV()" value="">Fazer download da tabela abaixo como csv</button> <br></br>
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 600px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                            	<th>Posição</th>
                                <th>Colonista</th>
                                <th>Responsável</th>
                                <th>Status</th>                                
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php
                            foreach ($colonists as $colonist) {
								?>
                                <tr>
                                	<td><?= $colonist->queue_number?></td>
                                    <td><a id="<?= $colonist->colonist_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?type=report&colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> summer_camp_id ?>"><?= $colonist -> colonist_name ?></a></td>
                                    <td><a target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> person_user_id ?>"><?= $colonist -> responsible_name ?></a></td>
                                 	 <td name= "status" id="<?=$colonist -> description?>"><font color="
	                                <?php
	                                    switch ($colonist->situation) {
	                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_PENDING_PAYMENT: echo "#061B91"; break;
	                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED: echo "#017D50"; break;
	                                    }
	                                ?>"><?= $colonist -> description ?></font></td>
                                 </tr>
	                                <?php
								}
	                            ?>    
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>