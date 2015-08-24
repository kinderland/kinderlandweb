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

        <form name="formulario" method="POST" action="<?= $this->config->item('url_link') ?>admin/editColonist">
            <input type="hidden" name="summerCampId" value="<?= $summerCampId ?>"/>
            <input type="hidden" name="colonistId" value="<?= $colonistId ?>"/>
            <input type="hidden" name="personId" value="<?= $personId ?>"/>
            <br />
            <br />
            <div class="row">

                <div class="form-group">
                    <label for="fullname" class="col-lg-2 control-label"> Nome Completo*: </label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control"
                               name="fullname" disabled  value="
                               <?php
                               if ($fullName) {
                                   echo $fullName;
                               }
                               ?>"/>

                    </div>
                    <br>
                    <br>
                    <br>
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
                    <div class="col-lg-4">
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
                    <br>
                    <br>
                    <br>
                    <label for="documentNumber" class="col-lg-2 control-label"> Numero do documento*: </label>
                    <div class="col-lg-10">
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

            <div class="form-group">
                <div class="col-lg-10">
                    <button class="btn btn-primary" onClick="validateForm(event)" style="margin-right:40px">Salvar</button> <br></br>
                    <button class="btn btn-warning" class="button" onclick="window.history.back();" value="Voltar">Voltar</button>
                </div>
            </div>

        </form>
    </div>
</div>