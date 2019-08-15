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

		function sortLowerCase(l, r) {
			return l.toLowerCase().localeCompare(r.toLowerCase());
		}

		function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
			return '';
		}

		function myFunction(a, b) {
		    return points.sort(function(a, b){return a-b});
		}

		function sendTableToCSV() {
                var data = [];
                var table = document.getElementById("tablebody");
                var name = getCSVName();
                var elements = document.getElementsByName('responsavel');
                var tablehead = document.getElementsByTagName("thead")[0];
                for (var i = 0, row; row = table.rows[i]; i++) {
                    var data2 = []
                    //Nome, retira pega o que esta entre um <> e outro <>
                    var email = elements[i].getAttribute('id');

                    data2.push(email);
                    data2.push(row.cells[4].innerHTML.split("<")[1].split(">")[1]);
                    data.push(data2)
                }
                if (i == 0) {
                    alert('Não há dados para geração da planilha');
                    return;
                }
                var dataToSend = JSON.stringify(data);
                var columName = ["Email", "Nome"];
                var columName = ["Email"];
                var columnNameToSend = JSON.stringify(columName);

                post('<?= $this->config->item('url_link'); ?>reports/toCSV', {data: dataToSend, name: name, columName: columnNameToSend});
        }


		var selectTodos = {
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
    	padding-right:50%;
    
    }
    
    </style>
    <body>
        <script>
        $(document).ready(function() {
			$('#sortable-table').datatable({
				pageSize : Number.MAX_VALUE,
				sort : [sortLowerCase, true, true, true],
				filters : [false,false,false,selectTodos],
				filterText : 'Escreva para filtrar... ',
				counterText : showCounter,
				sortKey : 1
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
						Colônia: <select name="colonia_f" onchange="this.form.submit()" id="colonia">
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
						Gênero: <select name="genero_f" onchange="this.form.submit()" id="genero">
					
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
					<button class="btn btn-primary" onclick="sendTableToCSV()" value="">Fazer download da tabela abaixo como csv</button>

					<?php if (isset($colonia_escolhida) && isset($colonists)){ ?>
                    <table class="table table-bordered table-striped table-min-td-size" style="width: 1100px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th>Colonista</th>
                                <th>Idade</th>
                                <th>Ano Escolar</th>
                                <th>Status</th>                                
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php
                            foreach ($colonists as $colonist) {
                                ?>
                                <tr>
                                    <td><a id="<?= $colonist->colonist_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?type=report&colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> camp_id ?>"><?= $colonist -> colonist_name ?></a></td>
                                    <td><?php $age = preg_split('/y/', $colonist -> age); echo $age[0]; ?></td>
                                    <td><?= $colonist -> school_year; ?></td>
                                 	 <td id="colonist_situation_<?=$colonist->colonist_id?>_<?=$colonist->camp_id?>"><font color="
	                                <?php
	                                    switch ($colonist->situation) {
	                                    	case SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED: echo "#061B91"; break;
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
                    <?php } ?>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>