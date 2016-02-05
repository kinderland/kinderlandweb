<div class = "row">
    <?php $actual_screen = "USUARIOS"; ?>
    <?php
    require_once APPPATH . 'core/menu_helper.php';
    require_once renderMenu($permissions);
    ?>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/select.box.iframe.js"></script>
    <div class="col-lg-9" style="width: 1100px;">
        <h3><strong>Administração</strong></h3>
        <hr/>
        <div class="row">
            <div class="col-lg-8">
                <select class="report-select" name="report_select" id="report_select">
                    <option selected="selected" value="<?= $this->config->item('url_link'); ?>admin/userPermissions">Perfis de usuários</option>
                </select>
            </div>
        </div>
        <br>

        <div class="row">
            <iframe class="frame-section" src="<?= $this->config->item('url_link'); ?>admin/userPermissions" />
        </div>
    </div>

</div>