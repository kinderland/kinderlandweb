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
                $(".sortable-table").tablesorter({widgets: ['zebra']});
                $(".datepicker").datepicker();
            });

            function updateCoordinator(campId,number) {
            	var coordinatorId = $("#coordinator"+number).val();
            	
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
            function updateAssistant(campId,number) {
                var assistantId = $("#assistant"+number).val();
                var room = '';
                if(assistantId != '' && assistantId > 0){
                    $.post("<?= $this->config->item('url_link'); ?>summercamps/updateMonitor",
                        { camp_id: campId, person_id: assistantId, room_number:room },
                            function ( data ){
                                if(data == "true")
                                    alert("Assistente atualizado");
                                else
                                    alert("Erro ao atualizar assistente");
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
                        $monitors = array(1 => null, 2 => null, 3 => null, 4 => null, 5 => null, 6 => null, 7 => null, 8 => null, 9 => null, 10 => null, 11 => null, 12 => null);
                        $coordinators = array(1 => null, 2 => null, 3 => null);
                        $doctor = null;
                        $room = null;
                        $assistants = array();
                        $numberCoordinators = 0;

                        if($staff != null){
                            foreach($staff as $s){
                                if($s->staff_function == 1){
                                	if($numberCoordinators == 0){
                                		$coordinators[1] = $s;
                                		$numberCoordinators++;
                                	}
                                	else if($numberCoordinators == 1){
                                		$coordinators[2] = $s;
                                		$numberCoordinators++;
                                	}
                                	else if($numberCoordinators == 2){
                                		$coordinators[3] = $s;
                                	}
                                }
                                else if($s->staff_function == 3)
                                    $doctor = $s;
                                else{
                                	
                                	if($s->room_number == ''){
                                		$assistants[] = $s;
                                	}
                                	else {
	                                	if($s->room_number == '1F')
	                                		$room = 1;
	                                	else if($s->room_number == '2F')
	                                		$room = 2;
	                                	else if($s->room_number == '3F')
	                                		$room = 3;
	                                	else if($s->room_number == '4F')
	                                		$room = 4;
	                                	else if($s->room_number == '5F')
	                                		$room = 5;
	                                	else if($s->room_number == '6F')
	                                		$room = 6;
	                                	else if($s->room_number == '1M')
	                                		$room = 7;
	                                	else if($s->room_number == '2M')
	                                		$room = 8;
	                                	else if($s->room_number == '3M')
	                                		$room = 9;
	                                	else if($s->room_number == '4M')
	                                		$room = 10;
	                                	else if($s->room_number == '5M')
	                                		$room = 11;
	                                	else if($s->room_number == '6M')
	                                		$room = 12;
	                                	
	                                    $monitors[$room] = $s;
                                	}
                                }
                            }
                        }
                    ?>
                    <h3>Colônia: <?=$summerCamp->getCampName();?></h3>

                    <p>
                    <br />
                        Coordenadores:<br />
                        <table class="sortable-table" >
                            <thead> 
                            <tr>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead> 
                        <tbody> 
                        <?php
                                $i = 1;
                                foreach($coordinators as $coordinator){
                            ?>

                            <tr>
                                <td>
			                        <select name="coordinator" id="coordinator<?=$i?>">
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
			                    </td>
			                    <td>							
			                        <a onClick="updateCoordinator(<?=$summerCamp->getCampId();?>,<?=$i?>)">Salvar </a>
			                    </td>
			                    </tr>
			                    <?php $i++;}?>
			             </tbody>
			           </table>
                    </p>
                    <p>
                        Médico: <br />
                        <table class="sortable-table" >
                            <thead> 
                            <tr>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead> 
                        <tbody>
                        	<tr>
                        		<td>
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
			                   </td>
			                   <td>		
		                        	<a onClick="updateDoctor(<?=$summerCamp->getCampId();?>)">Salvar </a>
		                       </td>
		                   </tr>
		                </tbody>
		                </table>
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
                                $gender = 'F';
                                foreach($monitors as $monitor){
                            ?>

                            <tr>
                                <td>
                                    <select name="monitor" id="monitores_<?=$i?><?=$gender?>">
                                        <option value="">-- Selecione --</option>
                                        <?php
                                        	if($i<=6) {
                                        		foreach ( $possibleMonitors as $pm ) {
                                        			$selected = "";
                                        			if ($monitor != null && $pm->getPersonId() == $monitor->person_id)
                                        				$selected = "selected";
                                        			echo "<option $selected value='".$pm->getPersonId()."'>".$pm->getFullname()."</option>";
                                        		}                                        		
                                        	}
                                        	else{
		                                        foreach ( $possibleMonitors as $pm ) {
		                                            $selected = "";
		                                            if ($monitor != null && $pm->getPersonId() == $monitor->person_id)
		                                                $selected = "selected";
		                                            echo "<option $selected value='".$pm->getPersonId()."'>".$pm->getFullname()."</option>";
		                                        }
                                        	}
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <?=$i?><?=$gender?>
                                </td>
                                <td> 
                                    <a onClick="updateMonitor(<?=$i?><?=$gender?>, <?=$summerCamp->getCampId();?>)">Salvar </a>
                                <td/>
                            </tr>

                            <?php
                            		if($i == 6){
                            			$i=1;
                            			$gender = 'M';
                            		}
                            		else
                                    	$i++;
                                }
                            ?>
                        <tbody>
                        </table>
                        
                    </p>
                  <!--   <p>
                        Assistentes:  <br />
                        <table class="sortable-table" >
                            <thead> 
                            <tr>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead> 
                        <tbody>
                        <?php /* $i=1;
                        	foreach($assistants as $assistant) {
                       */ ?>
                        	<tr>
                        		<td>
			                        <select name="assistant" id="assistant<?php //=$i?>">
			                            <option value="">-- Selecione --</option>
			                            <?php /*
			                            foreach ( $possibleMonitors as $pm ) {
			                                $selected = "";
			                                if ($assistant != null && $pm->getPersonId() == $assistant->person_id)
			                                    $selected = "selected";
			                                echo "<option $selected value='".$pm->getPersonId()."'>".$pm->getFullname()."</option>";
			                            }
			                            */?>
			                        </select>
			                   </td>
			                   <td>		
		                        	<a onClick="updateAssistant(<?php //=$summerCamp->getCampId();?>,<?php //$i?>)">Salvar </a>
		                       </td>
		                   </tr>
		                <?php /* $i++;
                        	}*/?>
                        	<tr>
                        		<td>
			                        <select name="assistant" id="assistant<?php //$i?>">
			                            <option value="">-- Selecione --</option>
			                            <?php /*
			                            foreach ( $possibleMonitors as $pm ) {
			                                $selected = "";
			                                if ($assistant != null && $pm->getPersonId() == $assistant->person_id)
			                                    $selected = "selected";
			                                echo "<option value='".$pm->getPersonId()."'>".$pm->getFullname()."</option>";
			                            }
			                           */ ?>
			                        </select>
			                   </td>
			                   <td>		
		                        	<a onClick="updateAssistant(<?php //$summerCamp->getCampId();?>,<?php //$i*/?>)">Salvar </a>
		                       </td>
		                   </tr>
		                </tbody>
		                </table>
                    </p> -->
                    

                </div>
            </div>
        </div>

    </body>
</html>