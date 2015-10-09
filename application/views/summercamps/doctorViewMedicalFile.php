<div id="cabecalho">
	<p align="right" style="color:red">
		O símbolo * indica preenchimento obrigatório!
	</p>
</div>

<div id='form'>
	<?php $disabled = "disabled"; ?>

<script>

	function saveObservations(colonistId, summerCampId) {
		var observations = $("#doctor_observations").val();
		if(observations != ""){
			$.post("<?= $this->config->item('url_link') ?>summercamps/updateDoctorObservations",
                {
                    'colonist_id': colonistId,
                    'summer_camp_id': summerCampId,
                    'doctor_observations': observations
                },
                function (data) {
                    if (data == "true") {
                        alert("Observações gravadas com sucesso!");
                    } else {
                        alert("Ocorreu um erro ao gravar as observações do médico.");
                    }
                }
            );
		}
	}
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
		
	<table class="table table-bordered" border=1 align="center">
            <tr>
                <td width = "25%"><span class="required"><b>Grupo Sanguíneo:</b></span>
                    <span><?=$medicalFile->getBloodTypeName()?></span>
                </td>
                <td width = "25%"><span class="required"><b>Fator RH:</b></span>
                    <span><?=(($medicalFile->getRH() == "t")?"Positivo":"Negativo")?></span>
                </td>

                <td width = "25%"><span><b>Peso:</b></span>
                    <span><?=$medicalFile->getWeight()?> kg</span>
                </td>
                <td width = "25%"><span><b>Altura:</b></span>
                    <span><?=$medicalFile->getHeight()?> cm</span>
                </td>
                
            </tr>
            <tr>
                <td colspan="2">
                    <p class="required">
                        <b>Alguma restrição à atividade física (esportes, natação, caminhadas...)?</b>
                        <br>
                        <?php if ($medicalFile->getPhysicalActivityRestriction() == NULL) { ?>
                            <span> Não se aplica. </span>
                        <?php } else { ?>
                            <span> Se aplica. </span><br />
                            <span> <?=$medicalFile->getPhysicalActivityRestriction()?> </span>
                        <?php } ?>
                    </p>
                </td>

                <td colspan="2">
                    <p class="required">
                        <b>Vacinas em dia?</b>
                        <br />
                        <span class="required"><b>Anti-Tetânica:</b> <?=(($medicalFile->getVacineTetanus() === "t") ? "Sim":"Não")?></span>
                        <br />
                        <span class="required"><b>MMR (Caxumba, Rubéola, Sarampo):</b> <?=(($medicalFile->getVacineMMR() === "t") ? "Sim":"Não")?></span>
                        <br />
                        <span class="required"><b>Hepatite A:</b> <?=(($medicalFile->getVacineHepatitis() === "t") ? "Sim":"Não")?></span>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <p class="required">
                        <b>Antecedentes Infecto-Contagiosos?</b>
                        <br>
                        <?php if ($medicalFile->getInfectoContagiousAntecedents() == NULL) { ?>
                            <span> Não se aplica. </span>
                        <?php } else { ?>
                            <span> Se aplica. </span><br />
                            <span> <?=$medicalFile->getInfectoContagiousAntecedents()?> </span>
                        <?php } ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="required">
                        <b>Medicamentos Habituais ou de uso regular:</b>
                        <br>
                        <?php if ($medicalFile->getRegularUseMedicine() == NULL) { ?>
                            <span> Não se aplica. </span>
                        <?php } else { ?>
                            <span> Se aplica. </span><br />
                            <span> <?=$medicalFile->getRegularUseMedicine()?> </span>
                        <?php } ?>
                    </p>
                </td>
                <td colspan="2">
                    <p class="required">
                        <b>Restrições Medicamentosas:</b>
                        <br>
                        <?php if ($medicalFile->getMedicineRestrictions() == NULL) { ?>
                            <span> Não se aplica. </span>
                        <?php } else { ?>
                            <span> Se aplica. </span><br />
                            <span> <?=$medicalFile->getMedicineRestrictions()?> </span>
                        <?php } ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="required">
                        <b>Alergias (Alimentares/Respiratórias/De Contato):</b>
                        <br>
                        <?php if ($medicalFile->getAllergies() == NULL) { ?>
                            <span> Não se aplica. </span>
                        <?php } else { ?>
                            <span> Se aplica. </span><br />
                            <span> <?=$medicalFile->getAllergies()?> </span>
                        <?php } ?>
                    </p>
                </td>
                <td colspan="2">
                    <p class="required">
                        <b>Antitérmico/Analgésico Habitual:</b>
                        <br>
                        <?php if ($medicalFile->getAnalgesicAntipyretic() == NULL) { ?>
                            <span> Não se aplica. </span>
                        <?php } else { ?>
                            <span> Se aplica. </span><br />
                            <span> <?=$medicalFile->getAnalgesicAntipyretic()?> </span>
                        <?php } ?>
                    </p>
                </td>
            </tr>
            <tr>
				<td colspan="4">
					<p class="campo"><b>Observações do médico da colônia:</b></p>
					<textarea id="doctor_observations" rows="10" cols="100" name="doctor_observations"><?=$medicalFile->getDoctorObservations()?></textarea>
					<br /><br />
					<button class="btn btn-primary" onclick="saveObservations(<?=$colonist_id?>, <?=$camp_id?>)"> Salvar </button>
				</td>
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
                        <span><?= $doctor->getFullname(); ?></span>
                    </p>
                </td>

                <td>
                    <p class="campo">
                        <b>*Telefone 1:</b>
                        <span><?= $doctor->getPhone1(); ?></span>
                    </p>
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    <p class="campo">
                        <b>Email:</b>
                        <span><?= $doctor->getEmail(); ?></span>
                    </p>
                </td>

                <td>
                    <p class="campo">
                        <b>Telefone 2:</b>
                        <span><?= $doctor->getPhone2(); ?></span>
                    </p>
                </td>
            </tr>
            
        </table>
	<br />
</div>