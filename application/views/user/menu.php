<div class = "row">
    <?php require_once APPPATH . 'views/include/common_user_left_menu.php' ?>
    <div class="col-lg-10" bgcolor="red">
        <h3>Bem <?= ($gender == "M") ? "vindo" : "vinda" ?>, <?= $fullname ?></h3>
    </div>
    <tr>
    <p align="justify">Texto doação emergencial...</p>    
    <tr>
    <div class="row">
                    <div  class="col-lg-4 col-lg-offset-4" style="padding-bottom:10px">
                        <a href="<?= $this->config->item('url_link'); ?>donnation/freedonation">
                            <button  class="btn btn-primary" style="margin: auto; width: 100%; ">Quero doar</button>
                        </a>
                    </div>
    </div>
</div>