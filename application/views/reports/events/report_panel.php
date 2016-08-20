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
    	padding-left: 9%;
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
		                <?php if($event !== null){?>
		                <div class="pad">
		                <table class="table table-bordered table-striped table-min-td-size"
					style="width: 920px;">
							<tr>
								<th style="width: 220px;"></th>
								<th align="right" colspan=2 style="width: 220px;text-align: center">Feminino</th>
								<th align="right" colspan=2 style="width: 220px;text-align: center">Masculino</th>
								<th align="right" colspan=2 style="width: 220px;text-align: center">Sem Pernoite</th>
								<th>Total</th>
							</tr>
							<tr>
								<th style="width: 150px;"></th>
								<th>Sócios</th>
								<th>Não Sócios</th>
								<th>Sócios</th>
								<th>Não Sócios</th>
								<th>Sócios</th>
								<th>Não Sócios</th>
								<th></th>
							</tr>
							<tr>
								<th>Pagos</th>
								<td><?php echo $info["fem3S"]; ?></td>
								<td><?php echo $info["fem3N"];?></td>
								<td><?php echo $info["mas3S"];?></td>
								<td><?php echo $info["mas3N"];?></td>
								<td><?php echo $info["non3S"];?></td>
								<td><?php echo $info["non3N"];?></td>
								<td><?php echo $info["3"];?></td>
							</tr>
							<tr>
								<th>Arguardando Pagamento</th>
								<td><?php echo $info["fem2S"]; ?></td>
								<td><?php echo $info["fem2N"];?></td>
								<td><?php echo $info["mas2S"];?></td>
								<td><?php echo $info["mas2N"];?></td>
								<td><?php echo $info["non2S"];?></td>
								<td><?php echo $info["non2N"];?></td>
								<td><?php echo $info["2"];?></td>
							</tr>
							<tr>
								<th>Total (Sócio/Não Sócio)</th>
								<td><?php echo $info["fem2S"]+$info["fem3S"]; ?></td>
								<td><?php echo $info["fem2N"]+$info["fem3N"];?></td>
								<td><?php echo $info["mas2S"]+$info["mas3S"];?></td>
								<td><?php echo $info["mas2N"]+$info["mas3N"];?></td>
								<td><?php echo $info["non2S"]+$info["non3S"];?></td>
								<td><?php echo $info["non2N"]+$info["non3N"];?></td>
								<td><?php echo $info["2"]+$info["3"];?></td>
							</tr>
							<tr>
								<th>Total</th>
								<td colspan="2"><?php echo $info["fem2S"]+$info["fem3S"]+$info["fem2N"]+$info["fem3N"]; ?></td>
								<td colspan="2"><?php echo $info["mas2S"]+$info["mas3S"]+$info["mas2N"]+$info["mas3N"];?></td>
								<td colspan="2"><?php echo $info["non2S"]+$info["non3S"]+$info["non2N"]+$info["non3N"];?></td>
								<td><?php echo $info["2"]+$info["3"];?></td>
							</tr>
						</table>
						</div>
						<?php }?>
		 </div>
		 </div>
	</body>
</html>