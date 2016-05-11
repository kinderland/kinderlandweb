<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css"
	rel="stylesheet" />
<!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
<link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css"
	rel="stylesheet" />
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css">
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>

</head>
<?php

function selected_option($option){
    if(empty($selected_option) || !isset($selected_option))
        return "";
  if ($option===$selected_option)
      return "selected";
  return "";
}

?>
  <form name="document_form" method="POST" action="<?= $this->config->item('url_link') ?>admin/completeDocument" id="document_form">
    <div class="col-lg-12">
        <h3><strong>Criação de documento</strong></h3>
        <hr/>
        <div class="row">
            <div class ="col-lg-8">
                <select class="report-select" name="report_select" id="report_select">
                    <option value="nota fiscal" onchange="this.form.submit()" selected="<?php selected_option("nota_fiscal") ?>">Nota Fiscal</option>
                    <option value="cupom fiscal" onchange="this.form.submit()" selected="<?php selected_option("nota_fiscal") ?>">Cupom Fiscal</option>  
                    <option value="recibo" onchange="this.form.submit()" selected="<?php selected_option("nota_fiscal") ?>">Recibo</option>  
                    <option value="boleto" onchange="this.form.submit()" selected="<?php selected_option("nota_fiscal") ?>">Boleto</option>  
                </select>