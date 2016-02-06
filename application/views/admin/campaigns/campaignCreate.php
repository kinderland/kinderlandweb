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

        <script type="text/javascript" charset="utf-8">

            function alertRequiredFields() {
                var error = "";
                if (document.getElementsByName("date_start")[0].value == "") {
                    error = error.concat("Data de ínicio do periodo da campanha\n");
                }
                if (document.getElementsByName("date_finish")[0].value == "")
                    error = error.concat("Data de fim do periodo da campanha\n");

                if (error != "") {
                    alert("Dados faltando para a criação da campanha.\nOs dados incompletos são:\n".concat(error));
                    document.getElementsByName("enabled")[0].value = 0;
                }
                document.getElementsByName("enabled")[0].value = 1;
            }

            function datepickers() {
                $('.datepickers').datepicker();
                $(".datepickers").datepicker("option", "dateFormat", "dd/mm/yy");
            }

            var string = "";

<?php
foreach ($errors as $error) {
    echo "string = string.concat('$error\\n');";
}
?>

            if (string !== "") {
                alert("Os seguintes erros foram encontrados:\n".concat(string));
            }

        </script>
    </head>
    <body>
        <script>
            $(document).ready(function () {
                datepickers();
            });
        </script>
        <form name="event_form" onsubmit="alertRequiredFields()" method="POST" action="<?= $this->config->item('url_link') ?>admin/completeCampaign" id="campaign_form">
            <div class="row">
                <div class="col-lg-12 middle-content">
                    <div class="row">
                        <div class="col-lg-8"><h4>Cadastro da campanha</h4></div>
                    </div>
                    <hr />

                    <div class="row">

                        <div class="row">
                            <div class="form-group">
                                <label for="date_start" class="col-lg-2 control-label"> Período da campanha: </label>
                                <label for="date_start" class="col-lg-1 control-label"> Início*: </label>
                                <div class="col-lg-2">
                                    <input type="text" class=" datepickers form-control required" placeholder="Data de Início" value="<?= $date_start ?>" name="date_start" />
                                </div>

                                <label for="date_finish" class="col-lg-1 control-label"> Fim*: </label>
                                <div class="col-lg-2">
                                    <input type="text" class="datepickers form-control required" placeholder="Data de Término" value="<?= $date_finish ?>" name="date_finish" />
                                </div>
                            </div>
                        </div>
                        <br />
                        <div style="padding-top:100px">
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10">
                                <button class="btn btn-primary" style="margin-right:40px">Confirmar</button>
                                <a href="<?= $this->config->item('url_link') ?>events/index"><button  type="button" class="btn btn-danger"
                                                                                                      onClick="window.close()">Fechar</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>
