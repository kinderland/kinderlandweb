
<script type="text/javascript" charset="utf-8">

function validateForm(){
	if(!validateEmail("signup_form","email","e-mail") || !validateNotEmptyField("signup_form","fullname","Nome")||
	 (!validateNotEmptyField("signup_form","cpf","CPF") || !validateNotEmptyField("signup_form","gender","Sexo"))||
	 (!validateNotEmptyField("signup_form","password","Senha") || !validateNotEmptyField("signup_form","street","Logradouro"))||
	 (!validateNotEmptyField("signup_form","number","Número") || !validateNotEmptyField("signup_form","city","Cidade"))||
	 (!validateNotEmptyField("signup_form","cep","CEP") || !validateNotEmptyField("signup_form","uf","Estado"))||
	 (!validateNotEmptyField("signup_form","phone1","Telefone 1"))||
	 (!confirmField("email","confirm_email","E-mail") || !confirmPassword("password","confirm_password")))
		return false;
  	
/*	if(!validateNotEmptyField("signup_form","cpf","CPF") || !validateNotEmptyField("signup_form","gender","Sexo"))
		return false;

	if(!confirmField("email","confirm_email","E-mail") || !confirmPassword("password","confirm_password"))
		return false;

	if(!validateNotEmptyField("signup_form","password","Senha") || !validateNotEmptyField("signup_form","street","Logradouro"))
		return false;

	if(!validateNotEmptyField("signup_form","number","Número") || !validateNotEmptyField("signup_form","city","Cidade"))
		return false;

	if(!validateNotEmptyField("signup_form","cep","CEP") || !validateNotEmptyField("signup_form","uf","Estado"))
		return false;

	if(!validateNotEmptyField("signup_form","phone1","Telefone 1"))
		return false;*/

		$("#signup_form").submit();
}

function callMasks(){

	$("input[name='cpf']").mask("999.999.999-99");
	$("input[name='phone1']").mask("(99)99999-9999");
	$("input[name='phone2']").mask("(99)99999-9999");
	$("input[name='cep']").mask("99999-999");
	//$("input[name='number']").mask("999999");

}


</script>

<div class="row">
	<div class="col-lg-12 middle-content">
		<div class="row">
			<div class="col-lg-8"><h4>Cadastro de usuário</h4></div>
			<div class="col-lg-4"><h6><span class="red_letters">Campos com * são de preenchimento obrigatório.</span></h6></div>
		</div>
		<hr />

		<form name="edit_form" method="POST" action="<?=$this->config->item('url_link')?>login/completeSignup" id="edit_form">
			<div class="row">
				<div class="form-group">
					<label for="fullname" class="col-lg-1 control-label"> Nome Completo*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Nome Completo"
							name="fullname" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
							
					</div>

					<label for="cpf" class="col-lg-1 control-label"> CPF*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="CPF"
							name="cpf" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="gender" class="col-lg-1 control-label"> Sexo*: </label>
					<div class="col-lg-3">
						<select  class="form-control" id="gender" name="gender" required
							oninvalid="this.setCustomValidity('Favor escolher um item da lista.')"
    						oninput="setCustomValidity('')">
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
						<input type="text" class="form-control" placeholder="Email"
							name="email" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="confirm_email" class="col-lg-1 control-label"> Confirme o E-mail*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Email"
							name="confirm_email" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="occupation" class="col-lg-1 control-label"> Ocupação*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Ocupação"
							name="occupation" required
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
							name="street" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="number" class="col-lg-1 control-label"> Número*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Número"
							name="number" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="complement" class="col-lg-2 control-label"> Complemento: </label>
					<div class="col-lg-2">
						<input type="text" class="form-control" placeholder="Complemento"
							name="complement" />
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="city" class="col-lg-1 control-label"> Cidade*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Cidade"
							name="city" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="cep" class="col-lg-1 control-label"> CEP*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="CEP"
							name="cep" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="neighborhood" class="col-lg-2 control-label"> Bairro: </label>
					<div class="col-lg-2">
						<input type="text" class="form-control" placeholder="Bairro"
							name="neighborhood" />
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="phone1" class="col-lg-1 control-label"> Telefone 1*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Telefone de contato 1"
							name="phone1" required
							oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    						oninput="setCustomValidity('')"/>
					</div>

					<label for="phone2" class="col-lg-1 control-label"> Telefone 2: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Telefone de contato 2"
							name="phone2" />
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
						<input type="password" class="form-control" placeholder="" name="password" required
						oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    					oninput="setCustomValidity('')"/>
					</div>

					<label for="confirm_password" class="col-lg-2 control-label"> Confirme a senha*: </label>
					<div class="col-lg-3">
						<input type="password" class="form-control" name="confirm_password" required
						oninvalid="this.setCustomValidity('Este campo não pode ficar vazio.')"
    					oninput="setCustomValidity('')"/>
					</div>
				</div>
			</div>

			<br /><br /><br />

			<div class="form-group">
				<div class="col-lg-10">
					<button class="btn btn-primary" style="margin-right:40px" onClick="validateFormInfo()">Confirmar</button>
					<a href="<?=$this->config->item('url_link')?>login/index"><button class="btn btn-warning">Voltar</button></a>
				</div>
			</div>
			
		</form>
	</div>
</div>