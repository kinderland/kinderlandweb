<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
    	<p> A doação número <?=$donation->getDonationId()?> já foi fechada e encontra-se como 
    		<strong><?=$donation->getDonationStatusName()?></strong>.<p>
    	<p> Se deseja seguir com a doação, por favor, refaça o processo de pagamento. </p>

    	<a href="<?=$this->config->item('url_link')?>system/menu">
	    	<button type="button" class="btn btn-danger">
	            Voltar
	        </button>
	    </a>
    </div>
</div>