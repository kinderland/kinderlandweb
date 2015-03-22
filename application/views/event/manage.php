<script>$( document ).ready(function() {
  $("[name='my-checkbox']").bootstrapSwitch();
});
</script>

<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">
    <a href="<?=$this->config->item("url_link")?>events/eventCreate"><button id="create" class="btn btn-default"  value="Criar novo evento" >Criar novo evento</button></a>

		<?php 
			if(isset($events) && count($events) > 0) {
			    ?>
               <div class="table middle-content"><table class="table"><tr><th>Nome</th><th>Data Inicio</th><th>Data Fim</th><th>Habilitar na Interface</th></tr> 
        <?php
            	foreach($events as $event) {
		?><tr>
		<td><a href="<?=$this->config->item("url_link")?>events/info/<?=$event->getEventId()?>"><?=$event->getEventName();?></a></td>
        <td><?= date_format(date_create($event->getDateStart()), 'd/m/y H:i');?> </td>
        <td><?= ($event->getDateStart() != $event->getDateFinish())? " - ".date_format(date_create($event->getDateFinish()), 'd/m/y H:i'):""?> </td>
        <td><input type="checkbox" data-inverse="true" name="my-checkbox" data-size="mini" checked></td>
		</tr>
		<?php 
				}
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