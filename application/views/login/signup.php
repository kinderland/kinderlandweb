<script type="text/javascript" charset="utf-8">

function validateForm(){
	if(!validateEmail("signup_form","email","e-mail") || !validateNotEmptyField("signup_form","fullname","Nome"))
		return false;

	if(!validateNotEmptyField("signup_form","cpf","CPF") || !validateNotEmptyField("signup_form","gender","Sexo"))
		return false;


		$("#signup_form").submit();
}

function callMasks(){

	$("input[name='cpf']").mask("999.999.999-99");

}

</script>
<body onload="callMasks()"> 
<!-- Start: page-top-outer -->
<div id="page-top-outer">    

<!-- Start: page-top -->
<div id="page-top">

	<!-- start logo -->
	<div id="logo">
	<a href=""><img src="<?=$this->config->item('assets');?>images/kinderland/logo.png" width="156" height="40" alt="" /></a>
	</div>
	<!-- end logo -->

 	<div class="clear"></div>

</div>
<!-- End: page-top -->

</div>
<!-- End: page-top-outer -->
	
<div class="clear">&nbsp;</div>
 
<div class="clear"></div>
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading">
	<h1>Cadastro de usuário</h1> <br />
	<span class="red_letters">Campos com * são de preenchimento obrigatório.</span>
</div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="<?=$this->config->item('assets');?>images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="<?=$this->config->item('assets');?>images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<form name="signup_form" method="POST" action="<?=$this->config->item('url_link')?>login/completeSignup" id="signup_form">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr valign="top">
		<td>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
			<tr>
				<th valign="top">Nome completo*:</th>
				<td><input type="text" id="fullname" name="fullname" class="inp-form" /></td>
				<th valign="top" class="offset-left">CPF*:</th>
				<td><input type="text" id="cpf" name="cpf" class="inp-form" /></td>
				<th valign="top" class="offset-left">Sexo*:</th>
				<td>	
				<select  class="styledselect_form_1" id="gender" name="gender" >
					<option value="" selected> -- Selecione -- </option>
					<option value="M">Masculino</option>
					<option value="F">Feminino</option>
				</select>
				</td>
			</tr>
			<tr>
				<th valign="top">E-mail*:</th>
				<td><input type="text" id="email" name="email" class="inp-form" /></td>
				<th valign="top" class="offset-left">Confirme o e-mail*:</th>
				<td><input type="text" id="confirm_email" name="confirm_email" class="inp-form" /></td>
				<th valign="top" class="offset-left">Ocupação:</th>
				<td><input type="text" id="occupation" name="occupation" class="inp-form" /></td>
			</tr>
			<tr>
				<th valign="top">Logradouro*:</th>
				<td><input type="text" id="street" name="street" class="inp-form" /></td>
				<th valign="top" class="offset-left">Número*:</th>
				<td><input type="text" id="number" name="number" class="inp-form" /></td>
				<th valign="top" class="offset-left">Complemento:</th>
				<td><input type="text" id="complement" name="complement" class="inp-form" /></td>
			</tr>
			<tr>
				<th valign="top">Cidade*:</th>
				<td><input type="text" id="city" name="city" class="inp-form" /></td>
				<th valign="top" class="offset-left">CEP*:</th>
				<td><input type="text" id="cep" name="cep" class="inp-form" /></td>
				<th valign="top" class="offset-left">Bairro:</th>
				<td><input type="text" id="neighborhood" name="neighborhood" class="inp-form" /></td>
			</tr>
			<tr>
				<th valign="top">Telefone 1*:</th>
				<td><input type="text" id="phone1" name="phone1" class="inp-form" /></td>
				<th valign="top" class="offset-left">Telefone 2:</th>
				<td><input type="text" id="phone2" name="phone2" class="inp-form" /></td>
				<th valign="top" class="offset-left">Estado*:</th>
				<td>
					<select  class="styledselect_form_1" id="uf" name="uf">
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
				</td>
			</tr>

			<tr>
				<th valign="top">Senha*:</th>
				<td><input type="password" id="password" name="password" class="inp-form" /></td>
				<th valign="top" class="offset-left">Confirme a senha*:</th>
				<td><input type="password" id="confirm_password" name="confirm_password" class="inp-form" /></td>
			</tr>

			<tr>
				<td valign="top">
					<input type="button" value="Cadastrar" class="form-submit" onClick="validateForm()"/>
				</td>
			</tr>
			
		</table>
		<!-- end id-form  -->
	</table>
	 
	<div class="clear"></div>
	 

	</div>
	<!--  end content-table-inner  -->
	</td>
	<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>

</form>
</table>

<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->

 

<div class="clear">&nbsp;</div>
    
<!-- start footer -->         
<div id="footer">
	<!--  start footer-left -->
	<div id="footer-left">
	Admin Skin &copy; Copyright Internet Dreams Ltd. <a href="">www.netdreams.co.uk</a>. All rights reserved.</div>
	<!--  end footer-left -->
	<div class="clear">&nbsp;</div>
</div>
<!-- end footer -->
 
</body>
</html>