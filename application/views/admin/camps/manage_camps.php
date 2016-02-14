<style type="text/css">
    html, body {
        
        padding-left:30px;
    }
</style>



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
<?php 
        
      //  require_once renderMenu($permissions); 
    ?>
    </head>
    <style>
    
    div.scroll{
    	
    	width:100%;
    	height:100%;
    	overflow-x:hidden;
    	padding-left:12%;
    
    }
    
    </style>
    <body>
        <script>
            $(function() {
                $("#sortable-table").tablesorter({widgets: ['zebra']});
                $(".datepicker").datepicker();
            });

            function updateCampEnabled(campId) {
                var enabled = true; //Tentar pegar o valor do Radio Button

                $.post("<?= $this->config->item('url_link'); ?>admin/changeCampEnabledStatus",
                    { camp_id: campId, status: ((enabled)?"t":"f")  },
                        function ( data ){
                            if(data == "true")
                                alert("Colônia atualizada");
                            else
                                alert("Erro ao atualizar pré-inscrições");
                        }
                );
            }
        </script>
        <div class="scroll">
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
                   <?php if (in_array(SYSTEM_ADMIN, $permissions)){?> 
                    <a target="_blank" href="<?= $this->config->item('url_link'); ?>admin/createCamp" target="_parent">
                        <button type="button" class="btn btn-primary btn-sm">
                            Criar colônia
                        </button>
                    </a>
                    <?php }?>
                    <table class="sortable-table" id="sortable-table">
                        <thead> 
                            <tr>
                                <th>Nome</th>
                                <th>Data Inicío</th>
                                <th>Data Fim</th>
                                <th>Habilitar pré-inscrições</th>
                                <th>Capacidade</th>
                                <th>Ações</th>
                            </tr>
                        </thead> 
                        <tbody>
                            <?php
                                if(isset($camps) && is_array($camps)){
                                    foreach($camps as $camp){
                            ?>

                            <tr>
                                <body onunload="window.opener.location.reload();"><td><a target='_blank' onclick="window.open('<?php echo $this->config->item("url_link");?>admin/editCamp/<?php echo $camp->getCampId()?>','dd'); return false;" href=""><?php echo $camp->getCampName() . ( ($camp->isMiniCamp())? " (Mini)":"" );?></a></td>
                                <td><?= date_format(date_create($camp->getDateStart()), 'd/m/y');?></td>
                                <td><?= date_format(date_create($camp->getDateFinish()), 'd/m/y');?></td>
                                <td>
                                    Sim: <input type="radio" name="pre_subscription<?=$camp->getCampId()?>" value="true"  <?= ($camp->isEnabled())?"checked='checked'":""?> /> | 
                                    Não: <input type="radio" name="pre_subscription<?=$camp->getCampId()?>" value="false" <?= (!$camp->isEnabled())?"checked='checked'":""?> />
                                </td>
                                <td>M: <?=$camp->getCapacityMale()?> | F: <?=$camp->getCapacityFemale()?></td>
                                <td><?php if (in_array(SYSTEM_ADMIN, $permissions)){?> <a onClick="updateCampEnabled(<?=$camp->getCampId()?>)"> Salvar </a> | <?php }?><a target="_blank" href="<?=$this->config->item('url_link')?>summercamps/manageStaff/<?=$camp->getCampId()?>"> Equipe </a> <td/>
                            </tr>

                            <?php
                                    }
                                }
                            ?>
                        <tbody>
                    </table>
                </div>
            </div>
        </div>
		</div>
    </body>
</html>