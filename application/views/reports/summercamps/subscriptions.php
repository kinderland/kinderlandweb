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

</script>

</head>
<body>
<script>
        $(document).ready(function() {
			$('#sortable-table').datatable({
				pageSize : Number.MAX_VALUE,
				sort : [sortLowerCase, sortLowerCase,sortLowerCase, sortLowerCase],				
				counterText	: showCounter
			});
		});
        </script>
        
        
<div class = "row">
                <div class="col-lg-12 middle-content">
                	<h2><b> Sub-relatório de Estatísticas de Inscrições <?php if($type == '1') { echo 'Descartadas';} 
                	else if($type == '2') { echo 'Por Turma';} else { echo "Por Status";} ?></b></h2>
                	<p><b><?php if($camp=='Todas'){ echo 'Todas as Colônias'; }
                		  else { echo 'Colônia: '; echo $camp;} ?></b></p>
                	<p><b>Inscrições com status: <?php echo $status;?></b></p>
                	<p><b>Pavilhão: <?php echo $pavilhao;?></b></p>
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 700px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th>Inscrição</th>
                                <th>Responsável</th>
                                <th>Sócio</th>
                                <th>Colônia</th>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php
                            foreach ($colonists as $colonist) {
                                ?>
                                <tr>
                                    <td><a id="<?= $colonist->colonist_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?type=report&colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> camp_id ?>"><?= $colonist -> colonist_name ?></a></td>
                                    <td><a id="<?= $colonist->responsable_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> responsable_id ?>"><?= $colonist -> responsable_name ?></a></td>
                                 	<td><?php if($colonist->associate == 'não sócio') { 
                                 						echo 'Não';
                                 			  } else{
                                 			  			echo 'Sim';
                            				  }?></td>
                                 	<td><?= $colonist->camp_name ?></td>
                                </tr>
	                                <?php
	                            }
	                            ?>    
                        </tbody>
                    </table>
                    <button class="btn btn-warning" class="button" onclick="self.close()" value="Fechar">Fechar</button>            
                  </div>
            </div>
          </body>
  </html>