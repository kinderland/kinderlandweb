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
                    <?php if (in_array(SYSTEM_ADMIN, $permissions)){ ?>
                        <option selected="selected" value="<?= $this->config->item('url_link'); ?>admin/manageCamps">Cadastro de colônias</option>
                    <?php } ?>
                    <?php if (in_array(SECRETARY, $permissions)){ ?>
                        <option selected="selected" value="<?= $this->config->item('url_link'); ?>admin/validateColonists">Validação</option>
                    <?php } ?>
                    
                </select>
            </div>
        </div>
        <hr class="footer-hr" />

        <div class="row">
            <iframe class="frame-section" src="<?= $this->config->item('url_link'); ?>admin/manageCamps" />
        </div>
    </div>

</div>