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

		var numero = {
				element : null,
				values : "auto",
				empty : "Todos",
				multiple : false,
				noColumn : false,
				
			}

		function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
			
			return '';
		}

		function sortLowerCase(l, r) {
			return l.toLowerCase().localeCompare(r.toLowerCase());
		}

		</script>

    </head>
    <style>
    
    div.scroll{
    	
    	width:100%;
    	height:100%;
    	overflow-x:hidden;
    	padding-right:60%;
    
    }
    
    
    
    </style>
    <body>
        <script>
        $(document).ready(function() {
			$('#sortable-table').datatable({
				pageSize : Number.MAX_VALUE,
				sort : [sortLowerCase, sortLowerCase,sortLowerCase, true,true],
				filters : [true,true,false,false],
				filterText: 'Escreva para filtrar... ',
				counterText	: showCounter
				
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
                    <table class="table table-bordered table-striped table-min-td-size" style="width: 1100px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Responsável não-sócio </th>
                                <th> Sócio que indicou </th>
                                <th> Número de Pré-inscrições </th>
                                <th> Número de Inscrições </th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                          	if(is_array($info))
                             foreach ($info as $i) {
                               ?> 
                                <tr>
                                	<td><a id="<?= $i -> responsable_id ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $i -> responsable_id ?>"><?= $i -> responsable_name ?></a></td>
                                    <td><a id="<?= $i -> associate_id ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $i -> associate_id ?>"><?= $i -> associate_name ?></a></td>
                                    <td><?= $i -> presubscription ?></td>
                                    <td><?= $i -> subscription ?></td>
                                    
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