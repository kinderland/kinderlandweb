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
	    	height:100%;
	    	padding-left:5px;
	    	
		}
        
	</style>
     
     <body>

    <div class = "scroll">
    <?php // $actual_screen = "COLONIA"; ?>
    <?php //require_once APPPATH . 'views/include/director_left_menu.php' ?>
        <script>
            $(function() {
                $("#sortable-table").tablesorter({widgets: ['zebra']});
                $(function() {
                    $( ".datepicker" ).datepicker({
                        showOn: "button",
                        dateFormat: "dd/mm/yy",
                        buttonImage: "<?= $this->config->item('assets'); ?>images/calendar.gif",
                        buttonImageOnly: true,
                        buttonText: "Selecionar data"
                    });
                });
            });

            var linha = '<tr><td><input type="text" class=" datepickers form-control" placeholder="Data de Início" name="payment_date_start[]"</td><td><input type="text" class=" datepickers form-control" placeholder="Data de Fim" name="payment_date_end[]"</td>			   		<td><input type="text" class="form-control" placeholder="Valor geral" name="price[]" id="price"></td>			   		<td><input type="number" class="form-control" name="payment_portions[]" id="payment_portions" value="1" min="1" max="5"></td>			   		<td><input type="text" class="form-control" placeholder="Valor Sócio" name="associated_price[]" id="associated_price"> </td>			   		<td><img src="<?=$this->config->item('assets')?>images/forms/icon_minus.gif" style="cursor: pointer; cursor: hand;" class="delete""></button></td>				   	</tr>	';

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

                if(formValid)
                    $("#form_insert_camp").submit();
                else
                    alert(alertMsg);
            }

            $(document).ready(function (){
                <?php foreach($payments as $payment){ ?>
        		addTableLine('<tr><td><input type="text" class=" datepickers form-control" placeholder="Data de Início" name="payment_date_start[]" value="<?=Events::toMMDDYYYY($payment["payment_date_start"])?>"</td><td><input type="text" class=" datepickers form-control" placeholder="Data de Fim" name="payment_date_end[]" value="<?=Events::toMMDDYYYY($payment["payment_date_end"])?>"</td>			   		<td><input type="text" class="form-control" placeholder="Valor geral" name="price[]" id="price" value="<?=$payment["price"]?>"></td>		   		<td><input type="number" class="form-control" name="payment_portions[]" id="payment_portions" value="1" min="1" max="5"></td>			   		<td><input type="text" class="form-control" placeholder="Valor Sócio" name="associated_price[]" id="associated_price" value="<?php echo $payment['associated_price'];?>"> </td>			   		<td><img src="<?=$this->config->item('assets')?>images/forms/icon_minus.gif" style="cursor: pointer; cursor: hand;" class="delete""></button></td>				   	</tr>	');
        		<?php } ?> 
            });
        </script>
        <div class="col-lg-9 middle-content">
            <div class="row">
                    <h3> Criar colônia </h3>
            <br/>
            <form name="form_insert_camp" method="POST" action="<?=$this->config->item('url_link')?>admin/insertNewCamp" id="form_insert_camp">
                        <label for="camp_name" style="width: 125px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-2 control-label"> Nome da colônia: </label>
                        <div class="col-lg-6" style="width: 590px; padding-left:0px;">
                            <input type="text" style="width: 590px;" class="form-control"
                                name="camp_name" id="camp_name"/>
                        </div>
                <br/><br/><br />
                        <label for="date_start" style="width: 80px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px; float:left;" class="col-lg-2 control-label"> Data Início: </label>
                        <div class="col-lg-3" style="padding-left:3px;">
                            <input type="text" class="form-control datepicker" placeholder="dd/mm/yy" name="date_start" id="date_start"/>
                        </div>

                        <label for="date_finish" style="width: 70px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-2 control-label"> Data Fim: </label>
                        <div class="col-lg-3" style="padding-left:3px;">
                            <input type="text" class="form-control datepicker" placeholder="dd/mm/yy" name="date_finish" id="date_finish"/>
                        </div>
                 <br/><br/><br />
                    <div class="col-lg-4 form-group" style="float:left; padding-left:0px;">
                        Número máximo de colonistas:
                    </div>
                    <br/><br/>                    
                            <label for="capacity_male" style="width: 70px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-3 control-label"> Masculino: </label>
                            <div class="col-lg-3" style="padding-left:10px;">
                                <input type="text" class="form-control" name="capacity_male" id="capacity_male" />
                            </div>
                       <br/><br/>
                           
                            <label for="capacity_female" style="width: 70px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;" class="col-lg-3 control-label"> Feminino: </label>
                            <div class="col-lg-3" style="padding-left:10px;">
                                <input type="text" class="form-control" name="capacity_female" id="capacity_female" />
                            </div>
                           <br/><br/><br/> 
                
                <div class="col-lg-4 col-lg-offset-1"  style="width: 120px; padding-left:0px; padding-top:0px; padding-bottom:0px; padding-right:0px; margin-bottom:0px; margin-top:7px; margin-left:0px;">
                        Tipo de colônia:
                    </div>
                    <br/><br/>
                    <div class="col-lg-4 col-lg-offset-1" style="width: 140px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-left:0px;">
                                <label for="mini_camp" class="control-label"> Kinderland Verão: </label>
                                <input type="radio" name="mini_camp" value="false" checked />
                            </div>
                    <div class="col-lg-4 col-lg-offset-1" style="width: 200px; padding-left:15px; padding-right:0px; margin-bottom:0px; margin-left:0px;">
                                <label for="mini_camp" class="control-label"> Mini Kinderland: </label>
                                <input type="radio" name="mini_camp" value="true" />
                            </div> 
                            <br/><br />
                    <div class="col-lg-6 form-group" style="width: 300px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;">
                        Período de pré-inscrições para associados:
                    </div>
                <br/><br/> 
                        <label for="date_start_pre_associate" class="col-lg-2 control-label" style="width: 80px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px; float:left;"> Data Início: </label>
                        <div class="col-lg-3" style="padding-left:3px;">
                            <input type="text" class="form-control datepicker" placeholder="dd/mm/yy" name="date_start_pre_associate" id="date_start_pre_associate"/>
                        </div>

                        <label for="date_finish_pre_associate" class="col-lg-2 control-label" style="width: 70px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;"> Data Fim: </label>
                        <div class="col-lg-3" style="padding-left:3px;">
                            <input type="text" class="form-control datepicker" placeholder="dd/mm/yy" name="date_finish_pre_associate" id="date_finish_pre_associate"/>
                        </div>
                        <br/><br/><br/>

                    <div class="col-lg-4 form-group" style="width: 300px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;">
                        Período de pré-inscrições:
                    </div>
                <br/><br/>
                        <label for="date_start_pre" class="col-lg-2 control-label" style="width: 80px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px; float:left;"> Data Início: </label>
                        <div class="col-lg-3" style="padding-left:3px;">
                            <input type="text" class="form-control datepicker" placeholder="dd/mm/yy" name="date_start_pre" id="date_start_pre"/>
                        </div>

                        <label for="date_finish_pre" class="col-lg-2 control-label" style="width: 70px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;"> Data Fim: </label>
                        <div class="col-lg-3" style="padding-left:3px;">
                            <input type="text" class="form-control datepicker" placeholder="dd/mm/yy" name="date_finish_pre" id="date_finish_pre"/>
                        </div>
				<br/><br/><br/>	
					<div class="col-lg-4 form-group" for="capacity_male" class="col-lg-4 control-label" style="width: 200px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px;"> Períodos para pagamento: </div><br /><br/>
				
               <table id="table" name="table" class="table"><tr><th>De</th><th>Até</th><th>Valor</th><th style="width: 150px;">Parcelas max</th><th style="width: 200px;">Valor Sócio</th></tr> 
			   <tbody>
			   </tbody>
			   </table>
			   <button style="width: 110px; padding-left:0px; padding-right:0px; margin-bottom:0px; margin-top:7px; float:left;" type="button" value="" onclick="addTableLine()">Novo periodo</button>
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
    </div>
    </body>
</html>
        