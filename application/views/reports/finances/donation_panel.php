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


    </head>
    <style>

        div.pad{
            padding-left:20%;
        }

    </style>

    <?php

    function formatarEMostrar($valor) {

        echo number_format($valor, 0, ",", ".");
    }

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

    function month_and_year($year, $month) {
        $name = getMonthName($month);
        echo $name . " / " . $year;
    }

    $firstDate = getMonthName($selected_months[0]) . $selected_years[0];
    $i = count($selected_years) - 1;
    $lastDate = getMonthName($selected_months[$i]) . $selected_years[$i];
    $date = date("Y-m-d H:i:s");
    ?>

    <body>
        <script>


<?php if ($error && !empty($error)) { ?>
                alert("<?php echo $error; ?>");
<?php }
?>

            function post(path, params, method) {
                method = method || "post"; // Set method to post by default if not specified.

                // The rest of this code assumes you are not using a library.
                // It can be made less wordy if you use one.
                var form = document.createElement("form");
                form.setAttribute("method", method);
                form.setAttribute("action", path);

                for (var key in params) {
                    if (params.hasOwnProperty(key)) {
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", key);
                        hiddenField.setAttribute("value", params[key]);
                        form.appendChild(hiddenField);
                    }
                }

                document.body.appendChild(form);
                form.submit();
            }

            function getCSVName() {

                var nomePadrao = " receitas-";
                nomePadrao = nomePadrao.concat("<?php echo $firstDate ?>-");
                nomePadrao = nomePadrao.concat("<?php echo $lastDate ?>-");
               // nomePadrao = nomePadrao.concat("<?php echo $date ?>");
                return nomePadrao;
            }


            function sendTableToCSV() {
                var data = [];
                var table = document.getElementById("tablebody");
                var name = getCSVName();
                var tablehead = document.getElementsByTagName("thead")[0];
                for (var i = 0, row; row = table.rows[i] && table.rows[i].cells[0].innerHTML != "Total"; i++) {
                
                    for (var j = 1; j < 4; j++) {
                        var data2 = [];
                        if (table.rows[i].cells[j].innerHTML > 0)
                        {
                            data2.push(tablehead.rows[0].cells[j].innerHTML.split("<")[2].split(">")[1]);
                            data2.push(table.rows[i].cells[j].innerHTML);
                            data2.push(table.rows[i].cells[0].innerHTML.split("/")[0]);
                            data2.push(table.rows[i].cells[0].innerHTML.split("/")[1]);
                        }
                        data.push(data2);
                    }
          
                }


                var dataToSend = JSON.stringify(data);
                var columName = ["Receita", "Valor", "Mes", "Ano"];
                var columnNameToSend = JSON.stringify(columName);
                post('<?= $this->config->item('url_link'); ?>reports/toCSV', {data: dataToSend, name: name, columName: columnNameToSend});
            }
        </script>
        <div class = "row">

            <div class="col-lg-10" bgcolor="red">
                <button class="button" onclick="sendTableToCSV()" value="">Fazer download da tabela abaixo como csv</button>
                <form method="GET">
                    <div style="padding-left:3px">
                        <p> De: 
                            Ano: <select name="year_start" onchange="this.form.submit()" id="year_start">
                                <?php
                                foreach ($years as $y) {
                                    $selected = "";
                                    if ($y == $year_start)
                                        $selected = "selected";
                                    echo "<option $selected value='$y'>$y</option>";
                                }
                                ?>
                            </select> 

                            Mês: <select name="month_start"  onchange="this.form.submit()" id="month_start">
                                <?php
                                for ($m = 1; $m <= 12; $m++) {
                                    $selected = "";
                                    if ($m == $month_start)
                                        $selected = "selected";
                                    echo "<option $selected value='$m'>" . getMonthName($m) . "</option>";
                                }
                                ?>
                            </select> </p>
                    </div>
                    <br/> 
                    <p>                Até:  Ano: <select name="year_finish" onchange="this.form.submit()" id="year_finish">
                            <?php
                            foreach ($years as $y) {
                                $selected = "";
                                if ($y == $year_finish)
                                    $selected = "selected";
                                echo "<option $selected value='$y'>$y</option>";
                            }
                            ?>
                        </select>
                        Mês: <select name="month_finish" onchange="this.form.submit()" id="month_finish">
                            <?php
                            for ($m = 1; $m <= 12; $m++) {
                                $selected = "";
                                if ($m == $month_finish)
                                    $selected = "selected";
                                echo "<option $selected value='$m'>" . getMonthName($m) . "</option>";
                            }
                            ?>
                        </select></p>
                </form>

                <div class="pad"> 
                    <h4 style="margin-top:30px;"> Total do período: <?php echo formatarEMostrar(intval($total)); ?> </h4>
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 800px; font-size:15px;"id="sortable-table" >
                        <thead>
                            <tr>
                                <td style="text-align: center;"><h4> <b>Período</b></h4> </td>
                                <td style="text-align: center;"><h4> <b>Avulsa</b></h4> </td>
                                <td style="text-align: center;"><h4> <b>Campanha</b></h4> </td>
                                <td style="text-align: center;"><h4> <b>Colônia</b></h4> </td>
                               <!-- <td style="text-align: center;"><h4> <b> MiniKinderland </b></h4> </td> -->
                                <td style="text-align: center;"><h4> <b>Total</b></h4> </td>
                            </tr>
                        </thead>
                        <tbody id="tablebody">
                            <?php for ($i = 0; $i < count($selected_years); $i++) { ?>
                                <tr>
                                    <td> <?php month_and_year($selected_years[$i], $selected_months[$i]); ?> </td>
                                    <td> <?php echo formatarEMostrar(intval($free[$i])); ?></td>
                                    <td> <?php echo formatarEMostrar(intval($campaign[$i])); ?></td>
                                    <td> <?php
                                        echo formatarEMostrar(intval($summercamp[$i]));
                                        ;
                                        ?></td>
                                    <!--<td> <?php
                                    echo formatarEMostrar(intval($mini[$i]));
                                    ;
                                    ?></td>-->
                                    <td> <?php echo formatarEMostrar(intval($total_per_period[$i])); ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td>Total</td>
                                <td> <?php echo formatarEMostrar(intval($total_free)); ?></td>
                                <td> <?php echo formatarEMostrar(intval($total_campaign)); ?></td>
                                <td> <?php echo formatarEMostrar(intval($total_summercamp)); ?></td>
                               <!-- <td> <?php echo formatarEMostrar(intval($total_mini)); ?></td> -->
                                <td> <?php echo formatarEMostrar(intval($total)); ?></td>
                        </tbody>
                        </tr>
                </div>
            </div>
        </div>
    </body>
