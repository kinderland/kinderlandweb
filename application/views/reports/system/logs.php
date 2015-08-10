<div class = "row">
    <?php $actual_screen = "LOGS"; ?>
    <?php
    require_once APPPATH . 'core/menu_helper.php';
    require_once renderMenu($permissions);
    ?>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-8">
                <?php
                for ($i = count($files) - 1; $i > 0; $i--) {
                    if ($files[$i] != "..") {
                        echo "<a href='openlog/" . $files[$i] . "'>" . $files[$i] . "</a><br>";
                    }
                }
                ?>
            </div>
        </div>
        <hr class="footer-hr" />
    </div>

</div>