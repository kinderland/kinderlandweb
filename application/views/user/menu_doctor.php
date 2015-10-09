<div class = "row">
    <?php 
        require_once APPPATH . 'views/include/doctor_left_menu.php';
    ?>
    <div class="col-lg-9" bgcolor="red">
        <h3>Bem <?= ($gender == "M") ? "vindo" : "vinda" ?>, <?= ($gender == "M") ? "Dr." : "Dra." ?> <?= $fullname ?></h3>
    </div>
</div>