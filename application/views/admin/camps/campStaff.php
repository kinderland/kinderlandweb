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
    <body>
        <script>
            $(function() {
                $("#sortable-table").tablesorter({widgets: ['zebra']});
                $(".datepicker").datepicker();
            });

            function updateCoordinator(campId) {
                var coordinatorId = $("#coordinator").val();
                if(coordinatorId != '' && coordinatorId > 0){
                    $.post("<?= $this->config->item('url_link'); ?>summercamps/updateCoordinator",
                        { camp_id: campId, person_id: coordinatorId  },
                            function ( data ){
                                if(data == "true")
                                    alert("Coordenador atualizado");
                                else
                                    alert("Erro ao atualizar coordenador");
                            }
                    );
                } else {
                    alert("Por favor, selecione uma pessoa para ser coordenadora.");
                }
            }

            function updateDoctor(campId) {
                var doctorId = $("#doctor").val();
                if(doctorId != '' && doctorId > 0){
                    $.post("<?= $this->config->item('url_link'); ?>summercamps/updateDoctor",
                        { camp_id: campId, person_id: doctorId  },
                            function ( data ){
                                if(data == "true")
                                    alert("Médico atualizado");
                                else
                                    alert("Erro ao atualizar médico");
                            }
                    );
                } else {
                    alert("Por favor, selecione uma pessoa para ser médica.");
                }
            }

            function updateMonitor(room, campId) {
                var monitorId = $("#monitores_"+room).val();
                if(monitorId != '' && monitorId > 0){
                    $.post("<?= $this->config->item('url_link'); ?>summercamps/updateMonitor",
                        { camp_id: campId, person_id: monitorId, room_number:room },
                            function ( data ){
                                if(data == "true")
                                    alert("Monitor atualizado");
                                else
                                    alert("Erro ao atualizar monitor");
                            }
                    );
                } else {
                    alert("Por favor, selecione uma pessoa para ser monitor.");
                }
            }
        </script>
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
                    <?php 
                        $monitors = array(1 => null, 2 => null, 3 => null, 4 => null, 5 => null, 6 => null);
                        $coordinator = null;
                        $doctor = null;

                        if($staff != null){
                            foreach($staff as $s){
                                if($s->staff_function == 1)
                                    $coordinator = $s;
                                else if($s->staff_function == 3)
                                    $doctor = $s;
                                else
                                    $monitors[$s->room_number] = $s;
                            }
                        }
                    ?>
                    <h3>Colônia: <?=$summerCamp->getCampName();?></h3>

                    <p>
                        Coordenador atual: 
                        <select name="coordinator" id="coordinator">
                            <option value="">-- Selecione --</option>
                            <?php
                            foreach ( $possibleCoordinators as $pm ) {
                                $selected = "";
                                if ($coordinator != null && $pm->getPersonId() == $coordinator->person_id)
                                    $selected = "selected";
                                echo "<option $selected value='".$pm->getPersonId()."'>".$pm->getFullname()."</option>";
                            }
                            ?>
                        </select>

                        <button class="btn btn-primary" onClick="updateCoordinator(<?=$summerCamp->getCampId();?>)">Salvar </button>
                    </p>

                    <p>
                        Monitores: <br />
                        <table class="sortable-table" id="sortable-table">
                            <thead> 
                            <tr>
                                <th>Nome</th>
                                <th>Quarto</th>
                                <th>Ações</th>
                            </tr>
                        </thead> 
                        <tbody>
                            <?php
                                $i = 1;
                                foreach($monitors as $monitor){
                            ?>

                            <tr>
                                <td>
                                    <select name="monitor" id="monitores_<?=$i?>">
                                        <option value="">-- Selecione --</option>
                                        <?php
                                        foreach ( $possibleMonitors as $pm ) {
                                            $selected = "";
                                            if ($monitor != null && $pm->getPersonId() == $monitor->person_id)
                                                $selected = "selected";
                                            echo "<option $selected value='".$pm->getPersonId()."'>".$pm->getFullname()."</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <?= $i ?>
                                </td>
                                <td> 
                                    <a onClick="updateMonitor(<?=$i?>, <?=$summerCamp->getCampId();?>)">Salvar </a>
                                <td/>
                            </tr>

                            <?php
                                    $i++;
                                }
                            ?>
                        <tbody>
                        </table>
                        
                    </p>

                    <p>
                        Médico atual: 
                        <select name="doctor" id="doctor">
                            <option value="">-- Selecione --</option>
                            <?php
                            foreach ( $possibleDoctors as $pm ) {
                                $selected = "";
                                if ($doctor != null && $pm->getPersonId() == $doctor->person_id)
                                    $selected = "selected";
                                echo "<option $selected value='".$pm->getPersonId()."'>".$pm->getFullname()."</option>";
                            }
                            ?>
                        </select>

                        <button class="btn btn-primary" onClick="updateDoctor(<?=$summerCamp->getCampId();?>)">Salvar </button>
                    </p>
                    
                </div>
            </div>
        </div>

    </body>
</html>