<script type="javascript/text">

function redirectToMenu(){
	document.location.href = "<?=$this->config->item('url_link')?>system/menu";
}

function redirectEditUser(){
	document.location.href = "<?=$this->config->item('url_link')?>user/edit";
}

</script>

<body> 
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
	<h1>Verifique seus dados</h1> <br />
	<span class="red_letters">Caso os mesmos se encontrem corretos clique ok para continuar, 
	senão por favor pressione editar e realize as alterações necessárias.</span>
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
	
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr valign="top">
		<td>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
			<tr>
				<th valign="top">Nome completo:</th>
				<td><p><?= $user->fullname ?></p></td>
				<th valign="top" class="offset-left">CPF:</th>
				<td><p><?= $user->cpf ?></p></td>
				<th valign="top" class="offset-left">Sexo:</th>
				<td><p><?= $user->gender ?></p></td>
			</tr>
			<tr>
				<th valign="top">E-mail:</th>
				<td colspan="2"><p><?= $user->email ?></p></td>
				<th valign="top" class="offset-left">Ocupação:</th>
				<td><p><?= $user->occupation ?></p></td>
			</tr>
			<tr>
				<th valign="top">Logradouro:</th>
				<td><p><?= $user->street ?></p></td>
				<th valign="top" class="offset-left">Número:</th>
				<td><p><?= $user->number ?></p></td>
				<th valign="top" class="offset-left">Complemento:</th>
				<td><p><?= $user->complement ?></p></td>
			</tr>
			<tr>
				<th valign="top">Cidade:</th>
				<td><p><?= $user->city ?></p></td>
				<th valign="top" class="offset-left">CEP:</th>
				<td><p><?= $user->cep ?></p></td>
				<th valign="top" class="offset-left">Bairro:</th>
				<td><p><?= $user->neighborhood ?></p></td>
			</tr>
			<tr>
				<th valign="top">Telefone 1:</th>
				<td><p><?= $user->phone1 ?></p></td>
				<th valign="top" class="offset-left">Telefone 2:</th>
				<td><p><?= $user->phone2 ?></p></td>
				<th valign="top" class="offset-left">Estado:</th>
				<td><p><?= $user->uf ?></p></td>
			</tr>

			<tr>
				<td valign="top">
					<input type="button" value="OK" class="form-submit" onClick="redirectToMenu()"/>
				</td>
				<td valign="top">
					<input type="button" value="Editar" class="form-submit" onClick="redirectEditUser()"/>
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