<?php

$colonist = $this -> summercamp_model -> getSummerCampSubscription($colonist_id, $camp_id);
$summerCamp = $this -> summercamp_model -> getSummerCampById($camp_id);
$start = $summerCamp -> getDateStart();
$start = date("d/m/Y", strtotime($start));
$birthdate = date("d/m/Y", strtotime($colonist->getBirthDate()));
$end = $summerCamp -> getDateFinish();
$end = date("d/m/Y", strtotime($end));
?>

<div id="main">
	<h2><a href="@{Admin.geraAutorizacaoPDF(colonista.sequencial)}">Gerar PDF para impressão (Ainda não funcional)</a>
	<br/>
	</h2>

	<div style="font-size:18px">
		<br>
		Autorizo o(a) menor <b><?=$colonist -> getFullname() ?></b> nascido em <b><?=$birthdate?></b> portador do(a) <b><?=$colonist->getDocumentType()?></b> de número <b><?=$colonist->getDocumentNumber()?></b> qualificado(a) a viajar para a Colônia de Férias Kinderland, situada
		na Estrada Velha de Morro Azul, s/nº, em Sacra Família do Tinguá / Paulo de Frontin (RJ)
		no período <b><?=$start ?> à <?=$end ?></b>, acompanhado(a) pelos respectivos coordenadores.
		<br>
		<br> ______________________________
		<br>
		Rio de Janeiro, <b>
		<script>
			document.write(<?=$day ?> + "/" + <?=$month ?> + "/" + <?=$year ?>
				);
		</script></b>.
	</div>
	<br>
	<br>
	<span style="font-size:small"> <b>Observação:</b> de acordo com o artigo 83, seus parágrafos e alíneas, da Lei nº 8.069/90,
		tem-se como regra a vedação da viagem de criança (pessoa menor de 12 anos de idade) para fora da comarca onde reside,
		desacompanhada dos pais ou responsável (guardião ou tutor), sem expressa autorização judicial. Contudo, tratando-se de viagem
		para comarca contígua à da residência da criança, ou de viagem dentro do mesmo Estado Federado, ou, ainda, dentro da mesma
		região metropolitana, não será exigida autorização judicial. </span>
	<br />
	<br />
	<span style="font-size:small"> De todo modo, a Associação Kinderland costuma solicitar o preenchimento desta ficha de autorização para os menores de
		18 anos de idade por precaução. Se o colonista tiver 12 anos ou mais, deve levar consigo no ônibus fretado pela Associação Kinderland
		um documento (RG ou certidão de nascimento), original ou cópia autenticada, preferencialmente RG por conter foto. Nos demais casos,
		levar o RG (cópia autenticada) do pai, mãe ou responsável legal pelo colonista. </span>
	<br>
	<br>

	<?php if($editable) { ?>

	<div id='form'>

			<form enctype="multipart/form-data" action="<?= $this -> config -> item('url_link'); ?>summercamps/acceptTripAuthorization" method="post">
				<input type="hidden" name="camp_id" value="<?=$camp_id ?>" /><input type="hidden" name="colonist_id" value="<?=$colonist_id ?>" /> 
				<input type="hidden" name="document_type" value="<?=$document_type ?>" /> 
				<button class="button btn btn-primary" type="submit">
					Autorizo
				</button>
			</form>
			<br />
		<div id='form2'>

			<form enctype="multipart/form-data" action="<?= $this -> config -> item('url_link'); ?>summercamps/rejectTripAuthorization" method="post">
				<input type="hidden" name="camp_id" value="<?=$camp_id ?>" /><input type="hidden" name="colonist_id" value="<?=$colonist_id ?>" /> 
				<input type="hidden" name="document_type" value="<?=$document_type ?>" /> 
				<button class="button btn btn-danger" type="submit">
					Não Autorizo
				</button>
			</form>
	<?php } ?>
			</p>
				<br/>
				<h2><a href="@{Admin.geraAutorizacaoPDF(colonista.sequencial)}">Gerar PDF para impressão (Ainda não funcional)</a>
				<br/>
				</h2>
				<input type="button" class="btn btn-warning" value="Voltar" onclick="history.back()" />
			</p>

		</div>
	</div>
