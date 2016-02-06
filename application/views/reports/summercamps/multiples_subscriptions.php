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

		function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
			return 'Apresentando ' + totalRow + ' colonistas, de um total de ' + totalRowUnfiltered+ ' colonistas';
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
    
    	}
    
    </style>
    <body>
        <script>
        $(document).ready(function() {
			$('#sortable-table').datatable({
				pageSize : Number.MAX_VALUE,
				sort : [sortLowerCase, true, sortLowerCase, true],
				filters : [true,selectTodas,true, selectTodos],
				filterText: 'Escreva para filtrar... ',
				counterText	: showCounter,
				sortKey : 0				
			});
		});
        </script>
        <div class="scroll">
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
					<div class="counter"></div>
                    <table class="table table-bordered table-striped table-min-td-size" style="width: 1000px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                            	<th style="min-width: 100px; max-width: 100px">Nome do Colonista</th>
                            	<th style="min-width: 140px; max-width: 140px">Colônia</th>
                                <th style="min-width: 100px; max-width: 100px">Responsável</th>
                                <th style="min-width: 140px; max-width: 140px">Status</th>
                                <th style="min-width: 80px; max-width: 70px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                          	if(is_array($colonists))
                             foreach ($colonists as $colonist) {
                               ?> 
                                <tr>
                                	<td><a id="<?= $colonist -> colonist_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?type=report&colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> camp_id ?>"><?= $colonist->colonist_name ?></a></td>
                                    <td><?= $colonist->camp_name ?></td>
                                    <td><a id="<?= $colonist -> responsable_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> responsable_id ?>"><?= $colonist -> responsable_name ?></a></td>
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
                                    <td><a target='blank' href="<?= $this -> config -> item('url_link');?>admin/viewEmails/<?= $colonist -> responsable_id ?>"> Ver e-mails enviados</a></td>
                                    
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