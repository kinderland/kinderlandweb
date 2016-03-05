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

        <script type="text/css">
            .block-click { /*Para quando não quiser que o link seja acessado */
                pointer-events: none;
            }
        </script>

        <script type="text/javascript" charset="utf-8">

            var linha = '<tr><td><input type="text" class=" datepickers form-control" placeholder="Data de Início" name="payment_date_start[]" size="8"></td>\n\
                 <td><input type="text" class=" datepickers form-control" placeholder="Data de Fim" name="payment_date_end[]" size="6"></td>\n\
                 <td><input type="text" class="form-control" placeholder="Valor geral" name="price[]" id="price" size="6>"></td>\n\
                 <td><input type="number" class="form-control" name="portions[]" id="portions" value="1" min="1" max="8"></td>			   		\n\
                 <td><img src="<?= $this->config->item('assets') ?>images/forms/icon_minus.gif" style="cursor: pointer; cursor: hand;" class="delete></button></td></tr>';

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
            $(document).ready(function () {
<?php foreach ($payments as $payment) { ?>
                    addTableLine('<tr><td><input type="text" class=" datepickers form-control" placeholder="Data de Início" name="payment_date_start[]" value="<?php echo Events::toMMDDYYYY($payment["payment_date_start"]) ?>" size="8"></td> \n\
                                                                                                              <td><input type="text" class=" datepickers form-control" placeholder="Data de Fim" name="payment_date_end[]" value="<?php echo Events::toMMDDYYYY($payment["payment_date_finish"]) ?>" size="8"></td> \n\
                                                                                                              <td><input type="text" class="form-control" placeholder="Preço" name="price[]" id="price" value="<?php echo $payment["price"] ?>" size="6"></td> \n\
                                                                                                              <td><input type="number" class="form-control" name="portions[]" id="portions" value="<?php echo $payment["portions"] ?>" min="1" max="5"></td> \n\
                                                                                                              <td><img src="<?= $this->config->item('assets') ?>images/forms/icon_minus.gif" style="cursor: pointer; cursor: hand;" class="delete></button></td></tr>	');
<?php } ?>
            });
        </script>
        <?php do_alert($errors); ?>
        <form name="campaign_form" method="POST" action="<?= $this->config->item('url_link') ?>admin/updateCampaign/<?php echo $campaign_id; ?>" id="campaign_form">
            <div class="row" style="width:1000px">
                <div class="col-lg-12 middle-content">
                    <div class="row">
                        <div class="col-lg-8"><h4>Edição de campanha</h4></div>

                    </div>
                    <hr />
                    <div class="row" style="margin-left:60px">

                        <div class="row">
                            <div class="form-group">
                                <label for="date_start" class="col-lg-12 control-label"> Período da campanha: </label>
                                <label for="date_start" class="col-lg-1 control-label"> Início*: </label>
                                <input type="hidden" name="current" value="<?php echo $current; ?>"/>
                                <?php if ($current) { ?>
                                    <div class="col-lg-2">
                                        <input type="text" class ="form-control required" readonly name="date_start" value="<?php echo $date_start; ?>"/>
                                    </div>
                                <?php } else { ?>


                                    <div class="col-lg-3">
                                        <input type="text" class="datepickers form-control required" placeholder="Data de Início"  name="date_start" value="<?php echo Admin::toMMDDYYYY($date_start); ?>"/>
                                    </div>
                                <?php } ?>
                                <label for="date_finish" class="col-lg-1 control-label"> Fim*: </label>
                                <div class="col-lg-3">
                                    <input type="text" class="datepickers form-control required" placeholder="Data de término" value="<?php echo Admin::toMMDDYYYY($date_finish); ?>" name="date_finish" />
                                </div>
                            </div>
                            <br><br>
                            <input type="hidden" name="id" value="<?php echo $campaign_id ?>"/>
                            <br>
                            <div style="padding-top:100px">
                            </div>
                            <br />
                            <br />
                            <div class="row">
                                <label class="col-lg-10 control-label"> Períodos para pagamento:                        <h5 style="color:red">Os períodos de pagamentos devem estar em ordem.</h5></label><br />
                                <div class="col-lg-9">
                                    <table id="table" name="table" class="table"><tr><th>De</th><th>Até</th><th>Valor</th><th>Parcelas max</th></tr>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <button type="button" value="" onclick="addTableLine()">Novo periodo</button>
                                </div>
                            </div>
                            <br /><br />
                            <div class="form-group">
                                <div class="col-lg-10">
                                    <button class="btn btn-primary" style="margin-right:40px">Confirmar</button>
                                    <a href="<?= $this->config->item('url_link'); ?>admin/manageCampaigns"><button  type="button" class="btn btn-danger">Fechar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>
