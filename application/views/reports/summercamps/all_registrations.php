<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Colônia Kinderland</title>

<link href="<?= $this->config->item('assets'); ?>css/basic.css"
	rel="stylesheet" />
<!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
<link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css"
	rel="stylesheet" />
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css">
<link rel="stylesheet"
	href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
<script type="text/javascript"
	src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>

</head>
<body>

	<div class="main-container-report">
		<div class="row">
			<div class="col-lg-10" bgcolor="red">
				<form method="GET">
					<select name="ano_f" onchange="this.form.submit()" id="anos">
					
							<?php
							foreach ( $years as $year ) {
								$selected = "";
								if ($ano_escolhido == $year)
									$selected = "selected";
								echo "<option $selected value='$year'>$year</option>";
							}
							?>
						</select> <select name="colonia_f" onchange="this.form.submit()"
						id="colonia">
						<option value="Todas"
							<?php if(!isset($colonia_escolhida)) echo "selected"; ?>>Todas</option>
							<?php
							foreach ( $camps as $camp ) {
								$selected = "";
								if ($colonia_escolhida == $camp)
									$selected = "selected";
								echo "<option $selected value='$camp'>$camp</option>";
							}
							?>
						</select>
				</form>
				<table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 700px;">

					<tr>
						<th align="right"></th>
						<th align="right" colspan=2 style="text-align: center">Feminino</th>
						<th align="right" colspan=2 style="text-align: center">Masculino</th>
					
					
					<tr>
					
					
					<tr>
						<th align="right"></th>
						<th align="right">Sócio</th>
						<th align="right">Não Sócio</th>
						<th align="right">Sócio</th>
						<th align="right">Não Sócio</th>
					
					
					<tr>
							<?php if(!isset($colonia_escolhida)) { $colonia_escolhida = 'Todas';} ?>
							<th align="right">Pré-inscrições em elaboração</th>
						<td align='right'><?php if($countsAssociatedF->elaboracao !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=0&associated=true&gender=F"> <?php echo $countsAssociatedF->elaboracao; ?></a><?php } else echo $countsAssociatedF->elaboracao; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->elaboracao !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=0&gender=F"> <?php echo $countsNotAssociatedF->elaboracao; ?> </a><?php } else echo $countsNotAssociatedF->elaboracao; ?></td>
						<td align='right'><?php if($countsAssociatedM->elaboracao !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=0&associated=true&gender=M"> <?php echo $countsAssociatedM->elaboracao; ?> </a><?php } else echo $countsAssociatedM->elaboracao; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->elaboracao !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=0&gender=M"> <?php echo $countsNotAssociatedM->elaboracao; ?> </a><?php } else echo $countsNotAssociatedM->elaboracao; ?></td>
					</tr>
					<tr>
						<th align="right">Pré-inscrições aguardando validação</th>
						<td align='right'><?php if($countsAssociatedF->aguardando_validacao !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=1&associated=true&gender=F"> <?php echo $countsAssociatedF->aguardando_validacao; ?> </a><?php } else echo $countsAssociatedF->aguardando_validacao; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->aguardando_validacao !=0) {?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=1&gender=F"> <?php echo $countsNotAssociatedF->aguardando_validacao; ?> </a><?php } else echo $countsNotAssociatedF->aguardando_validacao; ?></td>
						<td align='right'><?php if($countsAssociatedM->aguardando_validacao !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=1&associated=true&gender=M"> <?php echo $countsAssociatedM->aguardando_validacao; ?> </a><?php } else echo $countsAssociatedM->aguardando_validacao; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->aguardando_validacao !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=1&gender=M"> <?php echo $countsNotAssociatedM->aguardando_validacao; ?> </a><?php } else echo $countsNotAssociatedM->aguardando_validacao; ?></td>
					</tr>
					<tr>
						<th align="right" width='200px'>Pré-inscrições não validadas</th>
						<td align='right'><?php if($countsAssociatedF->nao_validada !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=6&associated=true&gender=F"> <?php echo $countsAssociatedF->nao_validada; ?> </a><?php } else echo $countsAssociatedF->nao_validada; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->nao_validada !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=6&gender=F"> <?php echo $countsNotAssociatedF->nao_validada; ?> </a><?php } else echo $countsNotAssociatedF->nao_validada; ?></td>
						<td align='right'><?php if($countsAssociatedM->nao_validada !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=6&associated=true&gender=M"> <?php echo $countsAssociatedM->nao_validada; ?> </a><?php } else echo $countsAssociatedM->nao_validada; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->nao_validada !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=6&gender=M"> <?php echo $countsNotAssociatedM->nao_validada; ?> </a><?php } else echo $countsNotAssociatedM->nao_validada; ?></td>
					</tr>
					<tr>
						<th align="right" width='200px'>Pré-inscrições validadas</th>
						<td align='right'><?php if($countsAssociatedF->validada !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=2&associated=true&gender=F"> <?php echo $countsAssociatedF->validada; ?> </a><?php } else echo $countsAssociatedF->validada; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->validada !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=2&gender=F"> <?php echo $countsNotAssociatedF->validada; ?> </a><?php } else echo $countsNotAssociatedF->validada; ?></td>
						<td align='right'><?php if($countsAssociatedM->validada !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=2&associated=true&gender=M"> <?php echo $countsAssociatedM->validada; ?> </a><?php } else echo $countsAssociatedM->validada; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->validada !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $camp?>&year=<?= $year?>&status=2&gender=M"> <?php echo $countsNotAssociatedM->validada; ?> </a><?php } else echo $countsNotAssociatedM->validada; ?></td>
					</tr>
					<tr>
						<th align="right" width='200px'>Pré-inscrições na fila de espera</th>
						<td align='right'><?php if($countsAssociatedF->fila_espera !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=3&associated=true&gender=F"> <?php echo $countsAssociatedF->fila_espera; ?> </a><?php } else echo $countsAssociatedF->fila_espera; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->fila_espera !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=3&gender=F"> <?php echo $countsNotAssociatedF->fila_espera; ?> </a><?php } else echo $countsNotAssociatedF->fila_espera; ?></td>
						<td align='right'><?php if($countsAssociatedM->fila_espera !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=3&associated=true&gender=M"> <?php echo $countsAssociatedM->fila_espera; ?> </a><?php } else echo $countsAssociatedM->fila_espera; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->fila_espera !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=3&gender=M"> <?php echo $countsNotAssociatedM->fila_espera; ?> </a><?php } else echo $countsNotAssociatedM->fila_espera; ?></td>
					</tr>
					<tr>
						<th align="right" width='200px'>Pré-inscrições aguardando
							pagamento</th>
						<td align='right'><?php if($countsAssociatedF->aguardando_pagamento !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=4&associated=true&gender=F"> <?php echo $countsAssociatedF->aguardando_pagamento; ?> </a><?php } else echo $countsAssociatedF->aguardando_pagamento; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->aguardando_pagamento !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=4&gender=F"> <?php echo $countsNotAssociatedF->aguardando_pagamento; ?> </a><?php } else echo $countsNotAssociatedF->aguardando_pagamento; ?></td>
						<td align='right'><?php if($countsAssociatedM->aguardando_pagamento !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=4&associated=true&gender=M"> <?php echo $countsAssociatedM->aguardando_pagamento; ?> </a><?php } else echo $countsAssociatedM->aguardando_pagamento; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->aguardando_pagamento !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=4&gender=M"> <?php echo $countsNotAssociatedM->aguardando_pagamento; ?> </a><?php } else echo $countsNotAssociatedM->aguardando_pagamento; ?></td>
					</tr>
					<tr>
						<th align="right">Inscritos</th>
						<td align='right'><?php if($countsAssociatedF->inscrito !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=5&associated=true&gender=F"> <?php echo $countsAssociatedF->inscrito; ?> </a><?php } else echo $countsAssociatedF->inscrito; ?></td>
						<td align='right'><?php if($countsNotAssociatedF->inscrito !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=5&gender=F"> <?php echo $countsNotAssociatedF->inscrito; ?> </a><?php } else echo $countsNotAssociatedF->inscrito; ?></td>
						<td align='right'><?php if($countsAssociatedM->inscrito !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=5&associated=true&gender=M"> <?php echo $countsAssociatedM->inscrito; ?> </a><?php } else echo $countsAssociatedM->inscrito; ?></td>
						<td align='right'><?php if($countsNotAssociatedM->inscrito !=0){?><a target="blank"
							href="<?= $this->config->item('url_link'); ?>reports/subscriptions?camp=<?= $colonia_escolhida?>&year=<?= $year?>&status=5&gender=M"> <?php echo $countsNotAssociatedM->inscrito; ?> </a><?php } else echo $countsNotAssociatedM->inscrito; ?></td>
					</tr>
					<tr>
						<th align="right" width='200px'>Total</th>
						<td align='right'> <?php echo $countsAssociatedF->inscrito + $countsAssociatedF->aguardando_pagamento + $countsAssociatedF->fila_espera 
	                                + $countsAssociatedF->validada + $countsAssociatedF->nao_validada + $countsAssociatedF->aguardando_validacao 
	                                + $countsAssociatedF->elaboracao; ?> 
	                                </td>
						<td align='right'> <?php echo $countsNotAssociatedF->inscrito + $countsNotAssociatedF->aguardando_pagamento + $countsNotAssociatedF->fila_espera 
	                                + $countsNotAssociatedF->validada + $countsNotAssociatedF->nao_validada + $countsNotAssociatedF->aguardando_validacao 
	                                + $countsNotAssociatedF->elaboracao; ?> 
	                                </td>
						<td align='right'> <?php echo $countsAssociatedM->inscrito + $countsAssociatedM->aguardando_pagamento + $countsAssociatedM->fila_espera 
	                                + $countsAssociatedM->validada + $countsAssociatedM->nao_validada + $countsAssociatedM->aguardando_validacao 
	                                + $countsAssociatedM->elaboracao; ?> 
	                                </td>
						<td align='right'> <?php echo $countsNotAssociatedM->inscrito + $countsNotAssociatedM->aguardando_pagamento + $countsNotAssociatedM->fila_espera 
	                                + $countsNotAssociatedM->validada + $countsNotAssociatedM->nao_validada + $countsNotAssociatedM->aguardando_validacao 
	                                + $countsNotAssociatedM->elaboracao; ?> 
	                                </td>
					</tr>
					<tr>
						<th align="right" width='200px'>Porcentagem de Inscritos</th>
						<td align='right'> <?php 
									$countTotalAssociatedF = $countsAssociatedF->inscrito + $countsAssociatedF->aguardando_pagamento + $countsAssociatedF->fila_espera 
	                                + $countsAssociatedF->validada + $countsAssociatedF->nao_validada + $countsAssociatedF->aguardando_validacao 
	                                + $countsAssociatedF->elaboracao;
									
									if($countTotalAssociatedF) echo number_format(($countsAssociatedF->inscrito/$countTotalAssociatedF)*100,1); 
									else echo "0.0";
									echo "%"; ?> 
	                                </td>
						<td align='right'> <?php 
									$countTotalNotAssociatedF = $countsNotAssociatedF->inscrito + $countsNotAssociatedF->aguardando_pagamento + $countsNotAssociatedF->fila_espera 
	                                + $countsNotAssociatedF->validada + $countsNotAssociatedF->nao_validada + $countsNotAssociatedF->aguardando_validacao 
	                                + $countsNotAssociatedF->elaboracao;
									
									if($countTotalNotAssociatedF) echo number_format(($countsNotAssociatedF->inscrito/$countTotalNotAssociatedF)*100,1); 
									else echo "0.0";
									echo "%"; ?> 
	                                </td>
						<td align='right'> <?php 
									$countTotalAssociatedM = $countsAssociatedM ->inscrito + $countsAssociatedM->aguardando_pagamento + $countsAssociatedM->fila_espera 
	                                + $countsAssociatedM->validada + $countsAssociatedM->nao_validada + $countsAssociatedM->aguardando_validacao 
	                                + $countsAssociatedM->elaboracao;
									
									if($countTotalAssociatedM) echo number_format(($countsAssociatedM->inscrito/$countTotalAssociatedM)*100,1); 
									else echo "0.0";
									echo "%"; ?> 
	                                </td>
						<td align='right'> <?php 
									$countTotalNotAssociatedM = $countsNotAssociatedM->inscrito + $countsNotAssociatedM->aguardando_pagamento + $countsNotAssociatedM->fila_espera 
	                                + $countsNotAssociatedM->validada + $countsNotAssociatedM->nao_validada + $countsNotAssociatedM->aguardando_validacao 
	                                + $countsNotAssociatedM->elaboracao;
									
									if($countTotalNotAssociatedM) echo number_format(($countsNotAssociatedM->inscrito/$countTotalNotAssociatedM)*100,1); 
									else echo "0.0";
									echo "%"; ?> 
	                                </td>
					</tr>
					<tr>
						<th align="right">Vagas Disponíveis</th>
						<td colspan="2"> <?php echo $vacancyFemale - ($countsAssociatedF->aguardando_pagamento 
						+ $countsAssociatedF->inscrito + $countsNotAssociatedF->aguardando_pagamento 
						+ $countsNotAssociatedF->inscrito); ?>
							
						
						<td colspan="2"> <?php echo $vacancyMale - ($countsAssociatedM->aguardando_pagamento 
						+ $countsAssociatedM->inscrito + $countsNotAssociatedM->aguardando_pagamento 
						+ $countsNotAssociatedM->inscrito); ?>
	                    
	                    
					
					
					
					</tr>
				</table>
				<table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 600px;">

					<tr>
						<th></th>
						<th>Sócios</th>
						<th>Não Sócios</th>
						<th>Total</th>
					</tr>
					<tr>
						<th align="right">Potencial de Inscritos</th>
						<td width="60px" align='right'> <?php echo $potInscritosAssociated = $countsAssociatedT->aguardando_pagamento 
						+ $countsAssociatedT->inscrito; ?></td>
						<td width="60px" align='right'> <?php echo $potInscritosNotAssociated = $countsNotAssociatedT->aguardando_pagamento 
						+ $countsNotAssociatedT->inscrito; ?></td>
						<td width="60px" align='right'> <?php echo $potInscritos = $countsT->aguardando_pagamento 
						+ $countsT->inscrito; ?></td>
					</tr>
					<tr>
						<th align="right">Porcentagem de Inscritos</th>
						<td width="60px" align='right'><?php 
						if($potInscritosAssociated)
							echo number_format(($countsAssociatedT->inscrito/$potInscritosAssociated)*100,1);
						 else echo "0.0";
						 echo "%"; ?>  </td>
						<td width="60px" align='right'><?php 
						if($potInscritosNotAssociated)
							echo number_format(($countsNotAssociatedT->inscrito/$potInscritosNotAssociated)*100,1);
						 else echo "0.0";
						 echo "%"; ?>  </td>
						<td width="60px" align='right'><?php 
						if($potInscritos)
							echo number_format(($countsT->inscrito/$potInscritos)*100,1);
						 else echo "0.0";
						 echo "%"; ?>  </td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
</html>