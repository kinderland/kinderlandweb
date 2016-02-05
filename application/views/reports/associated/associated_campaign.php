<div class = "row">
    <?php $actual_screen = "CAMPANHA_ASSOCIADOS"; ?>
    <?php
    require_once APPPATH . 'core/menu_helper.php';
    require_once renderMenu($permissions);
    ?>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/select.box.iframe.js"></script>
    <div class="col-lg-9" style="width: 1100px;">
        <h3><strong>Relatórios</strong></h3>
        <hr/>
        <div class="row">
            <div class="col-lg-8">
                <select class="report-select" name="report_select" id="report_select">
                    <?php foreach ($years as $year) { ?>
                        <option value="<?= $this->config->item('url_link'); ?>reports/associated_year/<?php echo $year->year_event; ?>">Campanha <?php echo $year->year_event; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <br>

        <div class="row">
            <iframe class="frame-section" />
        </div>
    </div>

</div>