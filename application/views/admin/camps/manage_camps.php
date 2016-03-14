<style type="text/css">
    html, body {
        
        padding-left:30px;
    }
</style>



<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css"
	rel="stylesheet" />
<!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
<link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css"
	rel="stylesheet" />
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css">
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>
<?php 
        
      //  require_once renderMenu($permissions); 
    ?>
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
            $(function() {
                $("#sortable-table").tablesorter({widgets: ['zebra']});
                $(".datepicker").datepicker();
            });

            $( document ).ready(function() {
            	  $("[name='my-checkbox']").bootstrapSwitch();
            	  $("[name='my-checkbox']").each(function( index ) {
            	  	if($(this).attr("checkedInDatabase") != undefined)
            	  		$(this).bootstrapSwitch('state', true, true);
            	  });
            	  $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
            	    var string = "<?=$this->config->item("url_link")?>admin/changeCampEnabledStatus/".concat($(this).attr("id"));
            	    var recarrega = "<?=$this->config->item("url_link")?>admin/manageCamps/";
            	    $.post( string ).done(function( data ) {
            	        if(data == 1)
            			    alert( "Colônia modificada com sucesso" );
            			else{
            				alert( "Problema ao modificar o estado da colônia" );
            				window.location=recarrega;
            			}
            			});
            	  });
            	});

            <?php if($message){?>
        	alert('<?php echo $message;?>');
        	<?php }?>

            function updateCampEnabled(campId) {
                var enabled = true; //Tentar pegar o valor do Radio Button

                $.post("<?= $this->config->item('url_link'); ?>admin/changeCampEnabledStatus",
                    { camp_id: campId, status: ((enabled)?"t":"f")  },
                        function ( data ){
                            if(data == "true")
                                alert("Colônia atualizada");
                            else
                                alert("Erro ao atualizar pré-inscrições");
                        }
                );
            }
        </script>
        <div class="scroll">
        
            <div class = "row">
                <div class="col-lg-12">
                   <?php if (in_array(SYSTEM_ADMIN, $permissions)){?> 
                    <a href="<?= $this->config->item('url_link'); ?>admin/createCamp">
                        <button type="button" class="btn btn-primary btn-sm">
                            Criar colônia
                        </button>
                        <br /><br />
                    </a>
                    <?php }?>
                    
                            <?php
                                if(isset($camps) && is_array($camps)){
                                	?>
                                	<table class="table"><tr><th>Nome</th><th>Data Inicio</th><th>Data Fim</th><th>Habilitar pré-inscrições</th><th>Capacidade</th><th>Ações</th></tr>
                                	<?php 
                                    foreach($camps as $camp){
                            ?>
                            

                            <tr>
                                <td><a href="<?php echo $this->config->item("url_link");?>admin/editCamp/<?php echo $camp->getCampId()?>"><?php echo $camp->getCampName() . ( ($camp->isMiniCamp())? " (Mini)":"" );?></a></td>
                                <td><?= date_format(date_create($camp->getDateStart()), 'd/m/y');?></td>
                                <td><?= date_format(date_create($camp->getDateFinish()), 'd/m/y');?></td>
                               	<td><input type="checkbox" data-inverse="true" name="my-checkbox" data-size="mini" id="<?=$camp->getCampId()?>" 
        						<?php if($camp->isEnabled()) echo "checkedInDatabase='true'"; else echo " disabled ";?> /> </td>
                                <td>M: <?=$camp->getCapacityMale()?> | F: <?=$camp->getCapacityFemale()?></td>
                                <td><a target="_blank" href="<?=$this->config->item('url_link')?>summercamps/manageStaff/<?=$camp->getCampId()?>"> Equipe </a> <td/>
                            </tr>

                            <?php
                                    }
                                }
                            ?>
                        
                </div>
            </div>
        
		</div>
    </body>
</html>