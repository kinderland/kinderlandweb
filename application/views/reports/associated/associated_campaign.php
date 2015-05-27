<div class = "row">
    <?php $actual_screen = "CAMPANHA_ASSOCIADOS"; ?>
    <?php require_once APPPATH . 'views/include/director_left_menu.php' ?>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/select.box.iframe.js"></script>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-8">
                <select class="report-select" name="report_select" id="report_select">
                    <?php foreach ($years as $year) { ?>
                        <option value="<?= $this->config->item('url_link'); ?>reports/associated_year/<?php echo $year->year_event; ?>">Campanha <?php echo $year->year_event; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <hr class="footer-hr" />

        <div class="row">
            <iframe class="frame-section" />
        </div>
    </div>

</div>