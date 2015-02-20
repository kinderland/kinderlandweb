<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">

		<?php 
			if($transaction != null && $transaction instanceof Event) { 
		?>
		<div class='row'>
			<div class="col-lg-8">
				<h3><?=$transaction->getTId();?></h3>
				<p>
					Data: 
					<strong>
						<?=$transaction->getDate_created();?> 
						<?= ($transaction->getDate_created() != $transaction->getDate_updated())? " - ".$transaction->getDate_updated():""?>
					</strong>
				</p>
			</div>
			<div class="col-lg-4">
				<h3>Preço: <strong>R$<?=$transaction->getTransaction_value()?></strong></h3>
			</div>

			<div class="col-lg-10 col-lg-offset-1">
				<p align="center">
					<?=$transaction->getPayment_status();?>
				</p>
			</div>
		</div>
		<?php 
			} else {
		?>
			<h3> 
				Nenhuma compra cielo registrada para o número indicado.
			</h3>
		<?php
			}
		?>

	</div>
</div>