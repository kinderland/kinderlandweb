<script type="text/javascript" charset="utf-8">

$("document").ready(function(){
	callMasks();
});

function validateForm(){
	if(!validateEmail("edit_form","email","e-mail") || !validateNotEmptyField("edit_form","fullname","Nome"))
		return false;

	if(!validateNotEmptyField("edit_form","cpf","CPF") || !validateNotEmptyField("edit_form","gender","Sexo"))
		return false;


	$("#edit_form").submit();
}

function callMasks(){

	$("input[name='cpf']").mask("999.999.999-99");
	$("input[name='phone1']").mask("(99)99999-9990");
	$("input[name='phone2']").mask("(99)99999-9990");
	$("input[name='cep']").mask("99999-999");
	$("input[name='number']").mask("000000");

}

</script>
<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">
		<div class="row">
			<div class="col-lg-8"><h4>Confirmação de dados</h4></div>
			<div class="col-lg-4"><h6><span class="red_letters">Campos com * são de preenchimento obrigatório.</span></h6></div>
		</div>
		<hr />

		<form name="edit_form" method="POST" action="<?=$this->config->item('url_link')?>user/update" id="edit_form">
			<div class="row">
				<div class="form-group">
					<label for="fullname" class="col-lg-1 control-label"> Nome Completo*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Nome Completo"
							name="fullname" value="<?=$user->getFullname()?>"/>
					</div>

					<label for="cpf" class="col-lg-1 control-label"> CPF*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="CPF"
							name="cpf" value="<?=$user->getCPF()?>"/>
					</div>

					<label for="gender" class="col-lg-1 control-label"> Sexo*: </label>
					<div class="col-lg-3">
						<select  class="form-control" id="gender" name="gender" >
							<option value="M" <?php if($user->getGender() == "M") echo "selected" ?> >Masculino</option>
							<option value="F" <?php if($user->getGender() == "F") echo "selected" ?> >Feminino</option>
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
							name="email" value="<?=$user->getEmail()?>" />
					</div>

					<label for="occupation" class="col-lg-1 control-label"> Ocupação*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Ocupação"
							name="occupation"  value="<?=$user->getOccupation()?>" />
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="street" class="col-lg-1 control-label"> Rua*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Logradouro"
							name="street" value="<?=$user->getAddress()->getStreet()?>" />
					</div>

					<label for="number" class="col-lg-1 control-label"> Número*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Número"
							name="number" value="<?=$user->getAddress()->getPlaceNumber()?>" />
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
							name="city" value="<?=$user->getAddress()->getCity()?>" />
					</div>

					<label for="cep" class="col-lg-1 control-label"> CEP*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="CEP"
							name="cep" value="<?=$user->getAddress()->getCEP()?>" />
					</div>

					<label for="neighborhood" class="col-lg-2 control-label"> Bairro: </label>
					<div class="col-lg-2">
						<input type="text" class="form-control" placeholder="Bairro"
							name="neighborhood" value="<?=$user->getAddress()->getNeighborhood()?>" />
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="form-group">
					<label for="phone1" class="col-lg-1 control-label"> Telefone 1*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Telefone de contato 1"
							name="phone1" />
					</div>

					<label for="phone2" class="col-lg-1 control-label"> Telefone 2*: </label>
					<div class="col-lg-3">
						<input type="text" class="form-control" placeholder="Telefone de contato 2"
							name="phone2" />
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
