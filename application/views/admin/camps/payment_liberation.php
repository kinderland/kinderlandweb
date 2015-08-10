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
	</head>
	<body>
		<script>

			function submitLiberation(event) {
				event.preventDefault();
				if($("#gender").val() == ""){
					alert("Por favor selecione o pavilhão.");
					return false;
				}
				if($("#qtd_liberate").val() == "" || isNaN($("#qtd_liberate").val())){
					alert("Quantidade para liberar inválida.");
					return false;
				}

				$("#form_liberate_payments").submit();
			}


			var selectTodos = {
				element : null,
				values : "auto",
				empty : "Todos",
				multiple : false,
				noColumn : false,
			}
        
			$(document).ready(function() {
				$('#sortable-table').datatable({
					pageSize : Number.MAX_VALUE,
					sort : [
					function(l, r) {
						return l.toLowerCase().localeCompare(r.toLowerCase());
					}, //Evita problemas com caps-lock
					function(l, r) {
						return l.toLowerCase().localeCompare(r.toLowerCase());
					}, //Evita problemas com caps-lock
					function(l, r) {
						return l.toLowerCase().localeCompare(r.toLowerCase());
					}, //Evita problemas com caps-lock
					function(l, r) {
						return l.toLowerCase().localeCompare(r.toLowerCase());
					}
					],
					filters : [true,selectTodos,true,selectTodos]
				});
			});
        </script>
		<div class="main-container-report">
			<div class="row">
				<div class="col-lg-10" bgcolor="red">
					<form method="POST">
						Ano: <select name="year" onchange="this.form.submit()" id="anos">
						<?php
							if(isset($years))
								foreach ( $years as $year ) {
									$selected = "";
									if ($year_selected == $year)
										$selected = "selected";
									echo "<option $selected value='$year'>$year</option>";
								}
						?>
						</select>
						<?php if(isset($camps)){ ?>
							<span style="margin-left:40px;">Colônia:</span> <select name="camp_id" onchange="this.form.submit()" id="colonia">
								<option value="0" <?php if(!isset($camp_selected_id)) echo "selected"; ?>>Selecione uma colônia</option>
								<?php
									foreach ( $camps as $camp ) {
										$selected = "";
										if ($camp_selected_id == $camp->getCampId())
											$selected = "selected";
										echo "<option $selected value='".$camp->getCampId()."'>".$camp->getCampName()."</option>";
									}
								?>
							</select>
						<?php } ?>
					</form>

					<?php if(isset($camp_details)) { ?>
						<table class="table table-bordered tablesorter table-striped table-min-td-size" style="max-width: 500px; font-size:15px">
							<tr>
								<th> Status </th>
								<th> Masculino </th>
								<th> Feminino </th>
							</tr>
							<tr>
								<td> Inscritos </td>
								<td> <?= $camp_details[5]['M'] ?> </td>
								<td> <?= $camp_details[5]['F'] ?> </td>
							</tr>
							<tr>
								<td> Aguardando Pagamento </td>
								<td> <?= $camp_details[4]['M'] ?> </td>
								<td> <?= $camp_details[4]['F'] ?> </td>
							</tr>
							<tr>
								<td> Fila de espera </td>
								<td> <?= $camp_details[3]['M'] ?> </td>
								<td> <?= $camp_details[3]['F'] ?> </td>
							</tr>
							<tr>
								<td> Disponível </td>
								<td> <?= $camp_selected_male_capacity - $camp_details[5]['M'] ?> </td>
								<td> <?= $camp_selected_female_capacity - $camp_details[5]['F'] ?> </td>
							</tr>
						</table>

						<hr />

						<form id="form_liberate_payments" action="<?= $this->config->item('url_link') ?>admin/liberatePayments" method="POST">
							<h3> Painel de liberação </h3>
							<input type="hidden" name="camp_id" id="camp_id" value="<? $camp_selected_id ?>" />

							Pavilhão: <select name="gender" id="gender">
								<option value=""> Selecione um sexo </option>
								<option value="M"> Masculino </option>
								<option value="F"> Feminino </option>
							</select>
							<br /><br />

							Quantidade a liberar: <input type="text" name="qtd_liberate" id="qtd_liberate" />

							<button class="btn btn-primary" onclick="submitLiberation(event)" style="margin-left:50px;">Liberar para pagamento</button>
						</form>

						<?php if(isset($subscriptions)) { ?>

							<hr />
							<br />
							<table class="table table-bordered table-striped table-min-td-size"
								style="max-width: 700px; font-size:15px" id="sortable-table">
								<thead>
									<tr>
										<th align="right">Colonista</th>
										<th align="right">Posição</th>
										<th align="right">Responsável</th>
										<th align="right">Status</th>
									</tr>	
								</thead>
								<tbody id="tablebody"> 
								<?php if(is_array($subscriptions))
			                            foreach ($subscriptions as $sub) { ?>  
									<tr>
										<td><a id="<?= $sub -> colonist_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?colonistId=<?= $sub -> colonist_id ?>&summerCampId=<?= $sub->summer_camp_id ?>"><?= $sub -> colonist_name ?></a></td>
			                            <td><?= $sub->queue_number ?></td>
			                            <td><a id="<?= $sub -> responsible_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $sub -> person_user_id ?>"><?= $sub -> responsible_name ?></a></td>
			                            <td><?= $sub->description ?></td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</body>
</html>