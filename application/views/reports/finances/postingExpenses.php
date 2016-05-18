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
        <script>
        $(function() {
            $(".sortable-table").tablesorter();
            $(".datepicker").datepicker();
        });
        </script>
        <br />
        <div class="scroll">
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
            <br /> 
           
                <div class = "row">
                    <div class="col-lg-12 middle-content">
                        <table class="table table-bordered table-striped table-min-td-size" style="width:1030px" id="sortable-table">
                            <thead>
                                <tr>
                                    <th style="width:100px; text-align: center" > Data </th>
                                    <th style="width:170px; text-align: center" > Documento </th>
                                    <th style="width:170px; text-align: center"> Tipo </th>
                                    <th style="width:80px; text-align: center"> Parcela </th>
                                    <th style="width:100px; text-align: center"> Valor </th>
                                    <th colspan=3 style="width:400px; text-align: center"> Conta </th>
                                </tr>
                                <tr>
                                	<th></th>
                                	<th></th>
                                	<th></th>
                                	<th></th>
                                	<th></th>
                                	<th style="width:100px; text-align: center"> Nome </th>
                                	<th style="width:200px; text-align: center"> Descrição </th>
                                	<th style="width:100px; text-align: center"> Tipo </th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                                <?php
                                
                                if($info){
                                foreach ($info as $i) {
                                    ?>
                                    <tr>
                                        <td><?= $i->posting_date ?></td>
                                        <td><?= $i->document_type ?></td>
                                        <td><?= $i->posting_type ?></td>
                                        <td><?= $i->portion ?>/<?= $portions[$i->document_expense_id]?></td>
                                        <td><?= $i->posting_value ?></td>
                                        <td><?= $i->account_name ?></td>
                                        <td><?= $i->account_description ?></td>
                                        <td><?= $i->account_type ?></td>
                                    </tr>
                                    <?php
                                }}
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </body>
</html>