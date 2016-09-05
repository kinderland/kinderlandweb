<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this -> config -> item('assets'); ?>css/basic.css" rel="stylesheet" />
        <link href="<?= $this -> config -> item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/bootstrap-switch.min.css">
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/theme.default.css" />
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/ui/jquery-ui.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquerysettings.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery/jquery.redirect.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/formValidationFunctions.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/bootstrap-switch.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery/jquery.mask.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>datatable/js/datatable.min.js"></script>
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>datatable/css/datatable-bootstrap.min.css" />
	
	<script>
		
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
			return 'Apresentando ' + totalRow + ' colonistas, de um total de ' + totalRowUnfiltered+ ' colonistas';
		}

		</script>

    </head>
    <style>
    
    div.scroll{
    	
    	width:100%;
    	height:100%;
    	overflow-x:hidden;
    	padding-right:500;
    
    }
    
    div.pad{
    	padding-left:25%;
    }
    
    div.pad1{
   		padding-left:10%;
   	}
    
    </style>
    <body>
        <script>
        $(document).ready(function() {
			$('#sortable-table').datatable({
				pageSize : Number.MAX_VALUE,
				sort : [sortLowerCase, sortLowerCase, true, true, true],
				filters : [true, true, selectTodos, false, selectTodos],
				filterText : 'Escreva para filtrar... ',
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
						Colônia: <select name="colonia_f" onchange="this.form.submit()" id="colonia">
							<?php if (!(isset($discountsT) && isset($discountsI) && !is_null($discountsT) && !is_null($discountsI))){ ?>
							<option value="0" <?php if(!isset($colonia_escolhida)) echo "selected"; ?>>-- Selecionar --</option>
							<?php }?>
							<option value="Todas" >Todas</option>
							<?php
							foreach ( $camps as $camp ) {
								$selected = "";
								if ($colonia_escolhida == $camp)
									$selected = "selected";
								echo "<option $selected value='$camp'>$camp</option>";
							}
							?>
						</select>
					</form>
					<?php if (isset($colonists) && isset($discountsT) && isset($discountsI) && !is_null($discountsT) && !is_null($discountsI)){ ?>
					<div class="pad">
					<table  class="table table-bordered table-striped table-min-td-size"
					style="max-width: 600px;">
						<thead>	
							<tr>
								<th></th>
								<th style="text-align: center" colspan = 2>Quantidade de bolsas</th>
							</tr>
						</thead>
						<tbody>
						    <tr>
								<th align="right">Motivo</th>
								<th style="text-align: center">Concedido</th>
								<th style="text-align: center">Doação Realizada</th>
							</tr>
							<tr>
								<td style="text-align: left">Desconto Igual ao da Escola</td>
								<td align='right'><?php echo number_format($discountsT -> same_school/100,2); ?> </td>
								<td align='right'> <?php echo number_format($discountsI -> same_school/100,2); ?> </td>
							</tr>
							<tr>
								<td style="text-align: left">Segundo Irmão</td>
								<td align='right'><?php echo number_format($discountsT -> second_brother/100,2); ?> </td>
								<td align='right'> <?php echo number_format($discountsI -> second_brother/100,2); ?> </td>
							</tr>
							<tr>
								<td style="text-align: left">Terceiro Irmão</td>
								<td align='right'><?php echo number_format($discountsT -> third_brother/100,2);?> </td>
								<td align='right'> <?php echo number_format($discountsI -> third_brother/100,2); ?> </td>
							</tr>
							<tr>
								<td style="text-align: left">Lar da Criança</td>
								<td align='right'><?php echo number_format($discountsT -> child_home/100,2);?> </td>
								<td align='right'> <?php echo number_format($discountsI -> child_home/100,2);?> </td>
							</tr>
							<tr>
								<td style="text-align: left">Outros</td>
								<td align='right'><?php echo number_format($discountsT -> others/100,2);?> </td>
								<td align='right'> <?php echo number_format($discountsI -> others/100,2);?> </td>
							</tr>
							<tr>
								<td style="text-align: left">Total</td>
								<td align='right'><?php echo number_format(($discountsT -> same_school + $discountsT -> second_brother + 
												$discountsT -> third_brother + $discountsT -> child_home + $discountsT -> others)/100,2); ?> </td>
								<td align='right'> <?php echo number_format(($discountsI -> same_school + $discountsI -> second_brother + 
												$discountsI -> third_brother + $discountsI -> child_home + $discountsI -> others)/100,2); ?> </td>
							</tr>
						</tbody>
					</table>
					</div>
					<div class="pad1">
					<table  class="table table-bordered table-striped table-min-td-size"
					style="width:1000px; font-size:15px" id="sortable-table">
						<thead>
                            <tr>
                                <th>Nome do Colonista</th>
                                <th>Responsável</th>
                                <th>Desconto</th>
                                <th>Motivo</th>
                                <th>Status da Inscrição</th>
                            </tr>
                        </thead>
						<tbody id="tablebody">
                            <?php
                            foreach ($colonists as $colonist) {
                                ?>
                                <tr>
                                    <td><a id="<?= $colonist -> colonist_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?type=report&colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> camp_id ?>"><?php echo $colonist -> colonist_name; ?></a></td>
                                    <td><a id="<?= $colonist -> responsable_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> responsable_id ?>"><?php echo $colonist -> responsable_name; ?></a></td>
                                    <td><?php echo $colonist->discount; echo "%";?></td>
                                    <td><?php echo $colonist->discount_reason;?></td>
                                    <td id="colonist_situation_<?=$colonist->colonist_id?>_<?php echo $colonist->camp_id;?>"><font color="
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
	                                ?>"><?php echo $colonist -> situation_description; ?></font></td>
                                 </tr>
	                                <?php
	                            }
	                            ?>    
                        </tbody>
					</table>
					</div>
					<?php } ?>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>