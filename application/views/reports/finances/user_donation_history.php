<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css" rel="stylesheet" />
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css">
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
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>datatable/js/datatable.min.js"></script>
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>datatable/css/datatable-bootstrap.min.css" />
    </head>
    <body>
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12 middle-content">
                    <h3>Histórico de doações de <?=$user->getFullname()?></h3>
                    <br />
                        <button type="button" class="btn btn-primary" onClick="history.back(-1)">
                            Voltar
                        </button>
                    <br />
                    <br />
                    <?php
                    if (isset($donations) && count($donations) > 0) {
                        ?>

                        <table class="table table-condensed table-hover" style="max-width:600px">
                            <tr>
                                <th>Data e hora</th>
                                <th>Descrição</th>
                                <th>Valor</th>
                                <th>Status</th>
                            </tr>
                            <?php
                            foreach ($donations as $donation) {
                                ?>
                                <tr>
                                    <td><?= date_format(date_create($donation->date_created), 'd/m/y H:i') ?></td>
                                    <td><?= $donation->donation_type ?>
                                    	<?php 
                                            if(isset($donation->extra)){
                                                foreach($donation->extra as $extra){
                                                    echo $extra;
                                                }
                                            }
										?>
                                    </td>
                                    <td><?= $donation->donated_value ?></td>
                                    <td><?= $donation->donation_status ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <?php
                    } else {
                        ?>
                        <h3>
                            Nenhuma doação efetuada até o momento.
                        </h3>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </body>
</html>