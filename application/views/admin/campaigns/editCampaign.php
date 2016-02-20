<?php

function do_alert($errors) {
    if (count($errors) > 0) {
        $all_errors = implode('', $errors);
        echo '<script type="text/javascript">alert("Os seguintes erros foram encontrados: \n' . $all_errors . '"); </script>';
    }
}
?>

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


            function datepickers() {
                $('.datepickers').datepicker();
                $(".datepickers").datepicker("option", "dateFormat", "dd/mm/yy");
            }



        </script>
    </head>
    <body>
        <script>
            $(document).ready(function () {
                datepickers();
            });
        </script>
        <?php do_alert($errors);?>
        <form name="campaign_form" method="POST" action="<?= $this->config->item('url_link') ?>admin/updateCampaign/<?php echo $campaign_id; ?>" id="campaign_form">
            <div class="row">
                <div class="col-lg-12 middle-content">
                    <div class="row">
                        <div class="col-lg-8"><h4>Edição de campanha</h4></div>

                    </div>
                    <hr />
                    <div class="row">

                        <div class="row">
                            <div class="form-group">
                                <label for="date_start" class="col-lg-12 control-label"> Período da campanha: </label>
                               
                                <?php if ($current) { ?>
                                
                                    <input type="hidden" name="date_start" value="<?php echo $date_start; ?>"/>
                                <?php } else { ?>
                                    <label for="date_start" class="col-lg-1 control-label"> Início*: </label>

                                    <div class="col-lg-2">
                                        <input type="text" class="datepickers form-control required" placeholder="Data de Início"  name="date_start" value=""/>
                                    </div>
                                <?php } ?>
                                <label for="date_finish" class="col-lg-1 control-label"> Fim*: </label>
                                <div class="col-lg-2">
                                    <input type="text" class="datepickers form-control required" placeholder="Data de término" value="" name="date_finish" />
                                </div>
                            </div>
                            <br><br>
                            <label for="price" class = "col-lg-1"> Preço: </label>
                            <div class ="col-lg-1">
                                <input type="number" step="0.01" placeholder="Preço da campanha" value="<?= $price ?>" name="price" />
                            </div>
                            <input type="hidden" name="id" value="<?php echo $campaign_id ?>"/>
                            <br>
                            <div style="padding-top:100px">
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10">
                                    <button class="btn btn-primary" style="margin-right:40px">Confirmar</button>
                                    <button  type="button" class="btn btn-danger" onClick="window.close()">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </body>
</html>
