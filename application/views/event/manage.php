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

<script>$( document ).ready(function() {
  $("[name='my-checkbox']").bootstrapSwitch();
  $("[name='my-checkbox']").each(function( index ) {
  	if($(this).attr("checkedInDatabase") != undefined)
  		$(this).bootstrapSwitch('state', true, true);
  });
  $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
    var string = "<?=$this->config->item("url_link")?>events/toggleEnable/".concat($(this).attr("id"));
    var recarrega = "<?=$this->config->item("url_link")?>events/manageEvents/";
    $.post( string ).done(function( data ) {
        if(data == 1)
		    alert( "Evento modificado com sucesso" );
		else{
			alert( "Problema ao modificar o estado do evento" );
			window.location=recarrega;
		}
		});
  });
});
</script>
</head>
<body>
<div class="row">
    <?php // require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">
        <body onunload="window.opener.location.reload();"><a target='_blank' onclick="window.open('<?=$this->config->item("url_link")?>events/eventCreate','dd'); return false;" href=""><button id="create" class="btn btn-primary"  value="Criar novo evento" >Criar novo evento</button></a>
<br /><br />
		<?php 
			if(isset($events) && count($events) > 0) {
			    ?>
               <table class="table"><tr><th>Nome</th><th>Data Inicio</th><th>Data Fim</th><th>Habilitar na Interface</th></tr> 
        <?php
            	foreach($events as $event) {
		?><tr>
		<!-- <td><a href="<?php //$this->config->item("url_link")?>events/info/<?php //$event->getEventId()?>"><?php //$event->getEventName();?></a></td> -->
		<td><?=$event->getEventName();?></td>
        <td><?= date_format(date_create($event->getDateStart()), 'd/m/y');?> </td>
        <td><?= date_format(date_create($event->getDateFinish()), 'd/m/y')?> </td>
        <td><input type="checkbox" data-inverse="true" name="my-checkbox" data-size="mini" id="<?=$event->getEventId()?>" 
        <?php if(!$event->getIsValid()) echo " disabled "; if($event->isEnabled()) echo "checkedInDatabase='true'";?> /> </td>
		</tr>
		<?php 
				}
        ?> </table>
        <?php
			} else {
		?>
			<h3> 
				Nenhum evento registrado para acontecer nos próximos dias. 
				<br />Continue acompanhando a Colônia Kinderland pelo nosso website.
			</h3>
		<?php
			}
		?>
    </div>
	</div>
</div>
</body>
</html>