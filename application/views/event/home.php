<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">

		<?php 
			if(isset($events) && count($events) > 0) { ?>
			<h2><strong>Eventos:</strong></h2><br />
			<div class='row'>
			<div class="col-lg-8">
				<table  class="table table-bordered table-striped" style="max-width:900px; min-width:100px; table-layout: fixed;">
					<tr>
						<th style="width:100px">Nome</th>
						<th style="width:300px">Descrição</th>
						<th style="width:70px">Início</th>
						<th style="width:70px">Fim</th>
						<th style="width:100px">abertas até</th>
						<th style="width:170px">Ingressos adquiridos</th>
						<th style="width:100px">Ação</th>						
					</tr>
			<?php 	foreach($events as $event) {
		?>
					<tr>
						<td><?=$event->getEventName();?></td>
						<td><?=$event->getDescription();?></td>
						<td><?= date_format(date_create($event->getDateStart()), 'd/m/y');?></td>
						<td><?= ($event->getDateStart() != $event->getDateFinish())? "".date_format(date_create($event->getDateFinish()), 'd/m/y'):""?></td>
						<td><?= date_format(date_create($event->getDateFinishShow()), 'd/m/y')?></td>
						<td style="text-align:center" ><?=$qtdSubs[$event->getEventId()]?></td>
						<td><a href="<?=$this->config->item("url_link")?>events/info/<?=$event->getEventId()?>"><button class="btn btn-primary">Inscrição</button></a></td>
					</tr>
		<?php 
				} ?>
				</table>
				</div>
				</div>
		<?php 	} else {
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