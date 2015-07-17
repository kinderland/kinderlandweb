<link href="<?=$this -> config -> item('assets'); ?>css/datepicker.css" rel="stylesheet" />
<link rel="text/javascript" href="<?=$this -> config -> item('assets'); ?>js/datepicker.less.js" />


<script>
	function verifyOtherSchool(){
		var val = $("#school_select").val();
		if(val == -1){
			$("#school_text").fadeIn();
			$("#school_text").prop('disabled', false);			
		}
		else{
			$("#school_text").fadeOut();
			$("#school_text").prop('disabled', true);			
		}
	}
	
	function verifyCPF(){
		var val = $("#documentType").val();
		if(val == "CPF"){
			var cpf = $("#documentNumber").val();
			if(!TestaCPF(cpf)){
				alert("CPF do colonista é inválido");
				$("#documentNumber").each(function() {
				    this.setCustomValidity("Este campo está ou vazio ou contém um CPF inválido");
				});
			}
		}
	}

    function TestaCPF(strCPF) {
        var cpf = strCPF.replace(".", "");
        cpf = cpf.replace(".","");
        cpf = cpf.replace("-","");
        var Soma;
        var Resto;
        Soma = 0;
        //strCPF  = RetiraCaracteresInvalidos(strCPF,11);
        //pequena modificaçao para verificar todos os cpfs com todos os digitos iguais, antes so era verificado o primeiro caso
        if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" ||
                cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" ||
                cpf == "88888888888" || cpf == "99999999999")
            return false;
        for (i = 1; i <= 9; i++)
            Soma = Soma + parseInt(cpf.substring(i - 1, i)) * (11 - i);cpf
        Resto = (Soma * 10) % 11;
        if ((Resto == 10) || (Resto == 11))
            Resto = 0;
        if (Resto != parseInt(cpf.substring(9, 10)))
            return false;
        Soma = 0;
        for (i = 1; i <= 10; i++)
            Soma = Soma + parseInt(cpf.substring(i - 1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;
        if ((Resto == 10) || (Resto == 11))
            Resto = 0;
        if (Resto != parseInt(cpf.substring(10, 11)))
            return false;
        return true;
    }


	function addressResponsable() {

		var val = $('input:radio[name=sameAddressResponsable]:checked').val();
    var changeTo = true;
    if(val == "s"){
      $("#addressRow").hide();
    }else{
      $("#addressRow").show();
      changeTo = false;
		}
		var labels = $(".endereco");
		for ( index = 0, len = labels.length; index < len; ++index) {
			labels[index].disabled = changeTo;
		}
	}

	function toggleInputStatusIn(element, disable) {
		if (disable == true) {
			$(element).find(':input').prop('disabled', true);
			$(element + ' a').click(function(e) {
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


	$(document).ready(function() {
		var SPMaskBehavior = function(val) {
			return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
		},
		    spOptions = {
			onKeyPress : function(val, e, field, options) {
				field.mask(SPMaskBehavior.apply({}, arguments), options);
			}
		};

		$(".phone").mask(SPMaskBehavior, spOptions);

		$(".birthdate").mask("00/00/0000", {
			placeholder : "__/__/____"
		});
		;
		addressResponsable();
	});

</script>
<div class="row">
    <div class="col-lg-12 middle-content">
        <div class="row">
            <div class="col-lg-8"><h4>Pré-inscrição de colonista na colonia: <?=$summerCamp -> getCampName() ?></h4></div>
            <div class="col-lg-4"><h6><span class="red_letters">Campos com * são de preenchimento obrigatório.</span></h6></div>
        </div>
        <hr />

        <form name="formulario" method="POST" action="<?= $this -> config -> item('url_link') ?>summercamps/completeSubscription">
        	<input type="hidden" name="summerCampId" value="<?= $id ?>"/>
            <div class="row">
                <div class="form-group">
                    <label for="fullname" class="col-lg-2 control-label"> Nome Completo*: </label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" placeholder="Nome Completo"
                               name="fullname" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php
							if (!empty($_POST['fullname'])) {
								echo $_POST['fullname'];
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
<?php if (!empty($_POST['gender']) && ($_POST['gender'] == "M")) echo "selected" ?> >Masculino</option>
                            <option value="F"
<?php if (!empty($_POST['gender']) && ($_POST['gender'] == "F")) echo "selected" ?>>Feminino</option>
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
							if (!empty($_POST['birthdate'])) {
								echo $_POST['birthdate'];
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
<?php if (!empty($_POST['documentType']) && ($_POST['gender'] == "RG")) echo "selected" ?> >RG</option>
                            <option value="CPF"
<?php if (!empty($_POST['documentType']) && ($_POST['documentType'] == "CPF")) echo "selected" ?>>CPF</option>
                            <option value="Certidao"
<?php if (!empty($_POST['documentType']) && ($_POST['documentType'] == "Certidao")) echo "selected" ?>>Certidão de Nascimento</option>
                        </select>
                    </div>
                    <label for="documentNumber" class="col-lg-1 control-label"> Numero do documento*: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" placeholder="Numero do documento"
                               name="documentNumber" id="documentNumber" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo está ou vazio ou contém um CPF inválido')"
                               oninput="setCustomValidity('');" onblur="verifyCPF();"
                               value="<?php
							if (!empty($_POST['documentNumber'])) {
								echo $_POST['documentNumber'];
							}
					?>"/>

                    </div>
                </div>
            </div>
            <br />

            <div class="row">
                <div class="form-group">
                    <label for="school" class="col-lg-2 control-label"> Nome da Escola*: </label>
                    <div class="col-lg-2">
                    	<?php $schools = $this -> summercamp_model -> getSchools(); ?>
                        <select  class="form-control" id="school_select" name="school[]" required                                
                        oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                               onchange="setCustomValidity('');verifyOtherSchool();"
						 >
						<option value="" selected>-- Selecione --</option>
                        <?php foreach($schools as $actual_school){
							echo "<option value='".$actual_school."' ";
							if (!empty($_POST['school']) && ($_POST['school'] == $actual_school)) echo "selected"; 
								echo ">".$actual_school."</option>";								                            	
                        }?>
                        <option value="-1">Outra</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-4">
                        <input type="text" class="form-control" placeholder="Nome da escola"
                               name="school[]" id="school_text" disabled style="display: none;" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               />
                     </div>
                    

                    <label for="schoolYear" class="col-lg-1 control-label"> Ano escolar*: </label>
                    <div class="col-lg-3">
                        <select  class="form-control" id="schoolYear" name="schoolYear" required                                
                        oninvalid="this.setCustomValidity('Por favor selecione uma opção.')"
                               onchange="setCustomValidity('')"
						 >
                            <option value="" selected>-- Selecione --</option>
                            <?php for($__school_year__=1;$__school_year__<=9;$__school_year__++){
								echo "<option value='".$__school_year__."' ";
								if (!empty($_POST['schoolYear']) && ($_POST['schoolYear'] == $__school_year__)) echo "selected"; 
								echo ">".$__school_year__."</option>";								                            	
                            }?>
                        </select>
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
							if (!empty($_POST['phone1'])) {
								echo $_POST['phone1'];
							}
						 ?>"/>
                    </div>

                    <label for="phone2" class="col-lg-3 control-label"> Telefone Secundário: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control phone" placeholder="(ddd) Telefone secundário"
                               name="phone2" maxlength="25" onkeypress="return validateNumberInput(event);"
                               value="<?php
							if (!empty($_POST['phone2'])) {
								echo $_POST['phone2'];
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
                        <?php if ( empty($_POST['sameAddressResponsable']) || 
                        (!empty($_POST['sameAddressResponsable']) && ($_POST['sameAddressResponsable'] == "s")
						)) echo "checked='checked'" ?>/> Sim
                        <input type="radio" onchange="addressResponsable();" name="sameAddressResponsable" value="n"                         
                        <?php if (!empty($_POST['sameAddressResponsable']) && ($_POST['sameAddressResponsable'] == "n")) echo "checked='checked'" ?>
						/> Não
                    </div>


                </div>
            </div>
            <br />
            <br />

            <div id="addressRow">
            <div class="row">
                <div class="form-group">
                    <label for="street" class="col-lg-1 control-label"> Logradouro: </label>
                    <div class="col-lg-11">
                        <input type="text" class="form-control endereco" placeholder="Logradouro"
                               name="street" onkeypress="return validateLetterInput(event);"
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php
							if (!empty($_POST['street'])) {
								echo $_POST['street'];
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
							if (!empty($_POST['number'])) {
								echo $_POST['number'];
							}
 ?>"/>
                    </div>

                    <label for="complement" class="col-lg-2 control-label " > Complemento: </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control endereco" placeholder="Complemento" 
                               name="complement"
                               value="<?php
							if (!empty($_POST['complement'])) {
								echo $_POST['complement'];
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
							if (!empty($_POST['neighborhood'])) {
								echo $_POST['neighborhood'];
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
							if (!empty($_POST['cep'])) {
								echo $_POST['cep'];
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
                               oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
                               oninput="setCustomValidity('')"
                               value="<?php
							if (!empty($_POST['city'])) {
								echo $_POST['city'];
							}
 ?>"/>
                    </div>

                    <label for="uf" class="col-lg-2 control-label"> Estado*: </label>
                    <div class="col-lg-3">
                        <select  class="form-control endereco" id="uf" name="uf" required
                                 oninvalid="this.setCustomValidity('Favor escolher um item da lista.')"
                                 oninput="setCustomValidity('')">
                            <option value=""> -- Selecione -- </option>
                            <option value="RJ" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "RJ")) echo "selected" ?>>RJ</option>
                            <option value="AC" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "AC")) echo "selected" ?>>AC</option>
                            <option value="AL" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "AL")) echo "selected" ?>>AL</option>
                            <option value="AM" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "AM")) echo "selected" ?>>AM</option>
                            <option value="AP" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "AP")) echo "selected" ?>>AP</option>
                            <option value="BA" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "BA")) echo "selected" ?>>BA</option>
                            <option value="CE" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "CE")) echo "selected" ?>>CE</option>
                            <option value="DF" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "DF")) echo "selected" ?>>DF</option>
                            <option value="ES" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "ES")) echo "selected" ?>>ES</option>
                            <option value="GO" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "GO")) echo "selected" ?>>GO</option>
                            <option value="MA" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "MA")) echo "selected" ?>>MA</option>
                            <option value="MG" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "MG")) echo "selected" ?>>MG</option>
                            <option value="MS" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "MS")) echo "selected" ?>>MS</option>
                            <option value="MT" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "MT")) echo "selected" ?>>MT</option>
                            <option value="PA" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "PA")) echo "selected" ?>>PA</option>
                            <option value="PB" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "PB")) echo "selected" ?>>PB</option>
                            <option value="PE" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "PE")) echo "selected" ?>>PE</option>
                            <option value="PI" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "PI")) echo "selected" ?>>PI</option>
                            <option value="PR" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "PR")) echo "selected" ?>>PR</option>
                            <option value="RN" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "RN")) echo "selected" ?>>RN</option>
                            <option value="RO" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "RO")) echo "selected" ?>>RO</option>
                            <option value="RR" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "RR")) echo "selected" ?>>RR</option>
                            <option value="RS" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "RS")) echo "selected" ?>>RS</option>
                            <option value="SC" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "SC")) echo "selected" ?>>SC</option>
                            <option value="SE" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "SE")) echo "selected" ?>>SE</option>
                            <option value="SP" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "SP")) echo "selected" ?>>SP</option>
                            <option value="TO" <?php if (!empty($_POST['uf']) && ($_POST['uf'] == "TO")) echo "selected" ?>>TO</option>
                        </select>
                    </div>
                </div>
            </div>

          </div>
            <br />
            <br />


            <div class="row">
                <div class="form-group">
                    <div class="col-lg-10">
                        <input type="radio" onchange="responsableDadMotherFunction();" name="responsableDadMother" value="not" 
                        <?php if ( empty($_POST['responsableDadMother']) || 
                        (!empty($_POST['responsableDadMother']) && ($_POST['responsableDadMother'] == "not")
						)) echo "checked='checked'" ?>/> Preencher os dados de pai e mãe
                        <input type="radio" onchange="responsableDadMotherFunction();" name="responsableDadMother" value="dad"                         
                        <?php if (!empty($_POST['responsableDadMother']) && ($_POST['responsableDadMother'] == "dad")) echo "checked='checked'" ?>
						/> Utilizar os dados do responsável como pai
                        <input type="radio" onchange="responsableDadMotherFunction();" name="responsableDadMother" value="mother"                         
                        <?php if (!empty($_POST['responsableDadMother']) && ($_POST['responsableDadMother'] == "mother")) echo "checked='checked'" ?>
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
			             <input onchange="hide_class('dad-form',this.checked);" class="dad" name="dadDeclare" type="checkbox"> Não desejo preencher
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
							if (!empty($_POST['dadFullName'])) {
								echo $_POST['dadFullName'];
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
                        <input type="text" class="dad dad-form form-control" placeholder="Telefone"
                               name="dadPhone" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Se não deseja preencher os dados do pai por favor marque a caixa de não desejo preencher.')"
                               oninput="setCustomValidity('')"
                               value="<?php
							if (!empty($_POST['dadPhone'])) {
								echo $_POST['dadPhone'];
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
							if (!empty($_POST['dadEmail'])) {
								echo $_POST['dadEmail'];
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
			             <input onchange="hide_class('mother-form',this.checked);" class="mother" name="motherDeclare" type="checkbox"> Não desejo preencher
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
							if (!empty($_POST['motherFullName'])) {
								echo $_POST['motherFullName'];
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
                        <input type="text" class="mother mother-form form-control" placeholder="Telefone"
                               name="motherPhone" onkeypress="return validateLetterInput(event);" required
                               oninvalid="this.setCustomValidity('Se não deseja preencher os dados da mãe por favor marque a caixa de não desejo preencher.')"
                               oninput="setCustomValidity('')"
                               value="<?php
							if (!empty($_POST['motherPhone'])) {
								echo $_POST['motherPhone'];
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
							if (!empty($_POST['motherEmail'])) {
								echo $_POST['motherEmail'];
							}
					 ?>"/>                
					</div>
				 </div>
            </div>
            <br class = "mother mother-form"/>            
            <br class = "mother mother-form"/>

            <br /><br />

            <div class="form-group">
                <div class="col-lg-10">
                    <button class="btn btn-primary" style="margin-right:40px" onClick="validateForm(event)">Confirmar</button>
                </div>
            </div>

        </form>
    </div>
</div>