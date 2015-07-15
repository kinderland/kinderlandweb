<div id="cabecalho">
	<p style="font-size: x-large; color:red">
		O símbolo * indica preenchimento obrigatório!
	</p>
</div>

<div id='form'>
	<table border=1 align="center">
		<INPUT TYPE="hidden" NAME="sequencial" VALUE="${sequencial}">
		<tr>
			<td width = "25%"><span class="required"><b>*Grupo Sanguíneo:</b></span>
			<select name="blood_type" value="Selecione" class="required">
				<option></option>
				<option value="A">A</option>
				<option value="B">B</option>
				<option value="O">O</option>
				<option value="AB">AB</option>
			</select></td>
			<td width = "25%"><span class="required"><b>*Fator RH:</b></span>
			<select name="rh" value="Selecione" class="required">
				<option></option>
				<option value="+">Positivo</option>
				<option value="-">Negativo</option>
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
				<input type="radio" name="restriction" value="Não se aplica" class="required">
				Não se aplica
				<br>
				<input type="radio" name="restrinction" id="sim1" value="Se aplica">
				Se aplica
				<br>
				<textarea id="t0" style="display:none;" rows="2" cols="50" class="nome required" name="physical_restrictions"></textarea>
			</p></td>
			<td colspan="2">
			<p class="required">
				<b>*Vacinas em dia?</b>
				<br>
				<span class="required"><b>*Anti-Tetânica:</b></span>
				<select class="required" name="antiTetanus">
					<option></option>
					<option value="Sim" >Sim</option>
					<option value="Não" >Não</option>
				</select>
				<br>
				<span class="required"><b>*MMR (Caxumba, Rubéola, Sarampo):</b></span>
				<select class="required" name="MMR">
					<option></option>
					<option value="Sim" >Sim</option>
					<option value="Não" >Não</option>
				</select>
				<br>
				<span class="required"><b>*Hepatite A:</b></span>
				<select class="required" name="hepatitis">
					<option></option>
					<option value="Sim" >Sim</option>
					<option value="Não" >Não</option>
				</select>
				<br>
			</p></td>
		</tr>
		<tr>
			<td colspan="4">
			<p>
				<b>*Antecedentes Infecto-Contagiosos?</b>
				<br>
				<input type="radio" name="antecedent" value="Não se aplica" class="required">
				Não se aplica
				<br>
				<input type="radio" name="antecedent" id="sim1" value="Se aplica">
				Se aplica
				<br>
				<textarea id="t1" style="display:none;" rows="2" cols="100" class="nome required" name="infecto-contagious_antecedents"></textarea>
			</p></td>
		</tr>
		<tr>
			<td colspan="2">
			<p class="required">
				<b>*Medicamentos Habituais ou de uso regular
				<br>
				(<u>anotar horários e dosagens</u>):</b>
				<br>
				<input type="radio" name="medicine" value="Não se aplica" class="required">
				Não se aplica
				<br>
				<input type="radio" name="medicine" id="sim1" value="Se aplica">
				Se aplica
				<br>
				<textarea id="t2" style="display:none;"  rows="2" cols="50" name="regular_use_medicine" class="required"></textarea>
<br>			</p></td>
			<td colspan="2">
			<p>
				<b>*Restrições Medicamentosas:</b>
				<br>
				<input type="radio" name="restrictions" value="Não se aplica" class="required">
				Não se aplica
				<br>
				<input type="radio" name="restrictions" id="sim1" value="Se aplica">
				Se aplica
				<br>
				<textarea id="t3" style="display:none;" rows="3" cols="50" name="medicine_restrictions" class="required"></textarea>
<br>			</p></td>
		</tr>

		<tr>
			<td colspan="2">
			<p>
				<b>*Alergias (Alimentares/Respiratórias/De Contato):</b>
				<br>
				<input type="radio" name="hasAlergies" value="Não se aplica" class="required">
				Não se aplica
				<br>
				<input type="radio" name="hasAlergies" id="sim1" value="Se aplica">
				Se aplica
				<br>
				<textarea id="t4" style="display:none;"  rows="2" cols="50" name="alergies" class="required"></textarea>
<br>			</p></td>
			<td colspan="2">
			<p>
				<b>*Antitérmico/Analgésico Habitual (<u>Indicar dose</u>):</b>
				<br>
				<input type="radio" name="g5" value="Não se aplica" class="required">
				Não se aplica
				<br>
				<input type="radio" name="g5" id="sim1" value="Se aplica">
				Se aplica
				<br>
				<textarea id="t5" style="display:none;" rows="2" cols="50" name="ficha.antitermico_habitual" class="required"></textarea>
<br>			</p></td>
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
				<input type="text" id="ficha.nome_medico" name="ficha.nome_medico" class="required" size="85px">
			</p></td>

			<td>
			<p class="campo">
				<b>*Telefone 1:</b>
				<input type="text" name="ficha.telefone1_medico" id="telefone1_medico" class="required" size="15px">
			</p></td>
		</tr>

		<tr>
			<td colspan="3">
			<p class="campo">
				<b>Email:</b>
				<input type="text" id="ficha.email_medico" name="ficha.email_medico"  size="85px">
			</p></td>

			<td>
			<p class="campo">
				<b>Telefone 2:</b>
				<input type="text" name="ficha.telefone2_medico" id="telefone2_medico" size="15px">
			</p></td>
		</tr>

		<tr>
			<td colspan="2">
			<p class="campo">
				<b>Local:</b>
				<input type="text" id="ficha.local" name="ficha.local" size="30px">
			</p></td>

			<td colspan="2">
			<p class="campo">
				<b>Data:</b>
				<input type="text" name="ficha.data" id="data" size="15px">
			</p></td>
		</tr>

		<tr>
			<td colspan="4">
			<p class="required">
				<input type="checkbox" class="required" name="ficha.veracidade" value="Ok">
				<span style="font-size:20px; color:red">Assumo a veracidade das informações.</span>
				<br>
			</p></td>
		</tr>

	</table>
	<p class="buttons">
		<input type="submit" value="Enviar ficha médica" id="upload">
	</p>
	<p class="buttons">
		<input type="submit" value="Voltar" id="upload" onClick="history.go(-1);return true;">
	</p>
	<p class="buttons" align="center">
		<input type="submit" align="center" value="Sair do sistema" id="formulario" onclick="location.href='@{Secure.logout()}'">
	</p>

</div>