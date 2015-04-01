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

			function deleteSubscription(eventId, userId){

			    $.post( "<?=$this->config->item('url_link')?>events/unsubscribeUsers", 
						{ event_id: eventId, user_ids: userId },
						function ( data ){
							location.reload();
						}
				);
			}

			function paymentDetailsScreen(eventId){
				var personIds = $("input[name=subscriptions]:checked").map(function() {
							return this.value;
						}).get().join(",");

				if(personIds.length == 0){
					alert("Selecione os convites que deseja deletar.");
					return;
				}

				$.redirect( "<?=$this->config->item('url_link')?>events/checkoutSubscriptions", 
						{ event_id: eventId, person_ids: personIds },
						"POST");
			}

			$("document").ready(function(){
				var peopleJson = <?=$peoplejson?>;
				var subscriptions = <?=json_encode($subscriptions)?>;
				var price = <?=json_encode($price)?>;

				$(".subscriptions").prop("checked", false);

				$("#box_options").change(function(){
					var person = peopleJson[parseInt($("#box_options").val())];
					if(person != null){
						$("#fullname").val(person.fullname);
						$("#gender").val(person.gender.toUpperCase());
						$("#fullname").attr("disabled", true);
						$("#gender").attr("disabled", true);
						$("#person_id").val(person.personId);
					}
					else{
						$("#fullname").val("");
						$("#gender").val("");
						$("#fullname").prop("disabled", false);
						$("#gender").prop("disabled", false);;
						$("#person_id").val("");
					}	
				});

				$(".subscriptions").change(function(){
					var sub = getSubscriptionByPersonId(subscriptions, this.value);
					console.log(sub);
					var priceAge = getPriceByAgeGroup(price, sub.age_group_id);

					if(this.checked) {
						var subtotal = parseFloat($("#subtotal").text().replace(",", ".")) + parseFloat(priceAge);

						$("#subtotal").text(subtotal.toFixed(2).toString().replace(".", ","));
						$("#qtd_invites").text(parseInt($("#qtd_invites").text()) + 1);
						if(sub.associate == "t"){
							var discount = parseFloat($("#discount").text().replace(",", ".")) + parseFloat(priceAge) * price.associate_discount;
							$("#discount").text(discount.toFixed(2).toString().replace(".", ","));
						}
							

						var totalAcc = parseFloat($("#subtotal").text().replace(",", ".")) - parseFloat($("#discount").text().replace(",", "."));
						$("#price_total").text(totalAcc.toFixed(2).toString().replace(".", ","));
						//$("#cart-info").show();
					} else {
						var subtotal = parseFloat($("#subtotal").text().replace(",", ".")) - parseFloat(priceAge);
						$("#subtotal").text(subtotal.toFixed(2).toString().replace(".", ","));
						$("#qtd_invites").text(parseInt($("#qtd_invites").text()) - 1);
						if(sub.associate == "t"){
							var discount = parseFloat($("#discount").text().replace(",", ".")) - parseFloat(priceAge) * price.associate_discount;
							$("#discount").text(discount.toFixed(2).toString().replace(".", ","));
						}

						var totalAcc = parseFloat($("#subtotal").text().replace(",", ".")) - parseFloat($("#discount").text().replace(",", "."));
						$("#price_total").text(totalAcc.toFixed(2).toString().replace(".", ","));
						//if(parseInt($("#qtd_invites").text()) == 0)
						//	$("#cart-info").hide();
					}
						

				});
			});

			function getPriceByAgeGroup(prices, ageGroup){
				if(ageGroup == 1)
					return prices.children_price;
				else if(ageGroup == 2)
					return prices.middle_price;
				else
					return prices.full_price;
			}

			function getSubscriptionByPersonId(subscriptions, personId) {
				for(sub in subscriptions){
					if(subscriptions[sub].person_id == personId){
						return subscriptions[sub];
					}
				}

				return null;
			}

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
				<div class="col-lg-10 col-lg-offset-1">
					<p align="center">
						<?=$fullname?>, você que é sócio, tem <?=$price->associate_discount*100?>% de desconto nos convites para você e seus dependentes diretos.
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
							<th><?=$age_groups[2]->description?></th>
							<th><?=$age_groups[1]->description?></th>
							<th><?=$age_groups[0]->description?></th>
						</tr>
						<tr>
							<td>Masculino</td>
							<td>R$ <?=number_format($price->full_price, 2, ',', '.');?></td>
							<td>R$ <?=number_format($price->middle_price, 2, ',', '.');?></td>
							<td>R$ <?=number_format($price->children_price, 2, ',', '.');?></td>
						</tr>
						<tr>
							<td>Feminino</td>
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
						<div class="row">
							&nbsp;
						</div>
						<form action="<?=$this->config->item("url_link")?>events/checkoutSubcriptions" method="POST" name="form_submit_payment" id="form_submit_payment">
							<input type="hidden" name="user_id" value="<=$user_id?>" />
							<table class="table table-condensed table-hover">
								<tr>
									<th>Pagar</th>
									<th>Nome do convidado</th>
									<th>Faixa etária</th>
									<th>Descrição do convite</th>
									<th>Deletar</th>
								</tr>
								<?php 
									foreach($subscriptions as $subscr){
								?>
									<tr>
										<td>
											<?php if($subscr->subscription_status != SUSCRIPTION_STATUS_SUBSCRIPTION_OK) { ?>
												<input type="checkbox" name="subscriptions" id="subscriptions" class="subscriptions" value="<?=$subscr->person_id?>" />
											<?php }  else { ?>
												<img src="<?= $this->config->item('assets') ."images/kinderland/confirma.png" ?>" width="20px" height="20px"/>
											<?php } ?>
										</td>
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
										 <td>
										 	<?php if($subscr->subscription_status != SUSCRIPTION_STATUS_SUBSCRIPTION_OK) { ?>
										 		<img src="<?= $this->config->item('assets') ."images/kinderland/lixo.png"  ?>" width="20px" height="20px" onClick="deleteSubscription(<?=$event->getEventId()?>, <?=$subscr->person_id?>)"/>
										 	<?php } ?>
										 </td>
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
			Novo convite
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

								<div>
								</div>

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
													<?php
														if($user_associate && $price->associate_discount > 0){ //$user->isAssociate()
													?>
														<label for="associate" class="control-label"> Dependente de sócio?: </label>
														<input type="radio" class="" name="associate" id="associate" value="true" /> Sim 
														<input type="radio" class="" name="associate" id="associate" value="false" /> Não
													<?php
														} else {
													?>
														<label for="associate" class="control-label"> Dependente de sócio?: </label>
														<input type="radio" class="" name="associate" id="associate" value="true" disabled/> Sim 
														<input type="radio" class="" name="associate" id="associate" value="false" checked disabled /> Não
													<?php
														}
													?>

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

		<div class="row" id="cart-info">

			<div class="col-lg-3 col-lg-offset-5" style="border-left-style:solid; border-left-width:1px; border-left-color:#cccccc">
				Quantidade de convites:<br />
				Subtotal:<br />
				Desconto:<br />

				Total:
			</div>
			<div class="col-lg-2">
				<span id="qtd_invites">0</span><br />
				R$<span id="subtotal">0,00</span><br />
				R$<span id="discount">0,00</span><br />
				R$<span id="price_total">0,00</span>
			</div>
			<div class="col-lg-1">
				<?php
					if($price != null){
				?>
					<br />
					<br />

					<button class="btn btn-primary" style="float:right; " onClick="paymentDetailsScreen(<?=$event->getEventId()?>)">Pagar</button>
				<?php
					}
				?>
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