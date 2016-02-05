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
        </script>

    </head>
    <body>
        <div class="col-lg-12">
            <div class = "row">
                <p>
                    **Lista de pessoas que não obtiveram <font color="red">nenhum</font> sucesso ao realizar doações no período selecionado
                </p>
                <form method="GET">
                    <select name="ano" onchange="this.form.submit()" id="anos">
                        <?php
                        foreach ($years as $y) {
                            $selected = "";
                            if ($y == $year)
                                $selected = "selected";
                            echo "<option $selected value='$y'>$y</option>";
                        }
                        ?>
                    </select>

                    <select name="mes" onchange="this.form.submit()" id="meses">
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
                <table class="table table-bordered table-striped table-min-td-size" style="max-width: 1000px; font-size:15px" id="sortable-table">
                    <thead>
                        <tr>
                            <th> Data e hora </th>
                            <th> Nome </th>
                            <th> Tipo de doação </th>
                            <th> Transação </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($donations as $donation) {
                            ?>
                            <tr>
                                <td><?= date_format(date_create($donation->date_created), 'd/m/y H:i') ?></td>
                                <td><a href="<?= $this->config->item('url_link') ?>user/details?id=<?= $donation->person_id ?>" target="_blank"><?= $donation->fullname ?></a></td>
                                <td><?= $donation->donation_type ?></td>
                                <td><?= $donation->payment_status ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>