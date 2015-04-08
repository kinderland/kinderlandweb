<script type="text/javascript" charset="utf-8">

function validateForm(event){
	var donation_value = document.getElementById("donation_value");

	if(parseInt(donation_value.value, 10) < 20) {
			alert("O valor mínimo para doação é de R$20,00.");
			event.preventDefault();
	}
}

</script>

<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">
		<h3> Doação Avulsa </h3>
		<div class="row">
			<div class="col-lg-9">
				<p align="justify">
					<strong>DOAÇÕES AVULSAS para a ASSOCIAÇÂO KINDERLAND </strong><br />
					<br />
					<?=($gender="M")?"Prezado":"Prezada"?> <?=$fullname?>, <br />
					<br />

					A Associação KINDERLAND é uma entidade sem fins lucrativos que necessita de contribuições e doações 
					regulares. Elas são utilizadas na manutenção e investimentos no espaço onde a Colônia de Férias é 
					realizada, além de ajudar com os demais custos institucionais.<br />

					Estas doações podem ser espontâneas e feitas a qualquer momento, como contribuições de itens úteis 
					para a colônia de férias, material de construção ou equipamentos em geral. Agradecemos a todos que 
					indistintamente contribuem regularmente a cada ano.<br />

					A Associação Kinderland realiza projetos sociais com jovens de comunidades carentes, oferece bolsas 
					parciais ou integrais para colonistas nas temporadas de verão e participa de várias outras iniciativas
					 comunitárias. Somente com estas doações, tudo isto se torna possível.<br />

					Para colaborar com a Associação Kinderland basta escolher como realizar sua doação abaixo (três opções
					 de cartão de crédito e uma de cartão de débito) - e definir o valor. Você será redirecionado para uma 
					 tela da operadora de cartões Cielo, para entrada dos dados do cartão. Em alguns casos, pode aparecer 
					 outra tela de validação e confirmação da doação, um controle adicional do próprio banco emissor do 
					 cartão.<br />

					Devido aos custos operacionais e taxas bancárias, pedimos apenas que o valor da doação seja igual ou 
					superior a R$<?=number_format(20, 2, ',', '.')?>. 
					Ao final do processo, um email será enviado automaticamente confirmando ou não o suceso da operação. 
					Agradecemos antecipadamente pelo interesse em contribuir com a Kinderland!<br />

					Atenção: o prazo de doações referentes à campanha de associados 2014 se encerrou no dia 30 de junho 
					de 2014.<br />

					Se houver dúvidas ou precisar de auxílio, favor entrar em contato conosco por telefone 
					<a href="#">(21) 2266-1980</a> ou 
					e-mail <a href="mailto:secretaria@kinderland.com.br">secretaria@kinderland.com.br</a>.<br /><br /><br />
				</p>
			</div>
		</div>


		<form action="<?=$this->config->item('url_link')?>donations/checkoutFreeDonation" method="POST">
			<div class="row">
				<label for="fullname" class="col-lg-2 control-label"> Valor da doação: </label>
				<div class="col-lg-4">
					<input type="text" min="20" class="form-control" value="20" 
					name="donation_value" id="donation_value"
					oninvalid="this.setCustomValidity('O valor mínimo para doação é de R$20,00.')"/>
					
				</div>
			</div>
			<div class="row"> 
				<div class="col-lg-12">
					<p><u>O valor mínimo da doação é de R$<?=number_format(20, 2, ',', '.')?> </u></p>
				</div>
			</div>
			<div class="row">
			 	<div class="col-lg-4">
					<input type="submit" class="btn btn-primary btn-sm" value="Prosseguir" onClick="validateForm(event)"/>
				</div>
			</div>

		</form>

	</div>
</div>