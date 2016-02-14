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
	<style>
	
	div.scroll{
    	
    	width:100%;
    	height:100%;
    	overflow-x:hidden;
    
    }
    div.pad{
    	
    	padding-left: 23%;
    }
	
	</style>
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

			function liberatePayment(colonist_id, summer_camp_id){
				if(confirm("Deseja liberar esse colonista para pagar sua inscrição?")){
					$.post("<?= $this->config->item('url_link') ?>admin/updateToWaitingPaymentIndividual",
			        {
			            'colonist_id': colonist_id,
			            'summer_camp_id': summer_camp_id
			        },
			        function (data) {
			            if (data == "true") {
			                alert("Liberado para pagamento!");
			                window.location.reload();
			            } else {
			                alert(data);
			            }
			        });
				}
			}
			function post(path, params, method) {
				method = method || "post"; // Set method to post by default if not specified.

				// The rest of this code assumes you are not using a library.
				// It can be made less wordy if you use one.
			    var form = document.createElement("form");
			    form.setAttribute("method", method);
			    form.setAttribute("action", path);

			    for(var key in params) {
			        if(params.hasOwnProperty(key)) {
			            var hiddenField = document.createElement("input");
			            hiddenField.setAttribute("type", "hidden");
			            hiddenField.setAttribute("name", key);
			            hiddenField.setAttribute("value", params[key]);
			            form.appendChild(hiddenField);
			         }
			    }

			    document.body.appendChild(form);
			    form.submit();
			}

			function getCSVName(){
				var nomePadrao = "lista_de_espera_colonistas";
				var colonia_escolhida = document.getElementById('colonia').value;
				var selecionado = document.getElementById('anos').value;
				
				nomePadrao = nomePadrao.concat("_"+colonia_escolhida)

				nomePadrao = nomePadrao.concat("_"+selecionado);

				return nomePadrao;
			}	

			function sendTableToCSV(){
				var data = [];
				var table = document.getElementById("tablebody");
				var name = getCSVName();
				var tablehead = document.getElementsByTagName("thead")[0];
				for (var i = 0, row; row = table.rows[i]; i++) {
					var data2 = []
			    	//Nome, retira pega o que esta entre um <> e outro <>
			    	data2.push(row.cells[0].innerHTML.split("<")[1].split(">")[1]);
			    	data2.push(row.cells[1].innerHTML);
			    	data2.push(row.cells[2].innerHTML);
			    	data2.push(row.cells[3].innerHTML.split("<")[1].split(">")[1]);
			    	data2.push(row.cells[4].innerHTML);
			    	data.push(data2)
			    } 
			    if(i==0){
						alert('Não há dados para geração da planilha');
						return;
			    }
			    var dataToSend = JSON.stringify(data);
			    var columName = ["Colonista", "Sexo","Posição na Lista de Espera", "Responsavel", "Status"];
			    var columnNameToSend = JSON.stringify(columName);
			    
			    post('<?= $this -> config -> item('url_link'); ?>reports/toCSV', {data: dataToSend,name: name,columName: columnNameToSend});
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
						var intL = parseInt(l);
						var intR = parseInt(r);
						return (intL < intR) ? -1:1;
					}, //Evita problemas com caps-lock
					function(l, r) {
						return l.toLowerCase().localeCompare(r.toLowerCase());
					}, //Evita problemas com caps-lock
					function(l, r) {
						return l.toLowerCase().localeCompare(r.toLowerCase());
					}
					],
					filters : [true,selectTodos,true,true,selectTodos]
				});
			});
        </script>
        <div class="scroll">
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
						<div class="pad">
						<table class="table table-bordered tablesorter table-striped table-min-td-size" style="max-width: 500px; padding-left: 30%; font-size:15px">
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
						</div>

						<hr />

						<form id="form_liberate_payments" action="<?= $this->config->item('url_link') ?>admin/liberatePayments" method="POST">
							<h3> Painel de liberação </h3>
							<input type="hidden" name="camp_id" id="camp_id" value="<? $camp_selected_id ?>" />

							<!--

							Pavilhão: <select name="gender" id="gender">
								<option value=""> Selecione um pavilhão </option>
								<option value="M"> Masculino </option>
								<option value="F"> Feminino </option>
							</select>
							<br /><br />

							Quantidade a liberar: <input type="text" disabled name="qtd_liberate" id="qtd_liberate" />

							<button class="btn btn-primary" disabled onclick="submitLiberation(event)" style="margin-left:50px;">Liberar para pagamento</button>
							!-->
							
						</form>

						<?php if(isset($subscriptions)) { ?>

							<hr />
							<br />
							<button class="button" onclick="sendTableToCSV()" value="">Gerar Planilha de colonistas na fila</button> <br></br>
							<br />
							<table class="table table-bordered table-striped table-min-td-size"
								style="width: 1000px; font-size:15px" id="sortable-table">
								<thead>
									<tr>
										<th>Colonista</th>
										<th>Sexo</th>
										<th>Posição</th>
										<th>Responsável</th>
										<th>Status</th>
										<th>Ações</th>
									</tr>	
								</thead>
								<tbody id="tablebody"> 
								<?php if(is_array($subscriptions))
			                            foreach ($subscriptions as $sub) { ?>  
									<tr>
										<td><a id="<?= $sub -> colonist_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?colonistId=<?= $sub -> colonist_id ?>&summerCampId=<?= $sub->summer_camp_id ?>"><?= $sub -> colonist_name ?></a></td>
			                            <td><?= $sub->gender ?></td>
			                            <td><?= $sub->queue_number ?></td>
			                            <td><a id="<?= $sub -> responsible_name ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $sub -> person_user_id ?>"><?= $sub -> responsible_name ?></a></td>
			                            <td><?= $sub->description ?></td>
			                            <td>
			                            	<?php if($sub->situation == SUMMER_CAMP_SUBSCRIPTION_STATUS_QUEUE){ ?>
			                            		<button class="btn btn-primary" onclick="liberatePayment(<?= $sub -> colonist_id ?>, <?= $sub -> summer_camp_id ?>)">Liberar pagamento</button> 
			                            	<?php } ?>
			                            </td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
		</div>
	</body>
</html>