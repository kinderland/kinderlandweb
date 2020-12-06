<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css" rel="stylesheet" />
        <!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/polyfiller.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.widgets.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
    <script type="text/javascript" src="<?= $this->config->item('assets'); ?>datatable/js/datatable.min.js"></script>
    <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>datatable/css/datatable-bootstrap.min.css" />


</head>
<body>
    <header class="navbar <?php if ($this->db->database == 'kinderland_teste') echo "navbar-test"; else echo "navbar-sags";?>" role="banner" id="top">
        <div class="container">
            <?php if (isset($user_id)) { ?>
                <a class="navbar-brand" href="<?= $this->config->item('url_link') ?>system/menu">
                <?php } else { ?>
                    <a class="navbar-brand" href="<?= $this->config->item('url_link') ?>login/index">
                    <?php } ?>

                    <img src="<?= $this->config->item('assets'); ?>images/kinderland/logo-kinderland.png" width=140 height=50 />
                </a>
                <a> <span class="login-span" style="width: 1400px;justify-content:center;align-items: center;text-size:36px">
                    Voce chegou no lugar certo !
                    </span>
                </a>
                
                <div class="navbar-form navbar-right" style="margin-top:20px">
                    <?php if (isset($user_id)) { ?>
                        <span class="login-span">
                            Olá, <?= $fullname; ?><br />
                            <?php if (count($permissions) > 1) { ?>
                                <span class="login-span">
                                    <a href="<?= $this->config->item('url_link') ?>system/menu">Trocar de perfil</a>
                                </span> |
                                <?php
                            }
                            if ($this->db->database == 'kinderland_teste') {
                                echo "AMBIENTE DE TESTES<br>";
                            }
                            ?>
                            
                            <a href="<?= $this->config->item('url_link') ?>login/logout">Sair do Sistema</a>
                        </span>

                    <?php } else { ?>
                    
                <!--    <a href="<?php // echo $this->config->item('url_link') ?>events/token"><button class="btn btn-primary">Eventos</button></a> -->
                    <a href="<?= $this->config->item('url_link') ?>login/signup"><button class="btn btn-primary">Cadastre-se</button></a>

                    <?php } ?>
                </div>
        </div>
    </header>

    <div class="main-container">