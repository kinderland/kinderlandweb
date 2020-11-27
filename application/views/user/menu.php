<div class = "row">
    <?php require_once APPPATH . 'views/include/common_user_left_menu.php' ?>
    <div class="col-lg-10" bgcolor="red">
        <h3>Bem <?= ($gender == "M") ? "vindo" : "vinda" ?>, <?= $fullname ?></h3>
    </div>
    <tr>
        <div class="row">
                    <div  class="col-lg-10" style="padding-bottom:10px">
    					<p align="justify">Texto doação emergencial...</p>
                    </div>
    </div>
    <tr>
    <div class="row">
                    <div  class="col-lg-10" style="padding-bottom:10px">
                        <a href="<?= $this->config->item('url_link'); ?>donations/freeDonation">
                            <button  class="btn btn-primary" style="margin: auto; width: 100%; ">Quero doar</button>
                        </a>
                    </div>
    </div>
</div>