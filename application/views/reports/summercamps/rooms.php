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

                for (var key in params) {
                    if (params.hasOwnProperty(key)) {
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

            function getCSVName(type) {
            	var filtroColonia = $("#colonia option:selected").text();
    			var filtroGenero = $("#pavilhao option:selected").text();
    			var filtroGeneroVal = $("#pavilhao option:selected").val();
    			var filtroQuarto = $("#room").val();
    			var nomePadrao = type.concat("-");

    			if(filtroQuarto == 0)
        			filtroQuarto = "Sem-Quarto".concat(filtroGenero);
        		else if(filtroQuarto == -1)
            		filtroQuarto = "Todos-os-Quartos".concat(filtroGenero);
            	else {
                	filtroQuarto = filtroQuarto.concat(filtroGeneroVal);
            	}	

    			nomePadrao = nomePadrao.concat(filtroQuarto);
    			nomePadrao = nomePadrao.concat("-");	
    			return nomePadrao.concat(filtroColonia);   			
            }

            function getFilters() {
            	var filtroColonia = $("#colonia option:selected").text();
    			var filtroGenero = $("#pavilhao option:selected").text();
    			var filtroGeneroVal = $("#pavilhao option:selected").val();
    			var filtroQuarto = $("#room").val();
                var saida = [];
                var temp = "";

                if (filtroColonia == false) {
                    saida.push("Colônias: todas");
                }
                else {
                    temp = "Colônia: ";
                    temp = temp.concat(filtroColonia);
                    saida.push(temp);
                }

                if (filtroQuarto == 0) {
                    if(filtroGeneroVal == 'M')
                        temp = "Maculino - ";
                    else
                        temp = "Feminino - ";
                    
                    temp = temp.concat("Sem Quarto");
                    saida.push(temp);
                }
                else if (filtroQuarto == -1) {
                	if(filtroGeneroVal == 'M')
                        temp = "Maculino - ";
                    else
                        temp = "Feminino - ";
                    
                    temp = temp.concat("Todos os Quartos");
                    saida.push(temp);
                }
                else {
                    temp = "Quarto: ";
                    temp = temp.concat(filtroQuarto);
                    temp = temp.concat(filtroGeneroVal);
                    saida.push(temp);
                }
                
                return saida;

            }


            

            function geraAutorizacaoPDF(camp_id){
            	var data = [];
                var table = document.getElementById("tablebody");
                var elements = document.getElementsByName('colonista');
                var tablehead = document.getElementsByTagName("thead")[0];
                var filtroColonia = $("#colonia option:selected").text();
                for (var i = 0, row; row = table.rows[i]; i++) {
                    var data2 = []
                    //Nome, retira pega o que esta entre um <> e outro <>
                    var colonist_id = elements[i].getAttribute('id');

                    data2.push(colonist_id);
                    data.push(data2)
                }
                if (i == 0) {
                    alert('Não há dados para geração da planilha');
                    return;
                }
                var dataToSend = JSON.stringify(data);
                var type = "Vários";

                var filtroGeneroVal = $("#pavilhao option:selected").val();
    			var filtroQuarto = $("#room").val();
    			var nomePadrao = "";

    			if(filtroQuarto == 0)
        			filtroQuarto = "Sem-Quarto";
        		else if(filtroQuarto == -1)
            		filtroQuarto = "Todos-os-Quartos";
            	else {
                	filtroQuarto = filtroQuarto.concat(filtroGeneroVal);
            	}	

            	if(filtroQuarto == "Sem-Quarto" || filtroQuarto == "Todos-os-Quartos")
                	if(filtroGeneroVal == 'M')
                		filtroQuarto = filtroQuarto.concat("-Masculino");
                	else
                		filtroQuarto = filtroQuarto.concat("-Feminino");
            	
    			nomePadrao = nomePadrao.concat("Autorização-de-Viagem-");
    			nomePadrao = nomePadrao.concat(filtroQuarto);
    			nomePadrao = nomePadrao.concat("-");
    			nomePadrao = nomePadrao.concat(filtroColonia);
                
        		post('<?= $this->config->item('url_link'); ?>summercamps/generatePDFTripAuthorization', {name: nomePadrao, data: dataToSend, camp_id: camp_id, type: type});
        	}

            function sendTableToCSV() {
                var data1 = [];
                var table = document.getElementById("tablebody");
                var name = getCSVName('Email');
                var elements = document.getElementsByName('responsavel');
                var summercamp = document.getElementById('colonia');
                var colonists = document.getElementsByName('colonista');
                var tablehead = document.getElementsByTagName("thead")[0];
                var summercamp_id = summercamp.getAttribute('key');

				var colonistsId = document.getElementById("colonistsId").getAttribute('key');
				colonistsId = colonistsId.split("|");

				var colonistsFather = document.getElementById("colonistsFather").getAttribute('key');
				colonistsFather = colonistsFather.split("|");

				var colonistsFatherE = document.getElementById("colonistsFatherE").getAttribute('key');
				colonistsFatherE = colonistsFatherE.split("|");

				var colonistsMother = document.getElementById("colonistsMother").getAttribute('key');
				colonistsMother = colonistsMother.split("|");

				var colonistsMotherE = document.getElementById("colonistsMotherE").getAttribute('key');
				colonistsMotherE = colonistsMotherE.split("|");

				var colonistsResponsable = document.getElementById("colonistsResponsable").getAttribute('key');
				colonistsResponsable = colonistsResponsable.split("|");

				var colonistsResponsableE = document.getElementById("colonistsResponsableE").getAttribute('key');
				colonistsResponsableE = colonistsResponsableE.split("|");
                
                for (var i = 0, row; row = table.rows[i]; i++) {
                    var data2 = [];
                    var data3 = [];
                    var data4 = [];
                    //Nome, retira pega o que esta entre um <> e outro <>
                    var email = elements[i].getAttribute('key');
					var nome = elements[i].getAttribute('id');

					var colonist_id = colonists[i].getAttribute('id');

					for( var j = 0; j < colonists.length ; j++){
						
						if(colonist_id == colonistsId[j]){
							
							if(colonistsFather[j] != ""){
								var nome = colonistsFather[j];
								var email = colonistsFatherE[j];

								data2.push(email);
								data2.push(nome);
								data1.push(data2);
							}

							if(colonistsMother[j] != ""){
								var nome = colonistsMother[j];
								var email = colonistsMotherE[j];

								data3.push(email);
								data3.push(nome);
								data1.push(data3);
							}

							if(colonistsResponsable[j] != ""){
								var nome = colonistsResponsable[j];
								var email = colonistsResponsableE[j];

								data4.push(email);
								data4.push(nome);
								data1.push(data4);
							}

						}
						
					} 

					
                }
                
                if (i == 0) {
                    alert('Não há dados para geração da planilha');
                    return;
                }
                var dataToSend = JSON.stringify(data1);
                var columName = ["Email", "Nome"];
                var columnNameToSend = JSON.stringify(columName);

                post('<?= $this->config->item('url_link'); ?>reports/toCSV', {data: dataToSend, name: name, columName: columnNameToSend});
            }

            function gerarPDFcomDadosCadastrais(type) {
                var data = [];
                var table = document.getElementById("tablebody");
                var name = getCSVName(type);
                var summercamp = $("#colonia option:selected").text();
                var summercampId = document.getElementById("colonia").getAttribute('key');
                var filtroGeneroVal = $("#pavilhao option:selected").val();
    			var filtroQuarto = $("#room").val();
    			var room;
    			var cadastroType = null;

    			if(filtroQuarto == -1) {
					if(filtroGeneroVal == 'M') {
						room = "Masculino - Todos os Quartos";
					} else {
						room = "Feminino - Todos os Quartos";
					}
    			}
    			else if(filtroQuarto == 0) {
						if(filtroGeneroVal == 'M') {
							room = "Masculino - Sem Quarto";
						} else {
							room = "Feminino - Sem Quarto";
						}					
    			} else {        			
    	    		room = filtroQuarto.concat(filtroGeneroVal);
    			}
                var filtersWindow = getFilters();
                var elements = document.getElementsByName('colonista');
                var tablehead = document.getElementsByTagName("thead")[0];
                for (var i = 0, row; row = table.rows[i]; i++) {
                    var data2 = []
                    //Nome, retira pega o que esta entre um <> e outro <>
                    var email = elements[i].getAttribute('key');

                    data2.push(email);
                    data2.push(row.cells[3].innerHTML.split("<")[1].split(">")[1]);
                    data.push(data2)
                }
                if (i == 0) {
                    alert('Não há dados para geração da planilha');
                    return;
                }
                var dataToSend = JSON.stringify(data);
                var filtersToSend = JSON.stringify(filtersWindow);
                var columName = ["Email", "Nome"];
                var columnNameToSend = JSON.stringify(columName);

               
                post('<?= $this->config->item('url_link'); ?>summercamps/generatePDFWithColonistData', {data: dataToSend, filters: filtersToSend, name: name, columName: columnNameToSend, type: type, summercamp: summercamp, summercampId: summercampId, room: room});
                
            }
            function createPDFMedicalFiles() {
                window.location.href = "<?= $this->config->item('url_link'); ?>summercamps/generatePDFWithColonistMedicalFiles/<?=$ano_escolhido?>/<?=(isset($summer_camp_id)?$summer_camp_id:'')?>/<?=(isset($pavilhao)?$pavilhao:'')?>/<?=(isset($quarto)?$quarto:'')?>/varios";
            }

            function openDisposal(){
            	$("#room").val(-1);
            	
                if($("#pavilhao").val() != "")
                    $(".btn_room_row").show();
                else
                    $(".btn_room_row").hide();

                if($("#anos").val() != null && $("#colonia").val() != 0 && $("#pavilhao").val() != "" && $("#room").val != "") {
                    $("#form_selection").submit();
                }
            }

            function openRoomDisposal( roomFilter ) {
                if($("#anos").val() != null && $("#colonia").val() != 0 && $("#pavilhao").val() != "") {
                    $("#room").val(roomFilter);
                    $("#form_selection").submit();
                } else {
                    alert("Preencha todas as caixas de seleção no topo da tela para seguir");
                }
            }

            var selectTodas = {
                element: null,
                values: "auto",
                empty: "Todas",
                multiple: false,
                noColumn: false,
            }

            var selectTodos = {
                element: null,
                values: "auto",
                empty: "Todos",
                multiple: false,
                noColumn: false,
            }

            function sortLowerCase(l, r) {
                return l.toLowerCase().localeCompare(r.toLowerCase());
            }

            function sortNumber(a,b) {
                return a-b;
            }

            function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
                return 'Apresentando ' + totalRow + ' inscrições, de um total de ' + totalRowUnfiltered + ' inscrições';
            }

        </script>

    </head>
    <body>
        <script>
            $(document).ready(function () {
                $('#sortable-table').datatable({
                    pageSize: Number.MAX_VALUE,
                    sort: [sortLowerCase, sortNumber, false, false],
                    filters: [false],
                    filterText: 'Escreva para filtrar... ',
                    counterText: showCounter
                });

                if($("#room").val() != null)
                    $("#btn_room_"+$("#room").val()).switchClass("btn-default", "btn-primary");
            });
        </script>
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
                    <select name="colonia_f" id= "colonia" key="<?php echo $summer_camp_id; ?>" onchange="openDisposal()">
                        <option value="0" <?php if(!isset($colonia_escolhida)) echo "selected"; ?>>Selecionar</option>
                        <?php
                        foreach ( $camps as $camp ) {
                            $selected = "";
                            if ($colonia_escolhida == $camp)
                                $selected = "selected";
                            echo "<option $selected value='$camp'>$camp</option>";
                        }
                        ?>
                    </select>
                    <select name="pavilhao" id="pavilhao" onchange="openDisposal()">
                        <option value=""  <?php if(!isset($pavilhao)) echo "selected"; ?>> Selecionar </option>
                        <option value="M" <?php if(isset($pavilhao) && $pavilhao == "M") echo "selected"; ?>> Masculino </option>
                        <option value="F" <?php if(isset($pavilhao) && $pavilhao == "F") echo "selected"; ?>> Feminino </option>
                    </select>

                    <input type="hidden" id="room" name="quarto" value = "<?= (isset($quarto)) ? $quarto : '' ?>" />

                    <br /><br />

                    <div class="btn_room_row" style="<?= ((isset($quarto))?'':'display:none')?>" >
                        <table>
                            <tr>
                                <th> <button class="btn btn-default" id="btn_room_0" style="margin-left:5px" onclick="openRoomDisposal(0)"> Sem Quarto </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_1" style="margin-left:5px" onclick="openRoomDisposal(1)"> 1<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_2" style="margin-left:5px" onclick="openRoomDisposal(2)"> 2<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_3" style="margin-left:5px" onclick="openRoomDisposal(3)"> 3<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_4" style="margin-left:5px" onclick="openRoomDisposal(4)"> 4<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_5" style="margin-left:5px" onclick="openRoomDisposal(5)"> 5<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_6" style="margin-left:5px" onclick="openRoomDisposal(6)"> 6<?= (isset($pavilhao))?$pavilhao:""?> </button> </th>
                                <th> <button class="btn btn-default" id="btn_room_-1" onclick="openRoomDisposal(-1)"> Todos os quartos </button> </th>
                            </tr>
                           <?php if(isset($room_occupation)){ ?>
                                <tr>
                                    <td align="center"><?=$room_occupation[0] ?></td>
                                    <td align="center"><?=$room_occupation[1] ?></td>
                                    <td align="center"><?=$room_occupation[2] ?></td>
                                    <td align="center"><?=$room_occupation[3] ?></td>
                                    <td align="center"><?=$room_occupation[4] ?></td>
                                    <td align="center"><?=$room_occupation[5] ?></td>
                                    <td align="center"><?=$room_occupation[6] ?></td>
                                    <td align="center"><?= $room_occupation[1]+
                                            $room_occupation[2]+
                                            $room_occupation[3]+
                                            $room_occupation[4]+
                                            $room_occupation[5]+
                                            $room_occupation[6] ?>
                                        <img src="<?= $this->config->item('assets') ?>images/kinderland/help.png" width="15" height="15"
                                            title="Número de colonistas por quarto."/>
                                    <td>
                                    
                                </tr>
                            <?php } ?> 
                        </table>
					</div>
					
					
                </form>
            </div>

        </div>

        <?php if(isset($colonists)) { ?>
            <div class = "row">
                <br /><br />

                <div class="col-lg-12">
                  <button class="btn btn-primary" onclick="gerarPDFcomDadosCadastrais('Lista')" value="">Lista</button>&nbsp;<button class="btn btn-primary" onclick="gerarPDFcomDadosCadastrais('Documentos')" value="">Documentos</button>&nbsp;<button class="btn btn-primary" onclick="gerarPDFcomDadosCadastrais('Cadastros')" value="">Cadastros</button>&nbsp;<button class="btn btn-primary" onclick="createPDFMedicalFiles()" value="">Fichas Médicas</button>&nbsp;<button class="btn btn-primary" onclick="geraAutorizacaoPDF('<?=$summer_camp_id?>')" value="">Autorizações</button>&nbsp;<button class="btn btn-primary" onclick="gerarPDFcomDadosCadastrais('Contatos')" value="">Contatos</button>&nbsp;<button class="btn btn-primary" onclick="sendTableToCSV()" value="">E-mails</button>
                  <br /><br />
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 700px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Colonista </th>
                                <th> Idade </th>
                                <th> Data de Nascimento </th>
                                <th> Ano Escolar </th>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php
                            $colonistsId = array();
                            $colonistsFather = array();
                            $colonistsFatherE = array();
                            $colonistsMother = array();
                            $colonistsMotherE = array();
                            $colonistsResponsable = array();
                            $colonistsResponsableE = array();
                            
                            $k = 0;
                            
                            foreach ($colonists as $colonist) { 
                            	$colonistsId[$k] = $colonist -> colonist_id;
                            	$colonistsFather[$k] = $colonist -> fatherName;
                            	$colonistsFatherE[$k] = $colonist -> fatherEmail;
                            	$colonistsMother[$k] = $colonist -> motherName;
                            	$colonistsMotherE[$k] = $colonist -> motherEmail;
                            	$colonistsResponsable[$k] = $colonist -> responsableName;
                            	$colonistsResponsableE[$k] = $colonist -> responsableEmail;
                            	
                            	$k++;
                            	
                            	?>
                                <tr>
                                    <td><a name= "colonista" id="<?= $colonist->colonist_id ?>" key="<?= $colonist->colonist_id ?>" target="_blank" href="<?= $this->config->item('url_link') ?>admin/viewColonistInfo?type=report&colonistId=<?= $colonist->colonist_id ?>&summerCampId=<?= $colonist->summer_camp_id ?>"><?= $colonist->colonist_name ?></a></td>
                                    <td><?= explode(" ", $colonist->age)[0] ?></td>
                                    <td><?= date('d/m/Y', strtotime(substr($colonist->birth_date, 0, 10))) ?></td>
                                    <td><a name="responsavel" id="<?= $colonist -> user_name?>" key="<?= $colonist -> email?>"></a><?= $colonist->school_year ?></td>
                                </tr>                                   
                            <?php }
                            
                            $colonistsId = implode("|",$colonistsId);
                            $colonistsFather = implode("|",$colonistsFather);
                            $colonistsFatherE = implode("|",$colonistsFatherE);
                            $colonistsMother = implode("|",$colonistsMother);
                            $colonistsMotherE = implode("|",$colonistsMotherE);
                            $colonistsResponsable = implode("|",$colonistsResponsable);
                            $colonistsResponsableE = implode("|",$colonistsResponsableE);
                            
                            ?>  
                            <div id="colonistsId" key="<?php echo $colonistsId;?>" style = "display:none"></div>
                            <div id="colonistsFather" key="<?php echo $colonistsFather;?>" style = "display:none"></div>
                            <div id="colonistsFatherE" key="<?php echo $colonistsFatherE;?>" style = "display:none"></div>
                            <div id="colonistsMother" key="<?php echo $colonistsMother;?>" style = "display:none"></div>
                            <div id="colonistsMotherE" key="<?php echo $colonistsMotherE;?>" style = "display:none"></div>
                            <div id="colonistsResponsable" key="<?php echo $colonistsResponsable;?>" style = "display:none"></div>
                            <div id="colonistsResponsableE" key="<?php echo $colonistsResponsableE;?>" style = "display:none"></div>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
        
    </div>
</div>
