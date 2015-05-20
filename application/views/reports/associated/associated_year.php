<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
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