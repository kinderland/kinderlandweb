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

            function showCounter(currentPage, totalPage, firstRow, lastRow, totalRow, totalRowUnfiltered) {
                return '';
            }

            function sortLowerCase(l, r) {
                return l.toLowerCase().localeCompare(r.toLowerCase());
            }

        </script>

    </head>
    <style>
    
    div.scroll{
    	
    	width:100%;
    	height:100%;
    	overflow-x:hidden;
    
    }
    
    </style>
    <body>
        <script>
            $(document).ready(function () {
                $('#sortable-table').datatable({
                    pageSize: Number.MAX_VALUE,
                    sort: [true, true, true, true, sortLowerCase],
                    counterText: showCounter
                });
            });
        </script>
        <div class="scroll">
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
                    <form method="GET">
                        <select name="ano_f" onchange="this.form.submit()" id="anos">

                            <?php
                            foreach ($years as $year) {
                                $selected = "";
                                if ($ano_escolhido == $year)
                                    $selected = "selected";
                                echo "<option $selected value='$year'>$year</option>";
                            }
                            ?>
                        </select>
                        <select name="colonia_f" onchange="this.form.submit()" id="colonia">
                            <option value="0" <?php if (!isset($colonia_escolhida)) echo "selected"; ?>>Todas</option>
                            <?php
                            foreach ($camps as $camp) {
                                $selected = "";
                                if ($colonia_escolhida == $camp)
                                    $selected = "selected";
                                echo "<option $selected value='$camp'>$camp</option>";
                            }
                            ?>
                        </select>
                    </form>

                    <div class="counter"></div>
                    <table class="table table-bordered table-striped table-min-td-size" style="width: 93%; font-size:15px;" id="sortable-table">
                        <thead>
                            <tr>
                                <th> Inscritos </th>
                                <th> Aguardando doação </th>
                                <th> Em fila de espera </th>
                                <th> Em elaboração </th>
                                <th> Nome da Escola </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (is_array($schools))
                                foreach ($schools as $school) {
                                    ?>
                                    <tr>
                                        <td><?= $school->inscrito ?></td>
                                        <td><?= $school->aguardando_pagamento ?></td>
                                        <td><?= $school->fila_espera ?></td>
                                        <td><?= $school->validada ?></td>
                                        <td><?= $school->school_name ?></td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>