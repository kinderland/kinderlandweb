<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">
		<h3> Doação Avulsa </h3>

		<p>
			A Kinderland bla-bla-bla
		</p>


		<form action="<?=$this->config->item('url_link')?>donations/checkoutFreeDonation" method="POST">
			<div class="row">
				<label for="fullname" class="col-lg-2 control-label"> Valor da doação: </label>
				<div class="col-lg-4">
					<input type="number" min="20" class="form-control" value="20" name="donation_value" 
					oninvalid="this.setCustomValidity('O valor mínimo para doação é de R$20,00.')"/>
				</div>
			</div>
			<div class="row"> 
				<div class="col-lg-12">
					<p><u>O valor mínimo da doação é de R$<?=number_format(20, 2, ',', '.')?> </u></p>
				</div>
			</div>
			<div class="row">
			 	<div class="col-lg-4">
					<input type="submit" class="btn btn-primary btn-sm" value="Prosseguir" />
				</div>
			</div>

		</form>

	</div>
</div>