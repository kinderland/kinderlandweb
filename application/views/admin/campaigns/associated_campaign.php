<div class = "row">
    <?php $actual_screen = "CAMPANHA_ASSOCIADOS"; ?>
    <?php
    require_once APPPATH . 'core/menu_helper.php';
    require_once renderMenu($permissions);
    ?>
    <body>
        <div class="row">
            <?php // require_once APPPATH.'views/include/common_user_left_menu.php' ?>
            <div class="col-lg-10 middle-content">
                <body onunload="window.opener.location.reload();"><a target='_blank' onclick="window.open('<?= $this->config->item("url_link") ?>admin/campaignCreate', 'dd');
                        return false;" href=""><button id="create" class="btn btn-primary"  value="Criar novo evento" >Criar novo evento</button></a>
                    <br /><br />
                </body>
            </div>
        </div>
    </body>
</div>