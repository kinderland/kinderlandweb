
    
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


        <link href="<?= $this->config->item('assets'); ?>css/datepicker.css" rel="stylesheet" />
        <link rel="text/javascript" href="<?= $this->config->item('assets'); ?>js/datepicker.less.js" />
        
        
        <script>
	    
            $(function() {
                $("#sortable-table").tablesorter({widgets: ['zebra']});
                $(".datepicker").datepicker();
            });

            $(document).ready(function () {
            	datepickers();
            });

            var linha = '<tr><td><input type="text" class=" datepickers form-control" placeholder="Data de Início" name="payment_date_start[]"</td><td><input type="text" class=" datepickers form-control" placeholder="Data de Fim" name="payment_date_end[]"</td>			   		<td><input type="text" class="form-control" placeholder="Valor geral" name="full_price[]" id="full_price"></td>			   		<td><input type="number" class="form-control" name="payment_portions[]" id="payment_portions" value="1" min="1" max="8"></td>			   		<td><input type="text" class="form-control" placeholder="Valor Associado" name="associated_price[]" id="associated_price"> </td>			   		<td><img src="<?=$this->config->item('assets')?>images/forms/icon_minus.gif" style="cursor: pointer; cursor: hand;" class="delete""></button></td>				   	</tr>	';

            function addTableLine(linhaAAdicionar){
            	if(!linhaAAdicionar)
            		$('#table > tbody:last').append(linha);
            	else
            		$('#table > tbody:last').append(linhaAAdicionar);
            	datepickers();
            	$(".delete").on('click', function(event) {
            		$(this).parent().parent().remove();
            	});

            }

            function back(){
            	$.redirect("<?=$this->config->item('url_link');?>admin/manageCamps");
            }

            function datepickers(){
            	$('.datepickers').datepicker();
            	$(".datepickers").datepicker("option", "dateFormat", "dd/mm/yy");	
            }

            var string = "";

            <?php foreach($errors as $e){
            	echo "string = string.concat('$e');";
            } ?>

            if(string !== ""){
            	alert("Os seguintes erros foram encontrados:\n".concat(string));
            }
            	

            function validateInfo() {
                var formValid = true;
                var alertMsg = "Os seguintes campos estão inválidos:";

                if($("#camp_name").val() == ""){
                    formValid = false;
                    alertMsg = alertMsg + "\nNome da colônia";
                }

                if($("#date_start").val() == ""){
                    formValid = false;
                    alertMsg = alertMsg + "\nData início da colônia";
                }

                if($("#date_finish").val() == ""){
                    formValid = false;
                    alertMsg = alertMsg + "\nData fim da colônia";
                }

                if($("#date_start_pre_associate").val() == ""){
                    formValid = false;
                    alertMsg = alertMsg + "\nData início das pré-inscrições";
                }

                if($("#date_finish_pre_associate").val() == ""){
                    formValid = false;
                    alertMsg = alertMsg + "\nData fim das pré-inscrições";
                }

                if($("#date_start_pre").val() == ""){
                    formValid = false;
                    alertMsg = alertMsg + "\nData início das pré-inscrições";
                }

                if($("#date_finish_pre").val() == ""){
                    formValid = false;
                    alertMsg = alertMsg + "\nData fim das pré-inscrições";
                }

                if(isNaN($("#capacity_male").val()) || $("#capacity_male").val() <= 0){
                    formValid = false;
                    alertMsg = alertMsg + "\nVagas Masculino";
                }
                if(isNaN($("#capacity_female").val()) || $("#capacity_female").val() <= 0){
                    formValid = false;
                    alertMsg = alertMsg + "\nVagas Feminino";
                }

                if(formValid == true)
                    $("#form_update_camp").submit();
                else
                    alert(alertMsg);
            }

            function chooseMiniCamp(value){
            	var rads = document.getElementsByName("mini_camp");
            	
          	  	for(var i = 0; i < rads.length; i++){
          	   		if(rads[i].value == value){
          	    		rads[i].checked = true;
          	   		}
          	   		else {
          	   			rads[i].checked = false;
          	   		}          	   		
          	   	}
            }

            function validateNumberInput(evt) {

                var key_code = (evt.which) ? evt.which : evt.keyCode;
                if ((key_code >= 48 && key_code <= 57) || key_code == 9 || key_code == 8) {
                    return true;
                }
                return false;
            }

            $(document).ready(function (){
                <?php foreach($payments as $payment){ ?>
        		addTableLine('<tr><td><input type="text" class=" datepickers form-control" placeholder="Data de Início" name="payment_date_start[]" value="<?php echo Events::toMMDDYYYY($payment["payment_date_start"])?>"</td><td><input type="text" class=" datepickers form-control" placeholder="Data de Fim" name="payment_date_end[]" value="<?php echo Events::toMMDDYYYY($payment["payment_date_end"])?>"</td>			   		<td><input type="text" class="form-control" placeholder="Valor geral" name="full_price[]" id="full_price" value="<?php echo $payment["full_price"]?>"></td>		   		<td><input type="number" class="form-control" name="payment_portions[]" id="payment_portions" value="<?php echo $payment["payment_portions"]?>" min="1" max="5"></td>			   		<td><input type="text" class="form-control" placeholder="Valor associado" name="associated_price[]" id="associated_price" value="<?php echo $payment["associated_price"];?>"> </td>			   		<td><img src="<?=$this->config->item('assets')?>images/forms/icon_minus.gif" style="cursor: pointer; cursor: hand;" class="delete""></button></td>				   	</tr>	');
        		<?php } ?> 
            });
        </script>
        </head>
<style>
        
	div.scroll{
    	height:100%;
    	padding-left:5px;
    	
	}
        
</style>
<div class="scroll">
        <div class="col-lg-9 middle-content">
            <div class="row">
                <div class="col-lg-6">
                    <h3> Editar colônia </h3>
                </div>
            </div>
            <div class="row">
                &nbsp;
            </div>
            <form name="form_update_camp" method="POST" action="<?=$this->config->item('url_link');?>admin/updateCamp/<?php echo $camp_id;?>" id="form_update_camp">
                <label for="camp_name" style="width: 125px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-2 control-label"> Nome da colônia: </label>
                        <div class="col-lg-6" style="width: 590px; padding-left:0px;">
                            <input type="text" class="form-control"
                              placeholder="Nome da colônia"  value="<?= $camp_name ?>" name="camp_name" id="camp_name"/>
                        </div>
                <br/><br/><br />
                <label for="schooling_description" style="width: 125px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-2 control-label"> Texto complementar: </label>
                        <div class="col-lg-6" style="width: 590px; padding-left:0px;">
                            <input type="text" class="form-control"
                              placeholder="Texto complementar"  value="<?= $schooling_description ?>" name="schooling_description" id="schooling_description"/>
                        </div>
                <br/><br/><br />
                        <label for="date_start" style="width: 80px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px; float:left;" class="col-lg-2 control-label"> Data Início: </label>
                        <div class="col-lg-3" style="padding-left:3px;">
                            <input type="text" class="datepickers form-control" value  = "<?php echo Events::toMMDDYYYY($date_start); ?>" name="date_start" id="date_start" />
                        </div>

                        <label for="date_finish" style="width: 70px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-2 control-label"> Data Fim: </label>
                        <div class="col-lg-3" style="padding-left:3px;">
                            <input type="text" class="datepickers form-control" value  = "<?php echo Events::toMMDDYYYY($date_finish); ?>" name="date_finish" id="date_finish" />
                        </div>
                 <br/><br/><br />
                    <div class="col-lg-4 form-group" style="float:left; padding-left:0px;">
                        Número máximo de colonistas:
                    </div>
                    <br/><br/>                    
                            <label for="capacity_male" style="width: 70px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-3 control-label"> Masculino: </label>
                            <div class="col-lg-3" style="padding-left:10px;">
                                <input onkeypress="return validateNumberInput(event);" type="text" class="form-control" value  = "<?php echo $capacity_male ?>" name="capacity_male" id="capacity_male" />
                            </div>
                       <br/><br/>
                           
                            <label for="capacity_female" style="width: 70px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-3 control-label"> Feminino: </label>
                            <div class="col-lg-3" style="padding-left:10px;">
                                <input onkeypress="return validateNumberInput(event);" type="text" class="form-control" value  = "<?php echo $capacity_female ?>" name="capacity_female" id="capacity_female" />
                            </div>
                           <br/><br/><br/> 
                
                <div class="col-lg-4 col-lg-offset-1"  style="width: 120px; padding-left:0px; padding-top:0px; padding-bottom:0px; padding-right:0px; margin-bottom:0px; margin-top:7px; margin-left:0px;">
                        Tipo de colônia:
                    </div>
                    <br/><br/>
                    <div class="col-lg-4 col-lg-offset-1" style="width: 140px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-left:0px;">
                                <label for="mini_camp" class="control-label"> Kinderland Verão: </label>
                                <input type="radio" name="mini_camp" value="false" onclick="chooseMiniCamp('false')"; <?php if($mini_camp == false) echo "checked";?>  />
                            </div>
                    <div class="col-lg-4 col-lg-offset-1" style="width: 200px; padding-left:15px; padding-right:0px; margin-bottom:0px; margin-left:0px;">
                                <label for="mini_camp" class="control-label"> Mini ou 1a Turma: </label>
                                <input type="radio" name="mini_camp" value="true" onclick="chooseMiniCamp('true')"; <?php if($mini_camp == true) echo "checked";?>  />
                            </div> 
                            <br/><br />
                    <div class="col-lg-6 form-group" style="width: 300px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;">
                        Período de pré-inscrições para associados:
                    </div>
                <br/><br/> 
                        <label for="date_start_pre_associate" class="col-lg-2 control-label" style="width: 80px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px; float:left;"> Data Início: </label>
                        <div class="col-lg-3" style="padding-left:3px;">
                            <input type="text" class="form-control datepickers" placeholder="dd/mm/yy" value ="<?php echo Events::toMMDDYYYY($date_start_pre_associate); ?>" name="date_start_pre_associate" id="date_start_pre_associate"/>
                        </div>

                        <label for="date_finish_pre_associate" class="col-lg-2 control-label" style="width: 70px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;"> Data Fim: </label>
                        <div class="col-lg-3" style="padding-left:3px;">
                            <input type="text" class="form-control datepickers" placeholder="dd/mm/yy" value = "<?php echo Events::toMMDDYYYY($date_finish_pre_associate); ?>" name="date_finish_pre_associate" id="date_finish_pre_associate"/>
                        </div>
                        <br/><br/><br/>

                    <div class="col-lg-4 form-group" style="width: 300px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;">
                        Período de pré-inscrições:
                    </div>
                <br/><br/>
                        <label for="date_start_pre" class="col-lg-2 control-label" style="width: 80px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px; float:left;"> Data Início: </label>
                        <div class="col-lg-3" style="padding-left:3px;">
                            <input type="text" class="form-control datepickers" placeholder="dd/mm/yy" value ="<?php echo Events::toMMDDYYYY($date_start_pre); ?>" name="date_start_pre" id="date_start_pre"/>
                        </div>

                        <label for="date_finish_pre" class="col-lg-2 control-label" style="width: 70px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;"> Data Fim: </label>
                        <div class="col-lg-3" style="padding-left:3px;">
                            <input type="text" class="form-control datepickers" placeholder="dd/mm/yy" value = "<?php echo Events::toMMDDYYYY($date_finish_pre); ?>" name="date_finish_pre" id="date_finish_pre"/>
                        </div>
				<br/><br/><br/>	
					<div for="capacity_male" class="col-lg-1 control-label" style="width: 300px;"> Períodos para pagamento: </div><br /><br/>
				<div class="col-lg-12">
               <table id="table" name="table" class="table"><tr><th>De</th><th>Até</th><th>Valor</th><th style="width: 150px;">Parcelas max</th><th style="width: 200px;">Valor Sócio</th></tr> 
			   <tbody>
			   </tbody>
			   </table>
			   <button style="width: 110px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px; float:left;" type="button" value="" onclick="addTableLine()">Novo periodo</button>
				</div>
				<br/><br/><br/>
                        <div class="col-lg-2" style="width: 80px; padding-left:0px; padding-right:120px; margin-bottom:0px; margin-top:7px; float:left;">
                            <button  type="button" class="btn btn-primary" onClick="validateInfo()">Confirmar</button>
                        </div>
                        <div class="col-lg-2" style="width: 70px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;">
                            <button  type="button" class="btn btn-warning"
					onClick="back()">Voltar</button></a>
                        </div>
                    
                
            </form>
            </div>
</div>
