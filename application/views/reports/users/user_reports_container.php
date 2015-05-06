<div class = "row">
    <?php $actual_screen = "USERS"; ?>
    <?php require_once APPPATH . 'views/include/director_left_menu.php' ?>
    <script>
        $(function() {
            //$( "#report_select" ).selectmenu();

            $( "#report_select" ).change(function() {
                $(".frame-section").attr("src", $( "#report_select option:selected" ).val());
            });
        });
    </script>
    <div class="col-lg-10">
        <div class="row">
            <div class="col-lg-8">
                <select class="report-select" name="report_select" id="report_select">
                    <option selected="selected" value="<?= $this->config->item('url_link'); ?>reports/user_registered">Painel de usuário</option>
                    <option value="<?= $this->config->item('url_link'); ?>reports/all_users">Cadastros Kinderland</option>
                </select>
            </div>
        </div>
        <hr class="footer-hr" />

        <div class="row">
            <iframe class="frame-section" src="<?= $this->config->item('url_link'); ?>reports/user_registered" />
        </div>
    </div>

</div>