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
                	<h2><b> Ingressos adquiridos para evento <?php echo $event[0]->event_name?></b></h2>
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 700px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th>Convidado</th>
                                <th>Faixa Etária</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php
                            foreach ($event as $e) {
                                ?>
                                <tr>
                                    <td><?= $e->person_name ?></td>
                                    <td><?= $e->age_group_name ?></td>
                                 	<td><?= number_format($e->price,2,",",".") ?></td>
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