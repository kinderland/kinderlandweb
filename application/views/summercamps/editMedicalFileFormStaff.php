 <script type="text/javascript"> 

/*
 function createPDFMedicalFilest() {
	    var a = "<?= $this->config->item('url_link'); ?>summercamps/generatePDFWithColonistMedicalFiles/<?=$ano_escolhido?>/<?=(isset($summer_camp_id)?$summer_camp_id:'')?>/<?=(isset($pavilhao)?$pavilhao:'')?>/<?=(isset($quarto)?$quarto:'')?>/<?=(isset($type)?$type:'')?>";
	    window.location.href = a;
	}
*/

 </script>
<div id="cabecalho">
	<p align="right" style="color:red">
		O símbolo * indica preenchimento obrigatório!
	</p>
	<p>
		<u><b><span style="color:red">Atenção:</span> cabe ao responsável pela pré-inscrição garantir que as informações 
		abaixo são corretas e verídicas. Recomendamos fortemente que, em caso de dúvidas, 
		um médico seja consultado antes da confirmação do envio desta ficha médica.
		</b></u>
	</p>
</div>

<div id='form'>
	<?php if($editable) {
		$disabled = ""; ?>
	<form enctype="multipart/form-data" action="<?= $this -> config -> item('url_link'); ?>summercamps/editMedicalFileStaff" method="post">
	<?php } else {
		$disabled = "disabled";
	} ?>

<script>

	$(document).ready(function() {

		$(('input:radio')).each(function() {
			name = ($(this).attr('name'));
			name_vector = name.split("_");
			name_textArea = name_vector[0] + "_text"
			value = $('input:radio[name=' + name + ']:checked').val();
			if (value == 1) {
				$('#' + name_textArea).show();
				if("<?=$disabled?>" == "")
					$('#' + name_textArea).prop('disabled', false);			
				
			} else {
				$('#' + name_textArea).hide();
				$('#' + name_textArea).prop('disabled', true);			
			}
		})
		
		var SPMaskBehavior = function (val) {
          return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
          onKeyPress: function(val, e, field, options) {
              field.mask(SPMaskBehavior.apply({}, arguments), options);
            },
          onChange: function(val, e, field, options) {
              field.mask(SPMaskBehavior.apply({}, arguments), options);
          }
        };
        $(".phone").mask(SPMaskBehavior, spOptions);
        $("#cep").mask("00000-000");
        $("#cpf").mask("000.000.000-00");


		$(('input:radio')).click(function() {
			name = ($(this).attr('name'));
			name_vector = name.split("_");
			name_textArea = name_vector[0] + "_text"
			value = $('input:radio[name=' + name + ']:checked').val();
			if (value == 1) {
				$('#' + name_textArea).show();
				$('#' + name_textArea).prop('disabled', false);			
				
			} else {
				$('#' + name_textArea).hide();
				$('#' + name_textArea).prop('disabled', true);			
			}
		})
	}); 
    
</script>

		<!--
		<input type="hidden" name="camp_id" value="<?=$camp_id ?>" />
		<input type="hidden" name="colonist_id" value="<?=$colonist_id ?>" />
		-->
		<input type="hidden" name="person_id" value="<?=$person_id ?>" />
		<table class="table table-bordered" border=1 align="center">
			<tr>
				<td width = "25%"><span class="required"><b>*Grupo Sanguíneo:</b></span>
				<select name="bloodType" value="Selecione" required <?=$disabled?> 
                        oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                               onchange="setCustomValidity('')"

>
					<option value="">-- Selecione --</option>
					<option value="<?=BLOOD_TYPE_A ?>" <?php if (!empty($bloodType) && ($bloodType == BLOOD_TYPE_A)) echo "selected" ?>>A</option>
					<option value="<?=BLOOD_TYPE_B ?>" <?php if (!empty($bloodType) && ($bloodType == BLOOD_TYPE_B)) echo "selected" ?>>B</option>
					<option value="<?=BLOOD_TYPE_O ?>" <?php if (!empty($bloodType) && ($bloodType == BLOOD_TYPE_O)) echo "selected" ?>>O</option>
					<option value="<?=BLOOD_TYPE_AB ?>" <?php if (!empty($bloodType) && ($bloodType == BLOOD_TYPE_AB)) echo "selected" ?>>AB</option>
				</select></td>
				<td width = "25%"><span class="required"><b>*Fator RH:</b></span>
				<select name="rh" value="Selecione" required <?=$disabled?>
                        oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                               onchange="setCustomValidity('')"

>
					<option value="">-- Selecione --</option>
					<option value="t" <?php if (!empty($rh) && ($rh === "t")) echo "selected" ?>>Positivo</option>
					<option value="f" <?php if (!empty($rh) && ($rh === "f")) echo "selected" ?>>Negativo</option>
				</select></td>

				<td width = "25%"><span><b>*Peso:</b></span>
				<input type="text" class="nome" <?=$disabled?> onkeypress='return event.charCode >= 48 && event.charCode <= 57' required maxlength="3" name="weight" size="4px" 					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" value="<?=$weight?>"
>
				kg </td>
				<td width = "25%"><span><b>*Altura:</b></span>
				<input type="text" class="nome" <?=$disabled?> onkeypress='return event.charCode >= 48 && event.charCode <= 57' required maxlength="4" name="height" id="height" size="4px" 					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" value="<?=$height?>">
				cm </td>
			</tr>
			<tr>
				<td colspan="2">
				<p class="required">
					<b>*Alguma restrição à atividade física (esportes, natação, caminhadas...)?</b>
					<br>
					<input type="radio" name="physicalrestrictions_radio" <?=$disabled?> value="0" required <?php if ($physicalActivityRestriction == NULL) echo "checked" ?> >
					Não se aplica
					<br>
					<input type="radio" name="physicalrestrictions_radio" <?=$disabled?> value="1" required <?php if ($physicalActivityRestriction != NULL) echo "checked" ?>                         oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                               onclick="setCustomValidity('')"
>
					Se aplica
					<br>
					<textarea id="physicalrestrictions_text" style="display:none;" disabled rows="2" cols="50" class="nome" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')" <?=$disabled?>
					onchange="setCustomValidity('')"
 name="physicalrestrictions_text"><?=$physicalActivityRestriction?></textarea>
				</p></td>
				<td colspan="2">
				<p class="required">
					<b>*Vacinas em dia?</b>
					<br>
					<span align="right" style="color:red">
						Informe a situação atual. Mas é fundamental estarem em dia até a colônia.
					</span>
					<span class="required"><b>*Anti-Tetânica:</b></span>
					<select class="required" name="antiTetanus" required <?=$disabled?>

>
						<option value="">-- Selecione --</option>
						<option value="t" <?php if (!empty($vacineTetanus) && ($vacineTetanus === "t")) echo "selected" ?> >Sim</option>
						<option value="f" <?php if (!empty($vacineTetanus) && ($vacineTetanus === "f")) echo "selected" ?>>Não</option>
					</select>
					<br>
					<span class="required"><b>*MMR (Caxumba, Rubéola, Sarampo):</b></span>
					<select class="required" name="MMR" required <?=$disabled?>

>
						<option value ="">-- Selecione --</option>
						<option value="t" <?php if (!empty($vacineMMR) && ($vacineMMR === "t")) echo "selected" ?> >Sim</option>
						<option value="f" <?php if (!empty($vacineMMR) && ($vacineMMR === "f")) echo "selected" ?>>Não</option>
					</select>
					<br>
					<span class="required"><b>*Hepatite A:</b></span>
					<select class="required" name="vacineHepatitis" required <?=$disabled?>

>
						<option value="">-- Selecione --</option>
						<option value="t" <?php if (!empty($vacineHepatitis) && ($vacineHepatitis === "t")) echo "selected" ?> >Sim</option>
						<option value="f" <?php if (!empty($vacineHepatitis) && ($vacineHepatitis === "f")) echo "selected" ?>>Não</option>
					</select>
					<br>
					<span class="required"><b>*Febre amarela:</b></span>
					<select class="required" name="vacineYellowFever" required <?=$disabled?>

>
						<option value="">-- Selecione --</option>
						<option value="t" <?php if (!empty($vacineYellowFever) && ($vacineYellowFever === "t")) echo "selected" ?> >Sim</option>
						<option value="f" <?php if (!empty($vacineYellowFever) && ($vacineYellowFever === "f")) echo "selected" ?>>Não</option>
					</select>
					<br>
				</p></td>
			</tr>
			<tr>
				<td colspan="4">
				<p>
					<b>*Antecedentes Infecto-Contagiosos?</b>
					<br>
					<input type="radio" name="antecedents_radio" value="0" required <?=$disabled?>   <?php if ($antecedents == NULL) echo "checked" ?>
>
					Não se aplica
					<br>
					<input type="radio" name="antecedents_radio" value="1" <?=$disabled?>  <?php if ($antecedents != NULL) echo "checked" ?> >
					Se aplica
					<br>
					<textarea id="antecedents_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" <?=$disabled?>
 rows="2" disabled cols="100" class="nome required" name="antecedents_text"><?=$antecedents?></textarea>
				</p></td>
			</tr>

			<tr>
				<td colspan="2">
				<p class="required">
					<b>*Medicamentos Habituais ou de uso regular
					<br>
					(<u>anotar horários e dosagens</u>):</b>
					<br>
					<input type="radio" name="habitualmedicine_radio" <?=$disabled?> value="0" required <?php if ($regularUseMedicine == NULL) echo "checked" ?> >
					Não se aplica
					<br>
					<input type="radio" name="habitualmedicine_radio" <?=$disabled?> value="1" <?php if ($regularUseMedicine != NULL) echo "checked" ?>>
					Se aplica
					<br>
					<textarea id="habitualmedicine_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')" <?=$disabled?>
					oninput="setCustomValidity('')"
  rows="2" disabled cols="50" name="habitualmedicine_text" class="required"><?=$regularUseMedicine?></textarea>
					<br>
				</p></td>
				<td colspan="2">
				<p>
					<b>*Restrições Medicamentosas:</b>
					<br>
					<input type="radio" name="medicinerestrictions_radio" value="0" required <?=$disabled?>  <?php if ($medicineRestrictions == NULL) echo "checked" ?>

>
					Não se aplica
					<br>
					<input type="radio" name="medicinerestrictions_radio" value="1" <?=$disabled?> <?php if ($medicineRestrictions != NULL) echo "checked" ?>>
					Se aplica
					<br>
					<textarea id="medicinerestrictions_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')" <?=$disabled?>
					oninput="setCustomValidity('')"
 rows="3" disabled cols="50" name="medicinerestrictions_text" class="required"><?=$medicineRestrictions?></textarea>
					<br>
				</p></td>
			</tr>

			<tr>
				<td colspan="2">
				<p>
					<b>*Alergias (Alimentares/Respiratórias/De Contato):</b>
					<br>
					<input type="radio" name="allergies_radio" value="0" required <?=$disabled?> <?php if ($allergies == NULL) echo "checked" ?>
>
					Não se aplica
					<br>
					<input type="radio" name="allergies_radio" id="sim1" value="1" <?=$disabled?> <?php if ($allergies != NULL) echo "checked" ?>>
					Se aplica
					<br>
					<textarea id="allergies_text" style="display:none;" required <?=$disabled?>                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')"
 rows="2" disabled cols="50" name="allergies_text" class="required"><?=$allergies?></textarea>
					<br>
				</p></td>
				<td colspan="2">
				<p>
					<b>*Antitérmico/Analgésico Habitual (<u>Indicar dose</u>):</b>
					<br>
					<input type="radio" name="analgesicantipyretic_radio" value="0" <?=$disabled?> required <?php if ($analgesicAntipyretic == NULL) echo "checked" ?>

>
					Não se aplica
					<br>
					<input type="radio" name="analgesicantipyretic_radio" id="sim1" value="1" <?=$disabled?> <?php if ($analgesicAntipyretic != NULL) echo "checked" ?>>
					Se aplica
					<br>
					<textarea id="analgesicantipyretic_text" style="display:none;" required                 <?=$disabled?>                
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')"
 required rows="2" cols="50" name="analgesicantipyretic_text" disabled class="required"><?=$analgesicAntipyretic?></textarea>
					<br>
				</p></td>
			</tr>


			<tr>
				<td colspan="4">
				<p>
					<b>*O colonista necessita de algum cuidado médico especial?</b>
					<br>
					<input type="radio" name="specialcare_radio" value="0" required <?=$disabled?>   <?php if ($specialCareMedical == NULL) echo "checked" ?>
>
					Não se aplica
					<br>
					<input type="radio" name="specialcare_radio" id="siml" value="1" <?=$disabled?>  <?php if ($specialCareMedical != NULL) echo "checked" ?> >
					Se aplica
					<br>
					<textarea id="specialcare_text" style="display:none;" required  <?=$disabled?>                               
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" 
 required rows="2" cols="100" name="specialcare_text" disabled class="required"><?=$specialCareMedical?></textarea>
				</p></td>
			</tr>

			<tr>
				<td colspan="4">
				<p>
					<b>*O colonista toma medicamentos psiquiatricos ou medicacao para deficit de atencao ou de comportamento?</b>
					<br>
					<input type="radio" name="psych_radio" value="0" required <?=$disabled?>   <?php if ($psychMedication == NULL) echo "checked" ?>
>
					Não se aplica
					<br>
					<input type="radio" name="psych_radio" id="siml" value="1" <?=$disabled?>  <?php if ($psychMedication != NULL) echo "checked" ?> >
					Se aplica
					<br>
					<textarea id="psych_text" style="display:none;" required  <?=$disabled?>                               
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" 
 required rows="2" cols="100" name="psych_text" disabled class="required"><?=$psychMedication?></textarea>
				</p></td>
			</tr>

			<tr>






			<tr>
				<td colspan="4">
				<p class="campo">
					<b>Observações:</b>
					<ol style="font-size:12px">
						<li>
							Caso seja iniciado algum tratamento no período da colônia, favor informar até o dia anterior ao embarque. Favor enviar também
							receita médica e medicamento.
						</li>
						<li>
							Em caso de emergência, o atendimento à criança no hospital mais próximo será sempre priorizado e os responsáveis serão
							devidamente informados.
						</li>
						<li>
							Os medicamentos prescritos e aplicados na colônia serão registrados no livro de ocorrências.
						</li>
						<li>
							Sugerimos que as informações aqui presentes sejam avalizadas pelo médico do colonista. Entretanto, apenas o responsável pela
							inscrição responde pelas informações aqui constantes.
						</li>
					</ol>
				</p></td>
			</tr>

			<tr>
				<td colspan="4">
				<p class="divisoria">
					<b>CONTATO DO MÉDICO RESPONSÁVEL PELOS DADOS NESTA FICHA</b>
				</p></td>
			</tr>

			<tr>
				<td colspan="3">
				<p class="campo">
					<b>*Nome do Médico:</b>
					<input type="text" id="doctor_name" name="doctor_name" required <?=$disabled?>
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" value="<?=$doctorName?>"
					size="85px">
				</p></td>

				<td>
				<p class="campo">
					<b>*Telefone 1:</b>
					<input type="text" class="form-control phone phone1" name="doctor_phone1" placeholder="(ddd) Telefone de contato" required onkeypress="return validateNumberInput(event);" id="doctor_phone1" required <?=$disabled?>
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" value="<?=$doctorPhone1?>"
					size="15px">
				</p></td>
			</tr>

			<tr>
				<td colspan="3">
				<p class="campo">
					<b>Email:</b>
					<input type="text" id="doctor_email" name="doctor_email" value="<?=$doctorEmail?>" <?=$disabled?> size="85px">
				</p></td>

				<td>
				<p class="campo">
					<b>Telefone 2:</b>
					<input type="text" class="form-control phone" name="doctor_phone2" placeholder="(ddd) Telefone secundário" required onkeypress="return validateNumberInput(event);" id="doctor_phone2" size="15px" value="<?=$doctorPhone2?> <?=$disabled?>">
				</p></td>
			</tr>

			<tr>
				<td colspan="4">
				<p>
					<u><b><span style="color:red">Atenção:</span> cabe ao responsável pela pré-inscrição garantir que as informações 
					abaixo são corretas e verídicas. Recomendamos fortemente que, em caso de dúvidas, 
					um médico seja consultado antes da confirmação do envio desta ficha médica.
					</b></u>
				</p>
				<p class="required">
					<input type="checkbox" required name="responsability" value="Ok" <?=$disabled?>>
					<span style="font-size:20px; color:red">Assumo a responsabilidade pela correção e veracidade das informações desta ficha médica</span>
					<br>
				</p></td>
			</tr>

		</table>
		<input type="submit" class="btn btn-primary" value="Salvar" id="upload">
	</form>
	<br />
	<br />
	<input type="submit" class="btn btn-warning" value="Voltar" id="upload" onClick="history.go(-1);return true;">

</div>



<!--

 <script type="text/javascript"> 

 function createPDFMedicalFilest() {
	   var a = "<?= $this->config->item('url_link'); ?>summercamps/generatePDFWithColonistMedicalFiles/<?=$ano_escolhido?>/<?=(isset($summer_camp_id)?$summer_camp_id:'')?>/<?=(isset($pavilhao)?$pavilhao:'')?>/<?=(isset($quarto)?$quarto:'')?>/<?=(isset($type)?$type:'')?>";
	  //  window.location.href = a; 
	}

 </script>
<div id="cabecalho">
	<p align="right" style="color:red">
		O símbolo * indica preenchimento obrigatório!
	</p>
	<p>
		Atenção: cabe ao responsável pela pré-inscrição garantir que as informações 
		abaixo são corretas e verídicas. Recomendamos fortemente que, em caso de dúvidas, 
		um médico seja consultado antes da confirmação do envio desta ficha médica.
	</p>
</div>

<div id='form'>
	<?php if($editable) {
		$disabled = ""; ?>
	<form enctype="multipart/form-data" action="<?= $this -> config -> item('url_link'); ?>summercamps/editMedicalFileStaff" method="post">
	<?php } else {
		$disabled = "disabled";
	} ?>

<script>

	$(document).ready(function() {

		$(('input:radio')).each(function() {
			name = ($(this).attr('name'));
			name_vector = name.split("_");
			name_textArea = name_vector[0] + "_text"
			value = $('input:radio[name=' + name + ']:checked').val();
			if (value == 1) {
				$('#' + name_textArea).show();
				if("<?=$disabled?>" == "")
					$('#' + name_textArea).prop('disabled', false);			
				
			} else {
				$('#' + name_textArea).hide();
				$('#' + name_textArea).prop('disabled', true);			
			}
		})
		
		var SPMaskBehavior = function (val) {
          return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
          onKeyPress: function(val, e, field, options) {
              field.mask(SPMaskBehavior.apply({}, arguments), options);
            },
          onChange: function(val, e, field, options) {
              field.mask(SPMaskBehavior.apply({}, arguments), options);
          }
        };
        $(".phone").mask(SPMaskBehavior, spOptions);
        $("#cep").mask("00000-000");
        $("#cpf").mask("000.000.000-00");


		$(('input:radio')).click(function() {
			name = ($(this).attr('name'));
			name_vector = name.split("_");
			name_textArea = name_vector[0] + "_text"
			value = $('input:radio[name=' + name + ']:checked').val();
			if (value == 1) {
				$('#' + name_textArea).show();
				$('#' + name_textArea).prop('disabled', false);			
				
			} else {
				$('#' + name_textArea).hide();
				$('#' + name_textArea).prop('disabled', true);			
			}
		})
	}); 
</script>


		<input type="hidden" name="person_id" value="<?=$person_id ?>" />
		<table class="table table-bordered" border=1 align="center">
			<tr>
				<td width = "25%"><span class="required"><b>*Grupo Sanguíneo:</b></span>
				<select name="bloodType" value="Selecione" required <?=$disabled?> 
                        oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                               onchange="setCustomValidity('')"

>
					<option value="">-- Selecione --</option>
					<option value="<?=BLOOD_TYPE_A ?>" <?php if (!empty($bloodType) && ($bloodType == BLOOD_TYPE_A)) echo "selected" ?>>A</option>
					<option value="<?=BLOOD_TYPE_B ?>" <?php if (!empty($bloodType) && ($bloodType == BLOOD_TYPE_B)) echo "selected" ?>>B</option>
					<option value="<?=BLOOD_TYPE_O ?>" <?php if (!empty($bloodType) && ($bloodType == BLOOD_TYPE_O)) echo "selected" ?>>O</option>
					<option value="<?=BLOOD_TYPE_AB ?>" <?php if (!empty($bloodType) && ($bloodType == BLOOD_TYPE_AB)) echo "selected" ?>>AB</option>
				</select></td>
				<td width = "25%"><span class="required"><b>*Fator RH:</b></span>
				<select name="rh" value="Selecione" required <?=$disabled?>
                        oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                               onchange="setCustomValidity('')"

>
					<option value="">-- Selecione --</option>
					<option value="t" <?php if (!empty($rh) && ($rh === "t")) echo "selected" ?>>Positivo</option>
					<option value="f" <?php if (!empty($rh) && ($rh === "f")) echo "selected" ?>>Negativo</option>
				</select></td>

				<td width = "25%"><span><b>*Peso:</b></span>
				<input type="text" class="nome" <?=$disabled?> required maxlength="3" name="weight" size="4px" 					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" value="<?=$weight?>"
>
				kg </td>
				<td width = "25%"><span><b>*Altura:</b></span>
				<input type="text" class="nome" <?=$disabled?> required maxlength="4" name="height" id="height" size="4px" 					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" value="<?=$height?>">
				cm </td>
			</tr>
			<tr>
				<td colspan="2">
				<p class="required">
					<b>*Alguma restrição à atividade física (esportes, natação, caminhadas...)?</b>
					<br>
					<input type="radio" name="physicalrestrictions_radio" <?=$disabled?> value="0" required <?php if ($physicalActivityRestriction == NULL) echo "checked" ?> >
					Não se aplica
					<br>
					<input type="radio" name="physicalrestrictions_radio" <?=$disabled?> value="1" required <?php if ($physicalActivityRestriction != NULL) echo "checked" ?>                         oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                               onclick="setCustomValidity('')"
>
					Se aplica
					<br>
					<textarea id="physicalrestrictions_text" style="display:none;" disabled rows="2" cols="50" class="nome" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')" <?=$disabled?>
					onchange="setCustomValidity('')"
 name="physicalrestrictions_text"><?=$physicalActivityRestriction?></textarea>
				</p></td>
				<td colspan="2">
				<p class="required">
					<b>*Vacinas em dia?</b>
					<br>
					<span class="required"><b>*Anti-Tetânica:</b></span>
					<select class="required" name="antiTetanus" required <?=$disabled?>

>
						<option value="">-- Selecione --</option>
						<option value="t" <?php if (!empty($vacineTetanus) && ($vacineTetanus === "t")) echo "selected" ?> >Sim</option>
						<option value="f" <?php if (!empty($vacineTetanus) && ($vacineTetanus === "f")) echo "selected" ?>>Não</option>
					</select>
					<br>
					<span class="required"><b>*MMR (Caxumba, Rubéola, Sarampo):</b></span>
					<select class="required" name="MMR" required <?=$disabled?>

>
						<option value ="">-- Selecione --</option>
						<option value="t" <?php if (!empty($vacineMMR) && ($vacineMMR === "t")) echo "selected" ?> >Sim</option>
						<option value="f" <?php if (!empty($vacineMMR) && ($vacineMMR === "f")) echo "selected" ?>>Não</option>
					</select>
					<br>
					<span class="required"><b>*Hepatite A:</b></span>
					<select class="required" name="vacineHepatitis" required <?=$disabled?>

>
						<option value="">-- Selecione --</option>
						<option value="t" <?php if (!empty($vacineHepatitis) && ($vacineHepatitis === "t")) echo "selected" ?> >Sim</option>
						<option value="f" <?php if (!empty($vacineHepatitis) && ($vacineHepatitis === "f")) echo "selected" ?>>Não</option>
					</select>
					<br>
					<span class="required"><b>*Febre amarela:</b></span>
					<select class="required" name="vacineYellowFever" required <?=$disabled?>

>
						<option value="">-- Selecione --</option>
						<option value="t" <?php if (!empty($vacineYellowFever) && ($vacineYellowFever === "t")) echo "selected" ?> >Sim</option>
						<option value="f" <?php if (!empty($vacineYellowFever) && ($vacineYellowFever === "f")) echo "selected" ?>>Não</option>
					</select>
					<br>
				</p></td>
			</tr>
			<tr>
				<td colspan="4">
				<p>
					<b>*Antecedentes Infecto-Contagiosos?</b>
					<br>
					<input type="radio" name="antecedents_radio" value="0" required <?=$disabled?>   <?php if ($antecedents == NULL) echo "checked" ?>
>
					Não se aplica
					<br>
					<input type="radio" name="antecedents_radio" value="1" <?=$disabled?>  <?php if ($antecedents != NULL) echo "checked" ?> >
					Se aplica
					<br>
					<textarea id="antecedents_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" <?=$disabled?>
 rows="2" disabled cols="100" class="nome required" name="antecedents_text"><?=$antecedents?></textarea>
				</p></td>
			</tr>
			<tr>
				<td colspan="2">
				<p class="required">
					<b>*Medicamentos Habituais ou de uso regular
					<br>
					(<u>anotar horários e dosagens</u>):</b>
					<br>
					<input type="radio" name="habitualmedicine_radio" <?=$disabled?> value="0" required <?php if ($regularUseMedicine == NULL) echo "checked" ?> >
					Não se aplica
					<br>
					<input type="radio" name="habitualmedicine_radio" <?=$disabled?> value="1" <?php if ($regularUseMedicine != NULL) echo "checked" ?>>
					Se aplica
					<br>
					<textarea id="habitualmedicine_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')" <?=$disabled?>
					oninput="setCustomValidity('')"
  rows="2" disabled cols="50" name="habitualmedicine_text" class="required"><?=$regularUseMedicine?></textarea>
					<br>
				</p></td>
				<td colspan="2">
				<p>
					<b>*Restrições Medicamentosas:</b>
					<br>
					<input type="radio" name="medicinerestrictions_radio" value="0" required <?=$disabled?>  <?php if ($medicineRestrictions == NULL) echo "checked" ?>

>
					Não se aplica
					<br>
					<input type="radio" name="medicinerestrictions_radio" value="1" <?=$disabled?> <?php if ($medicineRestrictions != NULL) echo "checked" ?>>
					Se aplica
					<br>
					<textarea id="medicinerestrictions_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')" <?=$disabled?>
					oninput="setCustomValidity('')"
 rows="3" disabled cols="50" name="medicinerestrictions_text" class="required"><?=$medicineRestrictions?></textarea>
					<br>
				</p></td>
			</tr>

			<tr>
				<td colspan="2">
				<p>
					<b>*Alergias (Alimentares/Respiratórias/De Contato):</b>
					<br>
					<input type="radio" name="allergies_radio" value="0" required <?=$disabled?> <?php if ($allergies == NULL) echo "checked" ?>
>
					Não se aplica
					<br>
					<input type="radio" name="allergies_radio" id="sim1" value="1" <?=$disabled?> <?php if ($allergies != NULL) echo "checked" ?>>
					Se aplica
					<br>
					<textarea id="allergies_text" style="display:none;" required <?=$disabled?>                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')"
 rows="2" disabled cols="50" name="allergies_text" class="required"><?=$allergies?></textarea>
					<br>
				</p></td>
				<td colspan="2">
				<p>
					<b>*Antitérmico/Analgésico Habitual (<u>Indicar dose</u>):</b>
					<br>
					<input type="radio" name="analgesicantipyretic_radio" value="0" <?=$disabled?> required <?php if ($analgesicAntipyretic == NULL) echo "checked" ?>

>
					Não se aplica
					<br>
					<input type="radio" name="analgesicantipyretic_radio" id="sim1" value="1" <?=$disabled?> <?php if ($analgesicAntipyretic != NULL) echo "checked" ?>>
					Se aplica
					<br>
					<textarea id="analgesicantipyretic_text" style="display:none;" required                 <?=$disabled?>                
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')"
 required rows="2" cols="50" name="analgesicantipyretic_text" disabled class="required"><?=$analgesicAntipyretic?></textarea>
					<br>
				</p></td>
			</tr>
			<tr>
				<td colspan="4">
				<p>
					<b>*O membro da equipe necessita de algum cuidado médico especial?</b>
					<br>
					<input type="radio" name="specialcare_radio" value="0" required <?=$disabled?>   <?php if ($specialCareMedical == NULL) echo "checked" ?>
>
					Não se aplica
					<br>
					<input type="radio" name="specialcare_radio" value="1" <?=$disabled?>  <?php if ($specialCareMedical != NULL) echo "checked" ?> >
					Se aplica
					<br>
					<textarea id="specialcare_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" <?=$disabled?>
 rows="2" disabled cols="100" class="nome required" name="specialcare_text"><?=$specialCareMedical?></textarea>
				</p></td>
			</tr>

			<tr>
				<td colspan="4">
				<p>
					<b>*O membro da equipe toma medicamentos psiquiatricos ou medicacao para deficit de atencao ou de comportamento?</b>
					<br>
					<input type="radio" name="psych_radio" value="0" required <?=$disabled?>   <?php if ($psychMedication == NULL) echo "checked" ?>
>
					Não se aplica
					<br>
					<input type="radio" name="psych_radio" value="1" <?=$disabled?>  <?php if ($psychMedication != NULL) echo "checked" ?> >
					Se aplica
					<br>
					<textarea id="psych_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" <?=$disabled?>
 rows="2" disabled cols="100" class="nome required" name="psych_text"><?=$psychMedication?></textarea>
				</p></td>
			</tr>

			<tr>
				<td colspan="4">
				<p class="campo">
					<b>Observações:</b>
					<ol style="font-size:12px">
						<li>
							Caso seja iniciado algum tratamento no período da colônia, favor informar até o dia anterior ao embarque. Favor enviar também
							receita médica e medicamento.
						</li>
						<li>
							Em caso de emergência, o atendimento à criança no hospital mais próximo será sempre priorizado e os responsáveis serão
							devidamente informados.
						</li>
						<li>
							Os medicamentos prescritos e aplicados na colônia serão registrados no livro de ocorrências.
						</li>
						<li>
							Sugerimos que as informações aqui presentes sejam avaliadas por um médico. 
						</li>
					</ol>
				</p></td>
			</tr>

			<tr>
				<td colspan="4">
				<p class="divisoria">
					<b>CONTATO DO MÉDICO RESPONSÁVEL PELOS DADOS NESTA FICHA</b>
				</p></td>
			</tr>

			<tr>
				<td colspan="3">
				<p class="campo">
					<b>*Nome do Médico:</b>
					<input type="text" id="doctor_name" name="doctor_name" required <?=$disabled?>
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" value="<?=$doctorName?>"
					size="85px">
				</p></td>

				<td>
				<p class="campo">
					<b>*Telefone 1:</b>
					<input type="text" class="form-control phone phone1" name="doctor_phone1" placeholder="(ddd) Telefone de contato" required onkeypress="return validateNumberInput(event);" id="doctor_phone1" required <?=$disabled?>
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')" value="<?=$doctorPhone1?>"
					size="15px">
				</p></td>
			</tr>

			<tr>
				<td colspan="3">
				<p class="campo">
					<b>Email:</b>
					<input type="text" id="doctor_email" name="doctor_email" value="<?=$doctorEmail?>" <?=$disabled?> size="85px">
				</p></td>

				<td>
				<p class="campo">
					<b>Telefone 2:</b>
					<input type="text" class="form-control phone" name="doctor_phone2" placeholder="(ddd) Telefone secundário" required onkeypress="return validateNumberInput(event);" id="doctor_phone2" size="15px" value="<?=$doctorPhone2?> <?=$disabled?>">
				</p></td>
			</tr>

			<tr>
				<td colspan="4">
				<p>
					Atenção: cabe ao responsável pela pré-inscrição garantir que as informações abaixo são corretas 
					e verídicas. Recomendamos fortemente que, em caso de dúvidas, um médico seja consultado 
					antes da confirmação do envio desta ficha médica.
				</p>
				<p class="required">
					<input type="checkbox" required name="responsability" value="Ok" <?=$disabled?>>
					<span style="font-size:20px; color:red">Assumo a correção e veracidade das informações</span>
					<br>
				</p></td>
			</tr>

		</table>
		<input type="submit" class="btn btn-primary" value="Salvar" id="upload">
	</form>
	<br />
	<br />
	<input type="submit" class="btn btn-warning" value="Voltar" id="upload" onClick="history.go(-1);return true;">

</div>

-->
