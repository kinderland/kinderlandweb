<div class = "row">
    <?php $actual_screen = "FINANCEIRO"; ?>
    <?php require_once APPPATH . 'views/include/director_left_menu.php' ?>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/select.box.iframe.js"></script>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-8">
                <select class="report-select" name="report_select" id="report_select">
                    <option selected="selected" value="<?= $this->config->item('url_link'); ?>reports/payments_bycard/?option=<?=PAYMENT_REPORTBYCARD_QUANTITY?>">Painel de doações (quantitativo)</option>
                    <option value="<?= $this->config->item('url_link'); ?>reports/payments_bycard/?option=<?=PAYMENT_REPORTBYCARD_VALUES?>">Painel de doações (valores)</option>
                    <option value="<?= $this->config->item('url_link'); ?>reports/all_transactions">Transações Cielo</option>
                </select>
            </div>
        </div>
        <hr class="footer-hr" />

        <div class="row">
            <iframe class="frame-section" src="<?= $this->config->item('url_link'); ?>reports/payments_bycard/?option=<?=PAYMENT_REPORTBYCARD_QUANTITY?>" />
        </div>
    </div>

</div>