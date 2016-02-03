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
            var filtroMeses = {
                /* The jQuery element to use (if you want to use a custom select element), if not specified, a new select
                 will be created. */
                element: null,
                /* The list of options. Notice that {0: "Option 0"} will output <option value=0>Option 0</option>, so the value used to filter is 0, not "Option 0".
                 HINT: If you don't want to specify the values manually, you can set this values: "auto" which will retrieve values from the table. */
                values: {
                    "01": "Janeiro",
                    "02": "Fevereiro",
                    "03": "Março",
                    "04": "Abril",
                    "05": "Maio",
                    "06": "Junho",
                    "07": "Julho",
                    "08": "Agosto",
                    "09": "Setembro",
                    "010": "Outubro",
                    "011": "Novembro",
                    "012": "Dezembro"
                },
                /* The select default selected options, can be either a value or an array (for multiple select). If not specified, no value will be selected (for simple select), or all the values (for multiple select). */
                /* Specify if an empty entry should be added. Default value is true. This parameter as no effect on multiple select. */
                empty: "Todos os meses ",
                /* True for multiple select, false for simple. Default value is false. */
                multiple: false,
                /* Will not create a column for this filter. Useful if you want to filter data on a field which is not displayed in the table. */
                noColumn: false,
                /* A custom filter function to specify if you don't want the value to be filtered according to the options key. */
                fn: function (data, selected) {
                    /* Note that selected is always an array of string. */
                    if (selected.length === 1) {// Only one option selected
                        var date = data.split("/");
                        var month = date[1];
                        return month == selected[0];
                    }
                    /* Note that when using multiple select, selected will contain selected keys.
                     When the empty value is picked, the selected array will contain all available keys. */
                    return true;
                }
            }

            var selectTodos = {
                element: null,
                values: "auto",
                empty: "Todos",
                multiple: false,
                noColumn: false,
            }

            var selectTodas = {
                element: null,
                values: "auto",
                empty: "Todos",
                multiple: false,
                noColumn: false,
            }

            function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
                return 'Apresentando ' + totalRow + ' transações, de um total de ' + totalRowUnfiltered + ' transações';
            }

            function sortLowerCase(l, r) {
                return l.toLowerCase().localeCompare(r.toLowerCase());
            }

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
        <script>
            $(document).ready(function () {
                $('#sortable-table').datatable({
                    pageSize: Number.MAX_VALUE,
                    sort: [comparaPorData, sortLowerCase, true, sortLowerCase, true, sortLowerCase, true, sortLowerCase],
                    filters: [filtroMeses, true, selectTodos, true, selectTodos, selectTodas, selectTodas, selectTodos],
                    filterText: 'Escreva para filtrar... ',
                    counterText: showCounter
                });
            });
        </script>
        <div class = "row">
            <div class="col-lg-12">
                <form method="GET">
                    <select name="ano" onchange="this.form.submit()" id="anos">
                        <?php
                        foreach ($years as $year) {
                            $selected = "";
                            if ($ano == $year)
                                $selected = "selected";
                            echo "<option $selected id='$year'>$year</option>";
                        }
                        ?>
                    </select>
                    <select name="mes" onchange="this.form.submit()" id="meses">
                        <option value="0"
                        <?php
                        if (!isset($mes) || empty($mes)) {
                            echo "selected";
                        }
                        ?>
                                >Todos</option>
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
                                    if ($m == $mes)
                                        $selected = "selected";
                                    echo "<option $selected value='$m'>" . getMonthName($m) . "</option>";
                                }
                                ?>
                    </select>
                </form>
                <table class="table table-bordered table-striped table-min-td-size" style="max-width: 500px; font-size:12px;" id="sortable-table">
                    <thead>
                        <tr>
                            <th> Data criação </th>
                            <th> Id </th>
                            <th style="width:60px;"> Status </th>
                            <th> Nome </th>
                            <th > Valor </th>
                            <th> Forma de Pagamento </th>
                            <th> Parcelas </th>
                            <th> Motivo </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($payments as $payment) {
                            ?>
                            <tr>
                                <td><?= $payment["date_created"] ?></td>
                                <td><?= $payment["tid"] ?></td>
                                <td><?= $payment["payment_status"] ?></td>
                                <td><?= $payment["name"] ?></td>
                                <td>R$<?= intval($payment["value"]) ?>.00</td>
                                <td><?= $payment["cardflag"] ?></td>
                                <td><?= $payment["payment_portions"] ?></td>
                                <td><?= $payment["reason"] ?></td>
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