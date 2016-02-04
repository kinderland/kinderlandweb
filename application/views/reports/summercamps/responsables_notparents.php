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

		var selectTodas = {
				element : null,
				values : "auto",
				empty : "Todas",
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
    
    	}
		
		</style>
<body>

	<script>
	$(document).ready(function() {
		$('#sortable-table').datatable({
			pageSize : Number.MAX_VALUE,
			sort : [sortLowerCase,true,sortLowerCase],
			filters : [true,selectTodas,true],
			filterText : 'Escreva para filtrar... ',
			counterText	: showCounter
		});
	});
        </script>
	<div class="scroll">
	<div class="main-container-report">
		<div class="row">
			<div class="col-lg-10">
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
				<table class="table table-bordered table-striped table-min-td-size"
					style="width: 93%; font-size:15px" id="sortable-table">
					<thead>
						<tr>
							<th align="right">Colonista</th>
							<th align="right">Colônia</th>
							<th align="right">Responsável</th>
						</tr>	
					 </thead>
					 <tbody id="tablebody"> 
					 <?php
                          	if(is_array($colonists))
                             foreach ($colonists as $colonist) {
                          ?>  
						<tr>
							<td><a id="<?= $colonist -> colonist ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?type=report&colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> camp_id ?>"><?= $colonist -> colonist ?></a></td>
							<td><?= $colonist -> camp_name ?></td>
                            <td><a id="<?= $colonist -> responsable ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> responsable_id ?>"><?= $colonist -> responsable ?></a></td>
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