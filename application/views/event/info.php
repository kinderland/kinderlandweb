
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Colônia Kinderland</title>

        <link href="<?= $this->config->item('assets'); ?>css/basic.css" rel="stylesheet" />
        <!--<link href="<?= $this->config->item('assets'); ?>css/old/screen.css" rel="stylesheet" />-->
        <link href="<?= $this->config->item('assets'); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/bootstrap-switch.min.css"></script>
        <link rel="stylesheet" href="<?= $this->config->item('assets'); ?>css/theme.default.css" />
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/ui/jquery-ui.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquerysettings.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.redirect.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/formValidationFunctions.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/bootstrap-switch.min.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery/jquery.mask.js"></script>
        <script type="text/javascript" src="<?= $this->config->item('assets'); ?>js/jquery.tablesorter.js"></script>

    </head>
    <body>
    
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
					$.post( "<?=$this->config->item('url_link');?>events/subscribeUser", 
							{ event_id: eventId, user_id: userId },
							function ( data ){								
								$('#thisdiv').load(document.URL +  ' #thisdiv');
								$('#myModal').modal('hide');
							}
					);
				}	
			}			

			function deleteSubscription(eventId, userId){

			    $.post( "<?=$this->config->item('url_link');?>events/unsubscribeUsers", 
						{ event_id: eventId, user_ids: userId },
						function ( data ){
							$('#thisdiv').load(document.URL +  ' #thisdiv');
							$('#myModal').modal('hide');
						}
				);
			}

			function paymentDetailsScreen(event_id){
				
				var personIds = document.getElementsByName("personIds");
				var Ids;

				if(personIds.length == 0){
					alert("Selecione os convites que deseja pagar.");
					return;
				}

				for(var i = 0; i < personIds.length; i++){
					if(i == 0)
						Ids = personIds[i].getAttribute("Id");
					else
						Ids = Ids.concat(",").concat(personIds[i].getAttribute("Id"));
				}

				$.redirect( "<?=$this->config->item('url_link');?>events/checkoutSubscriptions", 
										{ event_id: event_id, person_ids: Ids },
										"POST");
			}

			$("document").ready(function(){
				var peopleJson = <?=$peoplejson?>;
				var subscriptions = <?=json_encode($subscriptions)?>;
				var price = <?=json_encode($price)?>;

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
			function changeValue(idChecked,idNotChecked){
				document.getElementById(idChecked).value = "true";
				document.getElementById(idNotChecked).value = "false";
			}

			function validateFormInfo(){
				var fullname = $("#fullname").val();
				var age_group = $("#age_group").val();
				var gender = $("#gender").val();
				var nonsleeperyes = document.getElementById("nonsleeper_true").value;
				var nonsleeperno = document.getElementById("nonsleeper_false").value;
				var associateyes = document.getElementById("associate_true").value;
				var associateno = document.getElementById("associate_false").value;
				var event_id = $("#event_id").val();
				var user_id = $("#user_id").val();
				var person_id = null;
				var error = "";
				var type = "Simples"; 

				if(fullname == "")
					error = error.concat("Nome Completo\n");
				if(associateyes === "false" && associateno === "false")
					error = error.concat("Dependente de Sócio\n");
				if(age_group == "")
					error = error.concat("Faixa Etária\n");
				if(gender == "")
					error = error.concat("Sexo\n");
				if(nonsleeperyes === "false" && nonsleeperno === "false")
					error = error.concat("Com Pernoite\n");

				if(error != ""){
					alert("Os seguintes campos precisam ser preenchidos:\n\n".concat(error));
				}
				else{
					var nonsleeper = null;
					var associate = null;
					
					if(nonsleeperyes == "true")
						nonsleeper = "true";
					else
						nonsleeper = "false";

					if(associateyes == "true")
						associate = "true";
					else
						associate = "false";
					
					$.post("<?php  echo $this->config->item('url_link');?>events/checkVacancy", {event_id: event_id, nonsleeper: nonsleeper, gender: gender, type: type}, 
					function(data){
						if(data==true){						
							$.post("<?= $this->config->item('url_link');?>events/subscribePerson",{event_id: event_id, user_id: user_id, 
								person_id: person_id, age_group: age_group, associate: associate, nonsleeper: nonsleeper, gender:gender, fullname: fullname},
								function(data){
									if(data){
										alert("Convite criado com sucesso!");
										$('#thisdiv').load(document.URL +  ' #thisdiv');
										$('#myModal').modal('hide');
										$('body').removeClass('modal-open');
										$('.modal-backdrop').remove();	
									}
									else{
										alert("Houve um erro na criação do convite. Tente novamente!");	
									}
								});
						}
						else{
							if(gender == "M")
								gender = "Masculino";
							else if(gender == "F")
								gender = "Feminino";

							if(nonsleeper == "true")
								nonsleeper = "sem pernoite";
							else if(nonsleeper == "false")
								nonsleeper = "com pernoite";
							
							alert("Infelizmente, não há mais disponibilidade de convites ".concat(gender).concat(" ").concat(nonsleeper));
						}
					});
				}
			}


		</script>
		<div id="thisdiv">
		<?php 
			if($event != null && $event instanceof Event) { 
		?>
			<div class='row'>
				<div class="col-lg-8">
					<h2><?=$event->getEventName();?></h2>
					<h4 align="left"><strong><?=$event->getDescription();?></strong></h4>
					<h4>
						<strong>Período:</strong>
							<?= date_format(date_create($event->getDateStart()), 'd/m/y');?> 
							<?= ($event->getDateStart() != $event->getDateFinish())? " - ".date_format(date_create($event->getDateFinish()), 'd/m/y'):""?>
						
					</h4>
			<?php
				if($user_associate && $price->associate_discount > 0){ //$user->isAssociate()
			?>
					<p align="left">
						<?=$fullname?>, você que é sócio, tem <?=$price->associate_discount*100?>% de desconto nos convites para você e seus dependentes diretos.
					</p>
			<?php
				}
			?>
					<h4><strong>Valores:</strong></h4>
					<table class="table table-bordered table-striped" style="max-width:550px; min-width:550px; table-layout: fixed;">
						<tr>
							<th style="width:150px"></th>
							<th><?=$age_groups[2]->description?></th>
							<th><?=$age_groups[1]->description?></th>
							<th><?=$age_groups[0]->description?></th>
						</tr>
						<?php foreach($prices as $p){?>
							<tr>
								<?php if($p->date_start == $price->date_start && $p->date_finish == $price->date_finish){?>
								<th><?= date_format(date_create($p->date_start), 'd/m/y');?> 
							<?= ($p->date_start != $p->date_finish)? " - ".date_format(date_create($p->date_finish), 'd/m/y'):""?></th>
								<th>R$ <?=number_format($p->full_price, 2, ',', '.');?></th>
								<th>R$ <?=number_format($p->middle_price, 2, ',', '.');?></th>
								<th>R$ <?=number_format($p->children_price, 2, ',', '.');?></th>
							<?php } else{?>
								<td><?= date_format(date_create($p->date_start), 'd/m/y');?> 
							<?= ($p->date_start != $p->date_finish)? " - ".date_format(date_create($p->date_finish), 'd/m/y'):""?></td>
								<td>R$ <?=number_format($p->full_price, 2, ',', '.');?></td>
								<td>R$ <?=number_format($p->middle_price, 2, ',', '.');?></td>
								<td>R$ <?=number_format($p->children_price, 2, ',', '.');?></td>
							<?php }?>
							</tr>
						<?php }?>
					</table>
							<h4><strong>Meus convites:</strong></h4>
							<!-- Button trigger modal -->
							<?php if($event -> getCapacityNonSleeper() == 0 && $event -> getCapacityMale() == 0 && $event -> getCapacityFemale() == 0){?>
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" disabled>
								Não há mais convite disponível
							</button>
							<?php } else{?>
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
								Novo convite
							</button>
							<?php }?>
							<br/><br/>
							<?php 
				if(count($subscriptions) > 0) {
			?>
						<div name="form_submit_payment" id="form_submit_payment">
							<input type="hidden" name="user_id" value="<?php echo$user_id?>" />
							<table class="table table-bordered table-striped" style="max-width:808px; min-width:550px; table-layout: fixed;">
								<tr>
									<th style="width:300px">Nome do convidado</th>
									<th style="width:100px">Faixa etária</th>
									<th style="width:80px">Pernoite</th>
									<th style="width:165px">Dependente de Sócio</th>
									<th style="width:165px">Descrição do convite</th>
									<th style="width:165px">Status</th>
									<th style="width:90px">Ação</th>
								</tr>
								<?php 
									foreach($subscriptions as $subscr){
								?>
									<tr><?php if($subscr->subscription_status != SUSCRIPTION_STATUS_SUBSCRIPTION_OK){?>
										<td name="personIds" id="<?=$subscr->person_id?>"><?= $subscr->fullname ?></td>
										<?php } else{?>
											<td><?= $subscr->fullname ?></td>
										<?php }?>
										<td><?= $subscr->age_description ?></td>
										<td><?php if(!empty($subscr->nonsleeper) && ($subscr->nonsleeper === "t")) echo 'Não'; else echo 'Sim'; ?></td>
										<td><?php if(!empty($subscr->associate) && ($subscr->associate === "t")) echo 'Sim'; else echo 'Não'; ?></td>
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
													echo "Prazo de doação terminado";
												}
										  ?></td>
										  <td>
										  	<?php if($subscr->subscription_status != SUSCRIPTION_STATUS_SUBSCRIPTION_OK){
										  			echo "Aguardando Doação";
										  	} else{
										  		echo "Doação Realizada";
										  	}
										  		?>											  										  
										  </td>
										 <td>
										 	<?php if($subscr->subscription_status != SUSCRIPTION_STATUS_SUBSCRIPTION_OK) { ?>
										 		<button class="btn btn-danger" onclick="deleteSubscription(<?=$event->getEventId()?>, <?=$subscr->person_id?>)">Excluir</button>
										 	<?php } ?>
										 </td>
									</tr>
								<?php
									}
								?>
							</table>
					</div>
			<?php
				} 
			?>
			<h4><strong>Doação:</strong></h4>
			<div style= "margin-top: 15px; font-size:14px;" id="cart-info">
			<table  class="table table-bordered table-striped" style="max-width:425px; min-width:100px; table-layout: fixed;">
				<tr>
					<th style="width:210px">Quantidade de convites:</th>
					<td><span id="qtd_invites"><?php echo $qtd; ?></span></td>
				</tr>
				<tr>
					<th style="width:210px">Subtotal:</th>
					<td>R$<span id="subtotal"><?php echo number_format($subtotalPrice,2,",","."); ?></span></td>
				</tr>
				<tr>
					<th style="width:210px">Desconto:</th>
					<td>R$<span id="discount"><?php echo number_format($discount,2,",","."); ?></span></td>
				</tr>
				<tr>
					<th style="width:210px">Total:</th>
					<td>R$<span id="price_total"><?php echo number_format($totalPrice,2,",","."); ?></span></td>
					<?php
					if($price != null){
				?>
					<td>
					<button class="btn btn-primary" style="float:right; " onClick="paymentDetailsScreen(<?=$event->getEventId()?>)">Prosseguir</button>
					</td>
				<?php
					}
				?>
				</tr>
				</table>
		</div>	
	</div>
</div>
			
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

<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="solicitar-convite" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="solicitar-convite">Solicitar Convite: <?=$event->getEventName()?></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 middle-content">
								<div class="row">
									
								</div>

								<div>
								</div>
																
								<div name="form_subscribe" id="form_subscribe">
									<div class="row">
										<input type="hidden" id="event_id" name="event_id" value="<?=$event->getEventId()?>" />
										<input type="hidden" id="user_id" name="user_id" value="<?=$user_id?>" />
										<input type="hidden" id="person_id" name="person_id" value="" />
										<div class="form-group">
											<label for="fullname" style="width: 150px; margin-bottom:0px; margin-top:7px;" class="col-lg-1 control-label"> Nome Completo*: </label>
											
												<input  style="width: 300px" type="text" class="form-control" placeholder="Nome Completo"
													name="fullname" value="<?php echo $name;?>" id="fullname" />
											</div>
											</div>
											<br />
											<div class="row">
											<div class="form-group">
											<label style="width: 60px;margin-bottom:0px; margin-top:7px; padding-right:0px" for="gender" class="col-lg-1 control-label"> Sexo*: </label>
											<div style="width: 240px;" class="col-lg-2 control-label">
												<select  class="form-control" id="gender" name="gender">
													<option value="" selected>-- Selecione --</option>
													<option value="M">Masculino</option>
													<option value="F">Feminino</option>
												</select>
											</div>
										</div>
									</div>
									<br />

									<div class="row">
										<div class="form-group">
											<div class="col-lg-7">
												<p>
													<?php
														if($user_associate && $price->associate_discount > 0){ //$user->isAssociate()
													?>
														<label for="associate_true" class="control-label"> Dependente de sócio*: </label>
														<input type="radio" class="associate_yes" name="associate" id="associate_true" value="false" onclick = "changeValue('<?php echo "associate_true";  ?>','<?php echo "associate_false";?>')"/> Sim 
														<label for="associate_false" class="control-label"></label>
														<input type="radio" class="associate_no" name="associate" id="associate_false" value="false" onclick = "changeValue('<?php echo "associate_false"; ?>','<?php echo "associate_true"; ?>')" /> Não
													<?php
														} else {
													?>
														<label for="associate_true" class="control-label"> Dependente de sócio*: </label>
														<input type="radio" class="associate_yes" name="associate" id="associate_true" value="false" onclick = "changeValue('<?php echo "associate_true"; ?>','<?php echo "associate_false";?>')" disabled/> Sim 
														<label for="associate_false" class="control-label"></label>
														<input type="radio" class="associate_no" name="associate" id="associate_false" value="true" onclick = "changeValue('<?php echo "associate_false";  ?>','<?php echo "associate_true"; ?>')" checked disabled/> Não
													<?php
														}
													?>

												</p>
											</div>
											</div>
											</div>
											<div class="row">
											<div class="form-group">

											<label for="age_group" style="width: 125px; margin-bottom:0px; margin-top:7px; padding-right:0px" class="col-lg-1 control-label"> Faixa Etária*: </label>
											<div style="width: 240px;padding-left:0px" class="col-lg-1 control-label">
												<select class="form-control" id="age_group" name="age_group">
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
									<br />
									<div class="row">
										<div class="form-group">
											<div class="col-lg-6">
												<label for="nonsleeper_false" class="control-label"> Com Pernoite*: </label>
												<input type="radio" name="nonsleeper" id="nonsleeper_false" value="false" onclick = "changeValue('<?php echo "nonsleeper_false"; ?>','<?php echo "nonsleeper_true";?>')" /> Sim 
												<label for="nonsleeper_true" class="control-label"></label>
												<input type="radio" name="nonsleeper" id="nonsleeper_true" value="false" onclick = "changeValue('<?php echo "nonsleeper_true"; ?>','<?php echo "nonsleeper_false";?>')" /> Não 
											</div>
										</div>
									</div>
								</div>
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
		</div>
</body>
</html>
<script type="text/javascript">

		function alertaTempoTotal(){
			$('#thisdiv').load(document.URL +  ' #thisdiv');
			alert("ATENÇÃO! Você terá 10 minutos para criar os convites e prosseguir com a doação. Após esse prazo, todos os convites criados serão excluídos.");
		}

		function alertaTempoAcabando(){
			alert("ATENÇÃO! Você tem mais 2 minutos para criar os convites e prosseguir com a doação.");
		}	

		function deletAll(){
			var eventId = document.getElementById("event_id").value;
			var personIds = document.getElementsByName("personIds");

			for(var i = 0; i < personIds.length; i++){
				deleteSubscription(eventId,personIds[i].getAttribute("Id"));
			}
		}

		window.onbeforeunload = function() {
			deletAll();
			location.reload(true);
		};

		function alertaAcabou(){
			alert("Tempo Esgotado!");
			location.reload(true);
		}

		setTimeout(alertaAcabou,1000*60*10);

		setTimeout(alertaTempoAcabando,1000*60*8);

		setTimeout(alertaTempoTotal,0);

</script>