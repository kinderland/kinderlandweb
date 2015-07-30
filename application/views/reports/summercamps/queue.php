<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Colônia Kinderland</title>

<link href="<?= $this->config->item('assets'); ?>css/basic.css"
	rel="stylesheet" />
<!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
<link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css"
	rel="stylesheet" />
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css">

<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>
<script>

function sortLowerCase(l, r) {
	return l.toLowerCase().localeCompare(r.toLowerCase());
}

function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
	return '';
}

function saveQueuePosition(personId, userName){
	var summerCampType = $("#colonia").val();
	var yearSelected = $("#anos").val();
	var position = $("#queue_number_"+personId).val();

	if(confirm("Deseja atribuir a posição " + position + " ao responsável " + userName + "?")){
		$.post("<?= $this->config->item('url_link') ?>admin/updateQueueNumber",
	        {
	            'user_id': personId,
	            'summer_camp_type': summerCampType,
	            'year': yearSelected,
	            'position': position
	        },
	        function (data) {
	            if (data == "true") {
	                alert("Posição de fila de espera cadastrada!");
	            } else {
	                alert(data);
	            }
	        }
	    );
	}
	
}

</script>

</head>
<body>

	<script>
        $(document).ready(function() {
			$('#sortable-table').datatable({
				pageSize : Number.MAX_VALUE,
				sort : [sortLowerCase],
				filters : [true],
				filterText : 'Escreva para filtrar... ',
				counterText	: showCounter
			});
		});
        </script>
	
	<div class="main-container-report">
		<div class="row">
			<div class="col-lg-10">
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
						<select name="colonia_f" onchange="this.form.submit()" id="colonia">
							<?php
							$index = 0;
							foreach ( $camps as $camp ) {
								$selected = "";
								if ($colonia_escolhida == $index)
									$selected = "selected";
								echo "<option $selected value='$index'>$camp</option>";
								$index++;
							}
							?>
						</select>
						<select name="opcao_f" onchange="this.form.submit()" id="opcao">
							<?php
							$index = 0;
							foreach ( $opcoes as $opcao ) {
								$selected = "";
								if ($selecionado == $index)
									$selected = "selected";
								echo "<option $selected value='$index'>$opcao</option>";
								$index++;
							}
							?>
						</select>
				</form>
				<table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 600px; font-size:15px" id="sortable-table">
					<thead>
						<tr>
							<th align="right">Responsável</th>
							<th align="right">Sequencial</th>
							<th align="right">Posição</th>
							<th align="right">Ações</th>
						</tr>	
					 </thead>
					 <tbody> 
					 <?php
                          	if(is_array($people))
                             foreach ($people as $person) {
                          ?>  
						<tr>
							<td><a id="<?= $person -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $person -> person_id ?>"><?= $person -> fullname ?></a></td>
							<td><?= $person -> person_id ?></td>
                            <td>
                            	<input type="text" class="form-control" id="queue_number_<?= $person -> person_id ?>" value="<?= $person -> queue_number ?>" />
                            </td>
                            <td> <button class="btn btn-primary" onclick="saveQueuePosition(<?= $person -> person_id ?>, '<?= $person -> fullname ?>')">Cadastrar</button> </td>
                           
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