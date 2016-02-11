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

        <script>
            function arrumaData(data) {
                var separaEspaco = data.split(" ");
                var separaBarra = separaEspaco[0].split("/");
                var d = separaBarra[2].concat(separaBarra[1].concat(separaBarra[0].concat(separaEspaco[1])));
                return d;
            }

            function comparaPorData(l, r) {
                var a = arrumaData(l);
                var b = arrumaData(r);
                return a.toLowerCase().localeCompare(b.toLowerCase());
            }

            function sortLowerCase(l, r) {
                return l.toLowerCase().localeCompare(r.toLowerCase());
            }

            function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
                return 'Apresentando ' + totalRow + ' doações, de um total de ' + totalRowUnfiltered + ' doações';
            }
        </script>

    </head>
    <style>
    
    div.pad{
    	padding-left:7%;
    }
    
    </style>
    <body>
        <script>
            $(document).ready(function () {
                $('#sortable-table').datatable({
                    pageSize: Number.MAX_VALUE,
                    sort: [comparaPorData, sortLowerCase],
                    filters: [false, true],
                    filterText: 'Escreva para filtrar... ',
                    counterText: showCounter
                });
            });
        </script>
        <form method="GET">
            Ano: <select name="ano" onchange="this.form.submit()" id="anos">
                <?php
                foreach ($years as $y) {
                    $selected = "";
                    if ($y == $year)
                        $selected = "selected";
                    echo "<option $selected value='$y'>$y</option>";
                }
                ?>
            </select>

            Mês: <select name="mes" onchange="this.form.submit()" id="meses">
                <option value="0" <?php if (!isset($mes)) echo "selected"; ?>)>Todos</option>
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
        <p>Doações no período: <?= (is_array($donations)) ? count($donations) : 0 ?> ----
            Valor: R$
            <?php
            $value = 0;
            foreach ($donations as $donation) {
                $value += $donation->donated_value;
            }

            echo number_format($value, 2, ',', '.');
            ?>
        </p>
        <table class="table table-bordered table-striped table-min-td-size" style="max-width: 1000px; font-size:15px" id="sortable-table">
            <thead>
                <tr>
                    <th> Data e hora </th>
                    <th> Nome </th>
                    <?php if ($type != 'campaign_donations') { ?>
                        <th> Sócio </th>
                    <?php } ?>
                    <th> Valor </th>
                    <th> Forma de Pagamento </th>
                    <th> Parcelas </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($donations as $donation) {
                    ?>
                    <tr>
                        <td><?= date_format(date_create($donation->date_created), 'd/m/y H:i') ?></td>
                        <td><?= $donation->fullname ?></td>
                        <?php if ($type != 'campaign_donations') { ?>
                            <td><?= $donation->associate ?> </td>
                        <?php } ?>
                        <td><?= $donation->donated_value ?></td>
                        <td><?= $donation->payment_type . " " . $donation->cardflag ?></td>
                        <td><?= $donation->payment_portions ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        </div>
    </body>
</html>