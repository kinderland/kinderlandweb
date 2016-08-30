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
	<style>
	
	div.scroll{
    	
    	width:100%;
    	height:100%;
    	overflow-x:hidden;
    	
    }
    
    div.pad{
    	padding-left:9%;
    	}
	
	</style>
	<body>
	<div class="scroll">
		<div class="main-container-report">
		            <div class = "row">
		                <div class="col-lg-12">
		                     <form id="form_selection" method="GET">
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
		                    Evento: <select name="evento_f" onchange="this.form.submit()" id="events">
		                
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
		                <div class="pad">
		                <table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 900px;">
							<tr>
							  	<th style="width: 200px;"></th>
							    <th align="right" colspan=3 style="width: 150px;text-align: center">Feminino</th>
							    <th align="right" colspan=3 style="width: 150px;text-align: center">Masculino</th>
							</tr>
							<tr>
							  	<th></th>
							    <th style="text-align: center">+18</th>
							    <th style="text-align: center">7-17</th>
							    <th style="text-align: center">0-6</th>
							    <th style="text-align: center">+18</th>
							    <th style="text-align: center">7-17</th>
							    <th style="text-align: center">0-6</th>
							</tr>
							<tr>
							  	<th align="left">Com pernoite</th>
							    <td><?php echo $info["fem18S"]; ?></td>
							    <td><?php echo $info["fem717S"]; ?></td>		
							    <td><?php echo $info["fem06S"]; ?></td>
							    <td><?php echo $info["mas18S"]; ?></td>
							    <td><?php echo $info["mas717S"]; ?></td>		
							    <td><?php echo $info["mas06S"]; ?></td>
							</tr>
							<tr>
							  	<th align="left">Com pernoite por pavilhão</th>
							    <td colspan=3><?php echo $info["femS"]; ?></td>
							    <td colspan=3><?php echo $info["masS"]; ?></td>
							</tr>
							<tr>
							  	<th align="left">Sem pernoite</th>
							    <td><?php echo $info["fem18N"]; ?></td>
							    <td><?php echo $info["fem717N"]; ?></td>		
							    <td><?php echo $info["fem06N"]; ?></td>
							    <td><?php echo $info["mas18N"]; ?></td>
							    <td><?php echo $info["mas717N"]; ?></td>		
							    <td><?php echo $info["mas06N"]; ?></td>
							</tr>
							<tr>
							  	<th align="left">Sem pernoite por sexo</th>
							    <td colspan=3><?php echo $info["femN"]; ?></td>
							    <td colspan=3><?php echo $info["masN"]; ?></td>
							</tr>
							<tr>
							  	<th align="left">Total</th>
							    <td><?php echo $info["fem18N"]+$info["fem18S"]; ?></td>
							    <td><?php echo $info["fem717N"]+$info["fem717S"]; ?></td>		
							    <td><?php echo $info["fem06N"]+$info["fem06S"]; ?></td>
							    <td><?php echo $info["mas18N"]+$info["mas18S"]; ?></td>
							    <td><?php echo $info["mas717N"]+$info["mas717S"]; ?></td>		
							    <td><?php echo $info["mas06N"]+$info["mas06S"]; ?></td>
							</tr>
						</table>
						</div>
		 </div>
		 </div>
	</body>
</html>