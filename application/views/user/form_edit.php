<script type="text/javascript" charset="utf-8">

function validateForm(){
	// if(!validateEmail("edit_form","email","e-mail") || !validateNotEmptyField("edit_form","fullname","Nome"))
	// 	return false;

	// if(!validateNotEmptyField("edit_form","cpf","CPF") || !validateNotEmptyField("edit_form","gender","Sexo"))
	// 	return false;


	$("#edit_form").submit();
}

function callMasks(){

	$("input[name='cpf']").mask("999.999.999-99");
	$("input[name='cep']").mask("99999-999");
	//$("input[name='phone1']").mask("(99)99999-9999");
	//$("input[name='phone2']").mask("(99)99999-9999");
}
/* permite apenas numeros, tab e backspace*/
function validateNumberInput(evt){

    var key_code = (evt.which) ? evt.which : evt.keyCode; 
    if ((key_code >= 48 && key_code <= 57) || key_code == 9 || key_code == 8) {
    	return true;
    }
	return false;
}
/* permite letras, letras com acentos, hifen e espaco */
function validateLetterInput(evt) {

    var key_code = (evt.which) ? evt.which : evt.keyCode;

	if ((key_code >= 65 && key_code <= 90) || (key_code >= 97 && key_code <= 122) || key_code == 9 || key_code == 39
		|| key_code == 8 || key_code == 45 || key_code == 32  || (key_code >= 180 && key_code <= 252)) {

            return true;
    }
    return false;
} 
/* tirado diretamente do site da receita federal */
function TestaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;   
    //strCPF  = RetiraCaracteresInvalidos(strCPF,11);
    //pequena modificaçao para verificar todos os cpfs com todos os digitos iguais, antes so era verificado o primeiro caso
    if (strCPF == "00000000000" || strCPF == "11111111111" || strCPF == "22222222222" || strCPF == "33333333333" ||
    	strCPF == "44444444444" || strCPF == "55555555555" || strCPF == "66666666666" || strCPF == "77777777777" ||
    	strCPF == "88888888888" || strCPF == "99999999999") 
		return false;
    for (i=1; i<=9; i++)
		Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i); 
    Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11)) 
		Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) )
		return false;
	Soma = 0;
    for (i = 1; i <= 10; i++)
       Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;
    if ((Resto == 10) || (Resto == 11)) 
		Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) )
        return false;
    return true;
}

function funcCpf(){
	var cpfCheck = document.getElementById("cpf");
	cpfCheck.onchange = function(){
		if(TestaCPF(cpfCheck.value)){
			cpfCheck.style.backgroundColor = "#FFFFFF";
		}
		else{
			cpfCheck.style.backgroundColor = "#F78D8D"; 
		}
	};
}

function funcEmail(){
	var email = document.getElementById("email");
	var confirm_email = document.getElementById("confirm_email");
	confirm_email.onchange = function(){
		if(email.value === confirm_email.value){
			confirm_email.style.backgroundColor = "#FFFFFF";
		}
		else{
			 confirm_email.style.backgroundColor = "#F78D8D";
			 alert( "E-mail e confirmação de e-mail não estão iguais. Favor verificar." ); 
		}
	};
}

function funcPassword(){
	var password = document.getElementById("password");
	var confirm_password = document.getElementById("confirm_password");
	confirm_password.onchange = function(){
		if(password.value === confirm_password.value){
			confirm_password.style.backgroundColor = "#FFFFFF";
		}
		else{
			confirm_password.style.backgroundColor = "#F78D8D";
			alert( "Senha e confirmação de senha não estão iguais. Favor verificar." );
			 //$("#confirm_password > div").attr("class", "has-error"); 
		}
	};
}

</script>

<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">
		<div class="row">
			<div class="col-lg-8"><h4>Confirmação de dados</h4></div>
		</div>
		<hr />

		<form name="edit_form" method="POST" action="<?=$this->config->item('url_link')?>user/update" id="edit_form">
			<div class="row">
				<div class="form-group">
					<label for="fullname" class="col-lg-1 control-label"> Nome Completo*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Nome Completo"
							name="fullname" value="<?=$user->getFullname()?>" 
							onkeypress="return validateLetterInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="cpf" id="cpf" class="col-lg-1 control-label"> CPF*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="CPF"
							name="cpf" value="<?=$user->getCPF()?>" 
							maxlength="11" onkeypress="return validateNumberInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
    					<script type="text/javascript">
					        window.onload = funcCpf();
					    </script>
					</div>

					<label for="gender" class="col-lg-1 control-label"> Sexo*: </label>
					<div class="col-lg-3">
						<select  class="form-control" id="gender" name="gender" required
							oninvalid="this.setCustomValidity('Favor escolher um item da lista.')"
    						oninput="setCustomValidity('')">>
							<option value="M" <?php if($user->getGender() == "M") echo "selected" ?> >Masculino</option>
							<option value="F" <?php if($user->getGender() == "F") echo "selected" ?> >Feminino</option>
						</select>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="email" id="email" class="col-lg-1 control-label"> E-mail*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Email"
							name="email" value="<?=$user->getEmail()?>" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="email" id="confirm_email" class="col-lg-1 control-label"> Confirme o E-mail*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Email"
							name="email" value="<?=$user->getEmail()?>" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
    					<script type="text/javascript">
					        window.onload = funcEmail();
					    </script>
					</div>

					<label for="occupation" class="col-lg-1 control-label"> Ocupação*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Ocupação"
							name="occupation"  value="<?=$user->getOccupation()?>" 
							onkeypress="return validateLetterInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="street" class="col-lg-1 control-label"> Rua*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Logradouro"
							name="street" value="<?=$user->getAddress()->getStreet()?>" 
							onkeypress="return validateLetterInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="number" class="col-lg-1 control-label"> Número*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Número"
							name="number" value="<?=$user->getAddress()->getPlaceNumber()?>" 
							onkeypress="return validateNumberInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="complement" class="col-lg-2 control-label"> Complemento: </label>
					<div class="col-lg-2">
						<input type="text" class="form-control" placeholder="Complemento"
							name="complement" value="<?=$user->getAddress()->getComplement()?>" />
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="city" class="col-lg-1 control-label"> Cidade*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Cidade"
							name="city" value="<?=$user->getAddress()->getCity()?>" 
							onkeypress="return validateLetterInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="cep" class="col-lg-1 control-label"> CEP*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="CEP"
							name="cep" value="<?=$user->getAddress()->getCEP()?>" maxlength="8"
							onkeypress="return validateNumberInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="neighborhood" class="col-lg-2 control-label"> Bairro: </label>
					<div class="col-lg-2">
						<input type="text" class="form-control" placeholder="Bairro"
							name="neighborhood" value="<?=$user->getAddress()->getNeighborhood()?>" 
							onkeypress="return validateLetterInput(event);"/>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="phone1" class="col-lg-1 control-label"> Telefone 1*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Telefone de contato 1"
							name="phone1" value="<?=$user->getPhone1()?>"
							onkeypress="return validateNumberInput(event);"/>
					</div>

					<label for="phone2" class="col-lg-1 control-label"> Telefone 2*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Telefone de contato 2"
							name="phone2" value="<?=$user->getPhone2()?>"
							onkeypress="return validateNumberInput(event);"/>
					</div>

					<label for="uf" class="col-lg-1 control-label"> Estado*: </label>
					<div class="col-lg-3">
						<select  class="form-control" id="uf" name="uf" >
							<option value="RJ" <?php if($user->getAddress()->getUF() == "RJ") echo "selected" ?> >RJ</option>
							<option value="AC" <?php if($user->getAddress()->getUF() == "AC") echo "selected" ?> >AC</option>
							<option value="AL" <?php if($user->getAddress()->getUF() == "AL") echo "selected" ?> >AL</option>
							<option value="AM" <?php if($user->getAddress()->getUF() == "AM") echo "selected" ?> >AM</option>
							<option value="AP" <?php if($user->getAddress()->getUF() == "AP") echo "selected" ?> >AP</option>
							<option value="BA" <?php if($user->getAddress()->getUF() == "BA") echo "selected" ?> >BA</option>
							<option value="CE" <?php if($user->getAddress()->getUF() == "CE") echo "selected" ?> >CE</option>
							<option value="DF" <?php if($user->getAddress()->getUF() == "DF") echo "selected" ?> >DF</option>
							<option value="ES" <?php if($user->getAddress()->getUF() == "ES") echo "selected" ?> >ES</option>
							<option value="GO" <?php if($user->getAddress()->getUF() == "GO") echo "selected" ?> >GO</option>
							<option value="MA" <?php if($user->getAddress()->getUF() == "MA") echo "selected" ?> >MA</option>
							<option value="MG" <?php if($user->getAddress()->getUF() == "MG") echo "selected" ?> >MG</option>
							<option value="MS" <?php if($user->getAddress()->getUF() == "MS") echo "selected" ?> >MS</option>
							<option value="MT" <?php if($user->getAddress()->getUF() == "MT") echo "selected" ?> >MT</option>
							<option value="PA" <?php if($user->getAddress()->getUF() == "PA") echo "selected" ?> >PA</option>
							<option value="PB" <?php if($user->getAddress()->getUF() == "PB") echo "selected" ?> >PB</option>
							<option value="PE" <?php if($user->getAddress()->getUF() == "PE") echo "selected" ?> >PE</option>
							<option value="PI" <?php if($user->getAddress()->getUF() == "PI") echo "selected" ?> >PI</option>
							<option value="PR" <?php if($user->getAddress()->getUF() == "PR") echo "selected" ?> >PR</option>
							<option value="RN" <?php if($user->getAddress()->getUF() == "RN") echo "selected" ?> >RN</option>
							<option value="RO" <?php if($user->getAddress()->getUF() == "RO") echo "selected" ?> >RO</option>
							<option value="RR" <?php if($user->getAddress()->getUF() == "RR") echo "selected" ?> >RR</option>
							<option value="RS" <?php if($user->getAddress()->getUF() == "RS") echo "selected" ?> >RS</option>
							<option value="SC" <?php if($user->getAddress()->getUF() == "SC") echo "selected" ?> >SC</option>
							<option value="SE" <?php if($user->getAddress()->getUF() == "SE") echo "selected" ?> >SE</option>
							<option value="SP" <?php if($user->getAddress()->getUF() == "SP") echo "selected" ?> >SP</option>
							<option value="TO" <?php if($user->getAddress()->getUF() == "TO") echo "selected" ?> >TO</option>
						</select>
					</div>
				</div>
			</div>
			<br/>
				<div class="row">
				<div class="form-group">
					<label for="password" class="col-lg-1 control-label"> Senha*: </label>
					<div class="col-lg-3">
						<input type="password" class="form-control" placeholder="" name="password" />
					</div>

					<label for="confirm_password" class="col-lg-2 control-label"> Confirme a senha*: </label>
					<div class="col-lg-3">
						<input type="password" class="form-control" name="confirm_password" />
					</div>
				</div>
			</div>
				<br /><br /><br />

				<div class="form-group">
					<div class="col-lg-10">
						<button class="btn btn-primary" style="margin-right:40px" onClick="validateFormInfo()">Atualizar cadastro</button>
						<button class="btn btn-warning" onClick="goToMainMenu()">Voltar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
