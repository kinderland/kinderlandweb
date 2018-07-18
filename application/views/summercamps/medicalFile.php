<script>
	$(document).ready(function() {
		$(('input:radio')).click(function() {
			name = ($(this).attr('name'));
			name_vector = name.split("_");
			name_textArea = name_vector[0] + "_text"
			value = $('input:radio[name=' + name + ']:checked').val();
			if (value == 0) {
				$('#' + name_textArea).hide();
				$('#' + name_textArea).prop('disabled', true);			

			} else {
				$('#' + name_textArea).show();
				$('#' + name_textArea).prop('disabled', false);			
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
	}); 

	function createPDFMedicalFiles() {
        window.location.href = "<?= $this->config->item('url_link'); ?>summercamps/generatePDFWithColonistMedicalFiles/<?php if(isset($ano_escolhido)) echo $ano_escolhido; else echo "";?>/<?php if(isset($summer_camp_id)) echo $summer_camp_id; else echo'';?>/<?php if(isset($pavilhao)) echo $pavilhao; else echo '';?>/<?php if(isset($quarto)) echo $quarto; else echo '';?>/simples";
    }

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
	<form enctype="multipart/form-data" action="<?= $this -> config -> item('url_link'); ?>summercamps/submitMedicalFile" method="post">
		<input type="hidden" name="camp_id" value="<?=$camp_id ?>" />
		<input type="hidden" name="colonist_id" value="<?=$colonist_id ?>" />
		<table class="table table-bordered" border=1 align="center">
			<tr>
				<td width = "25%"><span class="required"><b>*Grupo Sanguíneo:</b></span>
				<select name="bloodType" value="Selecione" required 
                        oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                               onchange="setCustomValidity('')"

>
					<option value="">-- Selecione --</option>
					<option value="<?=BLOOD_TYPE_A ?>">A</option>
					<option value="<?=BLOOD_TYPE_B ?>">B</option>
					<option value="<?=BLOOD_TYPE_O ?>">O</option>
					<option value="<?=BLOOD_TYPE_AB ?>">AB</option>
				</select></td>
				<td width = "25%"><span class="required"><b>*Fator RH:</b></span>
				<select name="rh" value="Selecione" required 
                        oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                               onchange="setCustomValidity('')"

>
					<option value="">-- Selecione --</option>
					<option value="t">Positivo</option>
					<option value="f">Negativo</option>
				</select></td>

				<td width = "25%"><span><b>*Peso:</b></span>
				<input type="text" class="nome" required maxlength="3" name="weight" size="10px" onkeypress='return event.charCode >= 48 && event.charCode <= 57' oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')"
>
				kg </td>
				<td width = "25%"><span><b>*Altura:</b></span>
				<input type="text" class="nome" required maxlength="4" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="height" id="height" size="10px" oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')"
>
				cm </td>
			</tr>
			<tr>
				<td colspan="2">
				<p class="required">
					<b>*Alguma restrição à atividade física (esportes, natação, caminhadas...)?</b>
					<br>
					<input type="radio" name="physicalrestrictions_radio" value="0" required 

>
					Não se aplica
					<br>
					<input type="radio" name="physicalrestrictions_radio" value="1" required
>
					Se aplica
					<br>
					<textarea id="physicalrestrictions_text" style="display:none;" rows="2" disabled cols="50" class="nome" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					onchange="setCustomValidity('')"
 name="physicalrestrictions_text"></textarea>
				</p></td>
				<td colspan="2">
				<p class="required">
					<b>*Vacinas em dia?</b>
					<br>
					<span class="required"><b>*Anti-Tetânica:</b></span>
					<select class="required" name="antiTetanus" required 

>
						<option value="">-- Selecione --</option>
						<option value="t" >Sim</option>
						<option value="f" >Não</option>
					</select>
					<br>
					<span class="required"><b>*MMR (Caxumba, Rubéola, Sarampo):</b></span>
					<select class="required" name="MMR" required 

>
						<option value ="">-- Selecione --</option>
						<option value="t" >Sim</option>
						<option value="f" >Não</option>
					</select>
					<br>
					<span class="required"><b>*Hepatite A:</b></span>
					<select class="required" name="vacineHepatitis" required 

>
						<option value="">-- Selecione --</option>
						<option value="t" >Sim</option>
						<option value="f" >Não</option>
					</select>
					<br>
					<span class="required"><b>*Febre amarela:</b></span>
					<select class="required" name="vacineYellowFever" required 

>
						<option value="">-- Selecione --</option>
						<option value="t" >Sim</option>
						<option value="f" >Não</option>
					</select>
					<br>
				</p></td>
			</tr>
			<tr>
				<td colspan="4">
				<p>
					<b>*Antecedentes Infecto-Contagiosos?</b>
					<br>
					<input type="radio" name="antecedents_radio" value="0" required 
>
					Não se aplica
					<br>
					<input type="radio" name="antecedents_radio" value="1"                                onchange="setCustomValidity('')">
					Se aplica
					<br>
					<textarea id="antecedents_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')"
 rows="2" disabled cols="100" class="nome required" name="antecedents_text"></textarea>
				</p></td>
			</tr>
			<tr>
				<td colspan="2">
				<p class="required">
					<b>*Medicamentos Habituais ou de uso regular
					<br>
					(<u>anotar horários e dosagens</u>):</b>
					<br>
					<input type="radio" name="habitualmedicine_radio" value="0" required >
					Não se aplica
					<br>
					<input type="radio" name="habitualmedicine_radio" value="1">
					Se aplica
					<br>
					<textarea id="habitualmedicine_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')"
  rows="2" disabled cols="50" name="habitualmedicine_text" class="required"></textarea>
					<br>
				</p></td>
				<td colspan="2">
				<p>
					<b>*Restrições Medicamentosas:</b>
					<br>
					<input type="radio" name="medicinerestrictions_radio" value="0" required >
					Não se aplica
					<br>
					<input type="radio" name="medicinerestrictions_radio" value="1">
					Se aplica
					<br>
					<textarea id="medicinerestrictions_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')"
 rows="3" disabled cols="50" name="medicinerestrictions_text" class="required"></textarea>
					<br>
				</p></td>
			</tr>

			<tr>
				<td colspan="2">
				<p>
					<b>*Alergias (Alimentares/Respiratórias/De Contato):</b>
					<br>
					<input type="radio" name="allergies_radio" value="0" required 
>
					Não se aplica
					<br>
					<input type="radio" name="allergies_radio" id="sim1" value="1">
					Se aplica
					<br>
					<textarea id="allergies_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')"
 rows="2" disabled cols="50" name="allergies_text" class="required"></textarea>
					<br>
				</p></td>
				<td colspan="2">
				<p>
					<b>*Antitérmico/Analgésico Habitual (<u>Indicar dose</u>):</b>
					<br>
					<input type="radio" name="analgesicantipyretic_radio" value="0" required >
					Não se aplica
					<br>
					<input type="radio" name="analgesicantipyretic_radio" id="sim1" value="1">
					Se aplica
					<br>
					<textarea id="analgesicantipyretic_text" style="display:none;" required                                 
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')"
 required rows="2" cols="50" name="analgesicantipyretic_text" disabled class="required"></textarea>
					<br>
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
					</ol>
				</p></td>
			</tr>

			<tr>
				<td colspan="4">
				<p class="divisoria">
					<b>CONTATO DO MÉDICO ou PEDIATRA</b>
				</p></td>
			</tr>

			<tr>
				<td colspan="3">
				<p class="campo">
					<b>*Nome do Médico:</b>
					<input type="text" id="doctor_name" name="doctor_name" required
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
					oninput="setCustomValidity('')"
					size="85px">
				</p></td>

				<td>
				<p class="campo">
					<b>*Telefone 1:</b>
					<input type="text" name="doctor_phone1"  class="form-control phone phone1"  placeholder="(ddd) Telefone de contato" onkeypress="return validateNumberInput(event);" id="doctor_phone1"
					oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')" required
					oninput="setCustomValidity('')"
					size="15px">
				</p></td>
			</tr>

			<tr>
				<td colspan="3">
				<p class="campo">
					<b>Email:</b>
					<input type="text" id="doctor_email" name="doctor_email"  size="85px">
				</p></td>

				<td>
				<p class="campo">
					<b>Telefone 2:</b>
					<input type="text" name="doctor_phone2"  class="form-control phone" placeholder="(ddd) Telefone secundário" onkeypress="return validateNumberInput(event);" id="doctor_phone2" size="15px">
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
					<input type="checkbox" required name="responsability" value="Ok">
					<span style="font-size:20px; color:red">Assumo a responsabilidade pela correção e veracidade das informações desta ficha médica</span>
					<br>
				</p></td>
			</tr>

		</table>
		<input type="submit" class="btn btn-primary" value="Salvar" id="upload">&nbsp;&nbsp;<!-- <button class="btn btn-primary" onclick="createPDFMedicalFiles()" value="">PDF com ficha médica</button> -->
	</form>
	<br />
	<input type="submit" class="btn btn-warning" value="Voltar" id="upload" onClick="history.go(-1);return true;">

</div>
