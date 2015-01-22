<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Internet Dreams</title>
<link rel="stylesheet" href="<?=$this->config->item('assets');?>css/screen.css" type="text/css" media="screen" title="default" />
<!--[if IE]>
<link rel="stylesheet" media="all" type="text/css" href="css/pro_dropline_ie.css" />
<![endif]-->

<!--  jquery core -->
<script src="<?=$this->config->item('assets');?>js/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>
 
<!--  checkbox styling script -->
<script src="<?=$this->config->item('assets');?>js/jquery/ui.core.js" type="text/javascript"></script>
<script src="<?=$this->config->item('assets');?>js/jquery/ui.checkbox.js" type="text/javascript"></script>
<script src="<?=$this->config->item('assets');?>js/jquery/jquery.bind.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$('input').checkBox();
	$('#toggle-all').click(function(){
 	$('#toggle-all').toggleClass('toggle-checked');
	$('#mainform input[type=checkbox]').checkBox('toggle');
	return false;
	});
});
</script>  


<![if !IE 7]>

<!--  styled select box script version 1 -->
<script src="<?=$this->config->item('assets');?>js/jquery/jquery.selectbox-0.5.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect').selectbox({ inputClass: "selectbox_styled" });
});
</script>
 

<![endif]>


<!--  styled select box script version 2 --> 
<script src="<?=$this->config->item('assets');?>js/jquery/jquery.selectbox-0.5_style_2.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect_form_1').selectbox({ inputClass: "styledselect_form_1" });
	$('.styledselect_form_2').selectbox({ inputClass: "styledselect_form_2" });
});
</script>

<!--  styled select box script version 3 --> 
<script src="<?=$this->config->item('assets');?>js/jquery/jquery.selectbox-0.5_style_2.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect_pages').selectbox({ inputClass: "styledselect_pages" });
});
</script>


<!-- Custom jquery scripts -->
<script src="<?=$this->config->item('assets');?>js/jquery/custom_jquery.js" type="text/javascript"></script>
 
<!-- Tooltips -->
<script src="<?=$this->config->item('assets');?>js/jquery/jquery.tooltip.js" type="text/javascript"></script>
<script src="<?=$this->config->item('assets');?>js/jquery/jquery.dimensions.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('a.info-tooltip ').tooltip({
		track: true,
		delay: 0,
		fixPNG: true, 
		showURL: false,
		showBody: " - ",
		top: -35,
		left: 5
	});
});
</script> 

<!--  date picker script -->
<link rel="stylesheet" href="css/datePicker.css" type="text/css" />
<script src="<?=$this->config->item('assets');?>js/jquery/date.js" type="text/javascript"></script>
<script src="<?=$this->config->item('assets');?>js/jquery/jquery.datePicker.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
        $(function()
{

// initialise the "Select date" link
$('#date-pick')
	.datePicker(
		// associate the link with a date picker
		{
			createButton:false,
			startDate:'01/01/2005',
			endDate:'31/12/2020'
		}
	).bind(
		// when the link is clicked display the date picker
		'click',
		function()
		{
			updateSelects($(this).dpGetSelected()[0]);
			$(this).dpDisplay();
			return false;
		}
	).bind(
		// when a date is selected update the SELECTs
		'dateSelected',
		function(e, selectedDate, $td, state)
		{
			updateSelects(selectedDate);
		}
	).bind(
		'dpClosed',
		function(e, selected)
		{
			updateSelects(selected[0]);
		}
	);
	
var updateSelects = function (selectedDate)
{
	var selectedDate = new Date(selectedDate);
	$('#d option[value=' + selectedDate.getDate() + ']').attr('selected', 'selected');
	$('#m option[value=' + (selectedDate.getMonth()+1) + ']').attr('selected', 'selected');
	$('#y option[value=' + (selectedDate.getFullYear()) + ']').attr('selected', 'selected');
}
// listen for when the selects are changed and update the picker
$('#d, #m, #y')
	.bind(
		'change',
		function()
		{
			var d = new Date(
						$('#y').val(),
						$('#m').val()-1,
						$('#d').val()
					);
			$('#date-pick').dpSetSelected(d.asString());
		}
	);

// default the position of the selects to today
var today = new Date();
updateSelects(today.getTime());

// and update the datePicker to reflect it...
$('#d').trigger('change');
});
</script>


<script type="text/javascript" charset="utf-8">

function validateForm(){
	$("#signup_form").submit();
}

</script>

<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="<?=$this->config->item('assets');?>js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>



</head>
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


<div id="page-heading"><h1>Cadastro de usuário</h1></div>


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
	
	<form name="signup_form" method="POST" action="<?=$this->config->item('basic_url')?>completeSignup" id="signup_form">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr valign="top">
		<td>
			<!-- start id-form -->
			<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
			<tr>
				<th valign="top">Nome completo:</th>
				<td><input type="text" id="fullname" name="fullname" class="inp-form" /></td>
				<th valign="top" class="offset-left">CPF*:</th>
				<td><input type="text" id="cpf" name="cpf" class="inp-form" /></td>
				<th valign="top" class="offset-left">Sexo:</th>
				<td>	
				<select  class="styledselect_form_1" id="gender" name="gender" >
					<option value="M">Masculino</option>
					<option value="F">Feminino</option>
				</select>
				</td>
			</tr>
			<tr>
				<th valign="top">E-mail:</th>
				<td><input type="text" id="email" name="email" class="inp-form" /></td>
				<th valign="top" class="offset-left">Confirme o e-mail*:</th>
				<td><input type="text" id="confirm_email" name="confirm_email" class="inp-form" /></td>
				<th valign="top" class="offset-left">Ocupação:</th>
				<td><input type="text" id="occupation" name="occupation" class="inp-form" /></td>
			</tr>
			<tr>
				<th valign="top">Logradouro:</th>
				<td><input type="text" id="street" name="street" class="inp-form" /></td>
				<th valign="top" class="offset-left">Número:</th>
				<td><input type="text" id="number" name="number" class="inp-form" /></td>
				<th valign="top" class="offset-left">Complemento:</th>
				<td><input type="text" id="complement" name="complement" class="inp-form" /></td>
			</tr>
			<tr>
				<th valign="top">Cidade:</th>
				<td><input type="text" id="city" name="city" class="inp-form" /></td>
				<th valign="top" class="offset-left">CEP:</th>
				<td><input type="text" id="cep" name="cep" class="inp-form" /></td>
				<th valign="top" class="offset-left">Bairro:</th>
				<td><input type="text" id="neighborhood" name="neighborhood" class="inp-form" /></td>
			</tr>
			<tr>
				<th valign="top">Telefone 1:</th>
				<td><input type="text" id="phone1" name="phone1" class="inp-form" /></td>
				<th valign="top" class="offset-left">Telefone 2:</th>
				<td><input type="text" id="phone2" name="phone2" class="inp-form" /></td>
				<th valign="top" class="offset-left">Estado:</th>
				<td>
					<select  class="styledselect_form_1" id="uf" name="uf">
						<option value="RJ" selected>RJ</option>
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