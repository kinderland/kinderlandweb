<div class = "row">
    <?php 
        require_once APPPATH . 'views/include/monitor_left_menu.php';
    ?>
    <div class="col-lg-9" bgcolor="red">
        <h3>Bem <?= ($gender == "M") ? "vindo" : "vinda" ?>, <?= $fullname ?></h3>
    </div>
</div>