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
	
	<script>
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

	function sortAge(l, r) {
		if(l == '+18 anos'){
			if(r == '+18 anos')
				return 0;
			else
				return 1;
		}

		if(r == '+18 anos'){
			if(l == '+18 anos')
				return 0;
			else
				return -1;
		}

		if(l == '0-6 anos'){
			if(r == '0-6 anos')
				return 0;
			else
				return -1;
		}

		if(r == '0-6 anos'){
			if(l == '0-6 anos')
				return 0;
			else
				return 1;
		}

		if(l == '7-17 anos'){
			if(r == '7-17 anos')
				return 0;
			else if(r == '+18 anos')
				return -1;
			else if(r == '0-6 anos')
				return 1;
		}

		if(r == '7-17 anos'){
			if(l == '7-17 anos')
				return 0;
			else if(l == '+18 anos')
				return 1;
			else if(l == '0-6 anos')
				return -1;
		}			

	}

	function sortLowerCase(l, r) {
		return l.toLowerCase().localeCompare(r.toLowerCase());
	}

	function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
		return '';
	}
	
        $(document).ready(function() {
			$('#sortable-table').datatable({
				pageSize : Number.MAX_VALUE,
				sort : [sortLowerCaseLink, sortLowerCase, sortAge,false],
				filters : [true,true,false,false],
				filterText: 'Escreva para filtrar... ',
				counterText	: showCounter
				
			});
		});
     </script>
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
		                <?php if($info !== null){?>
		                <div class="pad">
		                <table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 800px;" id="sortable-table">
							<tr>
								<th style="width: 250px;">Responsável</th>
								<th style="width: 250px;">Convite</th>
								<th style="width: 150px;">Faixa Etária</th>
								<th style="width: 100px;">Pernoite</th>
							</tr>
							<?php foreach($info as $i){?>
								<tr>
									<td><a target="_blank" href="<?= $this->config->item('url_link') ?>user/details?id=<?= $i->person_user_id ?>"><?= $i->responsable_name ?></a></td>
									<td><?php echo $i->fullname;?></td>
									<td><?php echo $i->description;?></td>
									<td><?php if($i->nonsleeper === 't') echo 'Não'; else echo "Sim";?></td>
								</tr>
							<?php }?>
						</table>
						</div>
						<?php }?>
		 </div>
		 </div>
	</body>
</html>