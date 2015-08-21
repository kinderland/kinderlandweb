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
	
	var nomePadrao = "lista_de_sorteio";
	var colonia_escolhida = document.getElementById('colonia').value;
	var selecionado = document.getElementById('opcao').value;
	
	if(colonia_escolhida == "0") {
		nomePadrao = nomePadrao.concat("_colonia_verao");
	}
	else if(colonia_escolhida == "1") {
		nomePadrao = nomePadrao.concat("_mini_kinderland");
	}

	if(selecionado == "0") {
		nomePadrao = nomePadrao.concat("_socios");
	}

	else if(selecionado == "1") {
		nomePadrao = nomePadrao.concat("_nao_socios");
	}	

	else if(selecionado == "2") {
		nomePadrao = nomePadrao.concat("_todos");
	}

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
    	var posicao = row.cells[2].innerHTML;
    	posicao = posicao.split('value="');
    	posicao = posicao[1];
    	posicao = posicao.split('"');
    	posicao = posicao[0];
    	data2.push(posicao);
    	data.push(data2)
    } 
    if(i==0){
			alert('Não há dados para geração da planilha');
			return;
    }
    var dataToSend = JSON.stringify(data);
    var columName = ["Nome do Responsável", "Sequencial","Posição na Lista de Espera"];
    var columnNameToSend = JSON.stringify(columName);
    
    post('<?= $this -> config -> item('url_link'); ?>reports/toCSV', {data: dataToSend,name: name,columName: columnNameToSend});
}

function sortLowerCase(l, r) {
	return l.toLowerCase().localeCompare(r.toLowerCase());
}

function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
	return '';
}

function saveQueuePosition(personId, userName, index){
	var summerCampType = $("#colonia").val();
	var yearSelected = $("#anos").val();
	var position = $("#queue_number_"+index).val();

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
			sort : [sortLowerCase,true,true],
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
				<button class="button" onclick="sendTableToCSV()" value="">Gerar Planilha Para Sorteio</button> <br></br>
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
					 <tbody id="tablebody"> 
					 <?php
                          	if(is_array($people)){
                          		$i = 0;
                             	foreach ($people as $person) {
                          ?>  
						<tr>
							<td><a id="<?= $person -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $person -> person_id ?>"><?= $person -> fullname ?></a></td>
							<td><?= $person -> person_id ?></td>
                            <td>
                            	<input type="text" class="form-control" id="queue_number_<?= $i ?>" value="<?= $person -> queue_number ?>" />
                            </td>
                            <td> <button class="btn btn-primary" onclick="saveQueuePosition(<?= $person -> person_id ?>, '<?= $person -> fullname ?>', <?= $i ?>)">Cadastrar</button> </td>
                           
						</tr>
						<?php
									$i++;
	                            }
	                        }
                            ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>