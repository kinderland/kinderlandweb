<div class = "row">
    <?php $actual_screen = "FINANCEIRO"; ?>
    <?php 
        require_once APPPATH . 'core/menu_helper.php';
        require_once renderMenu($permissions); 
    ?>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/select.box.iframe.js"></script>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-8">
                <select class="report-select" name="report_select" id="report_select">
                    <?php if (in_array(SYSTEM_ADMIN, $permissions) || in_array(DIRECTOR, $permissions)){ ?>
                        <option selected="selected" value="<?= $this->config->item('url_link'); ?>reports/payments_bycard/?option=<?=PAYMENT_REPORTBYCARD_QUANTITY?>">Painel de doações (quantitativo)</option>
                        <option value="<?= $this->config->item('url_link'); ?>reports/payments_bycard/?option=<?=PAYMENT_REPORTBYCARD_VALUES?>">Painel de doações (valores)</option>
                        <option value="<?= $this->config->item('url_link'); ?>reports/free_donations">Doações avulsas</option>
                        <option value="<?= $this->config->item('url_link'); ?>reports/associate_campaign_donations">Doações Campanha de Sócios</option>
                   <!-- <option value="<?= $this->config->item('url_link'); ?>reports/camps_donations">Doações Colônias</option>  -->  
                    	<option value="<?= $this->config->item('url_link'); ?>reports/user_donation_history">Histórico individual de doações</option>
                    	<option value="<?= $this->config->item('url_link'); ?>reports/all_transactions">Transações Cielo</option>
                    <?php } ?>
                    <option value="<?= $this->config->item('url_link'); ?>reports/failed_transactions">Transações Cielo sem sucesso</option>
                <!--	<?php if (in_array(SYSTEM_ADMIN, $permissions) || in_array(DIRECTOR, $permissions)){ ?>
                	<option value="<?= $this->config->item('url_link'); ?>reports/transactions_expected">Cielo a Receber</option>
                	<?php } ?> -->
                </select>
            </div>
        </div>
        <hr class="footer-hr" />

        <div class="row">
            <iframe class="frame-section" src="<?= $this->config->item('url_link'); ?>reports/payments_bycard/?option=<?=PAYMENT_REPORTBYCARD_QUANTITY?>" />
        </div>
    </div>

</div>