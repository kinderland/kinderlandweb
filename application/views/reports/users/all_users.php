<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this -> config -> item('assets'); ?>css/basic.css" rel="stylesheet" />
        <link href="<?= $this -> config -> item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/bootstrap-switch.min.css">
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>css/theme.default.css" />
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/ui/jquery-ui.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquerysettings.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery/jquery.redirect.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/formValidationFunctions.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/bootstrap-switch.min.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery/jquery.mask.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>js/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="<?= $this -> config -> item('assets'); ?>datatable/js/datatable.min.js"></script>
        <link rel="stylesheet" href="<?= $this -> config -> item('assets'); ?>datatable/css/datatable-bootstrap.min.css" />
		

    </head>
    <body>
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
				var filtros = $(".datatable-filter");
				var filtroNome = filtros[0].value;
				var filtroEmail = filtros[1].value;
				var nomePadrao = "cadastro-kinderland";
				if(filtroNome == "" && filtroEmail == ""){
					var filtroSocio = filtros[2].value;
					if(filtroSocio == "-1")
						return nomePadrao.concat("-completo");
					else {
						var addToName = "-".concat(filtroSocio.concat("s")); //Pega identificador do filtro e adiciona - e um s no final.
						return nomePadrao.concat(addToName);						
					}	
				}
				else{
					return "cadastro-kinderland-filtrado";
				}
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
	            	data.push(data2)
		        } 
		        if(i==0){
       				alert('Não há dados para geração da planilha');
       				return;
		        }
		        var dataToSend = JSON.stringify(data);
		        var columName = ["Nome","Email"]
		        var columnNameToSend = JSON.stringify(columName);
		        
		        post('<?= $this -> config -> item('url_link'); ?>reports/toCSV', {data: dataToSend,name: name,columName: columnNameToSend});
			}

				$( document ).ready(function() {
					$('#sortable-table').datatable({
					pageSize:         Number.MAX_VALUE,
					sort: [
					function (l, r) { return l.toLowerCase().localeCompare(r.toLowerCase()); }, //Evita problemas com caps-lock
					function (l, r) { return l.toLowerCase().localeCompare(r.toLowerCase()); }, //Evita problemas com caps-lock
					true],
					filters: [true, true, {
					/* The jQuery element to use (if you want to use a custom select element), if not specified, a new select
					will be created. */
					element: null,
					/* The list of options. Notice that {0: "Option 0"} will output <option value=0>Option 0</option>, so the value used to filter is 0, not "Option 0".
					HINT: If you don't want to specify the values manually, you can set this values: "auto" which will retrieve values from the table. */
					values: {"-1": "Todos", "todos-socio": "Todos os sócios", "benemerito": "Sócios benemeritos", "contribuinte": "Sócios contribuintes", "não sócio": "Não associados"},
					/* The select default selected options, can be either a value or an array (for multiple select). If not specified, no value will be selected (for simple select), or all the values (for multiple select). */
					default: -1,
					/* Specify if an empty entry should be added. Default value is true. This parameter as no effect on multiple select. */
					empty: false,
					/* True for multiple select, false for simple. Default value is false. */
					multiple: false,
					/* Will not create a column for this filter. Useful if you want to filter data on a field which is not displayed in the table. */
					noColumn: false,
					/* A custom filter function to specify if you don't want the value to be filtered according to the options key. */
					fn: function (data, selected) {
					/* Note that selected is always an array of string. */
					if (selected.length > 0) {
						var i = 0;
						if(selected[0] === data || selected[0] === "-1")
							return true;
						else if(selected[0] === "todos-socio" && (data==="benemerito" || data==="contribuinte"))
							return true;
						return false;
					}
					/* Note that when using multiple select, selected will contain selected keys.
					When the empty value is picked, the selected array will contain all available keys. */
					return true ;
					}
					}],
					filterText: 'Escreva para filtrar... '
					});
					});
        </script>
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
					<button class="button" onclick="sendTableToCSV()" value="">Fazer download da tabela abaixo como csv</button>
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 600px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Nome </th>
                                <th> E-mail </th>
                                <th> Sócio </th>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php
                            foreach ($users as $user) {
                                ?>
                                <tr>
                                    <td><a id="<?= $user -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $user -> person_id ?>"><?= $user -> fullname ?></a></td>
                                    <td><?= $user -> email ?></td>
                                    <td><?= $user -> associate ?></td>
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