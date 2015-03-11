<script type="text/javascript" charset="utf-8">

function validateForm(){
	/*
	if(!validateEmail("signup_form","email","e-mail") || !validateNotEmptyField("signup_form","fullname","Nome")||
	 (!validateNotEmptyField("signup_form","cpf","CPF") || !validateNotEmptyField("signup_form","gender","Sexo"))||
	 (!validateNotEmptyField("signup_form","password","Senha") || !validateNotEmptyField("signup_form","street","Logradouro"))||
	 (!validateNotEmptyField("signup_form","number","Número") || !validateNotEmptyField("signup_form","city","Cidade"))||
	 (!validateNotEmptyField("signup_form","cep","CEP") || !validateNotEmptyField("signup_form","uf","Estado"))||
	 (!validateNotEmptyField("signup_form","phone1","Telefone 1"))||
	 (!confirmField("email","confirm_email","E-mail") || !confirmPassword("password","confirm_password")))
		return false;
	

	if(!validateEmail("signup_form","email","e-mail"))
		return false;
	if(!validateNotEmptyField("signup_form","fullname","Nome"))
		return false;
	if(!validateNotEmptyField("signup_form","cpf","CPF"))
		return false;
	if(!validateNotEmptyField("signup_form","gender","Sexo"))
		return false;
	
	(!validateNotEmptyField("signup_form","password","Senha") || !validateNotEmptyField("signup_form","street","Logradouro"))||
	(!validateNotEmptyField("signup_form","number","Número") || !validateNotEmptyField("signup_form","city","Cidade"))||
	(!validateNotEmptyField("signup_form","cep","CEP") || !validateNotEmptyField("signup_form","uf","Estado"))||
	(!validateNotEmptyField("signup_form","phone1","Telefone 1"))||
	(!confirmField("email","confirm_email","E-mail") || !confirmPassword("password","confirm_password")))
	

	$.get(
		"<?=$this->config->item('url_link')?>login/checkExistingCpf?cpf=" + $("#cpf").val(),
		function( data ) {
			if(data == "true")
				alert( "Este CPF já está cadastrado." );
			else{
				//alert("CPF ok");
				$("#signup_form").submit();
			}
		});*/

	$("#signup_form").submit();

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
			$.get(
			"<?=$this->config->item('url_link')?>login/checkExistingCpf?cpf=" + $("#cpf").val(),
			function( data ) {
				if(data == "true")
					alert( "Este CPF já está cadastrado." );
			});
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
	<div class="col-lg-12 middle-content">
		<div class="row">
			<div class="col-lg-8"><h4>Cadastro de usuário</h4></div>
			<!--<div class="col-lg-4"><h6><span class="red_letters">Campos com * são de preenchimento obrigatório.</span></h6></div>-->
		</div>
		<hr />

		<form name="edit_form" method="POST" action="<?=$this->config->item('url_link')?>login/completeSignup" id="edit_form">
			<div class="row">
				<div class="form-group">
					<label for="fullname" class="col-lg-1 control-label"> Nome Completo*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Nome Completo"
							name="fullname" onkeypress="return validateLetterInput(event);" required 
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
							
					</div>

					<label for="cpf" class="col-lg-1 control-label"> CPF*: </label>
					<div class="col-lg-3">
						<input type="text" id="cpf" class="form-control" placeholder="CPF"
							name="cpf" maxlength="11" onkeypress="return validateNumberInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
    					<script type="text/javascript">
					        window.onload = funcCpf();
					    </script>

					</div>

					<label for="gender" class="col-lg-1 control-label"> Sexo*: </label>
					<div class="col-lg-3">
						<select  class="form-control" id="gender" name="gender" >
							<option value="" selected>-- Selecione --</option>
							<option value="M">Masculino</option>
							<option value="F">Feminino</option>
						</select>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="email" class="col-lg-1 control-label"> E-mail*: </label>
					<div class="col-lg-3">
						<input type="email" id="email" class="form-control" placeholder="Email"
							name="email" required
							oninvalid="this.setCustomValidity('Este campo requer um endereço de email. Favor incluir @ e .')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="confirm_email" class="col-lg-1 control-label"> Confirme o E-mail*: </label>
					<div class="col-lg-3">
						<input type="email" id="confirm_email" class="form-control" placeholder="Email"
							name="confirm_email" required
							oninvalid="this.setCustomValidity('Este campo requer um endereço de email. Favor incluir @ e .')"
    						oninput="setCustomValidity('')"/>
    					<script type="text/javascript">
					        window.onload = funcEmail();
					    </script>
					</div>

					<label for="occupation" class="col-lg-1 control-label"> Ocupação*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Ocupação"
							name="occupation" onkeypress="return validateLetterInput(event);" required
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
							name="street" onkeypress="return validateLetterInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="number" class="col-lg-1 control-label"> Número*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Número"
							name="number" onkeypress="return validateNumberInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="complement" class="col-lg-2 control-label"> Complemento: </label>
					<div class="col-lg-2">
						<input type="text" class="form-control" placeholder="Complemento"
							name="complement"/>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="city" class="col-lg-1 control-label"> Cidade*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Cidade"
							name="city" onkeypress="return validateLetterInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="cep" class="col-lg-1 control-label"> CEP*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="CEP"
							name="cep" maxlength="8" onkeypress="return validateNumberInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="neighborhood" class="col-lg-2 control-label"> Bairro: </label>
					<div class="col-lg-2">
						<input type="text" class="form-control" placeholder="Bairro"
							name="neighborhood" onkeypress="return validateLetterInput(event);"/>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="phone1" class="col-lg-1 control-label"> Telefone 1*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Telefone de contato 1"
							name="phone1" maxlength="25" onkeypress="return validateNumberInput(event);" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="phone2" class="col-lg-1 control-label"> Telefone 2: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Telefone de contato 2"
							name="phone2" maxlength="25" onkeypress="return validateNumberInput(event);"/>
					</div>

					<label for="uf" class="col-lg-1 control-label"> Estado*: </label>
					<div class="col-lg-3">
						<select  class="form-control" id="uf" name="uf" required
							oninvalid="this.setCustomValidity('Favor escolher um item da lista.')"
    						oninput="setCustomValidity('')">
							<option value="" selected> -- Selecione -- </option>
							<option value="RJ">RJ</option>
							<option value="AC">AC</option>
							<option value="AL">AL</option>
							<option value="AM">AM</option>
							<option value="AP">AP</option>
							<option value="BA">BA</option>
							<option value="CE">CE</option>
							<option value="DF">DF</option>
							<option value="ES">ES</option>
							<option value="GO">GO</option>
							<option value="MA">MA</option>
							<option value="MG">MG</option>
							<option value="MS">MS</option>
							<option value="MT">MT</option>
							<option value="PA">PA</option>
							<option value="PB">PB</option>
							<option value="PE">PE</option>
							<option value="PI">PI</option>
							<option value="PR">PR</option>
							<option value="RN">RN</option>
							<option value="RO">RO</option>
							<option value="RR">RR</option>
							<option value="RS">RS</option>
							<option value="SC">SC</option>
							<option value="SE">SE</option>
							<option value="SP">SP</option>
							<option value="TO">TO</option>
						</select>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="password" class="col-lg-1 control-label"> Senha*: </label>
					<div class="col-lg-3">
						<input type="password" id="password" class="form-control" placeholder="" name="password" required
						oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    					oninput="setCustomValidity('')"/>
					</div>

					<label for="confirm_password" class="col-lg-2 control-label"> Confirme a senha*: </label>
					<div class="col-lg-3">
						<input type="password" id="confirm_password" class="form-control" name="confirm_password" required
						oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    					oninput="setCustomValidity('')"/>
    					 <script type="text/javascript">
					        window.onload = funcPassword();
					     </script>
					</div>
				</div>
			</div>

			<br /><br /><br />

			<div class="form-group">
				<div class="col-lg-10">
					<button class="btn btn-primary" style="margin-right:40px" onClick="validateForm()">Confirmar</button>
					<a href="<?=$this->config->item('url_link')?>login/index"><button class="btn btn-warning">Voltar</button></a>
				</div>
			</div>
			
		</form>
	</div>
</div>