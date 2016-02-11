<div class = "row">
    <?php $actual_screen = "EVENTOS"; ?>
    <?php
    require_once APPPATH . 'core/menu_helper.php';
    require_once renderMenu($permissions);
    ?>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/select.box.iframe.js"></script>
    <div class="col-lg-12">
        <h3><strong>Relatórios</strong></h3>
        <hr/>
        <div class="row">
            <div class="col-lg-8">
                <select class="report-select" name="report_select" id="report_select">
                    <?php if (in_array(SYSTEM_ADMIN, $permissions) || in_array(SECRETARY, $permissions)) { ?>
                        <option selected="selected" value="<?= $this->config->item('url_link'); ?>reports/reportPanel"> Painel de Relatório </option>
                        <option selected="selected" value="<?= $this->config->item('url_link'); ?>reports/report_panel_byage">Painel de Eventos por Faixa Etária</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <br>

        <div class="row">
            <iframe class="frame-section" src="<?= $this->config->item('url_link'); ?>reports/report_panel_byage" />
        </div>
    </div>

</div>