<div id="main">

	<div style="text-align:left;">
		<h1>Normas Gerais de: <?=$summercamp->getCampName()?></h1>
		<span style="margin-left:5px"><b>1.</b> A inscrição na colônia de férias Kinderland só é considerada válida após:</span>
		<br>
		<br>
		<span style="margin-left:30px"><b>a)</b> PRÉ-INSCRIÇÃO: preenchimento completo no sistema <i>on-line</i> de inscrições Kinderland:</span>
		<br>
		<span style="margin-left:70px"><b>I.</b> Ficha cadastral do responsável pela inscrição;</span>
		<br>
		<span style="margin-left:70px"><b>II-</b> Ficha cadastral do(a) colonista;</span>
		<br>
		<span style="margin-left:70px"><b>III-</b> Ficha de autorização de viagem do menor aceita e validada pelo responsável;</span>
		<br>
		<span style="margin-left:70px"><b>IV-</b> Ficha médica validada pelo responsável;</span>
		<br>
		<span style="margin-left:70px"><b>V-</b> Envio <i>(upload)</i> de documento (RG ou certidão de nascimento ) e de foto recente digitalizados;</span>
		<br>
		<span style="margin-left:70px"><b>VI-</b> Esta ficha de normas gerais aceita e validada pelo responsável;</span>
		<br>
		<br>
		<!-- <p class="divisoria"><b><u>A indisponibilidade de algum destes documentos, no ato da inscrição, impedirá a realização da mesma.</u></b></p><br> -->
		<span style="margin-left:30px"><b>b)</b> INSCRIÇÃO: efetivação da contribuição do valor da inscrição pelo sistema <i>on-line</i> de inscrições Kinderland, exclusivamente através do serviço disponibilizado na internet. Não serão aceitas contribuições em cheque ou dinheiro para recebimento em nossa secretaria.
			<br>
			<br>
			<span style="margin-left:5px"><b>2.</b> O colonista deverá ir e voltar da colônia utilizando apenas o transporte contratado pela Associação Kinderland, nos dias marcados para a turma na qual está inscrito. </span>
			<br>
			<br>
			<span style="margin-left:5px"><b>3.</b> Não é permitida a visita dos pais ou responsáveis durante o período da colônia.</span>
			<br>
			<br>
			<span style="margin-left:5px"><b>4.</b> A vaga do colonista é intransferível. No caso de desistência ou cancelamento, a vaga será preenchida respeitando-se a ordem da lista de espera.</span>
			<br>
			<br>
			<span style="margin-left:5px"><b>5.</b> A Associação Kinderland se reserva o direito de cancelar a inscrição de crianças que apresentem problemas médicos ou restrições alimentares que não permitam condições adequadas de atendimento no próprio local da colônia na temporada, devolvendo-se toda o valor da contribuição.</span>
			<br>
			<br>
			<span style="margin-left:5px"><b>6.</b> Em caso de desistência da inscrição do colonista com menos de 30 dias antes do início da temporada, ou retorno antecipado do colonista antes do final da temporada, a contribuição do valor da colônia não será restituída, independente da data de efetivação da inscrição. </span>
			<br>
			<br>
			<span style="margin-left:5px"><b>7.</b> Em caso de desistência da inscrição do colonista até 30 dias antes do início da temporada, a contribuição do valor da colônia será restituída, descontada uma taxa de administração correspondente a 10% (dez por cento) do valor nominal pago. </span>
			<br>
			<br>
			<span style="margin-left:5px"><b>8.</b> Se houver interrupção da temporada por motivos de caso fortuito ou força maior, não será devolvido o valor da contribuição equivalente aos dias restantes proporcionalmente não aproveitados. </span>
			<br>
			<br>
			<span style="margin-left:5px"><b>9.</b> A Associação Kinderland se reserva o direito de fazer voltar ao local de origem o colonista que:</span>
			<br>
			<span style="margin-left:30px"><b>a)</b> Praticar ou participar de qualquer tipo de agressão física ou moral, ou ainda praticar ou participar de brincadeiras ou atitudes que possam causar dano ou constrangimento a qualquer pessoa da colônia, sejam colonistas, monitores, instrutores, coordenadores ou funcionários;</span>
			<br>
			<span style="margin-left:30px"><b>b)</b> Portar ou fizer uso de cigarros, de qualquer espécie de drogas ou de bebidas alcoólicas;</span>
			<br>
			<span style="margin-left:30px"><b>c)</b> Portar ou fizer uso de fogos de artifício;</span>
			<br>
			<span style="margin-left:30px"><b>d)</b> Sair da colônia sem expressa autorização da coordenação;</span>
			<br>
			<span style="margin-left:30px"><b>e)</b> Transportar e utilizar na colônia telefones celulares ou qualquer outro aparelho que possua meios de comunicação pessoal.</span>
			<br>
			<br>
			<span style="margin-left:5px"><b>10.</b> No caso de prejuízo ou qualquer dano causado pelo colonista durante sua estadia na colônia, será enviada ao responsável pela inscrição a cobrança equivalente àquele prejuízo ou dano.</span>
			<br>
			<br>
			<span style="margin-left:5px"><b>11.</b> A Associação Kinderland não se responsabiliza:</span>
			<br>
			<span style="margin-left:30px"><b>a)</b> Por perdas de roupas, dinheiro ou objetos tais como: relógios, óculos, aparelhos ortodônticos, máquinas fotográficas e filmadoras, celulares e demais aparelhos portáteis multimídia; </span>
			<br>
			<span style="margin-left:30px"><b>b)</b> Pelo uso de medicamentos feito pelo colonista, sem prévio comunicado por escrito ao médico responsável da colônia. </span>
			<br>
			<br>
			<span style="margin-left:5px"><b>12.</b> Ao inscrever a criança na Colônia, o responsável está cedendo o direito de imagem para a divulgação nos meios de comunicação da Associação Kinderland.</span>
			<br>
			<br>
			<span style="margin-left:5px"><b>Casos excepcionais não previstos nestas Normas Gerais serão resolvidos pela diretoria da Associação Kinderland.</b></span><br />
			<span style="margin-left:5px"><b>Tomamos conhecimento destas normas e concordamos com os termos deste documento.</b></span>
			<br>
			<br>
	</div>
	<form enctype="multipart/form-data" action="<?= $this -> config -> item('url_link'); ?>summercamps/acceptGeneralRules" method="POST">
		<form >		
		<input type="hidden" name="camp_id" value="<?=$camp_id?>" /><input type="hidden" name="colonist_id" value="<?=$colonist_id?>" /> 
		<input type="hidden" name="document_type" value="<?=$document_type?>" /> 
		<input class="btn btn-primary" type="submit" class="button" value="De acordo" id="upload">
		<br /><br />
		</form>
		<div id='form2'>
			<button class="btn btn-warning" class="button" onclick="window.history.back();" value="Voltar">Voltar</button>
			
		</div>
	</div>
