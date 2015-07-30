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
				sort : [sortLowerCase, true],
				filters : [true, selectTodas],
				filterText : 'Escreva para filtrar... ',
				counterText	: showCounter
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
					</form>
					<div class="counter"></div> <br>
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 600px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Nome do Colonista </th>
                                <th> Colônia </th>
                                <th> Pai </th>
                                <th> Mãe </th>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php
                            foreach ($colonists as $colonist) {
                                ?>
                                <tr>
                                    <td><a id="<?= $colonist->fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> summer_camp_id ?>"><?= $colonist -> fullname ?></a></td>
                                    <td><?= $colonist->camp_name ?></td>
                                    <td><img src="<?php if($colonist->pai ) echo $this -> config -> item('assets') . 'images/payment/greenicon.png" width="20px" height="20px"'; else echo $this -> config -> item('assets') . 'images/payment/redicon.png" width="20px" height="20px"'; ?>"/></td>
                                    <td><img src="<?php if($colonist->mae ) echo $this -> config -> item('assets') . 'images/payment/greenicon.png" width="20px" height="20px"'; else echo $this -> config -> item('assets') . 'images/payment/redicon.png" width="20px" height="20px"'; ?>"/></td>
                                    
                                  </tr>
                                  <?php
                            }
                            ?>                                    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>