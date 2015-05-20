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
    <div class="main-container-report">
        <div class = "row">
            <div class="col-lg-10" bgcolor="red">
                <table class="table table-bordered table-striped table-min-td-size" style="max-width: 600px;">
                    <?php
                    foreach ($data as $row) {
                        switch ($row->donation_status) {
                            case "abandonado":
                                echo "<tr><th align='right' >Doações abandonadas</th><td align='right'>$row->count </td></tr>";
                                break;
                            case "pago":
                                echo "<tr><th align='right' >Doações recebidas</th><td align='right'>$row->count </td></tr>";
                                break;
                            case "aberto":
                                echo "<tr><th align='right' >Doações aguardando confirmação (abertas)</th><td align='right'>$row->count </td></tr>";
                                break;
                            case "não autorizado":
                                echo "<tr><th align='right' >Doações não autorizadas</th><td align='right'>$row->count </td></tr>";
                                break;
                            default:
                                break;
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>