<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">

		<?php 
			if(isset($events) && count($events) > 0) { 
				foreach($events as $event) {
		?>
		<a href="<?=$this->config->item("url_link")?>events/info/<?=$event->getEventId()?>">
			<div class='row event-row'>
				<div class="col-lg-8">
					<h3><?=$event->getEventName();?></h3>
					<p>
						Data: 
						<strong>
							<?=$event->getDateStart();?> 
							<?= ($event->getDateStart() != $event->getDateFinish())? " - ".$event->getDateFinish():""?>
						</strong>
					</p>
				</div>
				<div class="col-lg-4">
					<h3>Preço: <strong>R$<?=$event->getPrice()?></strong></h3>
				</div>

				<div class="col-lg-10 col-lg-offset-1">
					<p align="center">
						<?=$event->getDescription();?>
					</p>
				</div>
			</div>
		</a>
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