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
                <?php if(isset($admin)){?>
                Secretário: <select name="secretary" onchange="this.form.submit()" id="secretary">
                	<?php if (!isset($secretary)){?>
                		<option value='0' selected >- Selecione -</option>
                    <?php }
                    foreach ($secretaries as $s) {
                        $selected = "";
                        if ($s->person_id == $secretary)
                            $selected = "selected";
                        echo "<option $selected value='$s->person_id'>$s->fullname</option>";
                    }
                    ?>
                </select>
                <br /> <br />
                <?php }?>
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
                   <?php  if (isset($secretary) || !isset($admin)){ ?>
                        <table class="table table-bordered table-striped table-min-td-size" style="width:1000px" id="sortable-table">
                            <thead>
                                <tr>
                                    <th style="width:100px" > Data </th>
                                    <th> Descrição </th>
                                    <th style="width:100px"> Crédito </th>
                                    <th style="width:100px"> Débito </th>
                                    <th style="width:100px"> Saldo </th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                                <?php
                                
                                $sum = number_format(0,2,",",".");
                                
                                if($balance){
                                foreach ($balance as $b) {
                                    ?>
                                    <tr>
                                        <td><?= $b->date_created ?></td>
                                        <td><?php if(isset($b->description)) echo $b->description; else echo "Operação Efetuada pelo Administrador" ; ?></td>
                                        <?php if($b->operation_value > 0) {?>
	                                        <td><?= number_format($b->operation_value,2,",","."); ?></td>
	                                        <td> - </td>
	                                    <?php } else {?>
	                                    	<td> - </td>
	                                        <td><?= number_format($b->operation_value*(-1),2,",","."); ?></td>
                                        <?php } $sum += $b->operation_value; ?>
                                        <td><?= number_format($sum,2,",","."); ?></td>
                                    </tr>
                                    <?php
                                }}
                                ?>
                            </tbody>
                        </table>
                        <?php }?>
                    </div>
                </div>
            </div>
    </body>
</html>