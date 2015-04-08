<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">
		<h3> Campanha de sócios <?=date("Y")?> </h3>

		<div class="row">
			<div class="col-lg-9">
				<p align="justify">

					A Associação KINDERLAND é uma entidade sem fins lucrativos que necessita de contribuições e doações 
					regulares. Elas são utilizadas na manutenção e investimentos no espaço onde a Colônia de Férias é 
					realizada, além de ajudar com os demais custos institucionais.

					Estas doações podem ser espontâneas e feitas a qualquer momento, como contribuições de ítens úteis 
					para a colônia de férias, material de construção ou equipamentos em geral. Agradecemos a todos que 
					indistintamente contribuem regularmente como associados ou doadores.

					A Associação Kinderland realiza projetos sociais com jovens de comunidades carentes, oferece bolsas 
					parciais ou integrais para colonistas nas temporadas de verão e participa de várias outras iniciativas 
					comunitárias. Somente com estas doações, tudo isto torna-se possível.

					Todos os anos realizamos uma campanha de associados Kinderland, visando obter recursos financeiros 
					para as nossos projetos e operações ao longo do ano. Os associados da Kinderland têm, entre outros, 
					os seguintes benefícios:
					<ul>
						<li>
							Descontos nas doações pela cessão do espaço físico da colônia Kinderland para festas de 
							aniversário, finais de semana com amigos outros eventos particulares;
						</li>
						<li>
							Desconto nos eventos realizados pela Kinderland (ex. evento MaCK - Mostre a Colonia Kinderland);

						</li>
						<li>
							Inscrição antecipada para a temporada de verão (verificar <a target="_blank" 
							href="http://www.kinderland.com.br/como-ajudar/quero-ser-socio/">Restrições</a> 
							em nosso site).
						</li>
					</ul>

					A Associação Kinderland, neste ano de 2014, considera como associado as pessoas pertencentes ao nosso 
					cadastro

					<strong>
						<?php if(isset($benemerito) && $benemerito) {?>

						identificadas como beneméritas ou membros da diretoria. Nestes casos, não há necessidade de doação. 
						Entretanto, se houver interesse e possibilidade, sugerimos o valor mínimo de R$ 200,00 (duzentos reais) 
						até o dia 30 de junho.

						<?php } else { ?>

						que contribuírem com um valor igual ou superior a
						R$ 660,00 (seiscentos e sessenta reais) até o dia 30 de junho.

						<?php } ?>

					</strong>

					O valor da colaboração do associado pode ser doado em pagamento por cartão de crédito, em uma ou até 4 (quatro) 
					parcelas iguais sem acréscimo, em função da quantidade de meses restantes até o final do mês de junho. 
					<i>Por questões de segurança, não é possível receber doações em cheque ou dinheiro em nossa secretaria</i>.
					<br /><br />
					<span style="color:red;font-weight:bold"> 
						Se você concorda com as condições para ser um associado Kinderland 2014, basta escolher como realizar sua doação abaixo. 
						Ao final do processo, um email será enviado automaticamente, 
						confirmando a condição de associado. Caso não receba a mensagem de confirmação, entrar em contato conosco por telefone 
						(21 2266-1980) ou e-mail (secretaria@kinderland.com.br).
					</span>
				</p>
			</div>
		</div>

		<!-- Button trigger modal -->
		<a href="<?=$this->config->item('url_link')?>donations/checkoutAssociate">
			<button type="button" class="btn btn-primary btn-lg">
				Quero ser sócio
			</button>
		</a>
	</div>
</div>