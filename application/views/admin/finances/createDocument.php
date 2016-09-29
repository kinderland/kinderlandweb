	

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
    if (count($errors) > 0) {
        $all_errors = implode('', $errors);
        echo '<script type="text/javascript">alert("Os seguintes erros foram encontrados: \n' . $all_errors . '"); </script>';
    }

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

    function transform_date($date) {
        $newDate = "";
        if (isset($date) && !empty($date)) {
            $newDate = explode("/", $date);
            $temp = $newDate[0];
            $newDate[0] = $newDate[1];
            $newDate[1] = $temp;
            $newDate = implode("/", $newDate);
        }
        return $newDate;
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

        function validateNumberInput(evt) {

            var key_code = (evt.which) ? evt.which : evt.keyCode;
            if ((key_code >= 48 && key_code <= 57) || key_code == 9 || key_code == 8) {
                return true;
            }
            return false;
        }

        function maskIt(w,e,m,r,a){
        	// Cancela se o evento for Backspace
        	if (!e) var e = window.event
        	if (e.keyCode) code = e.keyCode;
        	else if (e.which) code = e.which;
        	// Variáveis da função
        	var txt  = (!r) ? w.value.replace(/[^\d]+/gi,'') : w.value.replace(/[^\d]+/gi,'').reverse();
        	var mask = (!r) ? m : m.reverse();
        	var pre  = (a ) ? a.pre : "";
        	var pos  = (a ) ? a.pos : "";
        	var ret  = "";
        	if(code == 9 || code == 8 || txt.length == mask.replace(/[^#]+/g,'').length) return false;
        	// Loop na máscara para aplicar os caracteres
        	for(var x=0,y=0, z=mask.length;x<z && y<txt.length;){
        	if(mask.charAt(x)!='#'){
        	ret += mask.charAt(x); x++; } 
        	else {
        	ret += txt.charAt(y); y++; x++; } }
        	// Retorno da função
        	ret = (!r) ? ret : ret.reverse()	
        	w.value = pre+ret+pos; }
        	// Novo método para o objeto 'String'
        	String.prototype.reverse = function(){
        	return this.split('').reverse().join(''); };
    </script>
<form method="POST" action="<?= $this->config->item('url_link') ?>admin/createDocument">
    <div class="col-lg-12">
        <h3><strong>Criação de documento</strong></h3>
        <hr/>
        <h4> Selecione o tipo do documento: </h4>
        <div class="row">
            <div class ="col- lg-8">
                <select class="report-select" onchange="this.form.submit()" name="document_type" id="document_type">
                	<option <?php if ($selected == "no_select") { ?>selected <?php } ?> value="no_select">-- Selecione -- </option>
                    <option <?php if ($selected == "nota fiscal") { ?>selected <?php } ?> value="nota fiscal"  >Nota Fiscal</option>
                    <option <?php if ($selected == "cupom fiscal") { ?>selected <?php } ?> value="cupom fiscal" >Cupom Fiscal</option>  
                    <option <?php if ($selected == "recibo") { ?>selected <?php } ?> value="recibo">Recibo</option>  
                    <option <?php if ($selected == "boleto") { ?>selected <?php } ?> value="boleto">Boleto</option> 
                </select>
            </div>
        </div>
    </div> 
</form>
<div class="middle-content">
    <form enctype="multipart/form-data" action="<?= $this->config->item('url_link') ?>admin/completeDocument" method ="POST">
        <input type="hidden" value="<?php echo $selected; ?>" name="document_type" >
        <?php if ($selected != "no_select") { ?>
            <div class="row">
                <label for="document_number" class="col-lg-1" style="padding-top:15px">Número: </label>
                <div class="col-lg-2">
                    <input onkeypress="return validateNumberInput(event);" name="document_number" style="margin-left:-20px" value="<?php echo $number; ?>" class="form-control required"/>
                </div>
            </div>
            <div class="row">
                <label for="document_name" class="col-lg-2" style="padding-top:15px;width:12%;padding-right:-15px">Nome <?php if ($selected != "recibo") { ?>empresa <?php } ?>: </label>
                <div class="col-lg-3">
                    <input type="text" name="document_name" class="form-control" style="margin-left:-20px" value="<?php echo $name; ?>"/>
                </div>
            </div>
            <div class="row">
                <label for="document_date" class="col-lg-2" style="padding-top:15px;width:15%"> Data <?php echo dataSwitch($selected); ?> : </label>
                <div class="col-lg-2">
                    <input type="text" class="datepickers required form-control" style="margin-left:-20px" name="document_date" value="<?php echo transform_date($date); ?>">
                </div>
            </div>
            <div class="row">
                <label for="description" class="col-lg-2" style="padding-top:15px;width:15%"> Descrição: </label>
                <div class="col-lg-5">
                    <input type="text" name="description" maxlength="50" class="form-control" style="margin-left:-90px" value="<?php echo $description; ?>">   
                </div>
            </div>
            <div class="row">
                <label for="document_value" class="col-lg-2" style="padding-top:15px;width:15%"> Valor: </label>
                <div class="col-lg-2">
                    <input class="form-control" type="text" size="8" name="document_value" style="margin-left:-100px" value="<?php echo $value;?>" onKeyUp="maskIt(this,event,'######,##',true)" onkeypress="return validateNumberInput(event);"> 
                </div>
            </div>
            <div class="row">
                <label for="uploadedfile" class="col-lg-2" style="padding-top:15px;width:15%"> Upload de imagem: </label>
                <div class="col-lg-2">
                    <input  type="file" style="margin-left:-50px" name="uploadedfile" class="btn btn-primary"/> 
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                </div>
            </div>
            <label style="padding-top:15px">Documento sendo inserido por: <?php echo $user_name; ?></label>
            </br>
            <div class="col-lg-1" style="margin-top:15px">
                <button class="btn btn-primary" type="submit">Salvar</button>
            </div>
        </form>
    <?php } ?>
    <div class="col-lg-1">
        <a href = "<?= $this->config->item('url_link') ?>admin/manageDocuments" style="padding-left:20px;margin-top:2px" class="btn btn-warning">Voltar</a>
    </div>
</div>
</head>
<!--
    <input type="hidden" value="<?php echo $selected; ?>" name="document_type" >
        Numero: <input  type="text" name="document_number" value="<?php echo $number; ?>">
  Nome <?php if ($selected != "recibo") { ?> empresa <?php } ?>: <input type="text" name="document_name" value="<?php echo $name; ?>">

        Data <?php echo dataSwitch($selected); ?> : <input type="text" class="datepickers required" name="document_date" value="<?php echo transform_date($date); ?>">
 <input type="text" name="description" maxlength="50" class="form-control" value="<?php echo $description; ?>">   
                <input  type="file" name="uploadedfile" class="btn btn-primary"/> 
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                <input class="form-control" type="number" step="0.01" size="6" name="document_value" value="<?php echo $value; ?>"> 

-->


