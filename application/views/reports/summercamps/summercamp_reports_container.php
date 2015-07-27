<div class = "row">
    <?php $actual_screen = "COLONIA"; ?>
    <?php 
        require_once APPPATH . 'core/menu_helper.php';
        require_once renderMenu($permissions); 
    ?>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/select.box.iframe.js"></script>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-8">
                <select class="report-select" name="report_select" id="report_select">
                    <option selected="selected" value="<?= $this->config->item('url_link');?>reports/all_registrations">Painel de Inscrições</option>
                	<option value="<?= $this->config->item('url_link'); ?>reports/colonist_registered">Inscrições</option>
                	<option value="<?= $this->config->item('url_link'); ?>reports/colonists_byschool">Colonistas por Escola</option>
                	<option value="<?= $this->config->item('url_link'); ?>reports/colonists_byassociated">Inscrições por Sócio</option>
                </select>
            </div>
        </div>
        <hr class="footer-hr" />

        <div class="row">
            <iframe class="frame-section" src="<?= $this->config->item('url_link'); ?>reports/all_registrations"/></iframe>
        </div>
    </div>

</div>


  