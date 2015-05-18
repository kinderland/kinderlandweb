<div class = "row">
    <?php $actual_screen = "USUARIO"; ?>
    <?php require_once APPPATH . 'views/include/director_left_menu.php' ?>
    <script>
        $(function() {
            //$( "#report_select" ).selectmenu();
            $(".frame-section").attr("src", $( "#report_select option:selected" ).val());

            $( "#report_select" ).change(function() {
                $(".frame-section").attr("src", $( "#report_select option:selected" ).val());
            });

            $(function(){
                var height = window.innerHeight;
                $('iframe').css('height', height);
            });

            //And if the outer div has no set specific height set.. 
            $(window).resize(function(){
                var height = window.innerHeight;
                $('iframe').css('height', height);
            });
        });
    </script>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-8">
                <select class="report-select" name="report_select" id="report_select">
                    <option value="<?= $this->config->item('url_link'); ?>reports/user_registered">Painel de usuário</option>
                    <option value="<?= $this->config->item('url_link'); ?>reports/all_users">Cadastros Kinderland</option>
                </select>
            </div>
        </div>
        <hr class="footer-hr" />

        <div class="row">
            <iframe class="frame-section" />
        </div>
    </div>

</div>