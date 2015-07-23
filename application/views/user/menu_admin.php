<div class = "row">
    <?php 
        require_once APPPATH . 'core/menu_helper.php';
        require_once renderMenu($permissions); 
    ?>
    <div class="col-lg-9" bgcolor="red">
        <h3>Bem <?= ($gender == "M") ? "vindo" : "vinda" ?>, <?= $fullname ?></h3>
    </div>
</div>