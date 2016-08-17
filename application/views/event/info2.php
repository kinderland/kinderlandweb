
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css" rel="stylesheet" />
        <!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css"></script>
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>

    </head>
    <body>
    <div id="thisdiv">
	<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">
		
		<script type="text/javascript">	

			function paymentDetailsScreen(){
				var event_id = "<?php echo $eventId; ?>";
				var ids = "<?php echo $personIds; ?>";

				$.redirect( "<?=$this->config->item('url_link');?>events/checkoutSubscriptions", 
										{event_id:event_id, ids:ids},
										"POST");
			}
			
		</script>
		<div class='row'>
				<div class="col-lg-8 col-lg-offset-2">
				<h2>Inscrição no Evento <?php echo $event->getEventName()?></h2>
				
					<div style= "margin-top: 15px; font-size:14px; width:1000px" id="cart-info">
					<table  class="table table-bordered table-striped" style="max-width:825px; min-width:100px; table-layout:fixed">
					
						<tr>
							<th style="width:210px">Quantidade de convites:</th>
							<td><span id="qtd_invites"><?php echo $qtd; ?></span></td>
							<th style="width:110px;visibility: hidden"></th>
							<th style="width:350px;visibility: hidden"></th>
						</tr>
						<tr>
							<th style="width:210px">Subtotal:</th>
							<td>R$<span id="subtotal"><?php echo number_format($subtotalPrice,2,",","."); ?></span></td>
						</tr>
						<tr>
							<th style="width:210px">Desconto:</th>
							<td>R$<span id="discount"><?php echo number_format($discount,2,",","."); ?></span></td>
						</tr>
						<tr>
							<th style="width:210px">Total:</th>
							<td>R$<span id="price_total"><?php echo number_format($totalPrice,2,",","."); ?></span></td>
						
						</tr>
						</table>
						<button class="btn btn-warning" style="float:left; " onclick="goHome()">Continuar depois</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="btn btn-primary"  onClick="paymentDetailsScreen()">Prosseguir com a doação</button>
						
				</div>
				</div>
		</div>
		</div>
		</div>
		</div>
		
		<script>
			function goHome(){
				window.location.href = "<?=$this->config->item('url_link');?>user/menu";
			}

		</script>
		
</body>
</html>