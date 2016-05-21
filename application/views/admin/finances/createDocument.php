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

    <link href="<?= $this->config->item('assets'); ?>css/datepicker.css" rel="stylesheet" />
    <link rel="text/javascript" href="<?= $this->config->item('assets'); ?>js/datepicker.less.js" />

    <style>
        input {margin-top:10px;margin-left:10px}
    </style>
    <?php

    function dataSwitch($option) {
        switch ($option) {
            case "nota fiscal": case "cupom fiscal": return "emissão";
                break;
            case "recibo": return "assinatura";
                break;
            case "boleto": return "processamento";
                break;
        }
    }
    ?>
    <script type="text/javascript">
        function datepickers() {
            $('.datepickers').datepicker();
            $(".datepickers").datepicker("option", "dateFormat", "dd/mm/yy");
        }
        $(document).ready(function () {
            datepickers();
        });
    </script>
<form method="POST" action="<?= $this->config->item('url_link') ?>admin/createDocument">
    <div class="col-lg-12">
        <h3><strong>Criação de documento</strong></h3>
        <hr/>
        <h4> Selecione o tipo do documento: </h4>
        <div class="row">
            <div class ="col- lg-8">
                <select class="report-select" onchange="this.form.submit()" name="document_type" id="document_type">
                    <option <?php if ($selected == "nota fiscal") { ?>selected <?php } ?> value="nota fiscal"  >Nota Fiscal</option>
                    <option <?php if ($selected == "cupom fiscal") { ?>selected <?php } ?> value="cupom fiscal" >Cupom Fiscal</option>  
                    <option <?php if ($selected == "recibo") { ?>selected <?php } ?> value="recibo">Recibo</option>  
                    <option <?php if ($selected == "boleto") { ?>selected <?php } ?> value="boleto">Boleto</option> 
                    <option <?php if ($selected == "no_select") { ?>selected <?php } ?> value="no_select">--Selecione-- </option>
                </select>
            </div>
        </div>
    </div> 
</form>

<form enctype="multipart/form-data" action="<?= $this->config->item('url_link') ?>admin/completeDocument" method ="POST">
    <input type="hidden" value="<?php echo $selected; ?>" name="document_type" >
<?php if ($selected != "no_select") { ?>
        Numero: <input  type="text" name="document_number" >
        </br>
        Nome <?php if ($selected != "recibo") { ?> empresa <?php } ?>: <input type="text" name="document_name">
        </br>
        Data <?php echo dataSwitch($selected); ?> : <input type="text" class="datepickers required" name="document_date">
        </br>
        Descrição :<input type="text" name="description" maxlength="50">
        </br>
        Valor :<input type="number" step="0.01" size="6" name="document_value">
        </br>
        <input  type="file" name="uploadedfile" class="btn btn-primary"/> 
        <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
		<br />
        <div class="col-lg-1" style="margin-top:15px">
        <button class="btn btn-primary" type="submit">Salvar</button>
        </div>
    </form>
<?php } ?>
<div class="col-lg-1">
    <button style="padding-left:20px;margin-top:2px" class="btn btn-warning" onclick="window.location.href = '<?= $this->config->item('url_link') ?>admin/manageDocuments'"> Voltar</button>
</div>

</head>
