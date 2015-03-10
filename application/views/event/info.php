<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">
		<script type="text/javascript">

			function subscribeUserOnSession(userId, eventId){
				var alreadyInvited = false;

				$(".subscriptions").each(function(){
					if($(this).val() == userId){
						alert("Convite já solicitado.");
						alreadyInvited = true;
					}
				});

				if(!alreadyInvited){
				$.post( "<?=$this->config->item('url_link')?>events/subscribeUser", 
							{ event_id: eventId, user_id: userId },
							function ( data ){
								location.reload();
							}
					);
				}	
			}

		</script>

		<?php 
			if($event != null && $event instanceof Event) { 
		?>
			<div class='row'>
				<div class="col-lg-8">
					<h3><?=$event->getEventName();?></h3>
					<p>
						Data: 
						<strong>
							<?= date_format(date_create($event->getDateStart()), 'd/m/y H:i');?> 
							<?= ($event->getDateStart() != $event->getDateFinish())? " - ".date_format(date_create($event->getDateFinish()), 'd/m/y H:i'):""?>
						</strong>
					</p>
				</div>
				<div class="col-lg-4">
					<h3>Preço: <strong>R$<?=number_format($event->getPrice(), 2, ',', '.')?></strong></h3>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-10 col-lg-offset-1">
					<p align="center">
						<?=$event->getDescription();?>
					</p>
				</div>
			</div>
			<div class="row">
				&nbsp;
			</div>
			<div class="row">
				<div class="col-lg-12">

					<div align="center">
						<h4>Solicitar convite:</h4>
						<button class="btn btn-primary" style="margin-right:40px" onClick="subscribeUserOnSession(<?=$user_id?>, <?=$event->getEventId()?>)">Para mim</button>
						<a href="<?=$this->config->item("url_link")?>events/subscribeNewPerson/<?=$event->getEventId()?>"><button class="btn btn-primary" >Para outros</button></a>
					</div>
				</div>
			</div>

			<div class="row">
				&nbsp;
			</div>
			<div class="row">
				&nbsp;
				<hr />
			</div>
			<?php 
				if(count($subscriptions) > 0) {
			?>
				<div class="row">
					<div class="col-lg-12">
						<form action="<?=$this->config->item("url_link")?>events/checkoutSubcriptions" method="POST" name="form_submit_payment" id="form_submit_payment">
							<input type="hidden" name="user_id" value="<=$user_id?>" />
							<div class="col-lg-8">
								<h4>Meus convites:</h4>
							</div>
							<div class="col-lg-4">
								<button class="btn btn-primary" style="float:right; " onClick="paymentDetailsScreen(<?=$user_id?>, <?=$event->getEventId()?>)">Pagar</button>
								<button class="btn btn-warning" style="float:right; margin-right:40px" onClick="deleteSubscriptions(<?=$user_id?>, <?=$event->getEventId()?>)">Deletar</button>
							</div>
							<div class="row">
								&nbsp;
							</div>
							<table class="table table-condensed table-hover">
								<tr>
									<th>-</th>
									<th>Pago</th>
									<th>Nome do convidado</th>
									<th>Descrição do convite</th>
								</tr>
								<?php 
									foreach($subscriptions as $subscr){
								?>
									<tr>
										<td><input type="checkbox" name="subscriptions" class="subscriptions" value="<?=$subscr->person_id?>" /></td>
										<td><img src="<?= $this->config->item('assets') ."images/kinderland/". ( ($subscr->subscription_status == SUSCRIPTION_STATUS_SUBSCRIPTION_OK)?'confirma.png':'nao-confirma.png' ) ?>" width="20px" height="20px"/></td>
										<td><?= $subscr->fullname ?></td>
										<td>R$ <?= number_format($subscr->final_price, 2, ',', '.') ?></td>
									</tr>
								<?php
									}
								?>
							</table>
						</form>
					<div>
				</div>
			<?php
				} 
			?>
					
			
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