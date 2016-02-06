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
	
	</style>
	<body>
	<div class="scroll">
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
		                <?php if($event !== null){?>
		                <table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 700px;">
							<tr>
							  	<th>Ingressos</th>
							    <th>Feminino</th>
							    <th>Masculino</th>		
							    <th>Sem Pernoite</th>
							    <th>Total</th>
							</tr>
							<tr>
							  	<td>Disponibilizado</td>
							    <td><?php echo $info["fem"] + $dispFem;?></td>
							    <td><?php echo $info["mas"] + $dispMas;?></td>		
							    <td><?php echo $info["non"] + $dispNon;?></td>
							    <td><?php echo $info["fem"]+$info["mas"]+$info["non"] + $dispNon + $dispMas + $dispFem;?></td>
							</tr>
							<tr>
							  	<td>Vendido</td>
							    <td><?php echo $info["fem"];?></td>
							    <td><?php echo $info["mas"];?></td>		
							    <td><?php echo $info["non"];?></td>
							    <td><?php echo $info["fem"]+$info["mas"]+$info["non"];?></td>
							</tr>
							<tr>
							  	<td>Disponível</td>
							    <td><?php echo $dispFem;?></td>
							    <td><?php echo $dispMas;?></td>		
							    <td><?php echo $dispNon;?></td>
							    <td><?php echo $dispNon + $dispMas + $dispFem;;?></td>
							</tr>
						</table>
						<?php }?>
		 </div>
		 </div>
	</body>
</html>