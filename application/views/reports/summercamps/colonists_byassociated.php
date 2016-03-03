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
			var qtda = <?php echo $qtdAssoc;?>;
			var qtdb = <?php echo $qtdBenemerits;?>;
			return 'Apresentando ' + totalRow + ' sócios, de um total de ' + totalRowUnfiltered+ ' sócios.'
			+ 'Sócios contribuintes com inscritos = ' + qtda + ". " +
			'Sócios beneméritos com inscritos = '+  qtdb + '.';
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
				sort : [sortLowerCase, sortLowerCase, true],
				filters : [true,true,numero],
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
                                <th> Responsável </th>
                                <th> E-mail </th>
                                <th> Número de Pré-inscrições </th>
                                <th> Tem Pré-inscrição? </th>
                                <th> Ações </th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                          	if(is_array($subscriptions))
                             foreach ($subscriptions as $subscription) {
                               ?> 
                                <tr>
                                	<td><a id="<?= $subscription -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $subscription -> person_id ?>"><?= $subscription->fullname ?></a></td>
                                    <td><?= $subscription->email ?></td>
                                    <td><?= $subscription->total_inscritos ?></td>
                                    <td><img src="<?php if($subscription->total_inscritos == 0) echo $this -> config -> item('assets') . 'images/payment/redicon.png" width="20px" height="20px"'; 
        											else  echo $this -> config -> item('assets') . 'images/payment/greenicon.png" width="20px" height="20px"'; ?>"/></td>
                                    <td><a target='blank' href="<?= $this -> config -> item('url_link');?>admin/viewEmails/<?= $subscription->person_id ?>"> Ver e-mails enviados</a></td>
                                    
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