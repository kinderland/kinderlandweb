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

<script>


<?php if($error && !empty($error)) { ?>
	alert("<?php echo $error; ?>");
<?php }
?>

</script>
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

function month_and_year($year, $month) {
    $name = getMonthName($month);
    echo $name . " / " . $year;
}
?>

<body>
    <div class = "row">

        <div class="col-lg-10" bgcolor="red">

            <form method="GET">
                <h5> De: </h5>

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
                Mês: <select name="month_start" onchange="this.form.submit()" id="month_start">
                    <?php
                    for ($m = 1; $m <= 12; $m++) {
                        $selected = "";
                        if ($m == $month_start)
                            $selected = "selected";
                        echo "<option $selected value='$m'>" . getMonthName($m) . "</option>";
                    }
                    ?>
                </select>
                <br/>
                <h5> Até: </h5>

                Ano: <select name="year_finish" onchange="this.form.submit()" id="year_finish">
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
                </select>
            </form>

            <div class="pad"> 
                <h4 style="margin-top:30px;"> Total: <?php echo $total; ?> </h4>
                <table class="table table-bordered table-striped table-min-td-size" style="max-width: 800px; font-size:15px;">
                    <tr>
                        <td style="text-align: center;"><h4> <b> Período </b></h4> </td>
                        <td style="text-align: center;"><h4> <b> Avulsa</b></h4> </td>
                        <td style="text-align: center;"><h4> <b> Campanha </b></h4> </td>
                        <td style="text-align: center;"><h4> <b> Colônia Verão </b></h4> </td>
                        <td style="text-align: center;"><h4> <b> MiniKinderland </b></h4> </td>
                        <td style="text-align: center;"><h4> <b> Total </b></h4> </td>
                    </tr>
<?php for ($i = 0; $i < count($selected_years); $i++) { ?>
                        <tr>
                            <td> <?php month_and_year($selected_years[$i], $selected_months[$i]); ?> </td>
                            <td> <?php echo $free[$i]; ?></td>
                            <td> <?php echo $campaign[$i]; ?></td>
                            <td> <?php echo $summercamp[$i]; ?></td>
                            <td> <?php echo $mini[$i]; ?></td>
                            <td> <?php echo $total_per_period[$i]; ?></td>
                        </tr>
<?php } ?>
                    <tr>
                        <td> Total </td>
                        <td> <?php echo $total_free; ?></td>
                        <td> <?php echo $total_campaign; ?></td>
                        <td> <?php echo $total_summercamp; ?></td>
                        <td> <?php echo $total_mini; ?></td>
                        <td> <?php echo $total; ?></td>
                    </tr>
            </div>
        </div>
    </div>
</body>
