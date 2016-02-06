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
    div.scroll{
    	
    	width:100%;
    	height:100%;
    	overflow-x:hidden;
    
    }
    
    
    </style>
    
    <body>
    <div class="scroll">
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-10" bgcolor="red">
                    <table class="table table-bordered table-striped table-min-td-size" style="max-width: 600px;">
                        <tr>
                            <th align="right" >
                                Sócios contribuintes
                            </th>
                            <td align='right'>
                                <?php echo $users[0]->count_associates; ?>
                            </td>
                        </tr>
                        <tr>
                            <th align="right" >
                                Sócios beneméritos
                            </th>
                            <td align='right'>
                                <?php echo $users[0]->count_benemerit; ?>
                            </td>
                        </tr>
                        <tr>
                            <th align="right" >
                                Não associados
                            </th>
                            <td align='right'>
                                <?php echo $users[0]->count_non_associate; ?>
                            </td>
                        </tr>
                        <tr>
                            <th align="right" width='200px'>
                                Total de usuários cadastrados
                            </th>
                            <td width="60px" align='right'>
                                <?php echo $users[0]->count_users; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>