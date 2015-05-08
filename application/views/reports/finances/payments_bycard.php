<div class = "row">
	<div class="col-lg-10" bgcolor="red">
		<h3>Pagamentos por cartão <?php echo $title_extra ?> </h3>
        <a href="<?= $this -> config -> item('url_link'); ?>reports/payments_bycard">
	        <button class="btn btn-primary" style="margin: 0px auto; ">Todos os pagamentos</button>
        </a>
        <a href="<?= $this -> config -> item('url_link'); ?>reports/payments_bycard?type=captured">
	        <button class="btn btn-primary" style="margin: 0px auto; ">Pagamentos finalizados</button>
        </a>
        <a href="<?= $this -> config -> item('url_link'); ?>reports/payments_bycard?type=canceled">
	        <button class="btn btn-primary" style="margin: 0px auto; ">Pagamentos cancelados</button>
        </a>
    
		<br>
		<table class="table table-bordered table-striped">
			<tr>
				<td colspan="5"> Crédito: </td>
			</tr>
			<tr>
				<td width='150px'> Bandeira do cartão: </td>
				<td width='150px'> À vista: </td>
				<td width='150px'> 2x: </td>
				<td width='150px'> 3x: </td>
				<td width='150px'> Total: </td>
			</tr>
			<tr>
				<td width='150px'> Amex </td>
				<td width='150px'><?php if(isset ($result["credito"]["amex"][1])) echo $result["credito"]["amex"][1]; else echo 0
				?></td>
				<td width='150px'><?php if(isset ($result["credito"]["amex"][2])) echo $result["credito"]["amex"][2]; else echo 0
				?></td>
				<td width='150px'><?php if(isset ($result["credito"]["amex"][3])) echo $result["credito"]["amex"][3]; else echo 0
				?></td>
				<td width='150px'><?php $total = 0;
					if (isset($result["credito"]["amex"])) {
						foreach ($result["credito"]["amex"] as $resultado)
							$total += $resultado;
					}
					echo $total;
 ?></td>
				
			</tr>
			<tr>
				<td width='150px'> Mastercard </td>
				<td width='150px'><?php if(isset ($result["credito"]["mastercard"][1])) echo $result["credito"]["mastercard"][1]; else echo 0
				?></td>
				<td width='150px'><?php if(isset ($result["credito"]["mastercard"][2])) echo $result["credito"]["mastercard"][2]; else echo 0
				?></td>
				<td width='150px'><?php if(isset ($result["credito"]["mastercard"][3])) echo $result["credito"]["mastercard"][3]; else echo 0
				?></td>
				<td width='150px'><?php $total = 0;
					if (isset($result["credito"]["mastercard"])) {
						foreach ($result["credito"]["mastercard"] as $resultado)
							$total += $resultado;
					}
					echo $total;
 ?></td>
			</tr>
			<tr>
				<td width='150px'> Visa </td>
				<td width='150px'><?php if(isset ($result["credito"]["visa"][1])) echo $result["credito"]["visa"][1]; else echo 0
				?></td>
				<td width='150px'><?php if(isset ($result["credito"]["visa"][2])) echo $result["credito"]["visa"][2]; else echo 0
				?></td>
				<td width='150px'><?php if(isset ($result["credito"]["visa"][3])) echo $result["credito"]["visa"][3]; else echo 0
				?></td>
				<td width='150px'><?php $total = 0;
					if (isset($result["credito"]["visa"])) {
						foreach ($result["credito"]["visa"] as $resultado)
							$total += $resultado;
					}
					echo $total;
 ?></td>
			</tr>
			<tr>
				<td width='150px'> Totais créditos </td>
				<td width='150px'><?php echo $credito[1]?></td>
				<td width='150px'><?php echo $credito[2]?></td>
				<td width='150px'><?php echo $credito[3]?></td>
				<td width='150px'><?php $total = 0;
					foreach ($credito as $resultado)
						$total += $resultado;
					echo $total;
 ?></td>
			</tr>
			<tr>
				<td colspan="5"> Débito: </td>
			</tr>
			<tr>
				<td colspan=2> Maestro </td>
				<td colspan=3><?php if(isset ($result["debito"]["mastercard"][1])) echo $result["debito"]["mastercard"][1]; else echo 0
				?></td>
			</tr>
			<tr>
				<td colspan=2> Visa Electron </td>
				<td colspan=3><?php if(isset ($result["debito"]["visa"][1])) echo $result["debito"]["visa"][1]; else echo 0
				?></td>
			</tr>
			<tr>
				<td colspan=2> Total débito </td>
				<td colspan=3><?php echo $debito; ?></td>
			</tr>
			<tr>
				<td colspan=2> Total geral </td>
				<td colspan=3><?php echo $soma; ?></td>
			</tr>
		</table>
	</div>
</div>