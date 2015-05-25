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

<div class="row">
    <?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">
        <a href="<?=$this->config->item("url_link")?>events/eventCreate"><button id="create" class="btn btn-default"  value="Criar novo evento" >Criar novo evento</button></a>

		<?php 
			if(isset($events) && count($events) > 0) {
			    ?>
               <table class="table"><tr><th>Nome</th><th>Data Inicio</th><th>Data Fim</th><th>Habilitar na Interface</th></tr> 
        <?php
            	foreach($events as $event) {
		?><tr>
		<td><a href="<?=$this->config->item("url_link")?>events/info/<?=$event->getEventId()?>"><?=$event->getEventName();?></a></td>
        <td><?= date_format(date_create($event->getDateStart()), 'd/m/y');?> </td>
        <td><?= date_format(date_create($event->getDateFinish()), 'd/m/y')?> </td>
        <td><input type="checkbox" data-inverse="true" name="my-checkbox" data-size="mini" id="<?=$event->getEventId()?>" 
        	<?php if(!$event->getIsValid()) echo " disabled "; if($event->isEnabled()) echo "checkedInDatabase='true'";?></td>
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