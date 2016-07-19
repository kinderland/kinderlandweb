<link href="<?= $this->config->item('assets'); ?>css/datepicker.css" rel="stylesheet" />
<link rel="text/javascript" href="<?= $this->config->item('assets'); ?>js/datepicker.less.js" />


<script>


    function verifyOtherSchool() {
        var val = $("#school_select").val();
        if (val == -1) {
            $("#school_text").fadeIn();
            $("#school_text").prop('disabled', false);
        }
        else {
            $("#school_text").fadeOut();
            $("#school_text").prop('disabled', true);
        }
    }


    function addressResponsable() {
        var val = $('input:radio[name=sameAddressResponsable]:checked').val();
        var changeTo = true;
        if (val == "n") {
            changeTo = false;
        }
        var labels = $(".endereco");
        for (index = 0,
                len = labels.length; index < len; ++index) {
            labels[index].disabled = changeTo;
        }
    }



    function toggleInputStatusIn(element, disable) {
        if (disable == true) {
            $(element).find(':input').prop('disabled', true);
            $(element + ' a').click(function (e) {
                e.preventDefault();
            });
        } else {
            $(element).find(':input').prop('disabled', false);
            $(element + ' a').unbind("click");
        }
    }

    function responsableDadMotherFunction() {
        var val = $('input:radio[name=responsableDadMother]:checked').val();
        if (val == "not") {//dois habilitados
            $(".dad").fadeIn();
            $(".mother").fadeIn();
            toggleInputStatusIn(".dad", false);
            toggleInputStatusIn(".mother", false);
        } else if (val == "dad") {//pai desabilitado
            $(".dad").fadeOut();
            $(".mother").fadeIn();
            toggleInputStatusIn(".mother", false);
            toggleInputStatusIn(".dad", true);
        } else if (val == "mother") {//mae desabilitado
            $(".mother").fadeOut();
            $(".dad").fadeIn();
            toggleInputStatusIn(".mother", true);
            toggleInputStatusIn(".dad", false);
        }
    }

    function hide_class(classn, hide) {
        if (hide == 0) {
            $("." + classn).fadeIn();
            toggleInputStatusIn("." + classn, false);
        } else {
            $("." + classn).fadeOut();
            toggleInputStatusIn("." + classn, true);
        }
    }


    $(document).ready(function () {
        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
                spOptions = {
                    onKeyPress: function (val, e, field, options) {
                        field.mask(SPMaskBehavior.apply({}, arguments), options);
                    }
                };

        $(".phone").mask(SPMaskBehavior, spOptions);
        $(".birthdate").mask("00/00/0000", {
            placeholder: "__/__/____"
        });
        ;
        addressResponsable();
        responsableDadMotherFunction();
    });

</script>
<div class="row">
    <div class="col-lg-12 middle-content">
        <div class="row">
            <div class="col-lg-8"><h4>Edição de pré-inscrição de colonista na colonia: <?= $summerCamp->getCampName() ?></h4></div>
            <div class="col-lg-4"><h6><span class="red_letters">Campos com * são de preenchimento obrigatório.</span></h6></div>
        </div>
        <hr />

        <form name="formulario" method="POST" action="<?= $this->config->item('url_link') ?>summercamps/editSubscriptionColonist">
            <input type="hidden" name="summerCampId" value="<?= $summerCampId ?>"/>
            <input type="hidden" name="colonistId" value="<?= $colonistId ?>"/>
            <input type="hidden" name="personId" value="<?= $personId ?>"/>
            <div class="row">
                <div class="form-group">
                    <label for="fullname" class="col-lg-2 control-label"> Nome Completo*: </label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" placeholder="Nome Completo"
                               name="fullname" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php
                               if ($fullName) {
                                   echo $fullName;
                               }
                               ?>"/>

                    </div>

                    <label for="gender" class="col-lg-1 control-label"> Sexo*: </label>
                    <div class="col-lg-3">
                        <select  class="form-control" id="gender" name="gender" required
                                 oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                                 onchange="setCustomValidity('')"
                                 >
                            <option value="" selected>-- Selecione --</option>
                            <option value="M"
                                    <?php if (!empty($Gender) && ($Gender == "M")) echo "selected" ?> >Masculino</option>
                            <option value="F"
                                    <?php if (!empty($Gender) && ($Gender == "F")) echo "selected" ?>>Feminino</option>
                        </select>
                    </div>
                </div>
            </div>
            <br />
            <br />
            <div class="row">
                <div class="form-group">
                    <label for="birthdate" class="col-lg-2 control-label"> Data de Nascimento*: </label>
                    <div class="col-lg-2">
                        <input type="text" class="birthdate form-control" placeholder="Data de Nascimento"
                               name="birthdate" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php
                               if (!empty($birthdate)) {
                                   echo $birthdate;
                               }
                               ?>"/>

                    </div>

                    <label for="gender" class="col-lg-2 control-label"> Tipo de Documento*: </label>
                    <div class="col-lg-2">
                        <select  class="form-control" id="documentType" name="documentType" required
                                 oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                                 onchange="setCustomValidity('')"
                                 >
                            <option value="" selected>-- Selecione --</option>
                            <option value="RG"
                                    <?php if (!empty($documentType) && ($documentType == "RG")) echo "selected" ?> >RG</option>
                            <option value="Passaporte"
                                    <?php if (!empty($documentType) && ($documentType == "Passaporte")) echo "selected" ?>>Passaporte</option>
                            <option value="Certidao"
                                    <?php if (!empty($documentType) && ($documentType == "Certidao")) echo "selected" ?>>Certidão de Nascimento</option>
                        </select>
                    </div>
                    <label for="documentNumber" class="col-lg-1 control-label"> Numero do documento*: </label>
                    <div class="col-lg-3">
                        <input type="text" id="documentNumber" class="form-control" placeholder="Numero do documento"
                               name="documentNumber" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('');"
                               value="<?php
                               if (!empty($documentNumber)) {
                                   echo $documentNumber;
                               }
                               ?>"/>

                    </div>

                </div>
            </div>
            <br />

            <div class="row">
                <div class="form-group">
                    <label for="school" class="col-lg-2 control-label"> Nome da Escola*: </label>
                    <div class="col-lg-4">
                        <?php $schools = $this->summercamp_model->getSchools(); ?>
                        <select  class="form-control" id="school_select" name="school[]" required
                                 oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                                 onchange="setCustomValidity('');
                                         verifyOtherSchool();"
                                 >
                            <option value="" selected>-- Selecione --</option>
                            <?php
                            foreach ($schools as $actual_school) {
                                echo "<option value='" . $actual_school . "' ";
                                if (!empty($school) && ($school == $actual_school))
                                    echo "selected";
                                echo ">" . $actual_school . "</option>";
                            }
                            ?>
                            <option value="-1">Outra</option>
                        </select>

                    </div>

                    <label for="schoolYear" class="col-lg-3 control-label"> Ano escolar em <?php echo date("Y");?> (fundamental)*: </label>
                    <div class="col-lg-3">
                        <select  class="form-control" id="schoolYear" name="schoolYear" required
                                 oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                                 onchange="setCustomValidity('')"
                                 >
                            <option value="" selected>-- Selecione --</option>
                            <?php
                            for ($__school_year__ = 2; $__school_year__ <= 9; $__school_year__++) {
                                echo "<option value='" . $__school_year__ . "' ";
                                if (!empty($school) && ($schoolYear == $__school_year__))
                                    echo "selected";
                                echo ">" . $__school_year__ . "</option>";
                            }
                            ?>
                        </select>

                    </div>


                    <div class="col-lg-4">
                        <input type="text" class="form-control" placeholder="Nome da escola"
                               name="school[]" id="school_text" disabled style="display: none;" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               />
                    </div>


                </div>
            </div>
            <br />

            <div class="row">
                <div class="form-group">
                    <label for="phone1" class="col-lg-2 control-label "> Telefone: </label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control phone phone1" placeholder="(ddd) Telefone de contato"
                               name="phone1" id="phone1" maxlength="25"
                               value="<?php
                               if (!empty($phone1)) {
                                   echo $phone1;
                               }
                               ?>"/>
                    </div>

                    <label for="phone2" class="col-lg-3 control-label"> Telefone Secundário: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control phone" placeholder="(ddd) Telefone secundário"
                               name="phone2" maxlength="25" onkeypress="return validateNumberInput(event);"
                               value="<?php
                               if (!empty($phone2)) {
                                   echo $phone2;
                               }
                               ?>"/>
                    </div>
                </div>
            </div>
            <br />
            <br />


            <div class="row">
                <div class="form-group">
                    <label for="school" class="col-lg-6 control-label"> Endereço do(a) colonista é o mesmo do(a) responsável?*: </label>
                    <div class="col-lg-6">
                        <input type="radio" onchange="addressResponsable();" name="sameAddressResponsable" value="s"
                        <?php
                        if (empty($sameAddressResponsable) ||
                                (!empty($sameAddressResponsable) && ($sameAddressResponsable == "s")
                                ))
                            echo "checked='checked'"
                            ?>/> Sim
                        <input type="radio" onchange="addressResponsable();" name="sameAddressResponsable" value="n"
                        <?php if (!empty($sameAddressResponsable) && ($sameAddressResponsable == "n")) echo "checked='checked'" ?>
                               /> Não
                    </div>


                </div>
            </div>
            <br />
            <br />


            <div class="row">
                <div class="form-group">
                    <label for="street" class="col-lg-1 control-label"> Logradouro: </label>
                    <div class="col-lg-11">
                        <input type="text" class="form-control endereco" placeholder="Logradouro"
                               name="street" onkeypress="return validateLetterInput(event);"
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php
                               if (!empty($street)) {
                                   echo $street;
                               }
                               ?>"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="form-group">
                    <label for="number" class="col-lg-1 control-label "> Número: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control endereco" placeholder="Número"
                               name="number" onkeypress="return validateLetterAndNumberInput(event);"
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php
                               if (!empty($number)) {
                                   echo $number;
                               }
                               ?>"/>
                    </div>

                    <label for="complement" class="col-lg-2 control-label " > Complemento: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control endereco" placeholder="Complemento"
                               name="complement"
                               value="<?php
                               if (!empty($complement)) {
                                   echo $complement;
                               }
                               ?>"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="form-group">

                    <label for="neighborhood" class="col-lg-1 control-label "> Bairro: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control endereco" placeholder="Bairro"
                               name="neighborhood" onkeypress="return validateLetterInput(event);"
                               value="<?php
                               if (!empty($neighborhood)) {
                                   echo $neighborhood;
                               }
                               ?>"/>
                    </div>


                    <label for="cep" class="col-lg-2 control-label"> CEP: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control endereco" placeholder="CEP"
                               name="cep" maxlength="8" onkeypress="return validateNumberInput(event);"
                               pattern=".{8,}" id="cep"
                               oninvalid="this.setCustomValidity('O CEP precisa ter 8 dígitos.')"
                               oninput="setCustomValidity('')" onblur="maskCEP(this)"
                               value="<?php
                               if (!empty($cep)) {
                                   echo $cep;
                               }
                               ?>"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="form-group">

                    <label for="city" class="col-lg-1 control-label "> Cidade: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control endereco" placeholder="Cidade"
                               name="city" onkeypress="return validateLetterInput(event);"
                               oninvalid="this.setCustomValidity('Este$this -> input -> post('neighborhood', TRUE) campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php
                               if (!empty($city)) {
                                   echo $city;
                               }
                               ?>"/>
                    </div>


                    <label for="uf" class="col-lg-2 control-label"> Estado*: </label>
                    <div class="col-lg-3">
                        <select  class="form-control endereco" id="uf" name="uf" required
                                 oninvalid="this.setCustomValidity('Favor escolher um item da lista.')"
                                 oninput="setCustomValidity('')">
                            <option value=""> -- Selecione -- </option>
                            <option value="RJ" <?php if (!empty($uf) && ($uf == "RJ")) echo "selected" ?>>RJ</option>
                            <option value="AC" <?php if (!empty($uf) && ($uf == "AC")) echo "selected" ?>>AC</option>
                            <option value="AL" <?php if (!empty($uf) && ($uf == "AL")) echo "selected" ?>>AL</option>
                            <option value="AM" <?php if (!empty($uf) && ($uf == "AM")) echo "selected" ?>>AM</option>
                            <option value="AP" <?php if (!empty($uf) && ($uf == "AP")) echo "selected" ?>>AP</option>
                            <option value="BA" <?php if (!empty($uf) && ($uf == "BA")) echo "selected" ?>>BA</option>
                            <option value="CE" <?php if (!empty($uf) && ($uf == "CE")) echo "selected" ?>>CE</option>
                            <option value="DF" <?php if (!empty($uf) && ($uf == "DF")) echo "selected" ?>>DF</option>
                            <option value="ES" <?php if (!empty($uf) && ($uf == "ES")) echo "selected" ?>>ES</option>
                            <option value="GO" <?php if (!empty($uf) && ($uf == "GO")) echo "selected" ?>>GO</option>
                            <option value="MA" <?php if (!empty($uf) && ($uf == "MA")) echo "selected" ?>>MA</option>
                            <option value="MG" <?php if (!empty($uf) && ($uf == "MG")) echo "selected" ?>>MG</option>
                            <option value="MS" <?php if (!empty($uf) && ($uf == "MS")) echo "selected" ?>>MS</option>
                            <option value="MT" <?php if (!empty($uf) && ($uf == "MT")) echo "selected" ?>>MT</option>
                            <option value="PA" <?php if (!empty($uf) && ($uf == "PA")) echo "selected" ?>>PA</option>
                            <option value="PB" <?php if (!empty($uf) && ($uf == "PB")) echo "selected" ?>>PB</option>
                            <option value="PE" <?php if (!empty($uf) && ($uf == "PE")) echo "selected" ?>>PE</option>
                            <option value="PI" <?php if (!empty($uf) && ($uf == "PI")) echo "selected" ?>>PI</option>
                            <option value="PR" <?php if (!empty($uf) && ($uf == "PR")) echo "selected" ?>>PR</option>
                            <option value="RN" <?php if (!empty($uf) && ($uf == "RN")) echo "selected" ?>>RN</option>
                            <option value="RO" <?php if (!empty($uf) && ($uf == "RO")) echo "selected" ?>>RO</option>
                            <option value="RR" <?php if (!empty($uf) && ($uf == "RR")) echo "selected" ?>>RR</option>
                            <option value="RS" <?php if (!empty($uf) && ($uf == "RS")) echo "selected" ?>>RS</option>
                            <option value="SC" <?php if (!empty($uf) && ($uf == "SC")) echo "selected" ?>>SC</option>
                            <option value="SE" <?php if (!empty($uf) && ($uf == "SE")) echo "selected" ?>>SE</option>
                            <option value="SP" <?php if (!empty($uf) && ($uf == "SP")) echo "selected" ?>>SP</option>
                            <option value="TO" <?php if (!empty($uf) && ($uf == "TO")) echo "selected" ?>>TO</option>
                        </select>
                    </div>
                </div>
            </div>
            <br />
            <br />


            <div class="row">
                <div class="form-group">
                    <div class="col-lg-10">
                        <input type="radio" onchange="responsableDadMotherFunction();" name="responsableDadMother" value="not"
                        <?php
                        if (empty($responsableDadMother) ||
                                (!empty($responsableDadMother) && ($responsableDadMother == "not")
                                ))
                            echo "checked='checked'"
                            ?>/> Preencher os dados de pai e mãe
                        <input type="radio" onchange="responsableDadMotherFunction();" name="responsableDadMother" value="dad"
                        <?php if (!empty($responsableDadMother) && ($responsableDadMother == "dad")) echo "checked='checked'" ?>
                               /> Utilizar os dados do responsável como pai
                        <input type="radio" onchange="responsableDadMotherFunction();" name="responsableDadMother" value="mother"
                        <?php if (!empty($responsableDadMother) && ($responsableDadMother == "mother")) echo "checked='checked'" ?>
                               /> Utilizar os dados do responsável como mãe
                    </div>


                </div>
            </div>
            <br class="dad" /><br class="dad" />
            <div class="row dad">
                <div class="form-group dad">
                    <div class="col-lg-3">
                        Dados do pai do(a) colonista:
                    </div>
                    <div class="col-lg-4">
                        <input onchange="hide_class('dad-form', this.checked);" class="dad" name="dadDeclare" type="checkbox"> Não desejo preencher
                        <input onchange="hide_class('dad-form', this.checked);" class="dad" name="dad" type="hidden" value="<?= $dad ?>">
                    </div>
                </div>
            </div>
            <br class="dad"/>
            <div class="dad dad-form row">
                <div class="form-group">
                    <label for="fullname" class="col-lg-2 control-label"> Nome: </label>
                    <div class="col-lg-6">
                        <input type="text" class="dad dad-form form-control" placeholder="Nome"
                               name="dadFullName" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Se não deseja preencher os dados do pai por favor marque a caixa de não desejo preencher.')"
                               oninput="setCustomValidity('')"
                               value="<?php
                               if (!empty($dadFullName)) {
                                   echo $dadFullName;
                               }
                               ?>"/>
                    </div>
                </div>
            </div>
            <br class="dad dad-form"/>
            <br class="dad dad-form"/>
            <div class="dad dad-form row">
                <div class="form-group">
                    <label for="dadphone" class="dad dad-form col-lg-1 control-label"> Telefone: </label>
                    <div class="col-lg-3">
                        <input type="text" class="dad dad-form form-control phone" placeholder="Telefone"
                               name="dadPhone" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Se não deseja preencher os dados do pai por favor marque a caixa de não desejo preencher.')"
                               oninput="setCustomValidity('')"
                               value="<?php
                               if (!empty($dadPhone)) {
                                   echo $dadPhone;
                               }
                               ?>"/>
                    </div>
                    <label for="fullname" class="dad dad-form col-lg-1 control-label"> E-mail: </label>
                    <div class="col-lg-3">
                        <input type="text" class="dad dad-form form-control" placeholder="E-mail"
                               name="dadEmail" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Se não deseja preencher os dados do pai por favor marque a caixa de não desejo preencher.')"
                               oninput="setCustomValidity('')"
                               value="<?php
                               if (!empty($dadEmail)) {
                                   echo $dadEmail;
                               }
                               ?>"/>
                    </div>
                </div>
            </div>
            <br class="dad-form" />
            <br class="dad-form" />
            <div class="row mother">
                <div class="form-group mother">
                    <div class="col-lg-3">
                        Dados da mãe do(a) colonista:
                    </div>
                    <div class="col-lg-4">
                        <input onchange="hide_class('mother-form', this.checked);" class="mother" name="motherDeclare" type="checkbox"> Não desejo preencher
                        <input onchange="hide_class('mother-form', this.checked);" class="mother" name="mother" type="hidden" value="<?= $mother ?>">
                    </div>
                </div>
            </div>
            <br class = "mother-form"/>
            <div class="mother mother-form row">
                <div class="form-group">
                    <label for="fullname" class="col-lg-2 control-label"> Nome: </label>
                    <div class="col-lg-6">
                        <input type="text" class="mother mother-form form-control" placeholder="Nome"
                               name="motherFullName" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Se não deseja preencher os dados da mãe por favor marque a caixa de não desejo preencher.')"
                               oninput="setCustomValidity('')"
                               value="<?php
                               if (!empty($motherFullName)) {
                                   echo $motherFullName;
                               }
                               ?>"/>
                    </div>
                </div>
            </div>
            <br class = "mother mother-form" />
            <br class = "mother mother-form"/>
            <div class="mother mother-form row">
                <div class="form-group">
                    <label for="motherphone" class="mother mother-form col-lg-1 control-label"> Telefone: </label>
                    <div class="col-lg-3">
                        <input type="text" class="mother mother-form form-control phone" placeholder="Telefone"
                               name="motherPhone" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Se não deseja preencher os dados da mãe por favor marque a caixa de não desejo preencher.')"
                               oninput="setCustomValidity('')"
                               value="<?php
                               if (!empty($motherPhone)) {
                                   echo $motherPhone;
                               }
                               ?>"/>
                    </div>
                    <label for="fullname" class="mother mother-form col-lg-1 control-label"> E-mail: </label>
                    <div class="col-lg-3">
                        <input type="text" class="mother mother-form form-control" placeholder="E-mail"
                               name="motherEmail" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Se não deseja preencher os dados da mãe por favor marque a caixa de não desejo preencher.')"
                               oninput="setCustomValidity('')"
                               value="<?php
                               if (!empty($motherEmail)) {
                                   echo $motherEmail;
                               }
                               ?>"/>
                    </div>
                </div>
            </div>
            <br class = "mother mother-form"/>
            <br class = "mother mother-form"/>

            <br/>
            <br/>
            <label class="control-label">Opcional: indique até 3 amigos(as) que gostaria que fizessem parte do quarto do(a) colonista: </label>
            <br/>
            <br/>

            <div class="row">
                <div class="form-group">
                    <label for="fullname" class="col-lg-2 control-label"> Amigo de quarto 1: </label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" placeholder="Nome Completo Amigo 1" name="roommate1"
                               value="<?php
                               if (!empty($roommate1)) {
                                   echo $roommate1;
                               }
                               ?>"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="fullname" class="col-lg-2 control-label"> Amigo de quarto 2: </label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" placeholder="Nome Completo Amigo 2" name="roommate2"
                               value="<?php
                               if (!empty($roommate2)) {
                                   echo $roommate2;
                               }
                               ?>"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="fullname" class="col-lg-2 control-label"> Amigo de quarto 3: </label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" placeholder="Nome Completo Amigo 3" name="roommate3"
                               value="<?php
                               if (!empty($roommate3)) {
                                   echo $roommate3;
                               }
                               ?>"/>
                    </div>
                </div>
            </div>

            <br /><br />

            <?php if ($summerCamp->isMiniCamp()) { ?>
                <input type="hidden" name="summerCampMini" value="1"/>
                <label class="control-label"><h4>MINI-KINDERLAND: </h4></label>
                <br />

                <div class="row">
                    <div class="form-group">
                        <label for="nameResponsible" class="col-lg-6 control-label">Nome do responsável para comunicação imediata em caso de emergência*: </label>
                        <input Name="nameResponsible" class="col-lg-5" ROWS=10 COLS=20 value="<?php echo $miniCamp->responsible_name; ?>"/>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="form-group">
                        <label for="phoneResponsible" class="col-lg-6 control-label">Telefone do responsável para comunicação em caso de emergência*: </label>
                        <input Name="phoneResponsible" class="col-lg-3 phone" placeholder="(ddd) Telefone de emergência"
                               maxlength="25" value="<?php echo $miniCamp->responsible_number; ?>"/>

                    </div>
                </div>
                <br>


                <div class="row">
                    <div class="form-group">
                        <label for="sleepOut" class="col-lg-6 control-label"> Já dormiu fora de casa?* </label>
                        <div class="col-lg-6">
                            <input type="radio" name="sleepOut" value="1"
                            <?php
                            if ($miniCamp->sleep_out == 't')
                                echo "checked='checked'"
                                ?>/> Sim
                            <input type="radio" name="sleepOut" value="0"
                            <?php
                            if ($miniCamp->sleep_out == 'f')
                                echo "checked='checked'"
                                ?>/> Não
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="wakeUpEarly" class="col-lg-6 control-label">O colonista costuma acordar cedo?* </label>
                        <div class="col-lg-6">
                            <input type="radio" name="wakeUpEarly" value="1"
                            <?php
                            if ($miniCamp->wake_up_early == 't')
                                echo "checked='checked'"
                                ?>/> Sim
                            <input type="radio" name="wakeUpEarly" value="0"
                            <?php
                            if ($miniCamp->wake_up_early == 'f')
                                echo "checked='checked'"
                                ?>
                                   /> Não
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group">
                        <label for="feedsIndependently" class="col-lg-6 control-label">Alimenta-se com independência?* </label>
                        <div class="col-lg-6">
                            <input type="radio" name="feedsIndependently" value="1"
                            <?php
                            if ($miniCamp->eat_by_oneself == 't')
                                echo "checked='checked'"
                                ?>/> Sim
                            <input type="radio" name="feedsIndependently" value="0"
                            <?php
                            if ($miniCamp->eat_by_oneself == 'f')
                                echo "checked='checked'"
                                ?>
                                   /> Não
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group">
                        <label for="wcIndependent" class="col-lg-6 control-label">Tem autonomia em relação ao uso do banheiro?* </label>
                        <div class="col-lg-6">
                            <input type="radio" name="wcIndependent" value="1"
                            <?php
                            if ($miniCamp->bathroom_freedom == 't')
                                echo "checked='checked'"
                                ?>/> Sim
                            <input type="radio" name="wcIndependent" value="0"
                            <?php
                            if ($miniCamp->bathroom_freedom == 'f')
                                echo "checked='checked'"
                                ?>
                                   /> Não
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group">
                        <label for="routineToFallAsleep" class="col-lg-6 control-label">O colonista tem algum tipo de rotina, ou ritual para adormecer?* </label>
                        <div class="col-lg-6">
                            <input type="radio" name="routineToFallAsleep" value="1"
                            <?php
                            if ($miniCamp->sleep_routine == 't')
                                echo "checked='checked'"
                                ?>/> Sim
                            <input type="radio" name="routineToFallAsleep" value="0"
                            <?php
                            if ($miniCamp->sleep_routine == 'f')
                                echo "checked='checked'"
                                ?>
                                   /> Não
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="bunkBed" class="col-lg-6 control-label">Possui alguma restrição quanto ao uso das camas de cima de um beliche?* </label>
                        <div class="col-lg-6">
                            <input type="radio" name="bunkBed" value="1"
                            <?php
                            if ($miniCamp->bunk_restriction == 't')
                                echo "checked='checked'"
                                ?>/> Sim
                            <input type="radio" name="bunkBed" value="0"
                            <?php
                            if ($miniCamp->bunk_restriction == 'f')
                                echo "checked='checked'"
                                ?>/> Não
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="awakeAtNight" class="col-lg-6 control-label">Costuma acordar a noite?* </label>
                        <div class="col-lg-6">
                            <input type="radio" name="awakeAtNight" value="1"
                            <?php
                            if ($miniCamp->wake_up_at_night == 't')
                                echo "checked='checked'"
                                ?>/> Sim
                            <input type="radio" name="awakeAtNight" value="0"
                            <?php
                            if ($miniCamp->wake_up_at_night == 'f')
                                echo "checked='checked'"
                                ?>
                                   /> Não
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="sleepwalk" class="col-lg-6 control-label">Apresenta sonambulismo?* </label>
                        <div class="col-lg-6">
                            <input type="radio" name="sleepwalk" value="1"
                            <?php
                            if ($miniCamp->sleepwalk == 't')
                                echo "checked='checked'"
                                ?>/> Sim
                            <input type="radio" name="sleepwalk" value="0"
                            <?php
                            if ($miniCamp->sleepwalk == 'f')
                                echo "checked='checked'"
                                ?>
                                   /> Não
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group">
                        <label for="sleepEnuresis" class="col-lg-6 control-label">Apresenta enurese noturna?* </label>
                        <div class="col-lg-6">
                            <input type="radio" name="sleepEnuresis" value="1"
                            <?php
                            if ($miniCamp->sleep_enuresis == 't')
                                echo "checked='checked'"
                                ?>/> Sim

                            <input type="radio" name="sleepEnuresis" value="0"
                            <?php
                            if ($miniCamp->sleep_enuresis == 'f')
                                echo "checked='checked'"
                                ?>
                                   /> Não
                        </div>
                    </div>
                </div>
                <br />
                <br />

                <div class="row">
                    <div class="form-group">
                        <label for="foodRestriction" class="col-lg-6 control-label">Possui restrição alimentar? Qual? </label>
                        <textarea Name="foodRestriction" class="col-lg-5" ROWS=5 COLS=20><?php echo $miniCamp->food_restriction; ?></textarea>
                    </div>
                </div>
                <br />
                <br />

                <div class="row">
                    <div class="form-group">
                        <label for="observationMini" class="col-lg-6 control-label">Há algo mais que seja relevante para a adaptação do colonista que você queira registrar? </label>
                        <textarea Name="observationMini" class="col-lg-5" ROWS=5 COLS=20><?php echo $miniCamp->observation; ?></textarea>
                    </div>
                </div>

                <br />
                <br />
            <?php } ?>


            <div class="form-group">
                <div class="col-lg-10">
                    <button class="btn btn-primary" onClick="validateForm(event)" style="margin-right:40px">Salvar</button> <br></br>
                    <button class="btn btn-warning" class="button" onclick="window.history.back();" value="Voltar">Voltar</button>
                </div>
            </div>

        </form>
    </div>
</div>