<?php
if($type == "Simples") {
$colonist = $this -> summercamp_model -> getSummerCampSubscription($colonist_id, $camp_id);
}
$summerCamp = $this -> summercamp_model -> getSummerCampById($camp_id);
$start = $summerCamp -> getDateStart();
$start = date("d/m/Y", strtotime($start));
$end = $summerCamp -> getDateFinish();
$end = date("d/m/Y", strtotime($end));

?>

<?php 

if($type == "Vários"){
	$number = 0;
	foreach($colonists as $colonist) {
		?>
<div id="main">
	<div style="font-size:14px; text-align:justify">
		<h1 style = "text-align:center"><strong>Autorização de Viagem</strong></h1>
		<br>
		Autorizo o(a) menor <b><?=$colonist -> getFullname() ?></b> nascido em <b><?=date("d/m/Y", strtotime($colonist->getBirthDate()))?></b> portador do(a) <b><?=$colonist->getDocumentType()?></b> de número <b><?=$colonist->getDocumentNumber()?></b> qualificado(a) a viajar para a Colônia de Férias Kinderland, situada
		na Estrada Velha de Morro Azul, s/nº, em Sacra Família do Tinguá / Paulo de Frontin (RJ)
		no período <b><?=$start ?> à <?=$end ?></b>, acompanhado(a) pelos respectivos coordenadores.
		<br>
		<br>
		Rio de Janeiro, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<br>
		<br>
		<br> ___________________________________________
		<br>
		<br>Nome:
		<br>
		<br>Documento:
		<br> 
		<br>
	<!--<span style="font-size:small"> <b>Observação:</b> de acordo com o artigo 83, seus parágrafos e alíneas, da Lei nº 8.069/90,
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
	<br> -->
		
	</div>
</div>
	<?php $number++; if($number == 2) { $number = 0;?>
	<p style="page-break-before: always"></p>
	<?php } else {?>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>	
	<?php }?>
<?php }} else {?>
<div id="main">
	<div style="font-size:14px; text-align:justify">
		<h1 style = "text-align:center"><strong>Autorização de Viagem</strong></h1>
		<br>
		Autorizo o(a) menor <b><?=$colonist -> getFullname() ?></b> nascido em <b><?=date("d/m/Y", strtotime($colonist->getBirthDate()))?></b> portador do(a) <b><?=$colonist->getDocumentType()?></b> de número <b><?=$colonist->getDocumentNumber()?></b> qualificado(a) a viajar para a Colônia de Férias Kinderland, situada
		na Estrada Velha de Morro Azul, s/nº, em Sacra Família do Tinguá / Paulo de Frontin (RJ)
		no período <b><?=$start ?> à <?=$end ?></b>, acompanhado(a) pelos respectivos coordenadores.
		<br>
		<br>
		Rio de Janeiro, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<br>
		<br>
		<br> ___________________________________________
		<br>
		<br>Nome:
		<br>
		<br>Documento:
		<br> 
		<br>
<!-- 	<span style="font-size:small"> <b>Observação:</b> de acordo com o artigo 83, seus parágrafos e alíneas, da Lei nº 8.069/90,
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
	<br> -->
		
	</div>
</div>
<?php }?>