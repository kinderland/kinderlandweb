<script>
	$(document).ready(function() {
		$(('input:radio')).click(function() {
			name = ($(this).attr('name'));
			name_vector = name.split("_");
			name_textArea = name_vector[0]+"_text"
			value = $('input:radio[name=' + name + ']:checked').val();
			if (value == 0) {
				$('#' + name_textArea).hide();
				$('#' + name_textArea).val("Não se aplica");
			} else {
				$('#' + name_textArea).show();
				$('#' + name_textArea).val("");
			}
		})
	}); 
</script>

<div id="cabecalho">
	<p style="font-size: x-large; color:red">
		O símbolo * indica preenchimento obrigatório!
	</p>
</div>

<div id='form'>
	<form enctype="multipart/form-data" action="<?= $this -> config -> item('url_link'); ?>summercamps/submitMedicalFile" method="post">
		<input type="hidden" name="camp_id" value="<?=$camp_id ?>" />
		<input type="hidden" name="colonist_id" value="<?=$colonist_id ?>" />
		<table class="table table-bordered" border=1 align="center">
			<tr>
				<td width = "25%"><span class="required"><b>*Grupo Sanguíneo:</b></span>
				<select name="bloodType" value="Selecione" class="required ">
					<option>-- Selecione --</option>
					<option value="<?=BLOOD_TYPE_A ?>">A</option>
					<option value="<?=BLOOD_TYPE_B ?>">B</option>
					<option value="<?=BLOOD_TYPE_O ?>">O</option>
					<option value="<?=BLOOD_TYPE_AB ?>">AB</option>
				</select></td>
				<td width = "25%"><span class="required"><b>*Fator RH:</b></span>
				<select name="rh" value="Selecione" class="required">
					<option>-- Selecione --</option>
					<option value="t">Positivo</option>
					<option value="f">Negativo</option>
				</select></td>

				<td width = "25%"><span class="required"><b>*Peso:</b></span>
				<input type="text" class="nome required" maxlength="3" name="weight" size="1px">
				kg </td>
				<td width = "25%"><span class="required"><b>*Altura:</b></span>
				<input type="text" class="nome required" maxlength="4" name="height" id="height" size="1px">
				cm </td>
			</tr>
			<tr>
				<td colspan="2">
				<p class="required">
					<b>*Alguma restrição à atividade física (esportes, natação, caminhadas...)?</b>
					<br>
					<input type="radio" name="physicalrestrictions_radio" value="0" class="required">
					Não se aplica
					<br>
					<input type="radio" name="physicalrestrictions_radio" value="1">
					Se aplica
					<br>
					<textarea id="physicalrestrictions_text" style="display:none;" rows="2" cols="50" class="nome required" name="physicalrestrictions_text"></textarea>
				</p></td>
				<td colspan="2">
				<p class="required">
					<b>*Vacinas em dia?</b>
					<br>
					<span class="required"><b>*Anti-Tetânica:</b></span>
					<select class="required" name="antiTetanus">
						<option>-- Selecione --</option>
						<option value="t" >Sim</option>
						<option value="f" >Não</option>
					</select>
					<br>
					<span class="required"><b>*MMR (Caxumba, Rubéola, Sarampo):</b></span>
					<select class="required" name="MMR">
						<option>-- Selecione --</option>
						<option value="t" >Sim</option>
						<option value="f" >Não</option>
					</select>
					<br>
					<span class="required"><b>*Hepatite A:</b></span>
					<select class="required" name="vacineHepatitis">
						<option>-- Selecione --</option>
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
					<input type="radio" name="antecedents_radio" value="0" class="required">
					Não se aplica
					<br>
					<input type="radio" name="antecedents_radio" value="1">
					Se aplica
					<br>
					<textarea id="antecedents_text" style="display:none;" rows="2" cols="100" class="nome required" name="antecedents_text"></textarea>
				</p></td>
			</tr>
			<tr>
				<td colspan="2">
				<p class="required">
					<b>*Medicamentos Habituais ou de uso regular
					<br>
					(<u>anotar horários e dosagens</u>):</b>
					<br>
					<input type="radio" name="habitualmedicine_radio" value="0" class="required">
					Não se aplica
					<br>
					<input type="radio" name="habitualmedicine_radio" value="1">
					Se aplica
					<br>
					<textarea id="habitualmedicine_text" style="display:none;"  rows="2" cols="50" name="habitualmedicine_text" class="required"></textarea>
					<br>
				</p></td>
				<td colspan="2">
				<p>
					<b>*Restrições Medicamentosas:</b>
					<br>
					<input type="radio" name="medicinerestrictions_radio" value="0" class="required">
					Não se aplica
					<br>
					<input type="radio" name="medicinerestrictions_radio" value="1">
					Se aplica
					<br>
					<textarea id="medicinerestrictions_text" style="display:none;" rows="3" cols="50" name="medicinerestrictions_text" class="required"></textarea>
					<br>
				</p></td>
			</tr>

			<tr>
				<td colspan="2">
				<p>
					<b>*Alergias (Alimentares/Respiratórias/De Contato):</b>
					<br>
					<input type="radio" name="allergies_radio" value="0" class="required">
					Não se aplica
					<br>
					<input type="radio" name="allergies_radio" id="sim1" value="1">
					Se aplica
					<br>
					<textarea id="allergies_text" style="display:none;" rows="2" cols="50" name="allergies_text" class="required"></textarea>
					<br>
				</p></td>
				<td colspan="2">
				<p>
					<b>*Antitérmico/Analgésico Habitual (<u>Indicar dose</u>):</b>
					<br>
					<input type="radio" name="analgesicantipyretic_radio" value="0" class="required">
					Não se aplica
					<br>
					<input type="radio" name="analgesicantipyretic_radio" id="sim1" value="1">
					Se aplica
					<br>
					<textarea id="analgesicantipyretic_text" style="display:none;" rows="2" cols="50" name="analgesicantipyretic_text" class="required"></textarea>
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
					<input type="text" id="doctor_name" name="doctor_name" class="required" size="85px">
				</p></td>

				<td>
				<p class="campo">
					<b>*Telefone 1:</b>
					<input type="text" name="doctor_phone1" id="doctor_phone1" class="required" size="15px">
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
					<input type="text" name="doctor_phone2" id="doctor_phone2" size="15px">
				</p></td>
			</tr>

			<tr>
				<td colspan="2">
				<p class="campo">
					<b>Local:</b>
					<input type="text" id="site" name="site" size="30px">
				</p></td>

				<td colspan="2">
				<p class="campo">
					<b>Data:</b>
					<input type="text" name="date" id="date" size="15px">
				</p></td>
			</tr>

			<tr>
				<td colspan="4">
				<p class="required">
					<input type="checkbox" class="required" name="responsability" value="Ok">
					<span style="font-size:20px; color:red">Assumo a veracidade das informações.</span>
					<br>
				</p></td>
			</tr>

		</table>
		<input type="submit" class="btn" value="Enviar ficha médica" id="upload">
	</form>
	<input type="submit" class="btn" value="Voltar" id="upload" onClick="history.go(-1);return true;">

</div>