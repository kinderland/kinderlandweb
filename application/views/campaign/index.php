
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css" rel="stylesheet" />
        <!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css"></script>
    <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>

</head>
<body>
    <div id="thisdiv">
        <div class="row">
            <?php require_once APPPATH . 'views/include/common_user_left_menu.php' ?>
            <div class="col-lg-10 middle-content">
                <?php if (isset($campaign) && !empty($campaign)) { ?>
                    <h3><strong>Campanha de sócios <?php echo $campaign->getCampaignYear(); ?></strong></h3>
                    <hr class="footer-hr"/>

                    <?php if (isset($associate) && !empty($associate)) { ?>
                        <h3>Você já é um sócio dessa campanha.</h3>
                    <?php } else { ?>
                        <h5>Campanha iniciada em: <?php echo $date_start
                        ?> às 00:00</h5>
                        <h5> Término da campanha: <?php echo $date_finish ?> às 23:59</h5>
                        <h5> Valor da doação: R$ <?php echo $campaign->getPrice(); ?></h5>

                        <div style="margin-top:130px">
                            <h6 style="color:red"><strong>Ao se tornar um sócio da Colônia Kinderland, você recebe diversos benefícios e prioridades.
                                    Você continuará como sócio até a próxima Campanha de Sócios começar. </strong></h6>
                        </div>

                        <a class="btn btn-primary" role="button" href="<?= $this->config->item('url_link') ?>campaigns/startAssociation">Prosseguir</a>

                        <?php
                    }
                } else {
                    ?>
                    <h3><strong> A campanha de sócios não está aberta no momento.<br> Continue acompanhando nosso site para novidades.</strong></h3>
                <?php } ?>


            </div>
        </div>
    </div>
</body>
</html>
