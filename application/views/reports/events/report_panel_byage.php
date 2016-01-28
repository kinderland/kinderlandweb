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

		</script>
	</head>
	<body>
		<div class="main-container-report">
		            <div class = "row">
		                <div class="col-lg-12">
		                     <form id="form_selection" method="GET">
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
		                    <select name="evento_f" onchange="this.form.submit()" id="events">
		                
		                        <?php
		                        foreach ( $events as $event ) {
		                            $selected = "";
		                            if ($evento_escolhido == $event)
		                                $selected = "selected";
		                            echo "<option $selected value='$event'>$event</option>";
		                        }
		                        ?>
		                    </select>
		                    </form>
		                  </div>
		                </div>
		                <table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 700px;">
							<tr>
							  	<th>Por faixa etária</th>
							    <th>Feminino +18</th>
							    <th>7 - 17</th>		
							    <th>0 - 6</th>
							    <th>Masculino +18</th>
							    <th>7 - 17</th>		
							    <th>0 - 6</th>
							</tr>
							<tr>
							  	<td>Vendido</td>
							    <td><?php echo $info["fem18"]; ?></td>
							    <td><?php echo $info["fem717"]; ?></td>		
							    <td><?php echo $info["fem06"]; ?></td>
							    <td><?php echo $info["mas18"]; ?></td>
							    <td><?php echo $info["mas717"]; ?></td>		
							    <td><?php echo $info["mas06"]; ?></td>
							</tr>
						</table>
		 </div>
	</body>
</html>