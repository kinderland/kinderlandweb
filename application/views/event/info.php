<div class="row">
	<?php require_once APPPATH.'views/include/common_user_left_menu.php' ?>
	<div class="col-lg-10 middle-content">
		<script type="text/javascript">

			function subscribeUserOnSession(userId, eventId){
				var alreadyInvited = false;

				$(".subscriptions").each(function(){
					if($(this).val() == userId){
						alert("Convite já solicitado.");
						alreadyInvited = true;
					}
				});

				if(!alreadyInvited){
					$.post( "<?=$this->config->item('url_link')?>events/subscribeUser", 
							{ event_id: eventId, user_id: userId },
							function ( data ){
								location.reload();
							}
					);
				}	
			}

			function deleteSubscriptions(eventId){
				var userIds = $("input[name=subscriptions]:checked").map(function() {
								    return this.value;
								}).get().join(",");
			    
			    if(userIds.length == 0){
			    	alert("Selecione os convites que deseja deletar.");
			    	return;
			    }

			    $.post( "<?=$this->config->item('url_link')?>events/unsubscribeUsers", 
						{ event_id: eventId, user_ids: userIds },
						function ( data ){
							location.reload();
						}
				);
			}

			function paymentDetailsScreen(){
				// TODO: toda a logica por tras deste submit
				$("#form_submit_payment").submit();
			}

			$("document").ready(function(){
				var peopleJson = <?=$peoplejson?>;

				$("#box_options").change(function(){
					var person = peopleJson[parseInt($("#box_options").val())];
					if(person != null){
						$("#fullname").val(person.fullname);
						$("#gender").val(person.gender.toUpperCase());
						$("#person_id").val(person.personId);
					}
					else{
						$("#fullname").val("");
						$("#gender").val("");
						$("#person_id").val("");
					}
						
				});
			});

			function validateFormInfo(){
				// TODO: Validate info

				$("#form_subscribe").submit();
			}

		</script>

		<?php 
			if($event != null && $event instanceof Event) { 
		?>
			<div class='row'>
				<div class="col-lg-8">
					<h3><?=$event->getEventName();?></h3>
				</div>
				<div class="col-lg-4">
					<h3>
						Data: 
						<strong>
							<?= date_format(date_create($event->getDateStart()), 'd/m/y');?> 
							<?= ($event->getDateStart() != $event->getDateFinish())? " - ".date_format(date_create($event->getDateFinish()), 'd/m/y'):""?>
						</strong>
					</h3>
				</div>
			</div>
			<div class="row">
				<hr />
				<div class="col-lg-10 col-lg-offset-1">
					<p align="justify">
						<?=$event->getDescription();?>
					</p>
					<hr />
				</div>
				
			</div>
			<?php
				if($user_associate && $price->associate_discount > 0){ //$user->isAssociate()
			?>
			<div class="row">
				<div class="col-lg-10 col-lg-offset-1" style="border-style:solid;border-width:1px">
					<p align="center">
						Você que é sócio, marque a caixa indicativa de sócios no ato da solicitação de convite para ganhar <?=$price->associate_discount*100?>% de desconto!<br />
						Válido para você e seus dependentes.
					</p>
				</div>
			</div>
			<?php
				}
			?>
			<div class="row">
				&nbsp;
			</div>

			<div class="row">
				<div class="col-lg-10 col-lg-offset-1">
					<table class="table table-condensed table-hover">
						<tr>
							<th></th>
							<th>Vagas</th>
							<th><?=$age_groups[2]->description?></th>
							<th><?=$age_groups[1]->description?></th>
							<th><?=$age_groups[0]->description?></th>
						</tr>
						<tr>
							<td>Pavilhão Masculino</td>
							<td><?=$event->getCapacityMale()?></td>
							<td>R$ <?=number_format($price->full_price, 2, ',', '.');?></td>
							<td>R$ <?=number_format($price->middle_price, 2, ',', '.');?></td>
							<td>R$ <?=number_format($price->children_price, 2, ',', '.');?></td>
						</tr>
						<tr>
							<td>Pavilhão Feminino</td>
							<td><?=$event->getCapacityFemale()?></td>
							<td>R$ <?=number_format($price->full_price, 2, ',', '.');?></td>
							<td>R$ <?=number_format($price->middle_price, 2, ',', '.');?></td>
							<td>R$ <?=number_format($price->children_price, 2, ',', '.');?></td>
						</tr>
					</table>
				</div>
			</div>

			

			<div class="row">
				&nbsp;
			</div>
			<div class="row">
				&nbsp;
				<hr />
			</div>
			<?php 
				if(count($subscriptions) > 0) {
			?>
				<div class="row">
					<div class="col-lg-12">	
						<div class="col-lg-8">
							<h4>Meus convites:</h4>
						</div>
						<div class="col-lg-4">
							<?php
								if($price != null){
							?>
								<button class="btn btn-primary" style="float:right; " onClick="paymentDetailsScreen(<?=$user_id?>, <?=$event->getEventId()?>)">Pagar</button>
							<?php
								}
							?>
							
							<button class="btn btn-warning" style="float:right; margin-right:40px" onClick="deleteSubscriptions(<?=$event->getEventId()?>)">Deletar</button>
						</div>
						<div class="row">
							&nbsp;
						</div>
						<form action="<?=$this->config->item("url_link")?>events/checkoutSubcriptions" method="POST" name="form_submit_payment" id="form_submit_payment">
							<input type="hidden" name="user_id" value="<=$user_id?>" />
							<table class="table table-condensed table-hover">
								<tr>
									<th>-</th>
									<th>Pago</th>
									<th>Nome do convidado</th>
									<th>Faixa etária</th>
									<th>Descrição do convite</th>
								</tr>
								<?php 
									foreach($subscriptions as $subscr){
								?>
									<tr>
										<td><input type="checkbox" name="subscriptions" id="subscriptions" class="subscriptions" value="<?=$subscr->person_id?>" /></td>
										<td><img src="<?= $this->config->item('assets') ."images/kinderland/". ( ($subscr->subscription_status == SUSCRIPTION_STATUS_SUBSCRIPTION_OK)?'confirma.png':'nao-confirma.png' ) ?>" width="20px" height="20px"/></td>
										<td><?= $subscr->fullname ?></td>
										<td><?= $subscr->age_description ?></td>
										<td>
											<?php
												if($price != null){
													switch($subscr->age_group_id){
														case 1:
															echo "R$ ".number_format($price->children_price, 2, ',', '.');
															break;
														case 2:
															echo "R$ ".number_format($price->middle_price, 2, ',', '.');
															break;
														case 3:
														default:
															echo "R$ ".number_format($price->full_price, 2, ',', '.');
															break;
													} 
												
												} else {
													echo "Prazo de pagamento terminado";
												}
										  ?></td>
									</tr>
								<?php
									}
								?>
							</table>
						</form>
					<div>
				</div>
			<?php
				} 
			?>
					
			
		<?php 
			} else {
		?>
			<h3> 
				Nenhum evento registrado para acontecer nos próximos dias. 
				<br />Continue acompanhando a Colônia Kinderland pelo nosso website.
			</h3>
		<?php
			}
		?>

		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
			+
		</button>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="solicitar-convite" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="solicitar-convite">Solicitar Convite</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 middle-content">
								<div class="row">
									<div class="col-lg-8"><h4>Inscrição de pessoa no evento: <?=$event->getEventName()?></h4></div>
								</div>
								<hr />

								<?php if(isset($people) && is_array($people) && count($people) > 0) { ?>
									<br />
									<div class="row">
										<div class="form-group">
											<label for="box_options" class="col-lg-3 control-label"> Opções de pessoas: </label>
											<div class="col-lg-9">
												<select class="form-control" id="box_options" name="box_options">
													<option value="" selected>-- Selecione --</option>
												  	<?php 
												  		$i = 0;
												  		foreach($people as $person) { 
												  	?>
												  		<option value="<?=$i++?>"><?=$person->getFullname()?></option>
												  	<?php } ?>
												</select> 
											</div>
										</div>
									</div>
									<br />
								<?php } ?>
								
								<form name="form_subscribe" method="POST" action="<?=$this->config->item('url_link')?>events/subscribePerson" id="form_subscribe">
									<div class="row">
										<input type="hidden" id="event_id" name="event_id" value="<?=$event->getEventId()?>" />
										<input type="hidden" id="user_id" name="user_id" value="<?=$user_id?>" />
										<input type="hidden" id="person_id" name="person_id" value="" />
										<div class="form-group">
											<label for="fullname" class="col-lg-2 control-label"> Nome Completo: </label>
											<div class="col-lg-4">
												<input type="text" class="form-control" placeholder="Nome Completo"
													name="fullname" id="fullname"/>
											</div>

											<label for="gender" class="col-lg-2 control-label"> Sexo: </label>
											<div class="col-lg-4">
												<select class="form-control" id="gender" name="gender" >
													<option value="" selected>-- Selecione --</option>
													<option value="M">Masculino</option>
													<option value="F">Feminino</option>
												</select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="form-group">
											<div class="col-lg-6">
												<p>
													<label for="associate" class="control-label"> Dependente de sócio: </label>
													<input type="checkbox" class="" name="associate" id="associate"/>
												</p>
											</div>

											<label for="age_group" class="col-lg-2 control-label"> Faixa Etária: </label>
											<div class="col-lg-4">
												<select class="form-control" id="age_group" name="age_group" >
													<option value="" selected>-- Selecione --</option>
													<?php
														foreach($age_groups as $group){
															echo "<option value='".$group->age_group_id."'>".$group->description."</option>";
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
						<button type="button" class="btn btn-primary" onClick="validateFormInfo()">Confirmar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			&nbsp;
		</div>
		<div class="row">
			&nbsp;
		</div>
		<div class="row">
			&nbsp;
		</div>
			

	</div>
</div>