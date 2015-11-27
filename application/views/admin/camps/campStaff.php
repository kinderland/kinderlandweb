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

            function updateCoordinator(campId,number,coordinatorId1,coordinatorId2,coordinatorId3) {
            	var coordinatorId = $("#coordinator"+number).val();
            	var personId;
            	var existOther;

            	if(number == 1){
                	personId = coordinatorId1;
                	existOther = (coordinatorId2 != 0 || coordinatorId3 != 0);
            	}
            	else if(number == 2){
            		personId = coordinatorId2;
            		existOther = (coordinatorId1 != 0 || coordinatorId3 != 0);
            	}
            	else if(number == 3){
            		personId = coordinatorId3;
            		existOther = (coordinatorId1 != 0 || coordinatorId2 != 0);
            	}

            	if((coordinatorId == '') && existOther) {                	

                	$.post("<?= $this->config->item('url_link'); ?>summercamps/deleteCoordinator",
                            { camp_id: campId, person_id: personId  },
                                function ( data ){
                                    if(data == "true"){
                                        alert("Coordenador atualizado");
                                        location.reload();
                                    }
                                    else{
                                        alert("Erro ao atualizar coordenador");
                                        location.reload();
                                    }
                                }
                        );

            	}
            	else{
            	
	                if(coordinatorId != '' && coordinatorId > 0){
	                	$.post("<?= $this->config->item('url_link'); ?>summercamps/deleteCoordinator",
	                            { camp_id: campId, person_id: personId  },
	                                function ( data ){
	                                    if(data == "true"){
	                                    	$.post("<?= $this->config->item('url_link'); ?>summercamps/updateCoordinator",
	                    	                        { camp_id: campId, person_id: coordinatorId  },
	                    	                            function ( data ){
	                    	                                if(data == "true"){
	                    	                                    alert("Coordenador atualizado");
	                    	                                	location.reload();
	                    	                                }
	                    	                                else{
	                    	                                    alert("Erro ao atualizar coordenador");
	                    	                                    location.reload();
	                    	                                }
	                    	                            }
	                    	                    );
	                                    }
	                                    else{
	                                        alert("Erro ao atualizar coordenador");
	                                        location.reload();
	                                    }
	                                }
	                        );
	                } else {
	                    alert("Por favor, selecione uma pessoa para ser coordenadora.");
	                    location.reload();
	                }
            	}
            }

            function updateDoctor(campId,oldDoctorId) {
                var doctorId = $("#doctor").val();
                if(doctorId != '' && doctorId > 0){
                    $.post("<?= $this->config->item('url_link'); ?>summercamps/updateDoctor",
                        { camp_id: campId, person_id: doctorId, oldDoctorId: oldDoctorId  },
                            function ( data ){
                                if(data == "true"){
                                    alert("Médico atualizado");
                                    location.reload();
                                }
                                else{
                                    alert("Erro ao atualizar médico");
                                    location.reload();
                                }
                            }
                    );
                } else {
                    alert("Por favor, selecione uma pessoa para ser médica.");
                }
            }

            function updateMonitor(room, campId, oldMonitorId) {
                var monitorId = $("#monitores_"+room).val();
                if(monitorId != '' && monitorId > 0){
                    $.post("<?= $this->config->item('url_link'); ?>summercamps/updateMonitor",
                        { camp_id: campId, person_id: monitorId, room_number:room, oldMonitorId: oldMonitorId},
                            function ( data ){
                                if(data == "true"){
                                    alert("Monitor atualizado");
                                	location.reload();
                                }
                                else{
                                    alert("Erro ao atualizar monitor");
                                    location.reload();
                                }
                            }
                    );
                } else {
                    alert("Por favor, selecione uma pessoa para ser monitor.");
                }
            }
            function updateAssistant(campId,number,oldMonitorId) {
                var assistantId = $("#assistant"+number).val();
                var room = '';
                if(assistantId != '' && assistantId > 0){
                    $.post("<?= $this->config->item('url_link'); ?>summercamps/updateMonitor",
                        { camp_id: campId, person_id: assistantId, room_number:room, oldMonitorId: oldMonitorId },
                            function ( data ){
                                if(data == "true"){
                                    alert("Assistente atualizado");
                                    location.reload();
                                }
                                else{
                                    alert("Erro ao atualizar assistente");
                                    location.reload();
                                }
                            }
                    );
                } else {
                    alert("Por favor, selecione uma pessoa para ser assistente.");
                    location.reload();
                }
            }
            function deleteAssistant(campId,number) {
                var assistantId = $("#assistant"+number).val();
                if(assistantId != '' && assistantId > 0){
                    $.post("<?= $this->config->item('url_link'); ?>summercamps/deleteAssistant",
                        { camp_id: campId, person_id: assistantId},
                            function ( data ){
                                if(data == "true"){
                                    alert("Assistente excluído");
                                    location.reload();
                                }
                                else{
                                    alert("Erro ao excluir assistente");
                                    location.reload();
                                }
                            }
                    );
                } 
            }
        </script>
        <div class="main-container-report">
            <div class = "row">
                <div class="col-lg-12">
                    <?php 
                        $monitors = array(1 => null, 2 => null, 3 => null, 4 => null, 5 => null, 6 => null, 7 => null, 8 => null, 9 => null, 10 => null, 11 => null, 12 => null);
                        $coordinators = array(1 => null, 2 => null, 3 => null);
                        $coordinatorsId = array(1 => 0, 2 => 0, 3 => 0);
                        $doctor = null;
                        $room = null;
                        $assistants = array();
                        $m = 1;
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
                                	
                                	if($s->room_number == null){
                                		$assistants[$m] = $s;
                                		$m++;
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
                                foreach($coordinators as $cordinator){
                                	if(isset($cordinator -> person_id)){
	                                	 $coordinatorsId[$i] = $cordinator -> person_id;
	                                	 $i++;
                                	}
                                }	 
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
			                                if ($coordinator != null && $pm->getPersonId() == $coordinator->person_id && $coordinatorsId[$i] == $coordinator->person_id) {
			                                    $selected = "selected";	
			                                }
			                                echo "<option $selected value='".$pm->getPersonId()."'>".$pm->getFullname()."</option>";
			                            }
			                            ?>
			                        </select>
			                    </td>
			                    <td>							
			                        <a onClick="updateCoordinator(<?=$summerCamp->getCampId();?>,<?=$i?>,<?= $coordinatorsId[1]?>,<?= $coordinatorsId[2]?>,<?= $coordinatorsId[3]?>)">Salvar </a>
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
		                        	<a onClick="updateDoctor(<?=$summerCamp->getCampId();?>,'<?php if(isset($doctor->person_id)) echo $doctor->person_id;?>')">Salvar </a>
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
                                $j = 1;
                                $gender = 'F';
                                foreach($monitors as $monitor){
                            ?>

                            <tr>
                                <td>
                                    <select name="monitor" id="monitores_<?=$i?><?=$gender?>">
                                        <option value="">-- Selecione --</option>
                                        <?php
                                        	if($j<=6) {
                                        		if($possibleFemaleMonitors!=null)
                                        		foreach ($possibleFemaleMonitors as $pm ) {
                                        			$selected = "";
                                        			if ($monitor != null && $pm->getPersonId() == $monitor->person_id)
                                        				$selected = "selected";
                                        			echo "<option $selected value='".$pm->getPersonId()."'>".$pm->getFullname()."</option>";
                                        		}                                        		
                                        	}
                                        	else{
                                        		if($possibleMaleMonitors!=null)
		                                        foreach ($possibleMaleMonitors as $pm ) {
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
                                    <?php $quarto = $i.$gender;?>
                                </td>
                                <td> 
                                    <a onClick="updateMonitor('<?=$quarto?>',<?=$summerCamp->getCampId();?>,'<?php if(isset($monitors[$j]->person_id)) echo $monitors[$j]->person_id;?>')">Salvar </a>
                                <td/>
                            </tr>

                            <?php
                            		if($i == 6){
                            			$i=1;
                            			$gender = 'M';
                            		}
                            		else{
                                    	$i++;
                            		}
                            		
                            		$j++;
                                }
                            ?>
                        <tbody>
                        </table>
                        
                    </p>
                    <p>
                        Assistentes:  <br />
                        <table class="sortable-table" >
                            <thead> 
                            <tr>
                                <th>Nome</th>
                                <th  colspan = '2'>Ações</th>
                            </tr>
                        </thead> 
                        <tbody>
                        <?php $i=1;
                        	if($assistants!=null)
                        	foreach($assistants as $assistant) {
                        ?>
                        	<tr>
                        		<td>
			                        <select name="assistant" id="assistant<?=$i?>">
			                            <option value="">-- Selecione --</option>
			                            <?php 
			                            foreach ( $possibleMonitors as $pm ) {
			                                $selected = "";
			                                if ($assistant != null && $pm->getPersonId() == $assistant->person_id)
			                                    $selected = "selected";
			                                echo "<option $selected value='".$pm->getPersonId()."'>".$pm->getFullname()."</option>";
			                            }
			                            ?>
			                        </select>
			                   </td>
			                   <td>		
		                        	<a onClick="updateAssistant(<?=$summerCamp->getCampId();?>,<?=$i?>,'<?php if(isset($assistants[$i]->person_id)) echo $assistants[$i]->person_id;?>')">Salvar </a>
		                       </td>
		                       <td>
		                        	<a onClick="deleteAssistant(<?=$summerCamp->getCampId();?>,<?=$i?>)">Excluir</a>
		                       </td>
		                   </tr>
		                <?php  $i++;
                        	}?>
                        	<tr>
                        		<td>
			                        <select name="assistant" id="assistant<?=$i?>">
			                            <option value="">-- Selecione --</option>
			                            <?php 
			                            foreach ( $possibleMonitors as $pm ) {
			                                $selected = "";
			                                if ($assistant != null && $pm->getPersonId() == $assistant->person_id) {
			                                    $selected = "selected";
			                                }
			                                echo "<option value='".$pm->getPersonId()."'>".$pm->getFullname()."</option>";
			                            }
			                            ?>
			                        </select>
			                   </td>
			                   <td>		
		                        	<a onClick="updateAssistant(<?=$summerCamp->getCampId();?>,<?=$i?>)">Salvar </a>
		                       </td>
		                   </tr>
		                </tbody>
		                </table>
                    </p> 
                    

                </div>
            </div>
        </div>

    </body>
</html>