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

            function updateCoordinator(campId,coordinatorId1,coordinatorId2,coordinatorId3) {
            	var cordinatorId1 = $("#coordinator_"+1).val();
            	var cordinatorId2 = $("#coordinator_"+2).val();
            	var cordinatorId3 = $("#coordinator_"+3).val();
            	var personId;
            	var func = 1;
            	
	                if(cordinatorId1 != 0 || cordinatorId2 != 0 || cordinatorId3 != 0 ){
	                	$.post("<?= $this->config->item('url_link'); ?>summercamps/deleteCoordinator",
	                            { camp_id: campId },
	                                function ( data ){
	                                    if(data == "true"){
	                                    	$.post("<?= $this->config->item('url_link'); ?>summercamps/updateCoordinator",
	                    	                        { camp_id: campId, coordinatorId1: cordinatorId1, coordinatorId2: cordinatorId2, coordinatorId3: cordinatorId3  },
	                    	                            function ( data ){
	                    	                                if(data == "true"){
	                    	                                    alert("Coordenadores atualizados");
	                    	                                    location.reload();
	                    	                                }
	                    	                                else{
	                    	                                	$.post("<?= $this->config->item('url_link'); ?>summercamps/updateCoordinator",
	                	                    	                        { camp_id: campId, coordinatorId1: coordinatorId1, coordinatorId2: coordinatorId2, coordinatorId3: coordinatorId3  });
	                    	                                    alert("Erro ao atualizar coordenadores");
	                    	                                    location.reload();
	                    	                                }
	                    	                            }
	                    	                    );
	                                    }
	                                    else{
	                                        alert("Erro ao atualizar coordenadores");
	                                        location.reload();
	                                    }
	                                }
	                        );
	                } else {
	                	$.post("<?= $this->config->item('url_link'); ?>summercamps/existStaffByFunction",
    	                        { camp_id: campId, func: func },
    	                            function ( data ){
    	                                if(data == "true"){
    	                                	$.post("<?= $this->config->item('url_link'); ?>summercamps/deleteCoordinator",
    	            	                            { camp_id: campId });
    	                                    alert("Coordenador atualizado");
    	                                    location.reload();
    	                                }
    	                                else{
    	                                	alert("Por favor, selecione uma pessoa para ser coordenadora.");
    	            	                    location.reload();
    	                                }
    	                            }
    	                    );
	                }
            }

            function updateDoctor(campId,oldDoctorId) {
                var doctorId = $("#doctor").val();
                var func = 3;
                
                if(doctorId != '' && doctorId > 0){
                    $.post("<?= $this->config->item('url_link'); ?>summercamps/deleteDoctor",
                        { camp_id: campId},
                            function ( data ){
                                if(data == "true"){
                                	$.post("<?= $this->config->item('url_link'); ?>summercamps/updateDoctor",
                                            { camp_id: campId, person_id: doctorId}, 
                                            function(data){
                                            	if(data == "true"){
                                    				alert("Médico atualizado");
                                    				location.reload();
                                            	}
                                            	else{
                                            		$.post("<?= $this->config->item('url_link'); ?>summercamps/updateDoctor",
                                                            { camp_id: campId, person_id: oldDoctorId});
                                            		alert("Erro ao atualizar médico");
                                                    location.reload();
                                            	}
                                			});
                                }
                                else{
                                    alert("Erro ao atualizar médico");
                                    location.reload();
                                }
                            }
                    );
                } else {
                	$.post("<?= $this->config->item('url_link'); ?>summercamps/existStaffByFunction",
	                        { camp_id: campId, func: func },
	                            function ( data ){
	                                if(data == "true"){
	                                	$.post("<?= $this->config->item('url_link'); ?>summercamps/deleteDoctor",
	            	                            { camp_id: campId });
	                                	alert("Médico atualizado");
	                                	location.reload();
	                                }
	                                else{
	                                    alert("Por favor, selecione uma pessoa para ser médica.");
	                                    location.reload();
	                                }
	                            }
	                    );
                }
            }

            function updateMonitor(campId, oldMonitorId1, oldMonitorId2, oldMonitorId3, oldMonitorId4, oldMonitorId5, oldMonitorId6, oldMonitorId7, oldMonitorId8, oldMonitorId9, oldMonitorId10, oldMonitorId11, oldMonitorId12,oldMonitorId13) {
                var monitorId1 = $("#monitores_1F").val();
                var monitorId2 = $("#monitores_2F").val();
                var monitorId3 = $("#monitores_3F").val();
                var monitorId4 = $("#monitores_4F").val();
                var monitorId5 = $("#monitores_5F").val();
                var monitorId6 = $("#monitores_6F").val();
                var monitorId7 = $("#monitores_7F").val();
                var monitorId8 = $("#monitores_1M").val();
                var monitorId9 = $("#monitores_2M").val();
                var monitorId10 = $("#monitores_3M").val();
                var monitorId11 = $("#monitores_4M").val();
                var monitorId12 = $("#monitores_5M").val();
                var monitorId13 = $("#monitores_6M").val();
                var func = 2;
                
                if( monitorId1!=0 || monitorId2!=0 || monitorId3!=0 || monitorId4!=0 || monitorId5!=0 || monitorId6!=0 || monitorId7!=0 || monitorId8!=0 || monitorId9!=0 || monitorId10!=0 || monitorId11!=0 || monitorId12!=0 || monitorId13 != 0){
                	$.post("<?= $this->config->item('url_link'); ?>summercamps/deleteMonitor",
                            { camp_id: campId },
                                function ( data ){
                                    if(data == "true"){
				                               $.post("<?= $this->config->item('url_link'); ?>summercamps/updateMonitor",
						                        { camp_id: campId, monitorId1: monitorId1, monitorId2: monitorId2, monitorId3: monitorId3, monitorId4: monitorId4, monitorId5: monitorId5, monitorId6: monitorId6, monitorId7: monitorId7, monitorId8: monitorId8, monitorId9: monitorId9, monitorId10: monitorId10, monitorId11: monitorId11, monitorId12: monitorId12, monitorId13:monitorId13 },
						                            function ( data ){
						                                if(data == "true"){
						                                    alert("Monitores atualizados");
						                                    location.reload();
						                                }
						                                else{
						                                	$.post("<?= $this->config->item('url_link'); ?>summercamps/updateMonitor",
						                                            { camp_id: campId, monitorId1: oldMonitorId1, monitorId2: oldMonitorId2, monitorId3: oldMonitorId3, monitorId4: oldMonitorId4, monitorId5: oldMonitorId5, monitorId6: oldMonitorId6, monitorId7: oldMonitorId7, monitorId8: oldMonitorId8, monitorId9: oldMonitorId9, monitorId10: oldMonitorId10, monitorId11: oldMonitorId11, monitorId12: oldMonitorId12,monitorId13:oldMonitor13Id });
						                                    alert("Erro ao atualizar monitores");
						                                    location.reload();
						                                }
						                            }
						                    );
                                    }
                                    else{
                                        alert("Erro ao atualizar monitores");
                                        location.reload();
                                    }
                            }
                            );
                } else {
                	$.post("<?= $this->config->item('url_link'); ?>summercamps/existStaffByFunction",
	                        { camp_id: campId, func: func },
	                            function ( data ){
	                                if(data == "true"){
	                                	$.post("<?= $this->config->item('url_link'); ?>summercamps/deleteMonitor",
	            	                            { camp_id: campId });
	                                	alert("Monitores atualizados");
	                                	location.reload();
	                                }
	                                else{
	                                    alert("Por favor, selecione uma pessoa para ser monitor.");
	                                    location.reload();
	                                }
	                            }
	                    );
                }
            }
            function addAssistant(campId,number) {
                var assistantId = $("#assistant"+number).val();
                var room = '';
                if(assistantId != '' && assistantId > 0){
                    $.post("<?= $this->config->item('url_link'); ?>summercamps/addAssistant",
                        { camp_id: campId, person_id: assistantId },
                            function ( data ){
                                if(data == "true"){
                                    alert("Auxiliar adicionado");
                                    location.reload();
                                }
                                else{
                                    alert("Erro ao adicionar auxiliar");
                                    location.reload();
                                }
                            }
                    );
                } else {
                    alert("Por favor, selecione uma pessoa para ser auxiliar.");
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
                                    alert("Auxiliar excluído");
                                    location.reload();
                                }
                                else{
                                    alert("Erro ao excluir auxiliar");
                                    location.reload();
                                }
                            }
                    );
                } 
            }

            function updateAssistant(campId,number,oldAssistantId) {
            	var assistantId = $("#assistant"+number).val();
            	
                if(assistantId != '' && assistantId > 0){
                    $.post("<?= $this->config->item('url_link'); ?>summercamps/deleteAssistant",
                        { camp_id: campId, person_id: oldAssistantId},
                            function ( data ){
                                if(data == "true"){
                                	$.post("<?= $this->config->item('url_link'); ?>summercamps/addAssistant",
                                            { camp_id: campId, person_id: assistantId },
                                                function ( data ){
                                                    if(data == "true"){
                                                        alert("Auxiliar atualizado");
                                                    }
                                                    else{
                                                    	$.post("<?= $this->config->item('url_link'); ?>summercamps/addAssistant",
                                                                { camp_id: campId, person_id: oldAssistantId });;
                                                        alert("Erro ao atualizar auxiliar");
                                                        location.reload();
                                                    }
                                                }
                                        );
                                }
                                else{
                                    alert("Erro ao atualizar assistente");
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
                        $monitors = array(1 => null, 2 => null, 3 => null, 4 => null, 5 => null, 6 => null, 7 => null, 8 => null, 9 => null, 10 => null, 11 => null, 12 => null, 13 => null);
                        $coordinators = array(1 => null, 2 => null, 3 => null);
                        $coordinatorsId = array(1 => 0, 2 => 0, 3 => 0);
                        $monitorsId = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0,13 => 0);
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
	                                	else if($s->room_number == '7F')
	                                		$room = 7;
	                                	else if($s->room_number == '1M')
	                                		$room = 8;
	                                	else if($s->room_number == '2M')
	                                		$room = 9;
	                                	else if($s->room_number == '3M')
	                                		$room = 10;
	                                	else if($s->room_number == '4M')
	                                		$room = 11;
	                                	else if($s->room_number == '5M')
	                                		$room = 12;
	                                	else if($s->room_number == '6M')
	                                		$room = 13;
	                                	
	                                    $monitors[$room] = $s;
                                	}
                                }
                            }
                        }
                    ?>
                    <h3><b>Equipe: <?=$summerCamp->getCampName();?></b></h3>

                    <p>
                    <br />
                        <h4><b>Coordenadores:</b> </h4>
                        <table class="sortable-table" style="max-width: 500px;" >
                            <thead> 
                            <tr>
                                <th>Nome</th>
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
			                        <select name="coordinator" id="coordinator_<?=$i?>">
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
			                    </tr>
			                    <?php $i++;}?>
			             </tbody>
			           </table>
                    </p>
                    <button class="btn btn-primary" onClick="updateCoordinator(<?=$summerCamp->getCampId();?>,<?= $coordinatorsId[1]?>,<?= $coordinatorsId[2]?>,<?= $coordinatorsId[3]?>)">Salvar </button>
                    <br /><br />
                    <p>
                       <h4><b> Médico: </b></h4>
                        <table class="sortable-table" style="max-width: 500px;" >
                            <thead> 
                            <tr>
                                <th>Nome</th>
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
		                       </tr>
		                </tbody>
		                </table>
                    </p>
					<button class="btn btn-primary" onClick="updateDoctor(<?=$summerCamp->getCampId();?>,'<?php if(isset($doctor->person_id)) echo $doctor->person_id;?>')">Salvar </button>
                    <p>
                    <br /><br />
                       <h4><b> Monitores:</b></h4>
                        <table class="sortable-table" id="sortable-table" style="max-width: 500px;">
                            <thead> 
                            <tr>
                                <th>Nome</th>
                                <th>Quarto</th>
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
                                        	if($j<=7) {
                                        		if($possibleFemaleMonitors!=null)
                                        		foreach ($possibleFemaleMonitors as $pm ) {
                                        			$selected = "";
                                        			if ($monitor != null && $pm->getPersonId() == $monitor->person_id){
                                        				$selected = "selected";
                                        				$monitorsId[$j] = $monitor->person_id;
                                        			}
                                        			echo "<option $selected value='".$pm->getPersonId()."'>".$pm->getFullname()."</option>";
                                        		}                                        		
                                        	}
                                        	else{
                                        		if($possibleMaleMonitors!=null)
		                                        foreach ($possibleMaleMonitors as $pm ) {
		                                            $selected = "";
		                                            if ($monitor != null && $pm->getPersonId() == $monitor->person_id){
                                        				$selected = "selected";
                                        				$monitorsId[$j] = $monitor->person_id;
                                        			}
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
                            </tr>

                            <?php
                            		if($i == 7){
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
                     <button class="btn btn-primary" onClick="updateMonitor(<?=$summerCamp->getCampId();?>,<?= $monitorsId[1]?>,<?= $monitorsId[2]?>,<?= $monitorsId[3]?>,<?= $monitorsId[4]?>,<?= $monitorsId[5]?>,<?= $monitorsId[6]?>,<?= $monitorsId[7]?>,<?= $monitorsId[8]?>,<?= $monitorsId[9]?>,<?= $monitorsId[10]?>,<?= $monitorsId[11]?>,<?= $monitorsId[12]?>, <?= $monitorsId[13]?>)">Salvar </button>
                    <p><br /><br />
                       <h4><b> Auxiliares: </b> </h4>
                        <table class="sortable-table" style="max-width: 500px;" >
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
		                        	<button class="btn btn-primary" onClick="updateAssistant(<?=$summerCamp->getCampId();?>,<?=$i?>,'<?php if(isset($assistants[$i]->person_id)) echo $assistants[$i]->person_id;?>')">Salvar </button>
		                       </td>
		                       <td>
		                        	<button class="btn btn-danger" onClick="deleteAssistant(<?=$summerCamp->getCampId();?>,<?=$i?>)">Excluir</button>
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
		                        	<button class="btn btn-primary" onClick="addAssistant(<?=$summerCamp->getCampId();?>,<?=$i?>)">Salvar </button>
		                       </td>
		                   </tr>
		                </tbody>
		                </table>
                    </p> 
                    
                </div>
            </div>
            <br />
            <button class="btn btn-warning" class="button" onclick="self.close()" value="Fechar">Fechar</button>                    
        </div>

    </body>
</html>
