<style type="text/css">
    html, body {
        
        padding-left:5px;
    }
</style>


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

        <script type="text/javascript">

        	

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



            function sendInfoToModal(colonistName, campName, userName, situation, colonistId, summerCampId, discount){
        		$("#colonist_name").html(colonistName);
        		$("#camp_name").html(campName);
        		$("#user_name").html(userName);
        		$("#situation").html(situation);
        		$("#colonist_id").html(colonistId);
        		$("#summer_camp_id").html(summerCampId);
        		$("#discount").html(discount);
            }


			
            function getCSVName() {
                var filtros = $(".datatable-filter");
                var filtroNomeColonista = filtros[1].value;
                var e = document.getElementById("colonia");
                var filtroColonia = filtros[2].value;
                var filtroNomeResponsavel = filtros[3].value;
                var filtroStatus = filtros[0].value;
                var nomePadrao = "inscricoes";


                if (filtroNomeColonista == "" && filtroNomeResponsavel == "") {

                    if (filtroColonia == false) {

                        nomePadrao = nomePadrao.concat("_todas_colonias");
                    }

                    else {
                        nomePadrao = nomePadrao.concat("_".concat(filtroColonia));
                    }
                    if (filtroStatus == false) {
                        return nomePadrao.concat("_todos_status");
                    }
                    else {

                        if (filtroStatus == "Cancelado") {
                            return nomePadrao.concat("_cancelados");
                        }
                        else if (filtroStatus == "Excluido") {
                            return nomePadrao.concat("_excluidos");
                        }
                        else if (filtroStatus == "Desistente") {
                            return nomePadrao.concat("_desistentes");
                        }
                        else if (filtroStatus == "Pré-inscrição em elaboração") {
                            return nomePadrao.concat("_em_elaboração");
                        }
                        else if (filtroStatus == "Pré-inscrição aguardando validação") {
                            return nomePadrao.concat("_aguardando_validação");
                        }
                        else if (filtroStatus == "Pré-inscrição validada") {
                            return nomePadrao.concat("_validados");
                        }
                        else if (filtroStatus == "Pré-inscrição na fila de espera") {
                            return nomePadrao.concat("_em_fila_espera");
                        }
                        else if (filtroStatus == "Pré-inscrição aguardando pagamento") {
                            return nomePadrao.concat("_aguardando_pagamento");
                        }
                        else if (filtroStatus == "Pré-inscrição não validada") {
                            return nomePadrao.concat("_não_validados");
                        }
                        else if (filtroStatus == "Inscrito") {
                            return nomePadrao.concat("_inscritos");
                        }
                    }
                }
                else {
                    if (filtroNomeResponsavel == "") {
                        return nomePadrao.concat("_filtrado_por_colonista_".concat(filtroNomeColonista));
                    }
                    else if (filtroNomeColonista == "") {
                        return nomePadrao.concat("_filtrado_por_responsavel_".concat(filtroNomeResponsavel));
                    }
                    else {
                        nomePadrao = nomePadrao.concat("_filtrado_por_responsavel_".concat(filtroNomeResponsavel));
                        return nomePadrao.concat("_e_por_colonista_".concat(filtroNomeColonista));
                    }
                }
            }
			
            
            function getFilters() {
                var filtros = $(".datatable-filter");
                var filtroNomeColonista = filtros[1].value;
                var e = document.getElementById("colonia");
                var filtroColonia = filtros[2].value;
                var filtroNomeResponsavel = filtros[3].value;
                var filtroStatus = filtros[0].value;
                var saida = [];
                var temp = "";

                if (filtroColonia == false) {
                    saida.push("Colônias: todas")
                }
                else {
                    temp = "Colônia: ";
                    temp = temp.concat(filtroColonia);
                    saida.push(temp)
                }

                if (filtroStatus == false) {
                    saida.push("Status: todos");
                }
                else {
                    temp = "Status: ";
                    temp = temp.concat(filtroStatus);
                    saida.push(temp);
                }
                if (filtroNomeColonista != "") {
                    temp = "Filtro por colonista: ";
                    temp = temp.concat(filtroNomeColonista);
                    saida.push(temp);
                }
                if (filtroNomeResponsavel != "") {
                    temp = "Filtro por responsável: ";
                    temp = temp.concat(filtroNomeResponsavel);
                    saida.push(temp);
                }
                return saida;

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

            function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
                return 'Apresentando ' + totalRow + ' inscrições, de um total de ' + totalRowUnfiltered + ' inscrições';
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
                    sort: [true, sortLowerCase, true, sortLowerCase],
                    filters: [selectTodos, true, selectTodas, true],
                    filterText: 'Escreva para filtrar... ',
                    counterText: showCounter
                });
            });
        </script>
        <div class="scroll">
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
                    <form method="GET">
                    Ano: <select name="ano_f" onchange="this.form.submit()" id="anos">

                            <?php
                            foreach ($years as $year) {
                                $selected = "";
                                if ($ano_escolhido == $year)
                                    $selected = "selected";
                                echo "<option $selected value='$year'>$year</option>";
                            }
                            ?>
                        </select>
                       
                        
                    </form>
                    <div class="counter"></div> <br>
                    <table class="table table-bordered table-striped table-min-td-size" style="width: 1000px; font-size:14px" id="sortable-table">
                        <thead>
                            <tr>
                                <th>Status da Inscrição</th>
                                <th>Nome do Colonista</th>
                                <th>Colônia</th>
                                <th>Responsável</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        
                        <script>

                        function excluirColonista(){
                        	var senha = document.getElementById('password').value;
                        	var cancel_reason = document.getElementById('cancel_reason').value;
                        	var colonist_id=document.getElementById("colonist_id").textContent;
                        	var summer_camp_id=document.getElementById("summer_camp_id").textContent;
                      	    var discount=document.getElementById("discount").textContent;
                    	    var situation=document.getElementById("situation").textContent;

                    	    if(situation == 3 || situation == 4 || situation == 5){
            					discount = 0;
            				}
            				
            				if(situation == 5)
            					situation = -2;
            										
            				else if(situation == 3 || situation == 4 || situation == 1 || situation == 0 || situation == 2)
            					situation = -3;
                    	    $.post('<?= $this->config->item('url_link');?>admin/password',
            						{senha: senha, colonist_id: colonist_id, summer_camp_id: summer_camp_id, situation: situation, cancel_reason: cancel_reason, discount: discount},
            						function(data){
            							if(data=="true"){
            								alert("Colonista excluído com sucesso");
            								location.reload();
            							}
            							else{
            								alert("Não foi possível excluir o colonista. Tente novamente!");
            								location.reload();
            							}
            						}
            				);											
                    	}	

                        	                        	
            													
            								

                        </script>
                        
                        <tbody id="tablebody">
                            <?php
                            $colonistsId = array();
                            $i = 0;

                            foreach ($colonists as $colonist) {

                                ?>
                                <tr>
                                    <td id="colonist_situation_<?= $colonist->colonist_id ?>_<?= $colonist->summer_camp_id ?>"><font color="
                                                                                                                                     <?php
                                                                                                                                     switch ($colonist->situation) {
                                                                                                                                         case SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION: echo "#061B91";
                                                                                                                                             break;
                                                                                                                                         case SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED: echo "#017D50";
                                                                                                                                             break;
                                                                                                                                         case SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS: echo "#FF0000";
                                                                                                                                             break;
                                                                                                                                         case SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN: echo "#555555";
                                                                                                                                             break;
                                                                                                                                         case SUMMER_CAMP_SUBSCRIPTION_STATUS_CANCELLED: echo "#FF0000";
                                                                                                                                             break;
                                                                                                                                         case SUMMER_CAMP_SUBSCRIPTION_STATUS_EXCLUDED: echo "#FF0000";
                                                                                                                                             break;
                                                                                                                                         case SUMMER_CAMP_SUBSCRIPTION_STATUS_GIVEN_UP: echo "#FF0000";
                                                                                                                                             break;
                                                                                                                                         case SUMMER_CAMP_SUBSCRIPTION_STATUS_QUEUE: echo "#555555";
                                                                                                                                             break;
                                                                                                                                         case SUMMER_CAMP_SUBSCRIPTION_STATUS_PENDING_PAYMENT: echo "#061B91";
                                                                                                                                             break;
                                                                                                                                         case SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED: echo "#017D50";
                                                                                                                                             break;
                                                                                                                                     }
                                                                                                                                     ?>"><?= $colonist->situation_description ?></td>

                                    <td><a name= "colonista" id="<?= $colonist->colonist_name ?>" key="<?= $colonist->colonist_id ?>" target="_blank" href="<?= $this->config->item('url_link') ?>admin/viewColonistInfo?type=report&colonistId=<?= $colonist->colonist_id ?>&summerCampId=<?= $colonist->summer_camp_id ?>"><?= $colonist->colonist_name ?></a></td>
                                    <td><?= $colonist->camp_name ?></td>
                                    <td><a name= "responsavel" id="<?= $colonist->email ?>" target="_blank" href="<?= $this->config->item('url_link') ?>user/details?id=<?= $colonist->person_user_id ?>"><?= $colonist->user_name ?></a></td>
                                    <?php 
                                    if ($colonist->situation == 3 || $colonist->situation == 4 || $colonist->situation == 1 || $colonist->situation == 0 || $colonist->situation == 2 ){
                                    ?>
                                    <td><button class="btn btn-primary" onclick="sendInfoToModal('<?= $colonist->colonist_name ?>', '<?= $colonist->camp_name ?>', '<?= $colonist->user_name ?>', '<?= $colonist->situation ?>', '<?= $colonist->colonist_id ?>', '<?= $colonist->summer_camp_id ?>', '<?= $colonist->discount ?>')" data-toggle="modal" data-target="#myModal">Cancelar</button></td>
                                    
                                    <?php }
                                    else if ($colonist->situation == 5){
                                    ?>
                                    <td><button class="btn btn-primary"  onclick="sendInfoToModal('<?= $colonist->colonist_name ?>', '<?= $colonist->camp_name ?>', '<?= $colonist->user_name ?>', '<?= $colonist->situation ?>', '<?= $colonist->colonist_id ?>', '<?= $colonist->summer_camp_id ?>', '<?= $colonist->discount ?>')" data-toggle="modal" data-target="#myModal">Excluir</button></td>
                                    <?php 
                                    }else{
                                    ?>
                                    <td><a href="" ></a></td>
                                    <?php }?>
                                    
                                </tr>                                

                                <?php
                            }
                            ?>				
                            
                            	
                        </tbody>
                    </table>
                </div>
            </div>
            	<!-- Modal -->
            	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="solicitar-convite" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="modal_title"></h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-6 middle-content">
								<form name="form_password" method="POST" action="<?=$this->config->item('url_link')?>admin/password" id="form_password">	                                         
										<div class="row">
											<div class="form-group">
												<div class="col-lg-6">
												
												
													<input type="hidden" id="colonist_id" name="colonist_id" value="" />
                                                    <input type="hidden" id="discount" name="discount" value="" />
                                                    <input type="hidden" id="summer_camp_id" name="summer_camp_id" value="" />
                                                    													
													<tr>
                                                        <td> Colonista: </td> 
                                                        <span id='colonist_name'></span> <br><br>                                                 
                                                    </tr>

                                                    <tr>
                                                        <td> Colônia: </td>
                                                        <span id='camp_name'></span> <br><br>
                                                    </tr>

                                                    <tr>
                                                        <td> Responsável: </td>
                                                        <span id='user_name' name="user_name"></span> <br><br>
                                                    </tr>

                                                    <tr>
                                                        <td> Status Atual: </td>
                                                        <span id='situation'></span> <br><br>
                                                    </tr>
                                                   
                                                    <tr>
                                                        <td> Senha: </td>
                                                        <td>
                                                            <input type="text" id="password" name="senha" /> <br><br>
                                                        </td>
                                                    </tr>                                                    
                                                    
                                                    <tr>
                                                        <td> Motivo: </td>
                                                        <td>
                                                            <input type="text" id="cancel_reason" name="cancel_reason" /> <br>
                                                        </td>
                                                    </tr>
													<input type="hidden" id="situation" name="situation" value="" />
													
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-warning" data-dismiss="modal">Voltar</button>
							<button class="btn btn-warning" onClick="excluirColonista()">Confirmar</button>

					</div>
				</div>
			</div>
        </div>
        </div>
        </div>
    </body>
</html>
