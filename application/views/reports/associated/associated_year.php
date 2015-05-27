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
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <script>
            $(function () {
                $("#sortable-table").tablesorter({widgets: ['zebra']});
            });
        </script>


    </head>
    <body>
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-10" bgcolor="red">
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 600px;">
                        <?php
                        foreach ($summary as $row) {
                            switch ($row->donation_status) {
                                /*case "abandonado":
                                    echo "<tr><th align='right' >Doações abandonadas</th><td align='right'>$row->count </td></tr>";
                                    break;*/
                                case "pago":
                                    echo "<tr><th align='right' >Número de sócios contribuintes</th><td align='right'>$row->count </td></tr>";
                                    break;
                                case "aberto":
                                    echo "<tr><th align='right' >Doações aguardando confirmação (abertas)</th><td align='right'>$row->count </td></tr>";
                                    break;
                                /*case "não autorizado":
                                    echo "<tr><th align='right' >Doações não autorizadas</th><td align='right'>$row->count </td></tr>";
                                    break;*/
                                default:
                                    break;
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class = "row">
                <div class="col-lg-12">

                    <table class="sortable-table" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Nome </th>
                                <th> E-mail </th>
                                <th> Data associação </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($users as $user) {
                                ?>
                                <tr>
                                    <td><a target="_blank" href="<?= $this->config->item('url_link') ?>user/details?id=<?= $user->person_id ?>"><?= $user->fullname ?></a></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= date("d/m/Y", strtotime($user->data_associacao)) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>