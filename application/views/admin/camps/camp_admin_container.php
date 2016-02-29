<div class = "row">
    <?php $actual_screen = "COLONIA"; ?>
    <?php
    require_once APPPATH . 'core/menu_helper.php';
    require_once renderMenu($permissions);
    ?>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/select.box.iframe.js"></script>
    <div class="col-lg-12" style="width: 1100px;">
        <div class="row">
            <div class="col-lg-8">
                <h3><strong>Administração</strong></h3>
                <hr/>
                <select class="report-select" name="report_select" id="report_select">
                    <?php if (in_array(SYSTEM_ADMIN, $permissions) || in_array(COORDINATOR, $permissions)) { ?>
                        <option value="<?= $this->config->item('url_link'); ?>admin/manageCamps">Cadastro de colônias</option>
                    <?php } if (in_array(SYSTEM_ADMIN, $permissions)) { ?>
                        <option value="<?= $this->config->item('url_link'); ?>admin/queue">Fila de Espera</option>
                        <option <?= $discount ?> value="<?= $this->config->item('url_link'); ?>admin/setDiscount">Conceder Desconto</option>
                        <option value="<?= $this->config->item('url_link'); ?>admin/paymentLiberation">Liberação para pagamento</option>
                        <option value="<?= $this->config->item('url_link'); ?>admin/managePaymentLiberation">Gerência de pagamentos pendentes</option>
                    <?php } ?>
                    <?php if (in_array(SYSTEM_ADMIN, $permissions) || in_array(SECRETARY, $permissions)) { ?>
                        <option <?= $validation ?> value="<?= $this->config->item('url_link'); ?>admin/validateColonists">Validação</option>
                    <?php } ?> 
                    <?php if (in_array(SYSTEM_ADMIN, $permissions)) { ?>
                        <option value="<?= $this->config->item('url_link'); ?>admin/colonist_exclusion">Cancelamentos e Exclusões</option>
                    <?php } ?> 
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <iframe class="frame-section" src="<?= $this->config->item('url_link'); ?>admin/validateColonists" />
        </div>
    </div>

</div>