
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
        if (count($errors) > 0) {
            $all_errors = implode('', $errors);
            echo '<script type="text/javascript">alert("Os seguintes erros foram encontrados: \n' . $all_errors . '"); </script>';
        }
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

        function transform_date($date) {
            $newDate = explode("/", $date);
            $temp = $newDate[0];
            $newDate[0] = $newDate[1];
            $newDate[1] = $temp;
            $newDate = implode("/", $newDate);
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
    <div class="main-container">
        <div class="col-lg-12"><b><h3>Edição de Documento</h3></b></div>
        <div class="row" style="width:1000px;margin-left:30px">
            <div class="col-lg-12 middle-content">

                <hr class="footer-hr">
                <form method="POST" action="<?php echo $exclusionUrl; ?>">
                    <button class="btn btn-danger" type="submit" onclick="return confirm('Você tem certeza que quer excluir esse documento?\nUma vez excluído, não poderá ser recuperado.')">Excluir documento </button> 
                </form>
                <form enctype="multipart/form-data" name="document_form" method="POST" action="<?= $this->config->item('url_link') ?>admin/updateDocument/<?php echo $id; ?>" id="document_form">
                    <div class="row">
                        <label for="document_type" class="col-lg-3" style="padding-top:15px">Tipo de documento: </label>
                        <div class="col-lg-2">
                            <input type="text" disabled="disabled" name="document_type" class="form-control" value="<?php echo ucwords($type); ?>" style="margin-left:-100px" >
                        </div>
                    </div>
                    <div class="row">
                        <label for="document_number" class="col-lg-1" style="padding-top:15px">Número: </label>
                        <div class="col-lg-2">
                            <input  type="number" name="document_number" style="margin-left:-20px" value="<?php echo $number; ?>" class="form-control required"/>
                        </div>
                    </div>
                    <div class="row">
                        <label for="document_name" class="col-lg-3" style="padding-top:15px;width:12%;padding-right:-15px">Nome <?php if ($type != "recibo") { ?>empresa <?php } ?>: </label>
                        <div class="col-lg-3">
                            <input type="text" name="document_name" class="form-control" style="margin-left:-20px" value="<?php echo $name; ?>"/>
                        </div>
                    </div>
                    <div class="row">
                        <label for="document_date" class="col-lg-3" style="padding-top:15px;width:15%"> Data <?php echo dataSwitch($type); ?> : </label>
                        <div class="col-lg-2">
                            <input type="text" class="datepickers required form-control" style="margin-left:-20px" name="document_date" value="<?php echo transform_date($date); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <label for="description" class="col-lg-2" style="padding-top:15px;width:15%"> Descrição: </label>
                        <div class="col-lg-5">
                            <input type="text" name="description" maxlength="50" class="form-control" style="margin-left:-60px" value="<?php echo $description; ?>">   
                        </div>
                    </div>
                    <div class="row">
                        <label for="document_value" class="col-lg-2" style="padding-top:15px;width:15%"> Valor: </label>
                        <div class="col-lg-2">
                            <input class="form-control" type="number" size="6" name="document_value" style="margin-left:-100px" value="<?php echo $value; ?>"> 
                        </div>
                    </div>
                    <div class="row">
                        <label for="uploadedfile" class="col-lg-2" style="padding-top:15px;width:15%"> Upload de imagem: </label>
                        <div class="col-lg-2">
                            <input  type="file" style="margin-left:-50px" name="uploadedfile" class="btn btn-primary"/> 
                            <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                        </div>

                    </div>
                    </br>
                </form>

                <?php if ($upload_id > 0) { ?>
                    <div class="row">
                        <a target="_blank" href="<?= $this->config->item('url_link'); ?>admin/verifyDocumentExpense?upload_id=<?php echo $upload_id; ?>">
                            <button class="btn btn-primary">
                                Visualizar último documento enviado
                            </button> </a>
                    </div>
                <?php } ?>
                <div style="margin-top:20px">
                    <div class="col-lg-1">
                        <button class="btn btn-primary" type="submit" form="document_form">Salvar</button>
                    </div>

                    <div class="col-lg-1">
                        <button style="padding-left:20px" class="btn btn-warning" onclick="window.location.href = '<?= $this->config->item('url_link') ?>admin/manageDocuments'"> Voltar</button>
                    </div>
                </div>
            </div>
            <hr />
        </div>
    </div>
