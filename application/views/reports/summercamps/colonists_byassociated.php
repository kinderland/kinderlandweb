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

		function sortLowerCaseLink(l, r) {
			l = l.split('>');
			l = l[1].split('<');
			if(l[0].split('')[0] == ' ')
				l[0] = l[0].replace(/\s+/g, '');

			r = r.split('>');
			r = r[1].split('<');
			if(r[0].split('')[0] == ' ')
				r[0] = r[0].replace(/\s+/g, '');
			
			return l[0].toLowerCase().localeCompare(r[0].toLowerCase());
		}

		function sortNumberLink(l, r) {

			if(l == 0 && r == 0)
				return 0;
			if(l == 0)
				return -1;
			if(r == 0)
				return 1;
			
			l = l.split('>');
			l = l[1].split('<');
			if(l[0].split('')[0] == ' ')
				l[0] = l[0].replace(/\s+/g, '');

			r = r.split('>');
			r = r[1].split('<');
			if(r[0].split('')[0] == ' ')
				r[0] = r[0].replace(/\s+/g, '');
			
			return l[0].localeCompare(r[0]);
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
				sort : [sortLowerCaseLink, sortNumberLink, false],
				filters : [true,false,false],
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
						1. Sócios contribuintes com pré e/ou inscrições = <?php echo $qtdAssoc;?>. <br/>
						2. Sócios beneméritos com pré e/ou inscrições = <?php echo $qtdBenemerits;?>. <br/>
						3. Sócios cujos indicados tem pré e/ou inscrições = <?php echo $qtdTemp;?>.<br/>
						Total(1+2+3) = <?php echo $qtdAssoc+$qtdBenemerits+$qtdTemp;?>.<br/>
						Total de Sócios = <?php echo $qtdAssocT;?><br />
						Sócios sem pré e/ou inscrições = <?php echo $qtdAssocT-($qtdAssoc+$qtdBenemerits+$qtdTemp); ?><br />
                    <table class="table table-bordered table-striped table-min-td-size" style="width: 800px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Nome do Sócio </th>
                                <th> Pré e/ou Inscrições </th>
                                <th> Ações </th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                          	if(is_array($subscriptions))
                             foreach ($subscriptions as $subscription) {
                               ?> 
                                <tr>
                                	<td><?php if(!isset($subscription->associate_id)){ ?>
                                	<a id ="<?= $subscription -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $subscription -> person_id ?>"><?= $subscription->fullname ?></a></td>
                                	<?php }else{?>
                                	<a id ="<?= $subscription -> associate_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $subscription -> associate_id ?>"><?= $subscription->associate_name ?></a> (indicando <?php echo $subscription->fullname ?>)</td>
                                	<?php }if($subscription->total_inscritos >0){?>
                                    <td><a target="_blank" href="<?= $this->config->item('url_link'); ?>reports/subscriptionsByAssociates?year=<?= $ano_escolhido?>&user_id=<?php echo $subscription->person_id;?>"><?= $subscription->total_inscritos ?></a></td>
                                    <?php }else{?>
                                    <td><?= $subscription->total_inscritos ?></td>
                                    <?php }?>
                                    <td><a target='blank' href="<?= $this -> config -> item('url_link');?>admin/viewEmails/<?= $subscription->person_id ?>"> e-mails enviados</a></td>
                                    
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