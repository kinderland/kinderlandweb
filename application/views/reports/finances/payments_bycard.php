<style type="text/css">
    html, body {
        overflow-x: hidden;
        width: 100%;
        padding-left:5px;
    }
</style>


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
<style>

    div.pad{
        padding-left:20%;
    }

</style>
<?php

function formatarEMostrar($valor, $opcao) {
    if ($opcao == PAYMENT_REPORTBYCARD_VALUES)
        echo number_format($valor, 0, ",", ".");
    else
        echo $valor;
}

function imprimeDados($result, $tipo, $cartao, $opcao = 2) {
    $total = 0;
    if (isset($result[$tipo][$cartao])) {
        foreach ($result[$tipo][$cartao] as $resultado)
            $total += $resultado;
    }
    echo "<td style='text-align: right;'>";
    formatarEMostrar($total, $opcao);
    echo "</td>";

    for ($i = 1; $i <= 8; $i++) {
        echo "<td  style='text-align: right;'>";
        if (isset($result[$tipo][$cartao][$i]))
            formatarEMostrar(intval($result[$tipo][$cartao][$i]), $opcao);
        else
            formatarEMostrar(0, $opcao);

        echo "</td>";
    }
}

function soma_credito($creditos) {
    $total = 0;
    foreach ($creditos as $credito) {
        $total+=$credito;
    }
    return $total;
}

function calcula_percentagem($num, $credito, $debito) {
    $perc = 100 * $num / ($credito + $debito);
    $perc = round($perc, 1);
    return $perc;
}
?>



<body>
    <div class = "row">


        <div class="col-lg-10" bgcolor="red">

            <form method="GET">
                <input type="hidden" name="option" value="<?= $option ?>"/>
                Ano: <select name="year" onchange="this.form.submit()" id="year">
                    <?php
                    foreach ($years as $y) {
                        $selected = "";
                        if ($y == $year)
                            $selected = "selected";
                        echo "<option $selected value='$y'>$y</option>";
                    }
                    ?>
                </select>

                Mês: <select name="month" onchange="this.form.submit()" id="month">
                    <option value="0" <?php if (!isset($mes)) echo "selected"; ?>>Todos</option>
                    <?php

                    function getMonthName($m) {
                        switch ($m) {
                            case 1: return "Janeiro";
                            case 2: return "Fevereiro";
                            case 3: return "Março";
                            case 4: return "Abril";
                            case 5: return "Maio";
                            case 6: return "Junho";
                            case 7: return "Julho";
                            case 8: return "Agosto";
                            case 9: return "Setembro";
                            case 10: return "Outubro";
                            case 11: return "Novembro";
                            case 12: return "Dezembro";
                        }
                    }

                    for ($m = 1; $m <= 12; $m++) {
                        $selected = "";
                        if ($m == $month)
                            $selected = "selected";
                        echo "<option $selected value='$m'>" . getMonthName($m) . "</option>";
                    }
                    ?>
                </select>
            </form>
            <div class="pad">

                <h4>Doações campanha de sócios: <?php formatarEMostrar(intval($associates), $option); ?>
                </h4>				<h4>Doações avulsas: <?php formatarEMostrar(intval($avulsas), $option); ?>
                </h4>				<h4>Doações colonias: <?php formatarEMostrar(intval($colonies), $option); ?>
                </h4>				<h4>Doações eventos: <?php formatarEMostrar(intval($events), $option); ?>
                </h4>
                <h4>Total: <?php formatarEMostrar(intval($associates) + intval($avulsas) + intval($colonies) + intval($events), $option); ?>
                </h4>

                <!--
                                <a href="<?= $this->config->item('url_link'); ?>reports/payments_bycard">
                                <button class="btn btn-primary" style="margin: 0px auto; ">Todos os pagamentos</button>
                                </a>
                                <a href="<?= $this->config->item('url_link'); ?>reports/payments_bycard?type=captured">
                                <button class="btn btn-primary" style="margin: 0px auto; ">Pagamentos finalizados</button>
                                </a>
                                <a href="<?= $this->config->item('url_link'); ?>reports/payments_bycard?type=canceled">
                                <button class="btn btn-primary" style="margin: 0px auto; ">Pagamentos cancelados</button>
                                </a>
                                <br>
                -->
                <table class="table table-bordered table-striped table-min-td-size" style="max-width: 600px; font-size:15px">
                    <tr>
                        <td colspan="10"> <h4> <b>Cartão de crédito: </b></h4> </td> <?php $tipo = "credito"; ?>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><h4> <b> Bandeira do cartão </b></h4> </td>
                        <td style="text-align: right;"><h4> <b> Total </b></h4> </td>
                        <td><h4> <b> 1x </b></h4></td>
                        <td><h4> <b> 2x </b></h4></td>
                        <td><h4> <b> 3x </b></h4></td>
                        <td><h4> <b> 4x </b></h4></td>
                        <td><h4> <b> 5x </b></h4></td>
                        <td><h4> <b> 6x </b></h4></td>
                        <td><h4> <b> 7x </b></h4></td>
                        <td><h4> <b> 8x </b></h4></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"> Amex </td>
                        <?php
                        $cartao = "amex";
                        imprimeDados($result, $tipo, $cartao, $option);
                        ?>
                    </tr>
                    <tr>
                        <td style="text-align: right;"> Mastercard </td>
                        <?php
                        $cartao = "mastercard";
                        imprimeDados($result, $tipo, $cartao, $option);
                        ?>
                    </tr>
                    <tr>
                        <td style="text-align: right;"> Visa </td>
                        <?php
                        $cartao = "visa";
                        imprimeDados($result, $tipo, $cartao, $option);
                        ?>
                    </tr>
                    <tr>
                        <td style="text-align: right;"> Totais crédito </td>
                        <td style="text-align: right;"><?php
                            $total = soma_credito($credito);
                            formatarEMostrar($total, $option);
                            ?>
                        </td>
                        <?php
                        for ($i = 1; $i <= 8; $i++) {
                            echo "<td style='text-align: right;'>";
                            formatarEMostrar($credito[$i], $option);
                            echo "</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td style="text-align:right;"> Percentual </td>
                        <td style ="text-align:right"> <?php
                            $total = soma_credito($credito);
                            $perc = calcula_percentagem($total, $total, $debito);
                            formatarEMostrar($perc, $option);
                            echo "%";
                            ?>
                            </td>
                        <?php
                        for ($i = 1; $i <= 8; $i++) {
                            echo "<td style='text-align: right;'>";
                            $perc = calcula_percentagem($credito[$i],$total,$debito);
                            formatarEMostrar($perc, $option);
                            echo "%</td>";
                        }
                        ?>  

                    </tr>
                </table>
                <table class="table table-bordered table-striped table-min-td-size" style="max-width: 600px;">
                    <tr>
                        <td colspan="2" style="text-align: center;"> <h4> <b>Cartão de débito: </b></h4> </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><h4> <b> Bandeira do cartão </b></h4> </td>
                        <td style="text-align: center;"><h4> <b> Total </b></h4> </td>

                    </tr>
                    <tr>
                        <td style="text-align: right;"> Maestro </td>
                        <td style="text-align: right;"><?php
                            if (isset($result["debito"]["mastercard"][1]))
                                echo formatarEMostrar(intval($result["debito"]["mastercard"][1]), $option);
                            else
                                echo formatarEMostrar(0, $option);
                            ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"> Visa Electron </td>
                        <td style="text-align: right;"><?php
                            if (isset($result["debito"]["visa"][1]))
                                echo formatarEMostrar(intval($result["debito"]["visa"][1]), $option);
                            else
                                echo formatarEMostrar(0, $option);
                            ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"> Total débito </td>
                        <td style="text-align: right;"><?php echo formatarEMostrar($debito, $option); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"> Percentual </td>
                        <td style="text-align:right;"> <?php
                        $perc = calcula_percentagem($debito,$total,$debito);
                        formatarEMostrar($perc, $option);
                        echo "%";
                         ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>