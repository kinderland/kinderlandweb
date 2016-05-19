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


        <link href="<?= $this->config->item('assets'); ?>css/datepicker.css" rel="stylesheet" />
        <link rel="text/javascript" href="<?= $this->config->item('assets'); ?>js/datepicker.less.js" />
        <?php
        $exclusionUrl = $this->config->item('url_link') . "admin/deleteDocument/" . $id;

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
        
        function transform_date($date){
            $newDate=explode("/",$date);
            $temp=$newDate[0];
            $newDate[0]=$newDate[1];
            $newDate[1]=$temp;
            $newDate=implode("/",$newDate);
            return $newDate;
        }
        ?>
        <style>
            input {margin-top:10px;margin-left:10px}
        </style>
        <script LANGUAGE='JavaScript'>
            function ConfirmExclusion() {
                url = <?php echo json_encode($exclusionUrl); ?>;
                window.alert("Você tem certeza que quer excluir esse documento?\nUma vez excluído, não poderá ser recuperado.");
                window.close();
                window.location.href = url;
            }
        </script>
        <script type="text/javascript">
            function datepickers() {
                $('.datepickers').datepicker();
                $(".datepickers").datepicker("option", "dateFormat", "dd/mm/yy");
            }
            $(document).ready(function () {
                datepickers();
            });
        </script>
    <div class="row" style="width:1000px">
        <div class="col-lg-12 middle-content">
            <div class="col-lg-8"><strong><h4>Edição de Documento</h4></strong></div>
            <form method="POST" action="<?php echo $exclusionUrl; ?>">
            <button class="btn btn-danger" type="submit" onclick="return confirm('Você tem certeza que quer excluir esse documento?\nUma vez excluído, não poderá ser recuperado.')">Excluir documento </button> 
            </form>
            <form name="document_form" method="POST" action="<?= $this->config->item('url_link') ?>admin/updateDocument/<?php echo $id; ?>" id="document_form">
                </br>
                Tipo do documento: <input type="text" disabled="disabled" name="document_type" value="<?php echo ucwords($type); ?>" >
                </br>
                Numero: <input  type="text" name="document_number" value="<?php echo $number; ?>">
                </br>
                Nome <?php if ($type != "recibo") { ?> empresa <?php } ?>: <input type="text" name="document_name" value="<?php echo $name; ?>">
                </br>
                Data <?php echo dataSwitch($type); ?> : <input type="text" class="datepickers" name="document_date" value="<?php echo transform_date($date); ?>">
                </br>
                Descrição :<input type="text" name="description" maxlength="50" value="<?php echo $description; ?>">
                </br>
                Valor :<input type="number" step="0.01" size="6" name="document_value" value="<?php echo $value; ?>">
                </br>
                <div class="col-lg-1" style="margin-top:15px">
                    <button class="btn btn-primary" type="submit">Salvar</button>
                </div>
            </form>
            <div class="col-lg-1">
                <button style="padding-left:20px" class="btn btn-danger" onclick="window.location.href = '<?= $this->config->item('url_link') ?>admin/manageDocuments'"> Fechar</button>
            </div>
        </div>
        <hr />
    </div>

</div>