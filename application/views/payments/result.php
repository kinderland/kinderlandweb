<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">

		<?php 
			if(isset($transactions) && count($transactions) > 0) { 
				foreach($transactions as $transaction) {
		?>
			<div class='row event-row'>
				<div class="col-lg-8">
					<h3><?=$transaction;?></h3>
				</div>
			</div>
		<?php 
				}
			} else {
		?>
			<h3> 
				Nenhum retorno cielo.
			</h3>
		<?php
			}
		?>

	</div>
</div>