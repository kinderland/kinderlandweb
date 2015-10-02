<?php

function hasPermission($permissions, $permissionRequested) {
    foreach ($permissions as $permission)
        if ($permission == $permissionRequested)
            return true;
    return false;
}
?>
<!-- Start: login-holder -->
<div class="row">



    <!--  start login-inner -->
    <div class="col-lg-8 col-lg-offset-2">
        <!-- start logo -->
        <div id="logo-login">
            <a href="index.html"><img src="<?= $this->config->item('assets'); ?>images/kinderland/logo.png" width="200" height="70" alt="" /></a>
        </div>
        <!-- end logo -->

        <div class="clear"></div>
        <div class="row">
            <center><h2> Bem <?= ($gender == "M") ? "vindo" : "vinda" ?>, <?= $fullname ?>.</h2></center>
            <br />

            <!--TO DO: Completar hrefs com os links para as devidas chamadas quando estiverem prontas-->

            <?php if (hasPermission($permissions, COMMON_USER)) { ?>
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4" style="padding-bottom:10px">
                        <a href="<?= $this->config->item('url_link'); ?>user/menu">
                            <button class="btn btn-primary" style="margin: 0px auto; width: 100%; ">Usuário comum</button>
                        </a>
                    </div>
                </div>

            <?php } ?>

            <?php if (hasPermission($permissions, SYSTEM_ADMIN) || hasPermission($permissions, DIRECTOR) || hasPermission($permissions, SECRETARY)) { ?>
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4" style="padding-bottom:10px">
                        <a href="<?= $this->config->item('url_link'); ?>user/admin">
                            <button class="btn btn-primary" style="margin: 0px auto; width: 100%">Painel Administrativo</button>
                        </a>
                    </div>
                </div>
            <?php } ?>

            <?php if (hasPermission($permissions, COORDINATOR)) { ?>
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4" style="padding-bottom:10px">
                        <a href="<?= $this->config->item('url_link'); ?>user/coordinator">
                            <button class="btn btn-primary" style="margin: 0px auto; width: 100%">Coordenador</button>
                        </a>
                    </div>
                </div>
            <?php } ?>

            <?php if (hasPermission($permissions, DOCTOR)) { ?>
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4" style="padding-bottom:10px">
                        <a href="<?= $this->config->item('url_link'); ?>user/doctor">
                            <button class="btn btn-primary" style="margin: 0px auto; width: 100%">Médico</button>
                        </a>
                    </div>
                </div>
            <?php } ?>

            <?php if (hasPermission($permissions, MONITOR)) { ?>
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4" style="padding-bottom:10px">
                        <a href="<?= $this->config->item('url_link'); ?>user/monitor">
                            <button class="btn btn-primary" style="margin: 0px auto; width: 100%">Monitor</button>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    <a href="<?= $this->config->item('url_link'); ?>login/logout">
                        <button class="btn btn-error" style="margin: 0px auto; width: 100%">Sair do Sistema</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--  end login-inner -->
    <div class="clear"></div>



</div>
<!-- End: login-holder -->
</body>
</html>