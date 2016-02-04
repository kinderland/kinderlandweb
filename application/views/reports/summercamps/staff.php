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

            function geraAutorizacaoPDF(camp_id){
				var type = "Vários";
            	
    			nomePadrao = "Autorização-de-Viagem-Monitores-Auxiliares";
                
        		post('<?= $this->config->item('url_link'); ?>summercamps/generateStaffPDFTripAuthorization', {name: nomePadrao,camp_id: camp_id, type: type});
        	}

            function gerarLista() {

                var campId = document.getElementById('colonia').getAttribute('key');
                  
                post('<?= $this->config->item('url_link'); ?>summercamps/generateStaffList', {campId: campId});
                
            }
            function createPDFMedicalFiles() {
                window.location.href = "<?= $this->config->item('url_link'); ?>summercamps/generatePDFWithStaffMedicalFiles/<?=$ano_escolhido?>/<?=(isset($summer_camp_id)?$summer_camp_id:'')?>";
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
        <script>
            $(document).ready(function () {
                $('#sortable-table').datatable({
                    pageSize: Number.MAX_VALUE,
                    sort: [sortLowerCase, sortLowerCase],
                    filters:[false]
                });

                if($("#room").val() != null)
                    $("#btn_room_"+$("#room").val()).switchClass("btn-default", "btn-primary");
            });
        </script>
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
                    <select name="colonia_f" key="<?php echo $summer_camp_id;?>" onchange="this.form.submit()" id="colonia" >
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
                </form>
            </div>

        </div>

        <?php if(isset($staff)) { $function = null;
        $qtdMonitor = 0; $qtdMedico = 0; $qtdAssistente = 0; $qtdCoordenador = 0;?>
            <div class = "row">
               <div class="col-lg-12">
                <?php foreach($staff as $s){
                	if($s->staff_function == 2){
                		if($s->room_number != null){
                			$function = 'Monitor '.$s->room_number;
                			$qtdMonitor++;
                		}
                		else {
                			$qtdAssistente++;
                			$function = 'Auxiliar';
                		}
                	}
                	else if($s->staff_function == 1){
                		$qtdCoordenador++;
                		$function = 'Coordenador';
                	}
                	else if($s->staff_function == 3){
                		$qtdMedico++;
                		$function = 'Médico';
                	}
                }
                	  if($qtdCoordenador>1) echo $qtdCoordenador." coordenadores";
        			  else if($qtdCoordenador==1) echo $qtdCoordenador." coordenador";
        			  else if($qtdCoordenador==0) echo 'Sem coordenador';?>
                <br />
                <?php if($qtdMedico>1) echo $qtdMedico." médicos";
        			  else if($qtdMedico==1) echo $qtdMedico." médico";
        			  else if($qtdMedico==0) echo 'Sem médico';?>
                <br />
                <?php if($qtdMonitor>1) echo $qtdMonitor." monitores";
        			  else if($qtdMonitor==1) echo $qtdMonitor." monitor";
        			  else if($qtdMonitor==0) echo 'Sem monitor';?>
                <br />
                <?php if($qtdAssistente>1) echo $qtdAssistente." auxiliares";
        			  else if($qtdAssistente==1) echo $qtdAssistente." auxiliar";
        			  else if($qtdAssistente==0) echo 'Sem auxiliar';?>
                <br /> <br />
               	<button class="btn btn-primary" onclick="gerarLista()" value="">Lista</button>&nbsp;<button class="btn btn-primary" onclick="createPDFMedicalFiles()" value="">Fichas Médicas</button>&nbsp;<button class="btn btn-primary" onclick="geraAutorizacaoPDF('<?= $summer_camp_id?>')" value="">Autorizações</button>
                  <br /><br />
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 400px; font-size:15px" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Nome </th>
                                <th> Função </th>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php foreach ($staff as $s) { 
                            	if($s->staff_function == 2){
                            		if($s->room_number != null){
                            			$function = 'Monitor '.$s->room_number;
                            		}
                            		else {
                            			$function = 'Auxiliar';
                            		}
                            	}
                            	else if($s->staff_function == 1){
                            		$function = 'Coordenador';
                            	}
                            	else if($s->staff_function == 3){
                            		$function = 'Médico';
                            	}
                            	?>
                                <tr>
                                    <td><a name= "name" id="<?= $s->person_id ?>" key="<?= $s->person_id ?>" target="_blank" href="<?= $this->config->item('url_link') ?>user/details?id=<?= $s->person_id ?>"><?= $s->fullname ?></a></td>
                                    <td><div name = "function" id="<?= $s->staff_function?>"><?php echo $function; ?></div></td>
                                </tr>                                   
                            <?php } ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
        
    </div>
</div>
</div>
</body>
</html>