<style>
	span {
		font-size: 12px;
	}
</style>

<table width="100%">
     <?php 
            if($type == "Contatos" || $type == "Simples" || $type == "Documentos" || $type == "Cadastros") { ?>
    <tr>
        <td align="center">
       
            	<h1><?= $summercamp ?></h1></td>
    </tr>
    <?php if($type == "Contatos" || $type == "Documentos" || $type == "Cadastros"){?>
    <tr>
        <td align="center">
            <h1><?php if($type == "Contatos"){?>Contatos dos Colonistas<?php } else if($type == "Documentos") {?>Documentos dos Colonistas<?php } else if($type == "Cadastros") {?>Cadastros dos Colonistas<?php }?></h1>
        </td>
    </tr>
     <?php }?>
     <tr>
        <td align="center">
        <br>
            <h1><?= $room ?></h1>
        </td>
     </tr>
           <?php  } else if($type == "Listagem de Inscrições") {?>
      <tr>
      	<td align="center">
            <h1><?= $type ?></h1>
        </td>
    </tr>
    <tr>
        <td align="center">
            <?php
            if ($filtros) {
                echo "<br><h3>Filtros utilizados:</h3>";
                foreach ($filtros as $filtro) {
                    echo $filtro . "<br>";
                }
            } else {
                echo "<br><br><br><br>";
            }
            ?>
        </td>
    </tr>
    <?php }?>
</table>
<br><br><br><br><br><br><br><br><br>

<?php 
if($type=="Simples"){
	foreach ($report as $colonist) {
		?>
		    <div class="row">
		        <div class="col-lg-12 middle-content">
		            <div class="row">
		            <br>
		                <span><strong><?= $colonist['colonist']->fullname ?></strong></span><br/>
		                </div>
		                </div>
		                </div>
	<?php }}
else if($type == "Documentos"){
	foreach ($report as $colonist) {
		?>
		    <div class="row">
		        <div class="col-lg-12 middle-content">
		            <div class="row">
		            <br>
		            <table>
		            	<tr>
		                <td><strong><?= $colonist['colonist']->fullname ?></strong></td>
		                <td><strong><?= $colonist['colonist']->fullname ?></strong></td>
		                <td><strong><?= $colonist['colonist']->fullname ?></strong></td>
		                </tr>
		                </table>
		                </div>
		                </div>
		                </div>
	<?php }}
else if($type == "Contatos" || $type == "Listagem de Inscrições" || $type == "Cadastros"){ 
	
	
	if($type == "Contatos" || $type == "Listagem de Inscrições" || "Cadastros")
		{$colunistsNumber = 2;}
		
foreach ($report as $colonist) {
	
	if($type == "Cadastros" && $colonist['minik'] != null){ ?>
	   	    		<p style="page-break-before: always"></p>
<?php } else if($type == "Contatos" || $type == "Listagem de Inscrições" || "Cadastros") {
	   		$colunistsNumber++; if($colunistsNumber == 3) { $colunistsNumber = 0; ?>
	    		<p style="page-break-before: always"></p>
	    <?php }}
    ?>
    <div class="row">
        <div class="col-lg-12 middle-content">
            <div class="row">
            <br>
            <table>
                    <tr>
                        <td>
                <h3><strong><?= $colonist['colonist']->fullname ?></strong></h3>
                <span><strong>Sexo: </strong><?php
                if ($colonist['colonist']->gender == 'M') {
                    echo "Masculino";
                    $amigo = "Amigo";
                } else {
                    echo "Feminino";
                    $amigo = "Amiga";
                }
                ?></span><br />
                <span><strong>Data nascimento: </strong><?= date("d/m/Y", strtotime($colonist['summercamp']->birth_date)); ?></span><br />
                <span><strong>Escola: </strong><?= $colonist['summercamp']->school_name ?></span><br>
                <span><strong>Ano escolar: </strong><?= $colonist['summercamp']->school_year ?></span><br>
                <span><strong>Número Quarto: </strong><?= $colonist['summercamp']->room_number ?></span><br>
                <span><strong>Telefone(s): </strong> <?= $colonist['colonist']->phone1 ?> -- <?= $colonist['colonist']->phone2 ?></span><br>
                <br>
                <?php if($type == "Contatos") {} else if($type == "Listagem de Inscrições" || ($type == "Cadastros" && $colonist['minik'] != null)){?>
                <span><strong><?= $amigo ?> 1: </strong><?= $colonist['summercamp']->roommate1 ?></span><br>
                <span><strong><?= $amigo ?> 2: </strong><?= $colonist['summercamp']->roommate2 ?></span><br>
                <span><strong><?= $amigo ?> 3: </strong><?= $colonist['summercamp']->roommate3 ?></span><br>
           
                <br>
                <?php }?>
                </td>
              	</tr>
               </table>

                <table>
                    <tr>
                        <td>
                            <?php
                            $key = 'father';
                            $person = 'Pai';
                            if ($colonist[$key]) {
                                ?>
                                <span><strong><?= $person ?>:</strong></span><br>
                                <span><strong>Nome: </strong><?= $colonist[$key]->fullname ?></span><br>
                                <span><strong>Telefone(s): </strong> <?= $colonist[$key]->phone1 ?> <?= $colonist[$key]->phone2 ?></span><br>
                                <span><strong>E-mail: </strong> <?= $colonist[$key]->email ?></span><br>
                                <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $key = 'mother';
                            $person = 'Mãe';
                            if ($colonist[$key]) {
                                ?>
                                <span><strong><?= $person ?>:</strong></span><br>
                                <span><strong>Nome: </strong><?= $colonist[$key]->fullname ?></span><br>
                                <span><strong>Telefone(s): </strong> <?= $colonist[$key]->phone1 ?> <?= $colonist[$key]->phone2 ?></span><br>
                                <span><strong>E-mail: </strong> <?= $colonist[$key]->email ?></span><br>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>

                </table>
			                <?php
			                $key = 'responsable';
			                $person = 'Responsável';
			                if ($colonist[$key]) {
			                    ?>
			                    <table>
                   					 <tr>
                        				<td>
						                    <span><strong><?= $person ?>:</strong></span><br>
						                    <span><strong>Nome: </strong><?= $colonist[$key]->fullname ?></span><br>
						                    <span><strong>Telefone(s): </strong> <?= $colonist[$key]->phone1 ?> -- <?= $colonist[$key]->phone2 ?></span><br>
						                    <span><strong>E-mail: </strong> <?= $colonist[$key]->email ?></span><br>
                    					</td>
                					</tr>
                				</table>
                	<?php
                } if($type == "Cadastros" && $colonist['minik'] != null) {
                ?>
                	<table>
                		<tr>
                			<td colspan="4">
                				<span><b>Nome do responsável para comunicação imediata em caso de emergência:</b></span>
                				<br>
                				<span><?php echo $colonist['minik'] -> responsible_name;?></span>
                			</td>
                		</tr>
                		<tr>
                			<td colspan="4">
                				<span><b>Telefone do responsável para comunicação em caso de emergência:</b></span>
                				<br>
                				<span><?php echo $colonist['minik'] -> responsible_number;?></span>
                			</td>
                		</tr>
                		<tr>
                			<td colspan='2'>
                				<span><b>Já dormiu fora de casa?</b></span>
                				<br>
                				<span><?php if($colonist['minik'] ->sleep_out == FALSE) { echo "Não";} else { echo "Sim";} ?></span>
                			</td>
                			<td colspan='2'>
                				<span><b>O colonista costuma acordar cedo?</b></span>
                				<br>
                				<span><?php if($colonist['minik'] ->wake_up_early == FALSE) { echo "Não";} else { echo "Sim";} ?></span>
                			</td>
                		</tr>
                		<tr>
                			<td colspan='2'>
                				<span><b>Alimenta-se com independência?</b></span>
                				<br>
                				<span><?php if($colonist['minik'] ->eat_by_oneself == FALSE) { echo "Não";} else { echo "Sim";} ?></span>
                			</td>
                			<td colspan='2'>
                				<span><b>Tem autonomia em relação ao uso do banheiro?</b></span>
                				<br>
                				<span><?php if($colonist['minik'] ->bathroom_freedom == FALSE) { echo "Não";} else { echo "Sim";} ?></span>
                			</td>
                		</tr>
                		<tr>
                			<td colspan='2'>
                				<span><b>O colonista tem algum tipo de rotina, ou ritual para adormecer?</b></span>
                				<br>
                				<span><?php if($colonist['minik'] ->sleep_routine == FALSE) { echo "Não";} else { echo "Sim";} ?></span>
                			</td>
                			<td colspan='2'>
                				<span><b>Possui alguma restrição quanto ao uso das camas de cima de um beliche?</b></span>
                				<br>
                				<span><?php if($colonist['minik'] ->bunk_restriction == FALSE) { echo "Não";} else { echo "Sim";} ?></span>
                			</td>
                		</tr>
                		<tr>
                			<td colspan='2'>
                				<span><b>Costuma acordar a noite?</b></span>
                				<br>
                				<span><?php if($colonist['minik'] ->wake_up_at_night == FALSE) { echo "Não";} else { echo "Sim";} ?></span>
                			</td>
                			<td colspan='2'>
                				<span><b>Apresenta sonambulismo?</b></span>
                				<br>
                				<span><?php if($colonist['minik'] ->sleepwalk == FALSE) { echo "Não";} else { echo "Sim";} ?></span>
                			</td>
                		</tr>
                		<tr>
                			<td colspan='2'>
                				<span><b>Apresenta enurese noturna?</b></span>
                				<br>
                				<span><?php if($colonist['minik'] ->sleep_enuresis == FALSE) { echo "Não";} else { echo "Sim";} ?></span>
                			</td>
                			<td colspan='2'>
                				<span><b>Possui restrição alimentar? Qual?</b></span>
                				<br>
                				<span><?php if($colonist['minik'] ->food_restriction == "") { echo "Não";} else { echo $colonist['minik'] ->food_restriction;}?></span>
                			</td>
                		</tr>
                		<tr>
                			<td colspan = "4">
                				<span><b>Há algo mais que seja relevante para a adaptação do colonista que você queira registrar?</b></span>
                				<br>
                				<span><?php if($colonist['minik'] -> observation == "") { echo "Não";} else{ echo $colonist['minik'] -> observation;} ?></span>
                			</td>
                		</tr>
                	
                	</table>
                <?php }?>
                
            </div>
        </div>
    </div>
   <?php 
   }?>
    <?php
}?>
