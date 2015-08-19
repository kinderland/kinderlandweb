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
</script>
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
						</select>
						<select name="colonia_f" onchange="this.form.submit()" id="colonia">
							<option value="0" <?php if(!isset($colonia_escolhida)) echo "selected"; ?>>Todas</option>
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
					style="max-width: 800px;">
					
						<tr>
							<th align="right"></th>
							<th align="right" colspan = 2 style="text-align: center">Feminino</th>
							<th align="right" colspan = 2 style="text-align: center">Masculino</th>
							<th align="right" colspan = 3 style="text-align: center">Ambos</th>
					    <tr>
					    <tr>
							<th align="right"></th>
							<th align="right">Sócio</th>
							<th align="right">Não Sócio</th>
							<th align="right">Sócio</th>
							<th align="right">Não Sócio</th>
							<th align="right">Sócio</th>
							<th align="right">Não Sócio</th>
							<th align="right">Total</th>
					    <tr>
							<th align="right">Inscritos</th>
							<td align='right'> <?php echo $countsAssociatedF->inscrito; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedF->inscrito; ?> </td>
							<td align='right'> <?php echo $countsAssociatedM->inscrito; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedM->inscrito; ?> </td>
							<td align='right'> <?php echo $countsAssociatedT->inscrito; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedT->inscrito; ?> </td>
							<td align='right'> <?php echo $countsT->inscrito; ?> </td>
						</tr>
						<tr>
							<th align="right">Pré-inscrições em elaboração</th>
							<td align='right'> <?php echo $countsAssociatedF->elaboracao; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedF->elaboracao; ?> </td>
							<td align='right'> <?php echo $countsAssociatedM->elaboracao; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedM->elaboracao; ?> </td>
							<td align='right'> <?php echo $countsAssociatedT->elaboracao; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedT->elaboracao; ?> </td>
							<td align='right'> <?php echo $countsT->elaboracao; ?> </td>
						</tr>
						<tr>
							<th align="right">Pré-inscrições aguardando validação</th>
							<td align='right'> <?php echo $countsAssociatedF->aguardando_validacao; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedF->aguardando_validacao; ?> </td>
							<td align='right'> <?php echo $countsAssociatedM->aguardando_validacao; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedM->aguardando_validacao; ?> </td>
							<td align='right'> <?php echo $countsAssociatedT->aguardando_validacao; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedT->aguardando_validacao; ?> </td>
							<td align='right'> <?php echo $countsT->aguardando_validacao; ?> </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Pré-inscrições não validadas</th>
							<td align='right'> <?php echo $countsAssociatedF->nao_validada; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedF->nao_validada; ?> </td>
							<td align='right'> <?php echo $countsAssociatedM->nao_validada; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedM->nao_validada; ?> </td>
							<td align='right'> <?php echo $countsAssociatedT->nao_validada; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedT->nao_validada; ?> </td>
							<td align='right'> <?php echo $countsT->nao_validada; ?> </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Pré-inscrições validadas</th>
							<td align='right'> <?php echo $countsAssociatedF->validada; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedF->validada; ?> </td>
							<td align='right'> <?php echo $countsAssociatedM->validada; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedM->validada; ?> </td>
							<td align='right'> <?php echo $countsAssociatedT->validada; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedT->validada; ?> </td>
							<td align='right'> <?php echo $countsT->validada; ?> </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Pré-inscrições na fila de espera</th>
							<td align='right'> <?php echo $countsAssociatedF->fila_espera; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedF->fila_espera; ?> </td>
							<td align='right'> <?php echo $countsAssociatedM->fila_espera; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedM->fila_espera; ?> </td>
							<td align='right'> <?php echo $countsAssociatedT->fila_espera; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedT->fila_espera; ?> </td>
							<td align='right'> <?php echo $countsT->fila_espera; ?> </td>
						</tr>
						<tr>
							<th align="right" width='200px'>Pré-inscrições aguardando
								pagamento</th>
							<td align='right'> <?php echo $countsAssociatedF->aguardando_pagamento; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedF->aguardando_pagamento; ?> </td>
							<td align='right'> <?php echo $countsAssociatedM->aguardando_pagamento; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedM->aguardando_pagamento; ?> </td>
							<td align='right'> <?php echo $countsAssociatedT->aguardando_pagamento; ?> </td>
							<td align='right'> <?php echo $countsNotAssociatedT->aguardando_pagamento; ?> </td>
							<td align='right'> <?php echo $countsT->aguardando_pagamento; ?> </td>
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
	                        <td align='right'> <?php echo $countsAssociatedT->inscrito + $countsAssociatedT->aguardando_pagamento + $countsAssociatedT->fila_espera 
	                                + $countsAssociatedT->validada + $countsAssociatedT->nao_validada + $countsAssociatedT->aguardando_validacao 
	                                + $countsAssociatedT->elaboracao; ?> 
	                                </td>
	                        <td align='right'> <?php echo $countsNotAssociatedT->inscrito + $countsNotAssociatedT->aguardando_pagamento + $countsNotAssociatedT->fila_espera 
	                                + $countsNotAssociatedT->validada + $countsNotAssociatedT->nao_validada + $countsNotAssociatedT->aguardando_validacao 
	                                + $countsNotAssociatedT->elaboracao; ?> 
	                                </td>
							<td width="60px" align='right'>
	                                <?php echo $countsT->inscrito + $countsT->aguardando_pagamento + $countsT->fila_espera 
	                                + $countsT->validada + $countsT->nao_validada + $countsT->aguardando_validacao 
	                                + $countsT->elaboracao; ?>
	                            </td>
						</tr>
						<tr>
							<th	align="right" width='200px'>Porcentagem de Inscritos</th>
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
	                        <td align='right'> <?php 
									$countTotalAssociatedT = $countsAssociatedT ->inscrito + $countsAssociatedT->aguardando_pagamento + $countsAssociatedT->fila_espera 
	                                + $countsAssociatedT->validada + $countsAssociatedT->nao_validada + $countsAssociatedT->aguardando_validacao 
	                                + $countsAssociatedT->elaboracao;
									
									if($countTotalAssociatedT) echo number_format(($countsAssociatedT->inscrito/$countTotalAssociatedT)*100,1); 
									else echo "0.0";
									echo "%"; ?> 
	                                </td>
	                        <td align='right'> <?php 
									$countTotalNotAssociatedT = $countsNotAssociatedT->inscrito + $countsNotAssociatedT->aguardando_pagamento + $countsNotAssociatedT->fila_espera 
	                                + $countsNotAssociatedT->validada + $countsNotAssociatedT->nao_validada + $countsNotAssociatedT->aguardando_validacao 
	                                + $countsNotAssociatedT->elaboracao;
									
									if($countTotalNotAssociatedT) echo number_format(($countsNotAssociatedT->inscrito/$countTotalNotAssociatedT)*100,1); 
									else echo "0.0";
									echo "%"; ?> 
	                                </td>
							<td width="60px" align='right'>
	                                <?php 
	                                $countTotalT = $countsT->inscrito + $countsT->aguardando_pagamento + $countsT->fila_espera 
	                                + $countsT->validada + $countsT->nao_validada + $countsT->aguardando_validacao 
	                                + $countsT->elaboracao;
	                                
	                                if($countTotalT) echo number_format(($countsT->inscrito/$countTotalT)*100,1);
	                                else echo "0.0";
									echo "%"; ?>
	                            </td>
	                    </tr>
				</table>
				<table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 600px;">
					
					<tr>
						<th></th>
						<th>Sócios</th>
						<th>Não Sócios</th>
						<th>Total </th>
					</tr>
					<tr>
						<th align="right">Potencial de Inscritos por Colônia</th>
						<td width="60px" align='right'> <?php echo $potInscritosAssociated = $countsAssociatedT->aguardando_pagamento 
						+ $countsAssociatedT->inscrito; ?></td>
						<td width="60px" align='right'> <?php echo $potInscritosNotAssociated = $countsNotAssociatedT->aguardando_pagamento 
						+ $countsNotAssociatedT->inscrito; ?></td>
						<td width="60px" align='right'> <?php echo $potInscritos = $countsT->aguardando_pagamento 
						+ $countsT->inscrito; ?></td>
					</tr>
					<tr>
						<th align="right">Porcentagem de Inscritos por Colônia</th>
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
				<table class="table table-bordered table-striped table-min-td-size"
					style="max-width: 600px;">
						<tr>
							<th align="right"></th>
							<th align="right" colspan = 2 style="text-align: center">Feminino</th>
							<th align="right" colspan = 2 style="text-align: center">Masculino</th>
							<th align="right" colspan = 3 style="text-align: center">Ambos</th>
					    </tr>
					    <tr>
							<th align="right"></th>
							<th align="right">Sócio</th>
							<th align="right">Não Sócio</th>
							<th align="right">Sócio</th>
							<th align="right">Não Sócio</th>
							<th align="right">Sócio</th>
							<th align="right">Não Sócio</th>
							<th align="right">Total</th>
					    <tr>					    
							<tr>
								<th align="right" width='200px'>Cancelados</th>
								<td align='right'> <?php echo $countsAssociatedF->cancelado; ?> </td>
								<td align='right'> <?php echo $countsNotAssociatedF->cancelado; ?> </td>
								<td align='right'> <?php echo $countsAssociatedM->cancelado; ?> </td>
								<td align='right'> <?php echo $countsNotAssociatedM->cancelado; ?> </td>
								<td align='right'> <?php echo $countsAssociatedT->cancelado; ?> </td>
								<td align='right'> <?php echo $countsNotAssociatedT->cancelado; ?> </td>
								<td align='right'> <?php echo $countsT->cancelado; ?> </td>
							</tr>
							<tr>
								<th align="right" width='200px'>Desistentes</th>
								<td align='right'> <?php echo $countsAssociatedF->desistente; ?> </td>
								<td align='right'> <?php echo $countsNotAssociatedF->desistente; ?> </td>
								<td align='right'> <?php echo $countsAssociatedM->desistente; ?> </td>
								<td align='right'> <?php echo $countsNotAssociatedM->desistente; ?> </td>
								<td align='right'> <?php echo $countsAssociatedT->desistente; ?> </td>
								<td align='right'> <?php echo $countsNotAssociatedT->desistente; ?> </td>
								<td align='right'> <?php echo $countsT->desistente; ?> </td>
							</tr>
							<tr>
								<th align="right" width='200px'>Excluidos</th>
								<td align='right'> <?php echo $countsAssociatedF->excluido; ?> </td>
								<td align='right'> <?php echo $countsNotAssociatedF->excluido; ?> </td>
								<td align='right'> <?php echo $countsAssociatedM->excluido; ?> </td>
								<td align='right'> <?php echo $countsNotAssociatedM->excluido; ?> </td>
								<td align='right'> <?php echo $countsAssociatedT->excluido; ?> </td>
								<td align='right'> <?php echo $countsNotAssociatedT->excluido; ?> </td>
								<td align='right'> <?php echo $countsT->excluido; ?> </td>
							</tr>
						<tr>
							<th align="right" width='200px'>Total</th>
							<td align='right'> <?php echo $countsAssociatedF->excluido + $countsAssociatedF->desistente + $countsAssociatedF->cancelado; ?> 
	                                </td>
	                        <td align='right'> <?php echo $countsNotAssociatedF->excluido + $countsNotAssociatedF->desistente + $countsNotAssociatedF->cancelado; ?> 
	                                </td>
							<td align='right'> <?php echo $countsAssociatedM->excluido + $countsAssociatedM->desistente + $countsAssociatedM->cancelado; ?> 
	                                </td>
	                        <td align='right'> <?php echo $countsNotAssociatedM->excluido + $countsNotAssociatedM->desistente + $countsNotAssociatedM->cancelado; ?> 
	                                </td>
	                        <td align='right'> <?php echo $countsAssociatedT->excluido + $countsAssociatedT->desistente + $countsAssociatedT->cancelado; ?> 
	                                </td>
	                        <td align='right'> <?php echo $countsNotAssociatedT->excluido + $countsNotAssociatedT->desistente + $countsNotAssociatedT->cancelado; ?> 
	                                </td>
							<td align='right'>
	                                <?php echo $countsT->excluido + $countsT->desistente + $countsT->cancelado; ?>
	                            </td>
						</tr>
				</table>
				
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="solicitar-convite" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modal_title">Detalhes das Inscrições</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 middle-content">			
								<div class="row">
									<div class="form-group">
										<div class="col-lg-12">
											<?php
                            foreach ($colonists as $colonist) {
                                ?>
                                <tr>
                                    <td><a id="<?= $colonist->fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>admin/viewColonistInfo?colonistId=<?= $colonist -> colonist_id ?>&summerCampId=<?= $colonist -> summer_camp_id ?>"><?= $colonist -> colonist_name ?></a></td>
                                    <td><?= $colonist->camp_name ?></td>
                                    <td><a id="<?= $colonist -> fullname ?>" target="_blank" href="<?= $this -> config -> item('url_link') ?>user/details?id=<?= $colonist -> person_user_id ?>"><?= $colonist -> user_name ?></a></td>
                                    <td><?= $colonist->email ?></td>
                                    <td id="colonist_situation_<?=$colonist->colonist_id?>_<?=$colonist->summer_camp_id?>"><font color="
                                <?php
                                    switch ($colonist->situation) {
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION: echo "#061B91"; break;
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED: echo "#017D50"; break;
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS: echo "#FF0000"; break;
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN: echo "#555555"; break;
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_CANCELLED: echo "#FF0000"; break;
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_EXCLUDED: echo "#FF0000"; break;
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_GIVEN_UP: echo "#FF0000"; break;
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_QUEUE: echo "#555555"; break;
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_PENDING_PAYMENT: echo "#061B91"; break;
                                        case SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED: echo "#017D50"; break;
                                    }
                                ?>"><?= $colonist -> situation_description ?></td>
                                </tr>
                                <?php
                            }
                            ?>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					</div>
				</div>
			</div>
		</div>
		
			</div>
		</div>
	</div>
</body>
</html>