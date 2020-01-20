<?php if(isset($type) && $type == "simples") {} else{?>

<table width="100%">
    <tr>
        <td align="center">
            <h1>Fichas médicas</h1>
        </td>
    </tr>
    <tr>
        <td align="center">
            <p>Colônia: <?=$summerCamp->getCampName()?></p>
            <?php if($roomNumber > 0 && $roomNumber < 7){ ?>
                <p>Quarto: <?=$roomNumber?><?=$pavilhao?></p>
            <?php } else { ?>
                <p>Pavilhão: <?=$pavilhao?></p>
            <?php } ?>
        </td>
    </tr>
</table>
<p style="page-break-before: always"></p>
<?php
} 
for($i = 0; $i < count($colonists); $i++) {
    $colonist = $colonists[$i];
    $medicalFile = $medicalFiles[$i];
    $doctor = $doctors[$i];
    ?>

    <div class="row">
        <div class="col-lg-12 middle-content">
            <div class="row">
                <h2><?= $colonist->colonist_name ?></h2>
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
                                <br />
                                <span class="required"><b>Febre Amarela:</b> <?=(($medicalFile->getVacineYellowFever() === "t") ? "Sim":"Não")?></span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <p class="required">
                                <b>Antecedentes Infecto-Contagiosos</b>
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
                                <b>Medicamentos habituais ou de uso regular</b>
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
                                <b>Restrições medicamentosas</b>
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
                                <b>Alergias (Alimentares/Respiratórias/De Contato)</b>
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
                                <b>Antitérmico / analgésico habitual</b>
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
                            <p class="required">
                                <b>Cuidado médico especial</b>
                                <br>
                                <?php if ($medicalFile->getSpecialCareMedical() == NULL) { ?>
                                    <span> Não se aplica. </span>
                                <?php } else { ?>
                                    <span> Se aplica. </span><br />
                                    <span> <?=$medicalFile->getSpecialCareMedical()?> </span>
                                <?php } ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <p class="required">
                                <b>Medicamentos psiquiátricos ou medicação para deficit de atenção ou de comportamento</b>
                                <br>
                                <?php if ($medicalFile->getPsychMedication() == NULL) { ?>
                                    <span> Não se aplica. </span>
                                <?php } else { ?>
                                    <span> Se aplica. </span><br />
                                    <span> <?=$medicalFile->getPsychMedication()?> </span>
                                <?php } ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <td colspan="4">
                            <p class="campo"><b>Observações do médico da colônia</b></p>
                            <p><?=$medicalFile->getDoctorObservations()?></p>
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
                                <b>Nome do médico</b>
                                <span><?= $doctor->getFullname(); ?></span>
                            </p>
                        </td>

                        <td>
                            <p class="campo">
                                <b>Telefone 1</b>
                                <span><?= $doctor->getPhone1(); ?></span>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <p class="campo">
                                <b>Email</b>
                                <span><?= $doctor->getEmail(); ?></span>
                            </p>
                        </td>

                        <td>
                            <p class="campo">
                                <b>Telefone 2</b>
                                <span><?= $doctor->getPhone2(); ?></span>
                            </p>
                        </td>
                    </tr>
                </table>
                <br />
            </div>
        </div>
    </div>

    <?php if($i % 2 == 1 && $i < count($colonists)-1){ ?>
    <?php
        }
    }
    ?>
