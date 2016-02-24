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
            var linha = '<tr><td><input type="text" class=" datepickers form-control" placeholder="Data de Início" name="payment_date_start[]"</td>\n\
                 <td><input type="text" class=" datepickers form-control" placeholder="Data de Fim" name="payment_date_end[]"</td>\n\
                 <td><input type="text" class="form-control" placeholder="Valor geral" name="price[]" id="price"></td>\n\
                 <td><input type="number" class="form-control" name="portions[]" id="portions" value="1" min="1" max="8"></td>			   		\n\
                 <td><img src="<?= $this->config->item('assets') ?>images/forms/icon_minus.gif" style="cursor: pointer; cursor: hand;" class="delete"></button></td></tr>';
            function addTableLine(linhaAAdicionar) {
                if (!linhaAAdicionar)
                    $('#table > tbody:last').append(linha);
                else
                    $('#table > tbody:last').append(linhaAAdicionar);
                datepickers();
                $(".delete").on('click', function (campaign) {
                    $(this).parent().parent().remove();
                });
            }
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
        <?php
        do_alert($errors);
        ?>
        <form name="campaign_form" onsubmit="alertRequiredFields()" method="POST" action="<?= $this->config->item('url_link') ?>admin/completeCampaign" id="campaign_form">
            <div class="row">
                <div class="col-lg-12 middle-content">

                    <div class="row">
                        <div class="col-lg-8"><h4>Cadastro da campanha</h4></div>
                    </div>
                    <hr />


                    <div class="row">

                        <div class="row">
                            <div class="form-group">
                                <label for="date_start" class="col-lg-12 control-label"> Período da campanha: </label>
                                <label for="date_start" class="col-lg-1 control-label"> Início*: </label>
                                <div class="col-lg-2">
                                    <input type="text" class=" datepickers form-control required" placeholder="Data de Início" value="<?php echo Admin::toMMDDYYYY($date_start); ?>" name="date_start" />
                                </div>

                                <label for="date_finish" class="col-lg-1 control-label"> Fim*: </label>
                                <div class="col-lg-2">
                                    <input type="text" class="datepickers form-control required" placeholder="Data de Término" value="<?php echo Admin::toMMDDYYYY($date_finish); ?>" name="date_finish" />
                                </div>
                            </div>
                            <br><br>

                            <div style="padding-top:100px">
                            </div>
                            <br />
                            <br />
                            <div class="row">
                                <label class="col-lg- control-label"> Períodos para pagamento:                        <h5 style="color:red">Os períodos de pagamentos devem estar em ordem.</h5></label><br />
                                <div class="col-lg-12">
                                    <table id="table" name="table" class="table"><tr><th>De</th><th>Até</th><th>Valor</th><th>Parcelas max</th></tr>
                                        <tbody>
                                            <?php foreach ($payments as $payment) {?>
                                   <tr><td><input type="text" class=" datepickers form-control" placeholder="Data de Início" name="payment_date_start[]" value="<?php echo Events::toMMDDYYYY($payment["payment_date_start"])?>"</td>
                                       <td><input type="text" class=" datepickers form-control" placeholder="Data de Fim" name="payment_date_end[]" value="<?php echo Events::toMMDDYYYY($payment["payment_date_end"])?>"</td>
                                       <td><input type="text" class="form-control" placeholder="Valor geral" name="price[]" id="full_price" value="<?php echo $payment["price"]?>"></td>			   		
                                       <td><input type="number" class="form-control" name="portions[]" id="payment_portions" value="<?php echo $payment["portions"]?>" min="1" max="5"></td>			   			   		
                                       <td><img src="<?=$this->config->item('assets')?>images/forms/icon_minus.gif" style="cursor: pointer; cursor: hand;" class="delete""></button></td>				   	
                                   </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <button type="button" value="" onclick="addTableLine()">Novo periodo</button>
                                </div>
                            </div>
                            <br /><br />
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
