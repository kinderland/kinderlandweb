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
	
	if(colonia_escolhida == "Colônia Verão") {
		nomePadrao = nomePadrao.concat("_colonia_verao");
	}
	else if(colonia_escolhida == "Mini Kinderland") {
		nomePadrao = nomePadrao.concat("_mini_kinderland");
	}

	if(selecionado == "Sócios") {
		nomePadrao = nomePadrao.concat("_socios");
	}

	else if(selecionado == "Não Sócios") {
		nomePadrao = nomePadrao.concat("_nao_socios");
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
    	data2.push(row.cells[2].innerHTML);
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
			<div class="col-lg-10" bgcolor="red">
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
							foreach ( $camps as $camp ) {
								$selected = "";
								if ($colonia_escolhida == $camp)
									$selected = "selected";
								echo "<option $selected value='$camp'>$camp</option>";
							}
							?>
						</select>
						<select name="opcao_f" onchange="this.form.submit()" id="opcao">
							<?php
							foreach ( $opcoes as $opcao ) {
								$selected = "";
								if ($selecionado == $opcao)
									$selected = "selected";
								echo "<option $selected value='$opcao'>$opcao</option>";
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
							<th align="right">Posição na Lista de Espera</th>
						</tr>	
					 </thead>
					 <tbody id="tablebody"> 
					 <?php
                          	if(is_array($people))
                             foreach ($people as $person) {
                          ?>  
						<tr>
							<td><a id="<?= $person -> getfullname() ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $person -> getPersonId() ?>"><?= $person -> getfullname() ?></a></td>
							<td><?= $person -> getPersonId() ?></td>
                            <td></td>
                           
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